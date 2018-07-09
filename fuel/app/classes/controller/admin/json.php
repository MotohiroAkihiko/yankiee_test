<?php
class Controller_Admin_Json extends Controller_Admin{

	public function action_json_viwe()
	{

	    // Ajax通信ではなく、直接URLを叩かれた場合はエラーメッセージを表示
	    if (
	        !(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
	        && (!empty($_SERVER['SCRIPT_FILENAME']) && 'json.php' === basename($_SERVER['SCRIPT_FILENAME']))
	        )
	    {
	        die ('このページは直接ロードしないでください。');
	    }

	    try
	    {

	        // 'users' テーブルのデータを取得する
	        $sql = DB::query('select * from mst_item')->execute()->as_array();

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