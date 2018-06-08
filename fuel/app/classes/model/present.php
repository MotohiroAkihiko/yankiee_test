<?php
class Model_Present extends \Orm\Model
{
	protected static $_table_name = 'mst_present_data';
	protected static $_primary_key = array('present_data_id');
	
	public $seq_name = 'mst_present_data_present_data_id_seq';
	
	protected static $_properties = array(
		'present_data_id',
		'present_id',
		'present_data_name',
		'present_data_txt',
		'del_flg',
		'reg_date',
		'upd_date',
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('present_data_name', '景品名', "required|max_length[200]");
		$val->add_field('present_data_txt', '景品説明', "required|max_length[1000]");
		
		return $val;
	}

}
