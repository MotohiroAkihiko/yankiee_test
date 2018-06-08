<?php
class Controller_Admin_Dailymission extends Controller_Admin{

	public function action_index()
	{
		$data = array();
		
		// 入力値取得
		$keyword = Input::get('keyword');
		
		// 再検索URL生成用パラメータ
		$param = array();
		!empty($keyword) and $param['keyword'] = $keyword;
		
		// リストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_daily_mission')
		->where('del_flg', '0')
		->order_by('id', 'asc');
		
		// キーワード検索
		if ( !empty($keyword) ) {
			$query->where('mission_name', 'like', "%$keyword%");
		}
		
		// ページャー設定
		$config = array(
				'pagination_url' => Uri::create(Uri::current(), array(), $param),
				'total_items' => $query->execute()->count(),
				'per_page' => 10,
				'num_links' => 3,
				'uri_segment' => 'p',
				'show_first' => true,
				'show_last' => true,
		);
		
		$pagination = Pagination::forge('pager', $config);
		
		// リストデータ取得
		$list = $query->limit($pagination->per_page)
						->offset($pagination->offset)
						->execute()->as_array();
		
		//var_dump(DB::last_query());
		
		$data['list'] = $list;
		
		// ゲームマスタのリストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_game')
		->order_by('id', 'asc');
		
		$data['list_mst_game'] = $query->execute()->as_array();
		//var_dump(DB::last_query());
		
		// アイテムマスタのリストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_item')
		->order_by('id', 'asc');
		
		$data['list_mst_item'] = $query->execute()->as_array();
		
		$this->template->title = "デイリーミッション一覧";
		$this->template->content = View::forge('admin/dailymission/index', $data);
	}
}