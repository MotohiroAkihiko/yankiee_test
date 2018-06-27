<?php
/**
 * 拡張バリデーションクラス
 *
 */
class Validation extends \Fuel\Core\Validation
{
    /**
     * Minimum string width
     *
     * @param   string
     * @param   int
     * @return  bool
     */
    public static function _validation_mb_min_length($val, $length)
    {
        return Validation::_empty($val) || (MBSTRING ? mb_strwidth($val) : strlen($val)*2) >= $length;
    }

    /**
     * Maximum string width
     *
     * @param   string
     * @param   int
     * @return  bool
     */
    public static function _validation_mb_max_length($val, $length)
    {
        return Validation::_empty($val) || (MBSTRING ? mb_strwidth($val) : strlen($val)*2) <= $length;
    }

    /**
     * Exact string width
     *
     * @param   string
     * @param   int
     * @return  bool
     */
    public static function _validation_mb_exact_length($val, $length)
    {
        return Validation::_empty($val) || (MBSTRING ? mb_strwidth($val) : strlen($val)*2) == $length;
    }

    /**
     * form_error
     *
     * @param string
     * @param int
     * @return bool
     */
    public static function _validation_form_error($val)
    {
        $query = DB::select('*')
        ->from('ng_word')->execute();

        $val_ = preg_replace("/( |　)/", "", $val );

            foreach ( $query as $row ){
                if(strpos($val_,$row['wordname']) !== false){
                    return false;
                }
             }
    }

    public static function _validation_date_time(){
        $start = Input::post('publish_start_date');
        $end = Input::post('publish_end_date');
        if($start > $end && $end != ""){
            return false;
        }
    }

    public static function _validation_item_number($val){
        if(!preg_match("/[0-9０-９]/", $val)){
            return false;
        }
    }

    public static function _validation_category_num($val){
        if($val > 3){
            return false;
        }
    }

}