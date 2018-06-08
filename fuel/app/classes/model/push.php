<?php
class Model_Push extends \Orm\Model
{
	protected static $_table_name = 'tbl_ausp_push';
	protected static $_primary_key = array('push_id');
	
	public $seq_name = 'tbl_ausp_push_push_id_seq';
	
	protected static $_properties = array(
		'push_id',
		'push_name',
		'push_ticker',
		'push_title',
		'push_message',
		'push_start_date',
		'push_end_date',
		'push_flg',
		'reg_date',
		'upd_date',
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('push_name', '通知名称', "required|mb_max_length[16]");
		$val->add_field('push_ticker', '通知ティッカー', "required|mb_max_length[16]");
		$val->add_field('push_title', '通知タイトル', "required|mb_max_length[16]");
		$val->add_field('push_message', '通知メッセージ', "required|mb_max_length[25]");
		$val->add_field('push_start_date', '通知配信開始日時', "required|valid_date[Y-m-d H:i]");
		$val->add_field('push_end_date', '通知配信終了日時', "valid_date[Y-m-d H:i]");
		$val->add_field('push_flg', '配信フラグ', "exact_length[1]");
		
		return $val;
	}

}
