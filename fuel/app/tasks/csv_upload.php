<?php
namespace Fuel\Tasks;
use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;


class csv_upload
{

    public static function run($item_data = '\item_data.csv') {

        echo '[Start]'.date('Y-m-d H:i:s') . PHP_EOL;
        \Common_Util::write_info_log('[Start]CSVアップロード開始', 'task');

        $buf = file_get_contents('C:\xampp\htdocs\fuelphp\public\yankiee_test\trunk\html\tools\assets\admin\csv{$item_data}');
        $buf = preg_replace("/\r\n|\r|\n/", "\n", $buf);
        $fp = tmpfile();
        fwrite($fp, $buf);
        rewind($fp);

        $sql = DB::query('select id from mst_item order by id asc')->execute()->as_array('id');

        try{
            DB::start_transaction();
            //配列に変換する
            while (($data = fgetcsv($fp, 0, ',')) !== FALSE)
            {
                if($data[0] != "ID"){

                    mb_convert_variables('UTF-8', 'SJIS-win', $data);

                    if(empty($data[7])){
                        $data[7] = null;
                    }

                    if(!empty($data[1]) && !empty($data[2]) && !empty($data[3]) && !empty($data[4])
                        && !empty($data[5]) && !empty($data[6]) && !empty($data[11])){

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
                        DB::rollback_transaction();
                        \Log::warning("必要な項目に値が入っていないところがあります。");
                        return 'errer';
                    }
                }

            }

            DB::commit_transaction();
            fclose($fp);

        }catch (Exception $e){
            DB::rollback_transaction();
            \Log::warning("CSVファイルの構成に誤りがあります。");
            return 'errer';
        }


        \Common_Util::write_info_log('[End]CSVアップロード完了', 'task');
        return 'success';
    }
}