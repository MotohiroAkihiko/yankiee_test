
<h2>ランキング報酬登録方法</h2>
<br>
週間個人ランキング、月間学校ランキング、月間個人ランキングにランクインした際、ユーザーに付与されるアイテムの情報を新規追加します。<br>
ランキングで付与されるアイテムは、週間ランキングは毎週、月間ランキングは毎月変わります。<br>
<br>

<div class="flakes-actions-bar">
	<div class="tips">
	
		[更新頻度]<br>
		
		<p class="flakes-message information">
		【毎月】
		</p>
		
		[手順]<br>
		
		<p class="flakes-message information">
		①NE様からの更新依頼Excelの[ポイントアップアイテム管理]シートを確認する。<br>
		②存在する食べ物系アイテム情報を元に週間個人ランキング報酬INSERT文を1か月分（4～5週間分）作成してデータベースに登録する。<br>
		（週間個人ランキングの報酬アイテムは存在する食べ物系アイテムのローテーションとする）<br>
		③更新依頼Excelを元に月間学校ランキング報酬INSERT文を作成してデータベースに登録する。<br>
		④更新依頼Excelを元に月間個人ランキング報酬INSERT文を作成してデータベースに登録する。<br>
		</p>

		[更新依頼Excelシートサンプル]<br>
	
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/item/excel.png', Asset::img('admin/img/sample/item/excel.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>

		[SQLサンプル(週間個人ランキング)]<br>
	
		<p class="flakes-message information">
			INSERT INTO mst_ranking_present (<br>
		    ranking_type, -- ランキングタイプ ["weekly":週間個人ランキングを指定]<br>
		    ranking_date_key, -- 日付キー [ランキング集計期間を、月曜日～日曜日"Ymd-Ymd"で指定]<br>
		    ranking_present_data -- 報酬JSONデータ  [アイテムマスタのIDをJSON形式「{"item_id":1}」で指定]<br>
		)<br>
		VALUES (<br>
		    'weekly',<br>
		    '20150302-20150308',<br>
		    '{"item_id":1}'<br>
		);<br>
		</p>

		[SQLサンプル(月間学校ランキング)]<br>
	
		<p class="flakes-message information">
			INSERT INTO mst_ranking_present (<br>
		    ranking_type, -- ランキングタイプ ["school":月間学校ランキングを指定]<br>
		    ranking_date_key, -- 日付キー [ランキング集計期間を、"Ym"で指定]<br>
		    ranking_present_data -- 報酬JSONデータ  [アイテムマスタのIDをJSON形式「{"item_id":1}」で指定]<br>
		)<br>
		VALUES (<br>
		    'school',<br>
		    '201503',<br>
		    '{"item_id":5}'<br>
		);<br>
		</p>

		[SQLサンプル(月間個人ランキング)]<br>
	
		<p class="flakes-message information">
			INSERT INTO mst_ranking_present (<br>
		    ranking_type, -- ランキングタイプ ["monthly:月間個人ランキングを指定]<br>
		    ranking_date_key, -- 日付キー [ランキング集計期間を、"Ym"で指定]<br>
		    ranking_present_data -- 報酬JSONデータ  [アイテムマスタのIDをJSON形式「{"item_id":1}」で指定]<br>
		)<br>
		VALUES (<br>
		    'monthly',<br>
		    '201503',<br>
		    '{"item_id":6}'<br>
		);<br>
		</p>
		
	</div>
</div>

