
<h2>デイリーミッション登録方法</h2>
<br>
発生したら整理する。<br>
<br>

<div class="flakes-actions-bar">
	<div class="tips">
	
		[更新頻度]<br>
		
		<p class="flakes-message information">
		【不定期】新しいゲームが投入されたタイミング？
		</p>
		
		[手順]<br>
		
		<p class="flakes-message information">
		①NE様からの更新依頼Excelを確認する。<br>
		②更新依頼Excelを元にINSERT文生成用Excelを利用してINSERT文を作成してアイテムマスタデータをデータベースに登録する。<br>
		③管理画面の<?php echo Html::anchor('/admin/dailymission', 'メインメニュー＞デイリーミッション管理'); ?>で登録内容を確認する。<br>
		</p>

		[更新依頼Excelシートサンプル]<br>
	
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/daily_mission/excel.png', Asset::img('admin/img/sample/daily_mission/excel.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>

		[INSERT文生成用Excelシートサンプル]<br>
	    <?php echo Html::anchor('/assets/admin/img/sample/daily_mission/mst_daily_mission_INSERT.xlsx', '※ダウンロードはコチラ', array('target' => '_blank')) ?>
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/daily_mission/excel2.png', Asset::img('admin/img/sample/daily_mission/excel2.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>
		
	</div>
</div>

