
<h1>4Qダッシュボード</h1>


<h2>当月・翌月のランキング報酬マスタ登録一覧</h2>

<span class="required">※翌月のデータがなければ、投入してください。</span><br>

<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>ID</td>
			<td>タイプ</td>
			<td>日付キー</td>
			<td>報酬JSONデータ</td>
			<td>登録日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list_mst_ranking_present as $row ) : ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['ranking_type']; ?></td>
			<td><?php echo $row['ranking_date_key']; ?></td>
			<td><?php echo $row['ranking_present_data'];?></td>
			<td><?php echo $row['reg_date']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h2>当月・翌月のマンスリーミッションマスタ登録一覧</h2>

<span class="required">※翌月のデータがなければ、投入してください。</span><br>

<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>ID</td>
			<td>ミッション年月</td>
			<td>ミッションタイトル</td>
			<td>ミッションタイプ</td>
			<td>クリア条件JSONデータ</td>
			<td>報酬JSONデータ</td>
			<td>ミッション内容</td>
			<td>報酬</td>
			<td>ストーリー</td>
			<td>登録日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list_mst_monthly_mission as $row ) : ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['mission_date_ym']; ?></td>
			<td><?php echo $row['mission_name'];?></td>
			<td><?php echo $row['mission_type'];?></td>
			<td><?php echo $row['mission_clear_data'];?></td>
			<td><?php echo $row['mission_present_data'];?></td>
			<td><?php echo $row['mission_clear_details'];?></td>
			<td><?php echo $row['mission_present_details'];?></td>
			<td><?php echo $row['mission_story']; ?></td>
			<td><?php echo $row['reg_date']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h2>当月・翌月のキャラクターマスタ登録一覧</h2>

<span class="required">※翌月のデータがなければ、投入してください。</span><br>

<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>ID</td>
			<td>キャラ名</td>
			<td>公開日時</td>
			<td>キャラ説明</td>
			<td>肩書き</td>
			<td>特徴</td>
			<td>登録日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list_mst_character as $row ) : ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['character_name']; ?></td>
			<td><?php echo $row['publish_start_date'];?></td>
			<td><?php echo $row['character_details']; ?></td>
			<td><?php echo $row['character_skill_name'];?></td>
			<td><?php echo $row['character_skill_details'];?></td>
			<td><?php echo $row['reg_date']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h2>当月・翌月のキャラクター得意ゲームマスタ登録一覧</h2>

<span class="required">※翌月のデータがなければ、投入してください。</span><br>

<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>キャラクターID</td>
			<td>キャラ名</td>
			<td>ゲームID</td>
			<td>ゲーム名</td>
			<td>登録日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list_mst_character_game as $row ) : ?>
		<tr>
			<td><?php echo $row['character_id']; ?></td>
			<td><?php echo $row['character_name']; ?></td>
			<td><?php echo $row['game_id'];?></td>
			<td><?php echo $row['game_name']; ?></td>
			<td><?php echo $row['reg_date']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>


