
<h2>お知らせ一括登録方法</h2>
<br>
お知らせ原稿のExcelの情報からINSERT文を生成して一括で登録します。<br>
<br>

<div class="flakes-actions-bar">
	<div class="tips">
	
		[更新頻度]<br>
		
		<p class="flakes-message information">
		【毎月】
		</p>
		
		[手順]<br>
		
		<p class="flakes-message information">
		①NE様からの更新依頼Excel[お知らせ原稿.xls]を確認する。<br>
		②依頼のあった行（掲載開始日が○月のもの等）をコピーして、「<?php echo Html::anchor('admin/tools/info', '4Q運用ツール＞お知らせ一括登録用SQL生成') ?>」でINSERT文を生成する。<br>
		③生成したINSERT文を実行してお知らせデータをデータベースに登録する。<br>
		</p>

		[更新依頼Excelシートサンプル]<br>
	
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/info/excel.png', Asset::img('admin/img/sample/info/excel.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>
		
	</div>
</div>

