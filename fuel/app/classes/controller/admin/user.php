<?php
class Controller_Admin_User extends Controller_Admin{

	public function action_index()
	{
		$data = array();
		
		// 入力値取得
		$sid = Input::get('sid');
		$keyword = Input::get('keyword');
		$school1 = Input::get('school1');
		$school2 = Input::get('school2');
		$school3 = Input::get('school3');
		$ym = Input::get('ym');
		
		// 再検索URL生成用パラメータ
		$param = array();
		!empty($sid) and $param['sid'] = $sid;
		!empty($keyword) and $param['keyword'] = $keyword;
		!empty($school1) and $param['school1'] = $school1;
		!empty($school2) and $param['school2'] = $school2;
		!empty($school3) and $param['school3'] = $school3;
		!empty($ym) and $param['ym'] = $ym;
		
		// リストデータ取得クエリ
		$bind = array();
		$queryString = " select U.*, S.school_name, C.character_name as character_name"
				." , case when UP.point is null then 0 else UP.point end as user_point"
				." , ( select count(id) from tbl_user_login_history where site_user_id = U.site_user_id ) as login_count"
				." , ( select count(id) from tbl_user_character where site_user_id = U.site_user_id ) as character_count"
				." from tbl_user U"
				." inner join mst_school S on S.id = U.school_id"
				." inner join mst_character C on C.id = U.character_id"
				." left join tbl_user_total_point UP on UP.site_user_id = U.site_user_id"
				." where true";
		
		$bind['now_date'] = date('Y-m-d H:i:s');

		// ID検索
		if ( !empty($sid) ) {
			$queryString .= " and U.site_user_id = :sid ";
			$bind['sid'] = $sid;
		}
		
		// キーワード検索 
		if ( !empty($keyword) ) {
			$queryString .= " and ( U.nick_name like :keyword or U.user_id like :keyword or cast(U.site_user_id as varchar) like :keyword ) ";
			$bind['keyword'] = "%$keyword%";
		}
		
		// 学校絞り込み検索
		if ( !empty($school1) || !empty($school2) || !empty($school3) ) {
			
			$schoolIdArray = array();
			!empty($school1) and $school1 == 'on' and $schoolIdArray[] = 1; 
			!empty($school2) and $school2 == 'on' and $schoolIdArray[] = 2; 
			!empty($school3) and $school3 == 'on' and $schoolIdArray[] = 3; 
			

			$queryString .= " and U.school_id in (" . implode(', ', $schoolIdArray) . ")";
		}
		
		// 年月絞り込み検索 
		if ( !empty($ym) ) {
			$queryString .= " and to_char(U.reg_date, 'YYYYMM') = :ym ";
			$bind['ym'] = $ym;
		}

		// ページャー設定
		$config = array(
				'pagination_url' => Uri::create(Uri::current(), array(), $param),
				'total_items' => DB::query($queryString)->parameters($bind)->execute()->count(),
				'per_page' => 10,
				'num_links' => 3,
				'uri_segment' => 'p',
				'show_first' => true,
				'show_last' => true,
		);
		
		$pagination = Pagination::forge('pager', $config);

		$query = DB::query(
				$queryString
				." order by user_point desc, login_count desc, site_user_id desc limit " . $pagination->per_page . " offset " . $pagination->offset
		);

		// リストデータ取得
		$list = $query->parameters($bind)->execute()->as_array();
		//var_dump(DB::last_query());
		
		$data['list'] = $list;
		
		// 年月検索条件用配列
		$regYmArray = array();
		$regYmArray[''] = 'すべて';
		
		$dateTime = DateTime::createFromFormat('Y-m-d', '2015-02-01');
		
		while( $dateTime->format('Ym') <= date('Ym') ) {
			$regYmArray[$dateTime->format('Ym')] = $dateTime->format('Y年m月');
			$dateTime->modify('+1 month');
		}
		
		$data['regYmArray'] = $regYmArray;
		
		$this->template->title = "ユーザー一覧";
		$this->template->content = View::forge('admin/user/index', $data);
	}
}