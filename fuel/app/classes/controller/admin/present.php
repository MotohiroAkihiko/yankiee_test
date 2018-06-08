<?php
class Controller_Admin_Present extends Controller_Admin{

	protected $auth_group = array('4q','admin');

	public function action_list($present_id = null)
	{
		$data = array();
		
		// キャンペーン情報取得
		if ( !is_numeric($present_id) || is_null($campaign = Model_Campaign::find($present_id)) ) {
			return Response::forge(ViewModel::forge('welcome/404'), 404);
		}
		
		$data['campaign'] = $campaign;
		
		// 入力値取得
		$keyword = Input::get('keyword');
		
		// 再検索URL生成用パラメータ
		$param = array();
		!empty($keyword) and $param['keyword'] = $keyword;
		
		// リストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_present_data')
		->where('del_flg', '0')
		->where('present_id', $present_id)
		->order_by('present_data_id', 'asc');
		
		// キーワード検索
		if ( !empty($keyword) ) {
			$query->where('present_data_name', 'like', "%$keyword%");
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
		
		$this->template->title = "景品一覧";
		$this->template->content = View::forge('admin/present/index', $data);
	}

	public function action_add($present_id = null)
	{
		$data = array();
		$errors = array();
		
		// キャンペーン情報取得
		if ( !is_numeric($present_id) || is_null($campaign = Model_Campaign::find($present_id)) ) {
			return Response::forge(ViewModel::forge('welcome/404'), 404);
		}
		
		$data['campaign'] = $campaign;
		
		if (Input::method() == 'POST') {

			$val = Model_Present::validate('add');
			
			if ($val->run()) {
				
				$model = Model_Present::forge(array(
					'present_id' => $present_id,
					'present_data_name' => Input::post('present_data_name'),
					'present_data_txt' => Input::post('present_data_txt'),
					'del_flg' => 0,
					'reg_date' => date('Y-m-d H:i:s'),
					'upd_date' => date('Y-m-d H:i:s'),
				));
				
				if ( $model->save() ) {
					Session::set_flash('success', '「'.$model->present_data_name.'」を追加しました。');
				} else {
					Session::set_flash('error', e('登録処理が失敗しました。'));
				}
				
				Response::redirect('admin/present/list/'.$present_id);
			}
			
			$errors = $val->error();
		}
		
		$this->template->set_global('errors', $errors, false);
		
		$this->template->title = "景品新規登録";
		$data['mode'] = 'new';
		Asset::js(array('admin/js/form_common.js', 'admin/js/present_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/present/form', $data);
	}

	public function action_edit($id = null)
	{
		$data = array();
		$errors = array();
		
		if ( !is_numeric($id) || is_null($model = Model_Present::find($id)) ) {
			return Response::forge(ViewModel::forge('welcome/404'), 404);
		}
		
		// キャンペーン情報取得
		if ( is_null($campaign = Model_Campaign::find($model->present_id)) ) {
			return Response::forge(ViewModel::forge('welcome/404'), 404);
		}
		
		$data['campaign'] = $campaign;
		
		if (Input::method() == 'POST') {

			$val = Model_Present::validate('add');
		
			if ($val->run()) {
				
				$model->present_data_name = Input::post('present_data_name');
				$model->present_data_txt = Input::post('present_data_txt');
				$model->upd_date = date('Y-m-d H:i:s');
				
				if ( $model->save() ) {
					Session::set_flash('success', '「'.$model->present_data_name.'」を更新しました。');
				} else {
					Session::set_flash('error', '登録処理に失敗しました。');
				}
				
				Response::redirect('admin/present/list/'.$model->present_id);
			}
			
			$errors = $val->error();
		} else {
			$model->present_data_name = $model->present_data_name;
			$model->present_data_txt = $model->present_data_txt;
			$data['dbRow'] = $model;
		}
		
		$this->template->set_global('errors', $errors, false);
		
		$this->template->title = "景品編集";
		$data['mode'] = 'edit';
		$data['delete_url'] = Uri::base().'admin/present/delete/'.$id;
		Asset::js(array('admin/js/form_common.js', 'admin/js/present_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/present/form', $data);
	}

	public function action_delete($id = null)
	{
		if (!is_numeric($id) || $model = Model_Present::find($id)) {
			
			$model->del_flg = 1;
			$model->upd_date = date('Y-m-d H:i:s');
			
			if ( $model->save() ) {
				Session::set_flash('success', '「'.$model->present_data_name.'」を削除しました。');
			} else {
				Session::set_flash('error', '削除処理に失敗しました。');
			}
		} else {
			Session::set_flash('error', '指定されたデータは存在しません。');
		}
				
		Response::redirect('admin/present/list/'.$model->present_id);
	}


}