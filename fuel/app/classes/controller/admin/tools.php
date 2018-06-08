<?php
class Controller_Admin_Tools extends Controller_Admin{

	protected $auth_group = array('4q','admin');

	public function action_info()
	{
		$data = array();
		$data['errors'] = array();
		
		$insert_query = '';
		
		if ( !is_null( ($infoTsv = Input::post('info_tsv') ) ) ) {
			$sql_format = 'INSERT INTO tbl_info (info_date, info_title, info_details, publish_start_date, publish_end_date) VALUES (##info_date##, ##info_title##, ##info_details##, ##publish_start_date##, ##publish_end_date##);';
	
			$info_details_format = '<p style=" margin-right:auto; margin-left:auto; width:80%;">
##text##</p>
<div style="text-align:center; padding-top:35px; padding-bottom:15px; ">
<a href="<?=$tagObj->getUrl(\'\'##url##\'\')?>">
<?=$tagObj->getImgClass(\'\'##img##\'\',\'\'\'\')?></a></div>';
			
			$csv  = array();
			$tsvList = explode(PHP_EOL, $infoTsv);
			
			$imgList = array();
			$imgList['挑戦する！'] = 'img/support/challenge.png';
			$imgList['マンスリーミッション'] = 'img/support/info_monthly.png';
			$imgList['確認する！'] = 'img/support/check_it.png';
			$imgList['学校ランキング'] = 'img/support/school_ranking.png';
			
			$cnt = 0;
			foreach($tsvList as $value) {
				if (empty($value)) continue;
				
				$row = explode("\t", $value);
				
				$cnt++;
				
				if (count($row) != 12) {
					$insert_query = '';
					$data['errors'][] = $cnt."行目の項目数が不正!";
					break;
				}
				
				$info_date = "'".$row[1] . ' 0' . $row[3] . ':00' . "'";
				$info_title = "'".str_replace("'", "''", $row[8]) . "'";
				
			
			
				$info_details = $info_details_format;
				
				$text = $row[9];
				$url = strstr($row[11], ".php") === FALSE ? $row[11] . ".php" : $row[11];
				
				if (strstr($url, 'y003')) {
					$url = '/mission/' . $url;
				}
				
				if (strstr($url, 'y004')) {
					$url = '/ranking/' . $url;
				}
				
				if (strstr($url, 'y007')) {
					$url = '/game/' . $url;
				}
				
				if (strstr($url, 'y009')) {
					$url = '/school/' . $url;
				}
				
				$img = $imgList[$row[10]];
				
				
				$info_details = str_replace("##text##", str_replace("'", "''", $text), $info_details);
				$info_details = str_replace("##url##", $url, $info_details);
				$info_details = str_replace("##img##", $img, $info_details);
				$info_details = "'". $info_details . "'";
				
				$publish_start_date = "'".$row[1] . ' ' . (strlen($row[3]) == 4 ? '0'.$row[3] : $row[3]) . ":00" . "'";
				
				if ($row[4] == '未定' || $row[4] == '-' || $row[4] == '') {
					$publish_end_date = 'NULL';
				} else {
					$publish_end_date = "'".$row[4] . ' ' . (strlen($row[6]) == 4 ? '0'.$row[6] : $row[6]) . ':59' . "'";
				}
				
				
				$sql = $sql_format;
				$sql = str_replace("##info_date##", $info_date, $sql);
				$sql = str_replace("##info_title##", $info_title, $sql);
				$sql = str_replace("##info_details##", $info_details, $sql);
				$sql = str_replace("##publish_start_date##", $publish_start_date, $sql);
				$sql = str_replace("##publish_end_date##", $publish_end_date, $sql);
				
				
				$insert_query .= $sql. PHP_EOL;
			}
		}
		
		$data['insert_query'] = $insert_query;
 		
		$this->template->title = 'お知らせ一括登録用SQL';
		$this->template->content = View::forge('admin/tools/info', $data);
	}
}