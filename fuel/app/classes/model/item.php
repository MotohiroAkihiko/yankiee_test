<?php
class Model_Item extends \Orm\Model
{
	protected static $_table_name = 'mst_item';
	protected static $_primary_key = array('id');

	protected static $_properties = array(
		'id',
		'item_name',
		'item_category_id',
		'item_details',
		'item_point_up_rate',
		'item_expire_seconds',
		'publish_start_date',
		'publish_end_date',
		'del_flg',
	    'reg_date',
	    'upd_date',
	    'photo_saved_as',
	);

}
