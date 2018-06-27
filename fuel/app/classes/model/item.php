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
	    'edit',
	    'user_name',
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('item_name', 'アイテム名', "required|max_length[200]");
		$val->add_field('item_details', 'アイテム説明', "required|max_length[1000]");
		$val->add_field('publish_start_date', '公開期間（開始）', "required|valid_date[Y-m-d H:i]");
		$val->add_field('publish_end_date', '公開期間（終了）', "valid_date[Y-m-d H:i]|date_time");
		$val->add_field('item_category_id', 'カテゴリー', "required|max_length[10]|category_num");
		$val->add_field('item_expire_seconds', 'アイテム有効期限(秒)', "required|max_length[10]|item_number|category_num");
		$val->add_field('item_point_up_rate', 'ポイントアップ率', "required|max_length[10]|item_number");

		return $val;
	}

}
