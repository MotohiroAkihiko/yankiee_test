<?php
class Model_Info extends \Orm\Model
{
	protected static $_table_name = 'tbl_info';
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'info_date',
		'info_title',
		'info_details',
		'publish_start_date',
		'publish_end_date',
		'del_flg',
		'reg_date',
		'upd_date',
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('info_title', 'お知らせタイトル', "required|max_length[200]");
		$val->add_field('info_details', 'お知らせ内容', "required|max_length[1000]");
		$val->add_field('publish_start_date', '公開期間（開始）', "required|valid_date[Y-m-d H:i]");
		$val->add_field('publish_end_date', '公開期間（終了）', "valid_date[Y-m-d H:i]");
		
		return $val;
	}

}
