<?php
class Controller_Admin_Dashboard extends Controller_Admin{

	public function action_index()
	{
		$data = array();

		// 学校別のユーザー数
		$data['school_user_count'] = Model_User::getSchoolUserCount();
		
		!isset($data['school_user_count'][1]['count']) and $data['school_user_count'][1]['count'] = 0;
		!isset($data['school_user_count'][2]['count']) and $data['school_user_count'][2]['count'] = 0;
		!isset($data['school_user_count'][3]['count']) and $data['school_user_count'][3]['count'] = 0;
		
		$this->template->title = 'ダッシュボード';
		$this->template->content = View::forge('admin/dashboard/index', $data);
	}
}