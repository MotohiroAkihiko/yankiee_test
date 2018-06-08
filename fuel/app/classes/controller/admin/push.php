<?php
class Controller_Admin_Push extends Controller_Admin{

	public function action_index()
	{
		$data = array();
		
		// 入力値取得
		$keyword = Input::get('keyword');
		
		// 再検索URL生成用パラメータ
		$param = array();
		!empty($keyword) and $param['keyword'] = $keyword;
		!empty($pub) and $param['pub'] = $pub;
		
		// リストデータ取得クエリ
		$query = DB::select('*')
		->from('tbl_ausp_push')
		->order_by('push_start_date','desc')->order_by('push_id', 'desc');
		
		// キーワード検索
		if ( !empty($keyword) ) {
			$query->where_open()
			->where('push_name', 'like', "%$keyword%")
			->or_where('push_ticker', 'like', "%$keyword%")
			->or_where('push_title', 'like', "%$keyword%")
			->or_where('push_message', 'like', "%$keyword%")
			->where_close();
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
		
		$this->template->title = "Push通知一覧";
		$this->template->content = View::forge('admin/push/index', $data);
	}

	public function action_add()
	{
		$data = array();
		$errors = array();
		
		if (Input::method() == 'POST') {

			$val = Model_Push::validate('add');
			
			if ($val->run()) {
				
				$model = Model_Push::forge(array(
					'push_name' => Input::post('push_name'),
					'push_ticker' => Input::post('push_ticker'),
					'push_title' => Input::post('push_title'),
					'push_message' => Input::post('push_message'),
					'push_start_date' => Common_Util::format_datetime_input2db(Input::post('push_start_date')),
					'push_end_date' => Input::post('push_end_date') ? Common_Util::format_datetime_input2db(Input::post('push_end_date'), '59') : NULL,
					'push_flg' => Input::post('push_flg', 0),
					'reg_date' => date('Y-m-d H:i:s'),
					'upd_date' => date('Y-m-d H:i:s'),
				));
				
				if ( $model->save() ) {
					Session::set_flash('success', '「'.$model->push_name.'」を追加しました。');
				} else {
					Session::set_flash('error', e('登録処理が失敗しました。'));
				}
				
				Response::redirect('admin/push');
			}
			
			$errors = $val->error();
		}
		
		$this->template->set_global('errors', $errors, false);
		
		$this->template->title = "Push通知新規登録";
		$data['mode'] = 'new';
		Asset::js(array('admin/js/form_common.js', 'admin/js/push_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/push/form', $data);
	}

	public function action_edit($id = null)
	{
		$data = array();
		$errors = array();
		
		if ( !is_numeric($id) || is_null($model = Model_Push::find($id)) ) {
			return Response::forge(ViewModel::forge('welcome/404'), 404);
		}
		
		if (Input::method() == 'POST') {

			$val = Model_Push::validate('add');
			
			if ($val->run()) {
				
				$model->push_name = Input::post('push_name');
				$model->push_ticker = Input::post('push_ticker');
				$model->push_title = Input::post('push_title');
				$model->push_message = Input::post('push_message');
				$model->push_start_date = Common_Util::format_datetime_input2db(Input::post('push_start_date'));
				$model->push_end_date = Input::post('push_end_date') ? Common_Util::format_datetime_input2db(Input::post('push_end_date'), '59') : NULL;
				$model->push_flg = Input::post('push_flg', 0);
				$model->upd_date = date('Y-m-d H:i:s');
				
				if ( $model->save() ) {
					Session::set_flash('success', '「'.$model->push_name.'」を更新しました。');
				} else {
					Session::set_flash('error', '登録処理に失敗しました。');
				}
				
				Response::redirect('admin/push');
			}
			
			$errors = $val->error();
		} else {
			$model->push_start_date = Common_Util::format_datetime_db2input($model->push_start_date);
			$model->push_end_date = !empty($model->push_end_date) ? Common_Util::format_datetime_db2input($model->push_end_date) : NULL;
			$data['dbRow'] = $model;
		}
		
		$this->template->set_global('errors', $errors, false);
		
		$this->template->title = "Push通知編集";
		$data['mode'] = 'edit';
		$data['delete_url'] = Uri::base().'admin/push/delete/'.$id;
		Asset::js(array('admin/js/form_common.js', 'admin/js/push_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/push/form', $data);
	}

	public function action_delete($id = null)
	{
		if (!is_numeric($id) || $model = Model_Push::find($id)) {
			
			if ( $model->delete() ) {
				Session::set_flash('success', '「'.$model->push_name.'」を削除しました。');
			} else {
				Session::set_flash('error', '削除処理に失敗しました。');
			}
		} else {
			Session::set_flash('error', '指定されたデータは存在しません。');
		}
				
		Response::redirect('admin/push');
	}


}