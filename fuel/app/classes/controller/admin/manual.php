<?php
class Controller_Admin_Manual extends Controller_Admin{

	protected $auth_group = array('4q','admin');

	public function action_index()
	{
		$data = array();
		
		$this->template->title = '運用マニュアル';
		$this->template->content = View::forge('admin/manual/index', $data);
	}
}