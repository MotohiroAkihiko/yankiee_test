<?php
class Controller_Admin_Master extends Controller_Admin{

	protected $auth_group = array('4q','admin');

	public function action_index()
	{
		$data = array();
		
		// ゲームマスタのリストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_game')
		->order_by('id', 'asc');
		
		$data['list_mst_game'] = $query->execute()->as_array();
		//var_dump(DB::last_query());
		
		// キャラクターマスタのリストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_character')
		->order_by('id', 'asc');
		
		$data['list_mst_character'] = $query->execute()->as_array();
		//var_dump(DB::last_query());

		// キャラクター得意ゲームマスタのリストデータ取得クエリ
		$query = DB::select('mst_character_game.*', 'mst_character.character_name', 'mst_game.game_name')
		->from('mst_character_game')
		->join('mst_character', 'left')->on('character_id', '=', 'mst_character.id')
		->join('mst_game', 'left')->on('game_id', '=', 'mst_game.id')
		->order_by('character_id','asc')->order_by('game_id','asc');
		
		$data['list_mst_character_game'] = $query->execute()->as_array();
		//var_dump(DB::last_query());
		
		// アイテムマスタのリストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_item')
		->order_by('id', 'asc');
		
		$data['item_category'] = array("1" => "食べ物", "2" => "季節もの", "3" => "ヤンキー");
		$data['list_mst_item'] = $query->execute()->as_array();
		//var_dump(DB::last_query());
		
		$this->template->title = '4Qダッシュボード';
		$this->template->content = View::forge('admin/master/index', $data);
	}
}