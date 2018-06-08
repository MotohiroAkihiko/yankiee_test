<?php
class Common_Util
{
	public static function _init()
	{
	}
	
	/**
	 * INFOログを強制出力（設定を一時的に変更）
	 * 
	 * @param string $message
	 * @param string $dirname
	 * @return void
	 */
	public static function write_info_log($message, $dirname=null)
	{
		// 既存設定を退避
		$log_threshold = \Config::get('log_threshold');
		$log_path = \Config::get('log_path');
		
		// ログレベルをINFOに変更
		\Config::set('log_threshold', \Fuel::L_INFO);
		
		// ディレクトリ指定がある場合、ログ出力先を変更
		if ( !is_null($dirname) ) {
			\Config::set('log_path', \Config::get('log_path').$dirname.'/');
		}

		// ログクラスを初期化して、INFOログを出力
		\Log::_init();
		\Log::info($message);
		
		// ログクラスの設定を元に戻す
		\Config::set('log_threshold', $log_threshold);
		\Config::set('log_path', $log_path);
		\Log::_init();
		
		return;
	}
	
	/**
	 * DBから取得した日付フォーマットを入力フォーム用に変換
	 * 
	 * @param string $datetime Y-m-d H:i:s
	 * @return string Y-m-dTH:i
	 */
	public static function format_datetime_db2input($datetime)
	{
		$datetime = DateTime::createFromFormat('Y-m-d H:i:s', $datetime);
		
		return $datetime->format('Y-m-d H:i');
	}
	
	/**
	 * 入力フォームから取得した日付フォーマットをDB登録用に変換
	 * 
	 * @param string $datetime Y-m-dTH:i
	 * @param string $minute 分
	 * @return string Y-m-d H:i:s
	 */
	public static function format_datetime_input2db($datetime, $minute='00')
	{
		$datetime = DateTime::createFromFormat('Y-m-d H:i', $datetime);
		
		return $datetime->format('Y-m-d H:i').':'.$minute;
	}
}