
<h2>ゲーム登録方法</h2>
<br>
新しいゲームを新規追加します。<br>
ゲームはJavascript製のゲームが納品されるため、そのソースの配置と、合わせてDB、画像データの投入となります。<br>
<br>

<div class="flakes-actions-bar">
	<div class="tips">
	
		[更新頻度]<br>
		
		<p class="flakes-message information">
		【不定期】
		</p>
		
		[手順]<br>
		
		<p class="flakes-message information">
		①NE様からの更新依頼Excel[ミニゲーム説明文.xls]を確認する。<br>
		②更新依頼Excelを元にINSERT文を作成してゲームマスタデータをデータベースに登録する。<br>
		③受領したアイテム画像に登録データのプライマリキーIDを付与してリネームする。<br>
		④リネームしたアイテム画像をサーバーにアップロードする。<br>
		⑤受領（開発サーバーにアップされる）したJavascript製ゲームのフォルダ内のindex.php内のID変数の値を変更する。（登録データのプライマリキーIDを付与）<br>
		⑥実際にゲームをプレイして競技結果画面に遷移したら成功。<br>
		<span class="required">※ゲーム一覧に遷移した場合、JSに問題がある可能性ありのため別途調査必要。（パラメータ名ミス等）</span><br>
		</p>

		[更新依頼Excelシートサンプル]<br>
	
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/game/excel.png', Asset::img('admin/img/sample/game/excel.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>

		[SQLサンプル(アイテム)]<br>
	
		<p class="flakes-message information">
			INSERT INTO mst_game (<br>
			    game_code, -- ゲームCODE[Javascriptゲームのフォルダ名を指定]<br>
			    game_name, -- 競技名<br>
			    game_short_details, -- 競技一覧画面用説明文<br>
			    game_details, -- 競技詳細画面用説明文<br>
			    user_point_rate, -- G変換率[競技スコアを割る値]<br>
			    conversion_max_score, -- G変換時に対象とする競技スコアの上限値[とりあえず10000でよい]<br>
			    publish_start_date -- 公開日時<br>
			)<br>
			VALUES (<br>
			    'steeplechase',<br>
			    '熱血障害物競走',<br>
			    '敵の妨害をジャンプでかわしてとにかく進め！',<br>
			    'タイミングよく画面をタップして障害物をさけろ！2回タップすると2段ジャンプができるぞ！★を3つ集めたら一定期間無敵になるぞ！',<br>
			    10,<br>
			    10000,<br>
			    '2015/02/01 00:00:00'<br>
			);<br>
		</p>
		
		[画像アップロード先]<br>
	
		<p class="flakes-message information">
			/html/img/common/game
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
				  <td>game_icon1.png</td>
				  <td>340×340</td>
				  <td><?php echo Asset::img('admin/img/sample/game/game_icon1.png', array('width' => '100px')); ?></td>
				  <td>・トップ画面<br>・競技一覧<br>・競技詳細</td>
				</tr>
				<tr>
				  <td>t_1.png</td>
				  <td>310×34</td>
				  <td><?php echo Asset::img('admin/img/sample/game/t_1.png', array('width' => '200px')); ?></td>
				  <td>・競技一覧</td>
				</tr>
				<tr>
				  <td>t_1_b.png</td>
				  <td>466×53</td>
				  <td><?php echo Asset::img('admin/img/sample/game/t_1_b.png', array('width' => '300px')); ?></td>
				  <td>・競技詳細</td>
				</tr>
			</tbody>
		</table>
		
		[Javascript製ゲームアップロード先]<br>
	
		<p class="flakes-message information">
			/html/game
		</p>

		[Javascript製ゲームindex.php変更箇所]<br>
	
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/game/game_js_index.png', Asset::img('admin/img/sample/game/game_js_index.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>
	</div>
</div>

