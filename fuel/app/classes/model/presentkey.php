<?php
class Model_PresentKey extends \Orm\Model
{
	protected static $_table_name = 'tbl_present_detail';
	protected static $_primary_key = array('present_detail_id');
	
	public $seq_name = 'tbl_present_detail_present_detail_id_seq';
	
	protected static $_properties = array(
		'present_detail_id',
		'present_data_id',
		'key',
		'win_id',
		'reg_date',
		'upd_date',
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('key', '当選シリアル', "required|max_length[100]")->add_rule('valid_string', array('alpha', 'numeric'), '半角英数字');
		
		return $val;
	}

}
