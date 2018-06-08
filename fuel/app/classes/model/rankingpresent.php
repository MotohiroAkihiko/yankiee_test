<?php
class Model_RankingPresent extends \Orm\Model
{
	protected static $_table_name = 'mst_ranking_present';
	protected static $_primary_key = array('id');
	
	protected static $_properties = array(
		'id',
		'ranking_type',
		'ranking_date_key',
		'ranking_present_data',
		'reg_date',
		'upd_date',
	);
	
	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('ranking_type', 'タイプ', "required");
		$val->add_field('ranking_date_key', '日付キー', "required");
		$val->add_field('ranking_present_data', 'ランキング報酬データ', "required");
		
		return $val;
	}

}
