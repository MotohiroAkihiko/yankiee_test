<?php
class Model_UserRankingHistory extends \Orm\Model
{
	protected static $_table_name = 'tbl_user_ranking_history';
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'site_user_id',
		'ranking_present_id',
		'rank',
		'ranking_present_get_date',
		'ranking_present_date',
		'reg_date',
		'upd_date',
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		
		return $val;
	}

}
