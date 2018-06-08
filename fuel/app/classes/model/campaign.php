<?php
class Model_Campaign extends \Orm\Model
{
	protected static $_table_name = 'mst_present';
	protected static $_primary_key = array('present_id');
	
	public $seq_name = 'mst_present_present_id_seq';
	
	protected static $_properties = array(
		'present_id',
		'present_name',
		'present_code',
		'present_start_date',
		'present_end_date',
		'result_start_date',
		'result_end_date',
		'del_flg',
		'reg_date',
		'upd_date',
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('present_name', 'キャンペーン名', "required|max_length[200]");
		$val->add_field('present_code', 'キャンペーンコード', "required|max_length[100]")->add_rule('valid_string', array('alpha', 'numeric'), '半角英数字');
		$val->add_field('present_start_date', '応募期間（開始）', "required|valid_date[Y-m-d H:i]");
		$val->add_field('present_end_date', '応募期間（終了）', "required|valid_date[Y-m-d H:i]");
		$val->add_field('result_start_date', '結果発表期間（開始）', "required|valid_date[Y-m-d H:i]");
		$val->add_field('result_end_date', '結果発表期間（終了）', "required|valid_date[Y-m-d H:i]");
		
		return $val;
	}

}
