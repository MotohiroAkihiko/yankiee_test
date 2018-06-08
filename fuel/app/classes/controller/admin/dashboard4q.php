<?php
class Controller_Admin_Dashboard4Q extends Controller_Admin{

	protected $auth_group = array('4q','admin');

	public function action_index()
	{
		$data = array();
		
		$month = date('Ym');
		$last_month = date('Ym', strtotime(date('Y-m-1') . '+1 month'));
		
		// 当月・翌月のランキング報酬マスタのリストデータ取得クエリ
		$query = DB::select('*')
					->from('mst_ranking_present')
					->where_open()
						->where('ranking_date_key' ,'like', "%{$month}%")
						->or_where('ranking_date_key' ,'like', "%{$last_month}%")
						->where_close()
					->order_by('ranking_type','asc')->order_by('ranking_date_key','asc')->order_by('id', 'asc');
		
		$data['list_mst_ranking_present'] = $query->execute()->as_array();
		//var_dump(DB::last_query());

		// 当月・翌月のマンスリーミッションマスタのリストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_monthly_mission')
		->where_open()
		->where('mission_date_ym' , $month)
		->or_where('mission_date_ym' , $last_month)
		->where_close()
		->order_by('mission_date_ym','asc')->order_by('id', 'asc');
		
		$data['list_mst_monthly_mission'] = $query->execute()->as_array();
		//var_dump(DB::last_query());

		// 当月・翌月のキャラクターマスタのリストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_character')
		->where_open()
		->where(DB::expr("to_char(publish_start_date, 'YYYYMM')") , $month)
		->or_where(DB::expr("to_char(publish_start_date, 'YYYYMM')") , $last_month)
		->where_close()
		->order_by('publish_start_date','asc')->order_by('id', 'asc');
		
		$data['list_mst_character'] = $query->execute()->as_array();
		//var_dump(DB::last_query());

		// 当月・翌月のキャラクター得意ゲームマスタのリストデータ取得クエリ
		$query = DB::select('mst_character_game.*', 'mst_character.character_name', 'mst_game.game_name')
		->from('mst_character_game')
		->join('mst_character', 'left')->on('character_id', '=', 'mst_character.id')
		->join('mst_game', 'left')->on('game_id', '=', 'mst_game.id')
		->where_open()
		->where(DB::expr("to_char(mst_character.publish_start_date, 'YYYYMM')") , $month)
		->or_where(DB::expr("to_char(mst_character.publish_start_date, 'YYYYMM')") , $last_month)
		->where_close()
		->order_by('character_id','asc')->order_by('game_id','asc');
		
		$data['list_mst_character_game'] = $query->execute()->as_array();
		//var_dump(DB::last_query());
		
		$this->template->title = '4Qダッシュボード';
		$this->template->content = View::forge('admin/dashboard4q/index', $data);
	}
}