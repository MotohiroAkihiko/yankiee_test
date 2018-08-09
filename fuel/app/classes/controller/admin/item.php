<?php
class Controller_Admin_Item extends Controller_Admin{

    public function action_index()
	{
	    Asset::js(array('admin/js/loading.js'), array(), 'add_js');
		$data = array();

		// 入力値取得
		$keyword = Input::get('keyword');
		$keyword_id = mb_convert_kana(Input::get('keyword_id'), 'kvrn');
		$pub = Input::get('pub');

		// 再検索URL生成用パラメータ
		$param = array();
		!empty($keyword) and $param['keyword'] = $keyword;
		!empty($keyword_id) and $param['keyword_id'] = $keyword_id;
		!empty($pub) and $param['pub'] = $pub;

		// リストデータ取得クエリ
		$query = DB::select('*')
		->from('mst_item')
		->where('del_flg', '0')
		->order_by('publish_start_date','desc')->order_by('id', 'desc');

		// キーワード検索
		if ( !empty($keyword) ) {
			$query->where_open()
			->where('item_name', 'like', "%$keyword%")
			->or_where('item_details', 'like', "%$keyword%")
			->where_close();
		}

		// キーワード検索 ID
		if(preg_match('/[0-9]/',$keyword_id)){
		    if ( !empty($keyword_id) ) {
		        $query->where_open()
		        ->where('id',"$keyword_id")
		        ->where_close();
		    }
		} else if(!preg_match('/[0-9]/',$keyword_id) && $keyword_id != ""){
		    Session::set_flash('errer', 'ID検索に数字以外が入力されてます。');
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
			$rowTmp['item_details'] = strip_tags($row['item_details']);
			$data['list'][] = $rowTmp;
		}

		$this->template->title = "商品一覧";
		$data['item_category'] = array("1" => "食べ物", "2" => "季節もの", "3" => "ヤンキー");
		$data['delete_url'] = Uri::base().'admin/item/delete/';
		$data['download_url'] = Uri::base().'admin/item/csv_download/';
		$data['upload_url'] = Uri::base().'admin/item/csv_upload/';
		Asset::js(array('admin/js/form_common.js', 'admin/js/item_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css','admin/css/loading.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/item/index', $data);
	}

	public function action_add()
	{
		$data = array();
		$errors = array();

		if (Input::method() == 'POST') {

		    $val = Validation::forge();

		    $val->add('item_name', 'アイテム名')
		    ->add_rule('required')
		    ->add_rule('max_length[200]');

		    $val->add('item_details', 'アイテム説明')
		    ->add_rule('required')
		    ->add_rule('max_length[1000]');

		    $val->add('publish_start_date', '公開期間（開始）')
		    ->add_rule('required')
		    ->add_rule('valid_date[Y-m-d H:i]');

		    $val->add('publish_end_date', '公開期間（終了）')
		    ->add_rule('valid_date[Y-m-d H:i]')
		    ->add_rule('date_time');

		    $val->add('item_category_id', 'カテゴリー')
		    ->add_rule('required')
		    ->add_rule('max_length[10]')
		    ->add_rule('item_number')
		    ->add_rule('category_num');

		    $val->add('item_expire_seconds', 'アイテム有効期限(秒)')
		    ->add_rule('required')
		    ->add_rule('max_length[10]')
		    ->add_rule('item_number')
		    ->add_rule('category_num');

		    $val->add('item_point_up_rate', 'ポイントアップ率')
		    ->add_rule('required')
		    ->add_rule('max_length[10]')
		    ->add_rule('item_number');

		    $val->add('upload','アイコン')
		    ->add_rule('item_data');

               if ($val->run())
               {

                   $config = array(
                       'path' => DOCROOT.'assets/admin/img/photo/',
                       'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
                   );

                   Upload::process($config);

                   if (Upload::is_valid())
                   {

                      Upload::save();

                       foreach (Upload::get_files() as $file)
                       {

            				 try{

            				    DB::start_transaction();

            				    $model = Model_Item::forge(array(
            				        'item_name' => htmlspecialchars(Input::post('item_name'), ENT_QUOTES, 'UTF-8'),
            				        'item_details' => Input::post('item_details'),
            				        'publish_start_date' => Common_Util::format_datetime_input2db(Input::post('publish_start_date')),
            				        'publish_end_date' => Input::post('publish_end_date') ? Common_Util::format_datetime_input2db(Input::post('publish_end_date'), '59') : NULL,
            				        'del_flg' => 0,
            				        'reg_date' => date('Y-m-d H:i:s'),
            				        'upd_date' => date('Y-m-d H:i:s'),
            				        'item_category_id' => mb_convert_kana(Input::post('item_category_id'), 'kvrn'),
            				        'item_expire_seconds' => mb_convert_kana(Input::post('item_expire_seconds'), 'kvrn'),
            				        'item_point_up_rate' => mb_convert_kana(Input::post('item_point_up_rate'), 'kvrn'),
            				        'photo_saved_as' => $file['saved_as'],
            				    ));

            				    DB::commit_transaction();

            				}
            				catch (Exception $e)
            				{
            				    DB::rollback_transaction();
            				    Session::set_flash('error', '現在編集中です');
            				    Response::redirect('admin/item');
            				}

            				if ( $model->save() ) {
            					Session::set_flash('success', '「'.$model->item_name.'」を追加しました。');
            				} else {
            					Session::set_flash('error', e('登録処理が失敗しました。'));
            				}
            	           Response::redirect('admin/item');
                        }
                    }
    			}
			$errors = $val->error();
		  }

		$this->template->set_global('errors', $errors, false);

		$this->template->title = "商品新規登録";
		$data['mode'] = 'new';
		Asset::js(array('admin/js/form_common.js', 'admin/js/item_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/item/form', $data);
	}

	public function action_edit($id = null)
	{
		$data = array();
		$errors = array();

		if ( !is_numeric($id) || is_null($model = Model_Item::find($id)) ) {
			return Response::forge(ViewModel::forge('welcome/404'), 404);
		}

		if (Input::method() == 'POST') {

		    $val = Validation::forge();

		    $val->add('item_name', 'アイテム名')
		    ->add_rule('required')
		    ->add_rule('max_length[200]');

		    $val->add('item_details', 'アイテム説明')
		    ->add_rule('required')
		    ->add_rule('max_length[1000]');

		    $val->add('publish_start_date', '公開期間（開始）')
		    ->add_rule('required')
		    ->add_rule('valid_date[Y-m-d H:i]');

		    $val->add('publish_end_date', '公開期間（終了）')
		    ->add_rule('valid_date[Y-m-d H:i]')
		    ->add_rule('date_time');

		    $val->add('item_category_id', 'カテゴリー')
		    ->add_rule('required')
		    ->add_rule('max_length[10]')
		    ->add_rule('item_number')
		    ->add_rule('category_num');

		    $val->add('item_expire_seconds', 'アイテム有効期限(秒)')
		    ->add_rule('required')
		    ->add_rule('max_length[10]')
		    ->add_rule('item_number');


		    $val->add('item_point_up_rate', 'ポイントアップ率')
		    ->add_rule('required')
		    ->add_rule('max_length[10]')
		    ->add_rule('item_number');

		    $val->add('upload','アイコン')
		    ->add_rule('item_data');

    			if ($val->run()) {

    			    $config = array(
    			        'path' => DOCROOT.'assets/admin/img/photo/',
    			        'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
    			    );

    			    Upload::process($config);

    			    if (Upload::is_valid())
    			    {
    			        Upload::save();

    			        foreach (Upload::get_files() as $file)
    			        {
    			            try{

        			            DB::start_transaction();

                			    $model->item_name = htmlspecialchars(Input::post('item_name'), ENT_QUOTES, 'UTF-8');
                				$model->item_details = Input::post('item_details');
                				$model->publish_start_date = Common_Util::format_datetime_input2db(Input::post('publish_start_date'));
                				$model->publish_end_date = Input::post('publish_end_date') ? Common_Util::format_datetime_input2db(Input::post('publish_end_date'), '59') : NULL;
                				$model->upd_date = date('Y-m-d H:i:s');
                				$model->item_category_id = mb_convert_kana(Input::post('item_category_id'), 'kvrn');
                				$model->item_expire_seconds = mb_convert_kana(Input::post('item_expire_seconds'), 'kvrn');
                				$model->item_point_up_rate = mb_convert_kana(Input::post('item_point_up_rate'), 'kvrn');
                				$model->photo_saved_as = $file['saved_as'];

                				DB::commit_transaction();

    			            }
    			            catch (Exception $e)
    			            {
			                    DB::rollback_transaction();
			                    Session::set_flash('error', '現在編集中です');
			                    Response::redirect('admin/item');
    			            }

            				if ( $model->save() ) {
            					Session::set_flash('success', '「'.$model->item_name.'」を更新しました。');
            				} else {
            				    Session::set_flash('error', e('登録処理が失敗しました。'));
            				}
            				Response::redirect('admin/item');
            			}
	                 }
			}
			$errors = $val->error();

		} else {
			$model->publish_start_date = Common_Util::format_datetime_db2input($model->publish_start_date);
			$model->publish_end_date = !empty($model->publish_end_date) ? Common_Util::format_datetime_db2input($model->publish_end_date) : NULL;
			$data['dbRow'] = $model;
		}

		$this->template->set_global('errors', $errors, false);

		$this->template->title = "商品編集";
		$data['item'] = $model->photo_saved_as;
		$data['mode'] = 'edit';
		$data['delete_url'] = Uri::base().'admin/item/delete/'.$id;
		Asset::js(array('admin/js/form_common.js', 'admin/js/item_form.js', 'admin/bower_components/datetimepicker/jquery.datetimepicker.js'), array(), 'add_js');
		Asset::css(array('admin/bower_components/datetimepicker/jquery.datetimepicker.css'), array(), 'add_css');
		$this->template->content = View::forge('admin/item/form', $data);
	}

	public function action_delete($id = null)
	{

	    if (!is_numeric($id) || $model = Model_Item::find($id)) {

        try{
            DB::start_transaction();

            DB::query('select * from mst_item where id ='.$model->id.' for update')->execute();

 			$model->del_flg = 1;
 			$model->upd_date = date('Y-m-d H:i:s');

 			DB::commit_transaction();

	        }
	        catch (Exception $e)
	        {
	            // 未決のトランザクションクエリをロールバックする
	            DB::rollback_transaction();
	            Session::set_flash('error', '現在編集中です');
	            Response::redirect('admin/item');
	        }

 			if ( $model->save() ) {
 				Session::set_flash('success', '「'.$model->item_name.'」を削除しました。');
 			} else {
				Session::set_flash('error', '削除処理に失敗しました。');
 			}

 		} else {
 			Session::set_flash('error', '指定されたデータは存在しません。');
		}
		Response::redirect('admin/item');
	}

	public static function action_csv_download(){

	    $keyword = Input::post('keyword');
	    $keyword_id = mb_convert_kana(Input::post('keyword_id'), 'kvrn');

	    if(!empty($keyword_id) && !empty($keyword)){
	        $sql = DB::query("select * from mst_item where id = '".$keyword_id."' and item_name LIKE '%".$keyword."%' or item_details LIKE '%".$keyword."%' order by id asc")->execute();
	    } else if(!empty($keyword_id)){
	        $sql = DB::query('select * from mst_item where id = '.$keyword_id.' order by id asc')->execute();
	    } else if(!empty($keyword)){
	        $sql = DB::query("select * from mst_item where item_name LIKE '%".$keyword."%' or item_details LIKE '%".$keyword."%' order by id asc")->execute();
	    } else {
	        $sql = DB::query('select * from mst_item order by id asc')->execute();
	    }

	    $data[] = array('ID','アイテム名','カテゴリーID','アイテム説明'
	        ,'ポイントアップ率','アイテム有効期限','公開期間（開始）'
	        ,'公開期間（終了)','削除フラグ','登録日時','更新日時'
	        ,'アイコン名',);

	    foreach ( $sql as $row ) {
            $data[] = array($row['id'],$row['item_name'],$row['item_category_id'],$row['item_details']
                ,$row['item_point_up_rate'],$row['item_expire_seconds'],$row['publish_start_date']
                ,$row['publish_end_date'],$row['del_flg'],$row['reg_date'],$row['upd_date']
                ,$row['photo_saved_as'],);
	    }

	    // Response
	    $response = new Response();

	    // content-type: csv
	    $response->set_header('Content-Type', 'application/csv');

	    // ファイル名をセット
	    $response->set_header('Content-Disposition', 'attachment; filename="item_data.csv"');

	    // CSVを出力
	    echo Format::forge($data)->to_csv();

	    // Response
	    return $response;
	}

	public function action_csv_upload()
	{
	    if (is_uploaded_file($_FILES["csv"]["tmp_name"]))
	    {
	        $file_name = $_FILES["csv"]["name"];
	        $file_tmp_name = $_FILES["csv"]["tmp_name"];

	        //拡張子を判定
	        if (pathinfo($file_name, PATHINFO_EXTENSION) != 'csv')
	        {
	            Session::set_flash('error', 'CSV形式のみ対応してます。');
	        }
	        else
	        {
	            $buf = file_get_contents($file_tmp_name);
	            $buf = preg_replace("/\r\n|\r|\n/", "\n", $buf);
	            $fp = tmpfile();
	            fwrite($fp, $buf);
	            rewind($fp);

	            $sql = DB::query('select id from mst_item order by id asc')->execute()->as_array('id');

	            try{
	                DB::start_transaction();

	                while (($data = fgetcsv($fp, 0, ',')) !== FALSE)
	                {
	                    if($data[0] != "ID"){
	                            mb_convert_variables('UTF-8', 'SJIS-win', $data);

	                            if(empty($data[7])){
	                                $data[7] = null;
	                            }

	                            if(empty($data[1])){
	                                Session::set_flash('error', 'アイテム名に値が入力されてない箇所があります。');
	                                Response::redirect('admin/item');
	                            }
	                            if(empty($data[2])){
	                                Session::set_flash('error', 'カテゴリーIDに値が入力されてない箇所があります。');
	                                Response::redirect('admin/item');
	                            }
	                            if(empty($data[3])){
	                                Session::set_flash('error', 'アイテム説明に値が入力されてない箇所があります。');
	                                Response::redirect('admin/item');
	                            }
	                            if(empty($data[4])){
	                                Session::set_flash('error', 'ポイントアップ率に値が入力されてない箇所があります。');
	                                Response::redirect('admin/item');
	                            }
	                            if(empty($data[5])){
	                                Session::set_flash('error', 'アイテム有効期限に値が入力されてない箇所があります。');
	                                Response::redirect('admin/item');
	                            }
	                            if(empty($data[6])){
	                                Session::set_flash('error', '公開期間（開始）に値が入力されてない箇所があります。');
	                                Response::redirect('admin/item');
	                            }
	                            if(empty($data[11])){
	                                Session::set_flash('error', 'アイコン名に値が入力されてない箇所があります。');
	                                Response::redirect('admin/item');
	                            }
	                            $i = $i + 1;
	                            if(empty($sql[$data[0]]) == true){

	                                $rec1 = array('item_name' => $data[1], 'item_category_id' => $data[2]
	                                    , 'item_details' => $data[3], 'item_point_up_rate' => $data[4]
	                                    , 'item_expire_seconds' => $data[5], 'publish_start_date' => $data[6]
	                                    , 'publish_end_date' => $data[7], 'del_flg' => $data[8], 'reg_date' => $data[9]
	                                    , 'upd_date' => $data[10], 'photo_saved_as' => $data[11]
	                                );

	                                DB::insert('mst_item')->set($rec1)->execute();
	                            } else {

	                                $rec2 = array('item_name' => $data[1], 'item_category_id' => $data[2]
	                                    , 'item_details' => $data[3], 'item_point_up_rate' => $data[4]
	                                    , 'item_expire_seconds' => $data[5], 'publish_start_date' => $data[6]
	                                    , 'publish_end_date' => $data[7], 'del_flg' => $data[8], 'reg_date' => $data[9]
	                                    , 'upd_date' => $data[10], 'photo_saved_as' => $data[11]
	                                );

	                                DB::update('mst_item')->set($rec2)->where('id',$data[0])->execute();
	                            }
	                        } else {
	                            Response::redirect('admin/item');
	                        }
	                }
	                fclose($fp);
	                DB::commit_transaction();
	                Session::set_flash('success', 'アップロードに成功しました。');
	                Response::redirect('admin/item');

	            }catch (Exception $e){
	                DB::rollback_transaction();
	                Session::set_flash('error', 'アップロードに失敗しました。');
	                Response::redirect('admin/item');
	            }
	        }
	    }
	    else
	    {
	        Session::set_flash('error', 'ファイルが選択されていません。');
	    }

	    Response::redirect('admin/item');
	}


}