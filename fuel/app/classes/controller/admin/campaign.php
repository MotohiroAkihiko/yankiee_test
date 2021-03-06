<?php
class Controller_Admin_Campaign extends Controller_Admin{

	protected $auth_group = array('4q','admin');
	
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
		->from('mst_present')
		->where('del_flg', '0')
		->order_by('present_start_date','desc')->order_by('present_id', 'desc');
		
		// キーワード検索
		if ( !empty($keyword) ) {
			$query->where('present_name', 'like', "%$keyword%");
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
		
		$this->template->title = "キャンペーン一覧";
		$this->template->content = View::forge('admin/campaign/index', $data);
	}

	public function action_add()
	{
		$data = array();
		$errors = array();
		
		if (Input::method() == 'POST') {

			$val = Model_Campaign::validate('add');
			
			if ($val->run()) {
				
				$model = Model_Campaign::forge(array(
					'present_name' => Input::post('present_name'),
					'present_code' => Input::post('present_code'),
					'present_start_date' => Common_Util::format_datetime_input2db(Input::post('present_start_date')),
					'present_end_date' => Common_Util::format_datetime_input2db(Input::post('present_end_date'), '59'),
					'result_start_date' => Common_Util::format_datetime_input2db(Input::post('result_start_date')),
					'result_end_date' => Common_Util::format_datetime_input2db(Input::post('result_end_date'), '59'),
					'del_flg' => 0,
					'reg_date' => date('Y-m-d H:i:s'),
					'upd_date' => date('Y-m-d H:i:s'),
				));
				
				if ( $model->save() ) {
					Session::set_flash('success', '「'.$model->present_name.'」を追加しました。');
				} else {
					Session::set_flash('error', e('登録処理が失敗しました。'));
				}
				
				Response::redirect('admin/campaign');
			}
			
			$errors = $val->error();
		}
		
		$this->template->set_global('errors', $errors, false);
		
		$this->template->title = "キャンペーン新規登録";
		$data['mode'] = 'new';
		Asset::js(array('admin/js/form_common.js', 'admin/js/campaign_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/campaign/form', $data);
	}

	public function action_edit($id = null)
	{
		$data = array();
		$errors = array();
		
		if ( !is_numeric($id) || is_null($model = Model_Campaign::find($id)) ) {
			return Response::forge(ViewModel::forge('welcome/404'), 404);
		}
		
		if (Input::method() == 'POST') {

			$val = Model_Campaign::validate('add');
			
			if ($val->run()) {
				
				$model->present_name = Input::post('present_name');
				$model->present_code = Input::post('present_code');
				$model->present_start_date = Common_Util::format_datetime_input2db(Input::post('present_start_date'));
				$model->present_end_date = Common_Util::format_datetime_input2db(Input::post('present_end_date'), '59');
				$model->result_start_date = Common_Util::format_datetime_input2db(Input::post('result_start_date'));
				$model->result_end_date = Common_Util::format_datetime_input2db(Input::post('result_end_date'), '59');
				$model->upd_date = date('Y-m-d H:i:s');
				
				if ( $model->save() ) {
					Session::set_flash('success', '「'.$model->present_name.'」を更新しました。');
				} else {
					Session::set_flash('error', '登録処理に失敗しました。');
				}
				
				Response::redirect('admin/campaign');
			}
			
			$errors = $val->error();
		} else {
			$model->present_start_date = Common_Util::format_datetime_db2input($model->present_start_date);
			$model->present_end_date = Common_Util::format_datetime_db2input($model->present_end_date);
			$model->result_start_date = Common_Util::format_datetime_db2input($model->result_start_date);
			$model->result_end_date = Common_Util::format_datetime_db2input($model->result_end_date);
			$data['dbRow'] = $model;
		}
		
		$this->template->set_global('errors', $errors, false);
		
		$this->template->title = "キャンペーン編集";
		$data['mode'] = 'edit';
		$data['delete_url'] = Uri::base().'admin/campaign/delete/'.$id;
		Asset::js(array('admin/js/form_common.js', 'admin/js/campaign_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/campaign/form', $data);
	}

	public function action_delete($id = null)
	{
		if (!is_numeric($id) || $model = Model_Campaign::find($id)) {
			
			$model->del_flg = 1;
			$model->upd_date = date('Y-m-d H:i:s');
			
			if ( $model->save() ) {
				Session::set_flash('success', '「'.$model->present_name.'」を削除しました。');
			} else {
				Session::set_flash('error', '削除処理に失敗しました。');
			}
		} else {
			Session::set_flash('error', '指定されたデータは存在しません。');
		}
				
		Response::redirect('admin/campaign');
	}


}