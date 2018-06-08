<?php
class Model_User extends \Orm\Model
{
	protected static $_table_name = 'tbl_user';
	protected static $_primary_key = array('site_user_id');
	
	protected static $_properties = array(
		'site_user_id',
		'user_id',
		'ausp_flg',
		'nick_name',
		'school_id',
		'character_id',
		'last_login_date',
		'reg_date',
		'upd_date',
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		return $val;
	}
	
	/*
	 * 学校別のユーザー数
	 */
	public static function getSchoolUserCount() {
		
		$query = DB::select('school_id')
					->select(DB::expr('COUNT(*) as count'))
					->from('tbl_user')
					->group_by('school_id')
					->order_by('school_id','asc');
		
		return $query->execute()->as_array('school_id');
	}

}
