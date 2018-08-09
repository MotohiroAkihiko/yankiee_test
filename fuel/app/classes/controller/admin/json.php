<?php
class Controller_Admin_Json extends Controller_Admin{

	public function action_json_viwe()
	{
	    try
	    {
	        // 'users' テーブルのデータを取得する
	        $sql = DB::query('select * from mst_item where not del_flg = 1 order by id asc')->execute()->as_array();

	        // JSON形式で出力する
	        header('Content-Type: application/json');
	        echo json_encode( $sql);
	        exit;
	    }
	    catch (PDOException $e)
	    {
	        // 例外処理
	        die('Error:' . $e->getMessage());
	    }
	}
}