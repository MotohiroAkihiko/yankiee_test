
<h2>キャラクター登録方法</h2>
<br>
キャラクターの情報を新規追加します。<br>
キャラクターはマンスリーミッションをクリアした際、ユーザーに付与されます。<br>
使用するキャラクターを変更することで、特定のゲームでの獲得ポイントがアップする場合があります。<br>
<br>
※マンスリーミッションデータの投入も合わせて行う必要があります。<br>
<br>

<div class="flakes-actions-bar">
	<div class="tips">
	
		[更新頻度]<br>
		
		<p class="flakes-message information">
		【毎月】
		</p>
		
		[手順]<br>
		
		<p class="flakes-message information">
		①NE様からの更新依頼Excelの[マンスリーミッション管理]シートを確認する。<br>
		②更新依頼Excelを元にINSERT文を作成してキャラクターマスタデータをデータベースに登録する。<br>
		③更新依頼Excelを元に得意ゲーム数がある場合、ゲーム数分のINSERT文を作成してキャラクター得意ゲームマスタデータをデータベースに登録する。<br>
		④受領したキャラクター画像にマスタ登録データのプライマリキーIDを付与してリネームする。<br>
		⑤リネームしたキャラクター画像をサーバーにアップロードする。<br>
		<span class="required">※開発サイトで確認時はデータ投入後、公開日を当月にしてください。</span><br>
		</p>

		[更新依頼Excelシートサンプル]<br>
	
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/character/excel.png', Asset::img('admin/img/sample/character/excel.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>

		[SQLサンプル(キャラクター)]<br>
	
		<p class="flakes-message information">
			INSERT INTO mst_character (<br>
			    character_name, -- キャラクター名<br>
			    character_sex, -- 性別 ["1":男性 "2":女性 "9":不明]<br>
			    character_details, -- キャラ説明 ※改行対応<br>
			    character_skill_name, -- 肩書き<br>
			    character_skill_details, -- 特徴<br>
			    publish_start_date -- 公開期間（開始） [Y/m/d H:i:s]　配信月1日を指定<br>
			)<br>
			VALUES (<br>
			    '井合アキラ',<br>
			    1,<br>
			    '陸上部所属のフツーヤンキー二年生。<br>
			    見た目はチャラいが面倒見が良いアニキ肌で、仲間にも慕われているぞ。<br>
			    一年に弟がいるらしいが…？',<br>
			    'ランニングエース',<br>
			    '足が速いのでスピード重視の種目で力を発揮するぞ！',<br>
			    '2015/03/01 00:00:00'<br>
			);<br>
		</p>

		[SQLサンプル(キャラクター得意ゲーム)]<br>
	
		<p class="flakes-message information">
			INSERT INTO mst_character_game (<br>
			    character_id, -- キャラクターマスタのID<br>
			    game_id, -- ゲームマスタのID<br>
			    point_up_rate -- ポイントアップ率(%)<br>
			)<br>
			VALUES (<br>
			    4,<br>
			    1,<br>
			    4<br>
			);<br>
		</p>
		
		[画像アップロード先]<br>
	
		<p class="flakes-message information">
			/html/img/common/character
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
				  <td>icon_character4.png</td>
				  <td>150×150</td>
				  <td><?php echo Asset::img('admin/img/sample/character/icon_character4.png', array('width' => '100px')); ?></td>
				  <td>・キャラクターコンプ一覧画面<br>・マンスリーミッションクリア済画面</td>
				</tr>
				<tr>
				  <td>icon_character4_s.png</td>
				  <td>150×150</td>
				  <td><?php echo Asset::img('admin/img/sample/character/icon_character4_s.png', array('width' => '100px')); ?></td>
				  <td>・キャラクターコンプ一覧「未入手」状態<br>・マンスリーミッション未クリア画面</td>
				</tr>
				<tr>
				  <td>detail_character4.png</td>
				  <td>180×180</td>
				  <td><?php echo Asset::img('admin/img/sample/character/detail_character4.png', array('width' => '100px')); ?></td>
				  <td>・TOP画面<br>・マイページ<br>・キャラクター詳細画面</td>
				</tr>
				<tr>
				  <td>name_character4.png</td>
				  <td>261×35</td>
				  <td><?php echo Asset::img('admin/img/sample/character/name_character4.png', array('width' => '100px')); ?></td>
				  <td>・キャラクター詳細画面</td>
				</tr>
			</tbody>
		</table>
		
	</div>
</div>

