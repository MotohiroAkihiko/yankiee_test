<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Fuel\Tasks;

/**
 * ランキング処理 task
 *
 */

class Ranking
{
	/**
	 * 週間ランキング報酬付与バッチ
	 *
	 * @param int $rank_limit
	 * @param string $date_week
	 * @return string
	 */
	public static function weeklyPresent($rank_limit, $date_week=null)
	{
		echo '[Start]'.date('Y-m-d H:i:s') . PHP_EOL;
		\Common_Util::write_info_log('[Start]週間ランキング報酬付与バッチ', 'task');
		
		if ( is_null($date_week) ) {
			// 先週の日付キーを生成
			$dateTime = new \DateTime();
			$dateTime->modify('- 1 week');
			$date_week = self::getWeekString($dateTime);
		}
		
		\Common_Util::write_info_log("  日付キー:$date_week", 'task');

		// ランキング報酬マスタから週間ランキング報酬の情報を取得
		$query = \Model_RankingPresent::query()
					->where('ranking_type', 'weekly')
					->where('ranking_date_key', $date_week);
		
		if ( is_null($rankingPresent = $query->get_one()) ) {
			$ret = 1;
			\Common_Util::write_info_log("  [error:{$ret}]日付キーに該当するランキング報酬マスタが存在しません。", 'task');
			return "error:{$ret}";
		} else {
			// 既に登録済みかチェックする
			$query = \Model_UserRankingHistory::query()
					->where('ranking_present_id', $rankingPresent->id);
			
			\Common_Util::write_info_log("  ランキング報酬ID:{$rankingPresent->id}", 'task');
			if ( !is_null($query->get_one()) ) {
				$ret = 2;
				\Common_Util::write_info_log("  [error:{$ret}]ユーザーランキング履歴に既にデータが存在します。", 'task');
				return "error:{$ret}";
			}
			
			// 週間ランキングを取得
			$rankingList = self::getWeeklyRankingList($date_week, $rank_limit);
			$count = count($rankingList);
			
			if ( $count == 0 ) {
				$ret = 3;
				\Common_Util::write_info_log("  [error:{$ret}]週間ランキングの集計データが存在しません。", 'task');
				return "error:{$ret}";
			}
			
			try {
				\DB::start_transaction();
				
				$now_date = date('Y-m-d H:i:s');
				foreach ( $rankingList as $row ) {
					// ユーザーランキング履歴へ登録
					$m = \Model_UserRankingHistory::forge(array(
							'site_user_id' => $row['site_user_id'],
							'ranking_present_id' => $rankingPresent->id,
							'rank' => $row['rank'],
							'ranking_present_get_date' => $now_date,
							'reg_date' => $now_date,
							'upd_date' => $now_date,
					));
						
					$m->save();
				}
				
				\DB::commit_transaction();
			}catch(\Database_exception $e){
				\DB::rollback_transaction();
			}
		}
		
		\Common_Util::write_info_log("  [sccess]ユーザーランキング履歴に{$count}件のデータを登録しました。", 'task');
		return 'success';
	}
	/**
	 * 月間ランキング報酬付与バッチ
	 *
	 * @param int $rank_limit
	 * @param string $date_ym
	 * @return string
	 */
	public static function monthlyPresent($rank_limit, $date_ym=null)
	{
		echo '[Start]'.date('Y-m-d H:i:s') . PHP_EOL;
		\Common_Util::write_info_log('[Start]月間ランキング報酬付与バッチ', 'task');

		if ( is_null($date_ym) ) {
			// 先月の日付キーを生成
			$dateTime = new \DateTime();
			$dateTime->modify('- 1 month');
			$date_ym = $dateTime->format('Ym');
		}

		\Common_Util::write_info_log("  日付キー:$date_ym", 'task');

		// ランキング報酬マスタから週間ランキング報酬の情報を取得
		$query = \Model_RankingPresent::query()
					->where('ranking_type', 'monthly')
					->where('ranking_date_key', $date_ym);
		
		if ( is_null($rankingPresent = $query->get_one()) ) {
			$ret = 1;
			\Common_Util::write_info_log("  [error:{$ret}]日付キーに該当するランキング報酬マスタが存在しません。", 'task');
			return "error:{$ret}";
		} else {
			// 既に登録済みかチェックする
			$query = \Model_UserRankingHistory::query()
					->where('ranking_present_id', $rankingPresent->id);
			
			\Common_Util::write_info_log("  ランキング報酬ID:{$rankingPresent->id}", 'task');
			if ( !is_null($query->get_one()) ) {
				$ret = 2;
				\Common_Util::write_info_log("  [error:{$ret}]ユーザーランキング履歴に既にデータが存在します。", 'task');
				return "error:{$ret}";
			}
			
			// 月間ランキングを取得
			$rankingList = self::getMonthlyRankingList($date_ym, $rank_limit);
			$count = count($rankingList);
			
			if ( $count == 0 ) {
				$ret = 3;
				\Common_Util::write_info_log("  [error:{$ret}]月間ランキングの集計データが存在しません。", 'task');
				return "error:{$ret}";
			}
			
			try {
				\DB::start_transaction();
				
				$now_date = date('Y-m-d H:i:s');
				foreach ( $rankingList as $row ) {
					// ユーザーランキング履歴へ登録
					$m = \Model_UserRankingHistory::forge(array(
							'site_user_id' => $row['site_user_id'],
							'ranking_present_id' => $rankingPresent->id,
							'rank' => $row['rank'],
							'ranking_present_get_date' => $now_date,
							'reg_date' => $now_date,
							'upd_date' => $now_date,
					));
						
					$m->save();
				}
				
				\DB::commit_transaction();
			}catch(\Database_exception $e){
				\DB::rollback_transaction();
			}
		}
		
		\Common_Util::write_info_log("  [success]ユーザーランキング履歴に{$count}件のデータを登録しました。", 'task');
		return 'success';
	}
	
