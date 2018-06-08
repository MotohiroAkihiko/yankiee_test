
<h2>アイテム登録方法</h2>
<br>
ゲームプレイ時に利用できるアイテムの情報を新規追加します。<br>
カテゴリー「食べ物」、「季節モノ」、「装飾品」があり毎月それぞれ１つ増える予定で、週間個人ランキング、月間学校ランキング、月間個人ランキングにランクインした際、ユーザーに付与されます。<br>
<br>
※週間個人ランキング、月間学校ランキング、月間個人ランキングの報酬データの投入も合わせて行う必要があります。<br>
<br>

<div class="flakes-actions-bar">
	<div class="tips">
	
		[更新頻度]<br>
		
		<p class="flakes-message information">
		カテゴリー「食べ物」：【不定期（毎月1個は一定数になるまで増えるかも】<br>
		カテゴリー「季節モノ」、「装飾品」：【毎月】
		</p>
		
		[手順]<br>
		
		<p class="flakes-message information">
		①NE様からの更新依頼Excelの[ポイントアップアイテム管理]シートを確認する。<br>
		②更新依頼Excelを元にINSERT文を作成してアイテムマスタデータをデータベースに登録する。<br>
		③受領したアイテム画像に登録データのプライマリキーIDを付与してリネームする。<br>
		④リネームしたアイテム画像をサーバーにアップロードする。<br>
		</p>

		[更新依頼Excelシートサンプル]<br>
	
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/item/excel.png', Asset::img('admin/img/sample/item/excel.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>

		[SQLサンプル(アイテム)]<br>
	
		<p class="flakes-message information">
			INSERT INTO mst_item (<br>
			    item_name,			-- アイテム名<br>
			    item_category_id,		-- カテゴリ ["1":食べ物　"2":季節もの　"3":ヤンキー]<br>
			    item_details,			-- アイテム説明<br>
			    item_point_up_rate,	-- アイテムポイントアップ率(%)<br>
			    item_expire_seconds,	--  アイテム有効期限(秒) [ "604800":7日(1週間) "2592000":30日(1か月間）]<br>
			    publish_start_date		-- 公開期間（開始） [Y/m/d H:i:s]　配信月1日を指定<br>
			)<br>
			VALUES (<br>
			    '最強おにぎり',<br>
			    1,<br>
			    '購買部のおばちゃんの手作りおにぎり。食べると力がみなぎってポイントアップするぞ！',<br>
			    2,<br>
			    604800,<br>
			    '2015/02/01 00:00:00'<br>
			);<br>
		</p>
		
		[画像アップロード先]<br>
	
		<p class="flakes-message information">
			/html/img/common/item
		</p>
		
		[画像サンプル]<br>
		
		<table class="flakes-table">
			<thead>
				<tr>
					<td>画像名</td>
					<td>サイズ</td>
					<td>イメージ</td>
					<td>画像使用箇所例</td>
				</tr>
			</thead>
			<tbody>
				<tr>
				  <td>item1.png</td>
				  <td>80×80</td>
				  <td><?php echo Asset::img('admin/img/sample/item/item1.png', array('width' => '100px')); ?></td>
				  <td>アイテム一覧:<br>/item/y005-02.php</td>
				</tr>
				<tr>
				  <td>item_large1.png</td>
				  <td>180×180</td>
				  <td><?php echo Asset::img('admin/img/sample/item/item_large1.png', array('width' => '100px')); ?></td>
				  <td>アイテム詳細:<br>/item/y005-03.php</td>
				</tr>
				<tr>
				  <td>text_item1.png</td>
				  <td>261×35</td>
				  <td><?php echo Asset::img('admin/img/sample/item/text_item1.png', array('width' => '100px')); ?></td>
				  <td>アイテム詳細:<br>/item/y005-03.php</td>
				</tr>
			</tbody>
		</table>
		
	</div>
</div>

