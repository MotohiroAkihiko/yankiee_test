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
	    'info_category',
	);
}
