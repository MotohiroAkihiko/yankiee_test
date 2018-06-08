
<h2>マンスリーミッション登録方法</h2>
<br>
マンスリーミッションの情報を新規追加します。<br>
※マンスリーミッションの報酬となるキャラクター情報を予め登録する必要があります。<br>
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
		②更新依頼Excelを元にINSERT文を作成してマンスリーミッションマスタデータをデータベースに登録する。<br>
		<span class="required">※開発サイトで確認時はデータ投入後、ミッション年月を当月にしてください。</span><br>
		</p>

		[更新依頼Excelシートサンプル]<br>
	
		<p class="flakes-message information">
			<?php echo Html::anchor('/assets/admin/img/sample/character/excel.png', Asset::img('admin/img/sample/character/excel.png', array('width' => '100%')), array('target' => '_blank')) ?>
		</p>

		[SQLサンプル(マンスリーミッション)]<br>
	
		<p class="flakes-message information">
			INSERT INTO mst_monthly_mission (<br>
			    mission_date_ym, -- ミッション年月<br>
			    mission_name, -- ミッションタイトル<br>
			    mission_story, -- ストーリー<br>
			    mission_clear_details, -- ミッション内容(クリア条件)<br>
			    mission_present_details, -- 報酬内容(キャラクタ名)<br>
			    mission_type, -- ミッションタイプ  ※後述の[ミッションタイプ・クリア条件JSONデータ]を参照<br>
			    mission_clear_data, -- クリア条件JSONデータ  ※後述の[ミッションタイプ・クリア条件JSONデータ]を参照<br>
			    mission_present_data -- 報酬JSONデータ  [キャラクタマスタのIDをJSON形式「{"character_id":4}」で指定]<br>
			)<br>
			VALUES (<br>
			    '201503',<br>
			    '8回以上参戦しろ！',<br>
			    'いよいよ俺たちヤンキーの一大イベント、熱血！ヤンキー体育祭が始まったぞ！まずは最初のマンスリーミッションだ。<br>
			1ヶ月のあいだに8回以上体育祭に参戦しろ。成功するとミッションキャラクターの【井合 アキラ】が、お前の仲間になって一緒に戦ってくれるぞ！<br>
			今回のミッションクリアのコツは、「熱血！ヤンキー体育祭」のことを1日たりとも忘れないことだ！とにかく毎日ログインして体育祭を楽しむんだ！<br>
			まあ、今回のような簡単なミッションなら、お前なら余裕でクリアできるはずだ。油断しないでしっかりとログインしろよ！',<br>
			    '1ヶ月の間に8日以上、熱血！ヤンキー体育祭にログインしろ！',<br>
			    '【井合 アキラ】',<br>
			    'TypeLogin',<br>
			    '{"login_count":8}',<br>
			    '{"character_id":4}'<br>
			);<br>
		</p>
		
		[ミッションタイプ・クリア条件JSONデータ]<br>
		
		<table class="flakes-table">
			<thead>
				<tr>
					<td>タイプ</td>
					<td>クリア条件</td>
					<td>クリア条件JSONデータ例</td>
				</tr>
			</thead>
			<tbody>
				<tr>
				  <td>typeLogin</td>
				  <td>月間ログイン回数が条件値を超えればクリア</td>
				  <td>{"login_count":8}</td>
				</tr>
				<tr>
				  <td>typeA</td>
				  <td>月間獲得G数が条件値を超えればクリア</td>
				  <td>{"user_point":6000}</td>
				</tr>
			</tbody>
		</table>
		
		<br>
		※ここにないタイプは実装が必要です。/include/game/monthly_missionの下にMonthlyMissionLogicBaseクラスを継承して作成してください。
		
	</div>
</div>

