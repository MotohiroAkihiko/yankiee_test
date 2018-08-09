<?php
class Controller_Admin_Count extends Controller_Admin{

    public function action_count_data()
    {
        try
        {
            $directory = DOCROOT.'assets/admin/csv/';
            $filecount = 0;
            $files = glob($directory . "*");
            if ($files){
                $filecount = count($files);
            }

            // JSON形式で出力する
            header('Content-Type: application/json');
            echo json_encode($filecount);
            exit;
        }
        catch (PDOException $e)
        {
            // 例外処理
            die('Error:' . $e->getMessage());
        }
    }
}