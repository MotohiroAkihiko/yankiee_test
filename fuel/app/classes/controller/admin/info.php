<?php
class Controller_Admin_Info extends Controller_Admin{

    public function action_index()
	{
		$data = array();

		// 入力値取得
		$keyword = Input::get('keyword');
		$keyword_id = Input::get('keyword_id');
		$pub = Input::get('pub');

		// 再検索URL生成用パラメータ
		$param = array();
		!empty($keyword) and $param['keyword'] = $keyword;
		!empty($keyword_id) and $param['keyword_id'] = $keyword_id;
		!empty($pub) and $param['pub'] = $pub;

		// リストデータ取得クエリ
		$query = DB::select('*')
		->from('tbl_info')
		->where('del_flg', '0')
		->order_by('publish_start_date','desc')->order_by('id', 'desc');

		// キーワード検索
		if ( !empty($keyword) ) {
			$query->where_open()
			->where('info_title', 'like', "%$keyword%")
			->or_where('info_details', 'like', "%$keyword%")
			->where_close();
		}

		// キーワード検索 ID
		if ( !empty($keyword_id) ) {
		    $query->where_open()
		    ->where('id', mb_convert_kana("$keyword_id", 'kvrn'))
		    ->where_close();
		}

		// 公開中のみ表示
		if ( !empty($pub) ) {
			$query->where('publish_start_date', '<=', date('Y-m-d H:i:s'))
			->where_open()
			->where('publish_end_date', '>=', date('Y-m-d H:i:s'))
			->or_where('publish_end_date', NULL)
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

		// 一覧に省略表示するためお知らせ内容、HTMLタグ除去
		$data['list'] = array();
		foreach ( $list as $row ) {
			$rowTmp = $row;
			$rowTmp['info_details'] = strip_tags($row['info_details']);
			$data['list'][] = $rowTmp;
		}
		$this->template->title = "お知らせ一覧";
		$data['delete_url'] = Uri::base().'admin/info/delete/';
		Asset::js(array('admin/js/form_common.js', 'admin/js/info_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/info/index', $data);
	}

	public function action_add()
	{
		$data = array();
		$errors = array();

		if (Input::method() == 'POST') {

			$val = Model_Info::validate('add');

			if ($val->run()) {

				$model = Model_Info::forge(array(
					'info_date' => Common_Util::format_datetime_input2db(Input::post('publish_start_date')),
				    'info_title' => htmlspecialchars(Input::post('info_title'), ENT_QUOTES, 'UTF-8'),
					'info_details' => Input::post('info_details'),
					'publish_start_date' => Common_Util::format_datetime_input2db(Input::post('publish_start_date')),
					'publish_end_date' => Input::post('publish_end_date') ? Common_Util::format_datetime_input2db(Input::post('publish_end_date'), '59') : NULL,
					'del_flg' => 0,
					'reg_date' => date('Y-m-d H:i:s'),
					'upd_date' => date('Y-m-d H:i:s'),
				    'info_category' => Input::post('info_category'),
				));

				if ( $model->save() ) {
					Session::set_flash('success', '「'.$model->info_title.'」を追加しました。');
				} else {
					Session::set_flash('error', e('登録処理が失敗しました。'));
				}

				Response::redirect('admin/info');
			}

			$errors = $val->error();
		}

		$this->template->set_global('errors', $errors, false);

		$this->template->title = "お知らせ新規登録";
		$data['mode'] = 'new';
		Asset::js(array('admin/js/form_common.js', 'admin/js/info_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/info/form', $data);
	}

	public function action_edit($id = null)
	{
		$data = array();
		$errors = array();

		if ( !is_numeric($id) || is_null($model = Model_Info::find($id)) ) {
			return Response::forge(ViewModel::forge('welcome/404'), 404);
		}

		if (Input::method() == 'POST') {

			$val = Model_Info::validate('add');

			if ($val->run()) {

				$model->info_date = Common_Util::format_datetime_input2db(Input::post('publish_start_date'));
				$model->info_title = Input::post('info_title');
				$model->info_details = Input::post('info_details');
				$model->publish_start_date = Common_Util::format_datetime_input2db(Input::post('publish_start_date'));
				$model->publish_end_date = Input::post('publish_end_date') ? Common_Util::format_datetime_input2db(Input::post('publish_end_date'), '59') : NULL;
				$model->upd_date = date('Y-m-d H:i:s');
				$model->info_category = Input::post('info_category');

				if ( $model->save() ) {
					Session::set_flash('success', '「'.$model->info_title.'」を更新しました。');
				} else {
					Session::set_flash('error', '登録処理に失敗しました。');
				}

				Response::redirect('admin/info');
			}

			$errors = $val->error();
		} else {
			$model->publish_start_date = Common_Util::format_datetime_db2input($model->publish_start_date);
			$model->publish_end_date = !empty($model->publish_end_date) ? Common_Util::format_datetime_db2input($model->publish_end_date) : NULL;
			$data['dbRow'] = $model;
		}

		$this->template->set_global('errors', $errors, false);

		$this->template->title = "お知らせ編集";
		$data['mode'] = 'edit';
		$data['delete_url'] = Uri::base().'admin/info/delete/'.$id;
		Asset::js(array('admin/js/form_common.js', 'admin/js/info_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/info/form', $data);
	}

	public function action_delete($id = null)
	{
		if (!is_numeric($id) || $model = Model_Info::find($id)) {

 			$model->del_flg = 1;
 			$model->upd_date = date('Y-m-d H:i:s');

 			if ( $model->save() ) {
 				Session::set_flash('success', '「'.$model->info_title.'」を削除しました。');
 			} else {
				Session::set_flash('error', '削除処理に失敗しました。');
 			}
 		} else {
 			Session::set_flash('error', '指定されたデータは存在しません。');
		}

		Response::redirect('admin/info');
	}


}