	/**
	 * 週間を表す文字列(Ymd-Ymd)を取得
	 *
	 * @param string $dateTime
	 * @return string
	 */
	private static function getWeekString($dateTime=null) {
	
		if (is_null($dateTime)) {
			$dateTime = new \DateTime();
		}
	
		$w = $dateTime->format('w');
		$ymd = $dateTime->format('Y-m-d');
	
		if ($w == 0) {
			$d = 6;
		}
		else {
			$d = $w - 1 ;
		}
	
		$monday = new \DateTime($ymd);
		$monday->modify("-{$d} day");
	
		if ($w == 0) {
			$d = 0;
		}
		else {
			$d = 7 - $w;
		}
	
		$sunday = new \DateTime($ymd);
		$sunday->modify("+{$d} day");
	
		return "{$monday->format('Ymd')}-{$sunday->format('Ymd')}";
	}

	/**
	 * 週間ランキング取得
	 * 
	 * @param string $date_week_string
	 * @param int $rank_limit
	 * @return 存在する場合:ランキング情報配列 存在しない場合:false
	 */
	private static function getWeeklyRankingList($date_week_string, $rank_limit) {
		
		$queryString  = " select A.rank, A.site_user_id, A.point from";
		$queryString .= " (select rank() over (order by point desc) as rank, R.site_user_id, point from tbl_user_weekly_point R";
		$queryString .= " inner join tbl_user U on U.site_user_id = R.site_user_id";
		$queryString .= " where date_week = :date_week) A";
		$queryString .= " where rank <= :rank_limit";
		$queryString .= " order by rank, A.site_user_id";

		$bind = array();
		$bind['date_week'] = $date_week_string;
		$bind['rank_limit'] = $rank_limit;
		
		$list = \DB::query($queryString)->parameters($bind)->execute()->as_array();
		
		return $list;
	}

	/**
	 * 先月の月間ランキング
	 * 
	 * @param string $date_ym
	 * @param int $rank_limit
	 * @return 存在する場合:ランキング情報配列 存在しない場合:false
	 */
	private static function getMonthlyRankingList($date_ym, $rank_limit) {
		
		$queryString  = " select A.rank, A.site_user_id, A.point from";
		$queryString .= " (select rank() over (order by point desc) as rank, R.site_user_id, point from tbl_user_monthly_point R";
		$queryString .= " inner join tbl_user U on U.site_user_id = R.site_user_id";
		$queryString .= " where date_ym = :date_ym) A";
		$queryString .= " where rank <= :rank_limit";
		$queryString .= " order by rank, A.site_user_id";

		$bind = array();
		$bind['date_ym'] = $date_ym;
		$bind['rank_limit'] = $rank_limit;
		
		$list = \DB::query($queryString)->parameters($bind)->execute()->as_array();
		
		return $list;
	
		return $this->dbObj->getResultAll();
	}
}

/* End of file tasks/robots.php */
