
<h1>各種マスタ</h1>

<h2>競技マスタ登録一覧</h2>
<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>ID</td>
			<td>ゲーム名</td>
			<td>ゲーム識別コード</td>
			<td>ゲーム説明テキスト(短)</td>
			<td>ゲーム説明テキスト</td>
			<td>個人ポイント変換率</td>
			<td>個人ポイント変換対象最大得点</td>
			<td>公開日時</td>
			<td>登録日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list_mst_game as $row ) : ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['game_name']; ?></td>
			<td><?php echo $row['game_code']; ?></td>
			<td><?php echo mb_strimwidth($row['game_short_details'], 0, 30, '...'); ?></td>
			<td><?php echo mb_strimwidth($row['game_details'], 0, 30, '...'); ?></td>
			<td>競技スコア/<?php echo $row['user_point_rate'];?>＝ガッツ</td>
			<td><?php echo number_format($row['conversion_max_score']); ?></td>
			<td><?php echo $row['publish_start_date'];?></td>
			<td><?php echo $row['reg_date']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h2>キャラクターマスタ登録一覧</h2>
<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>ID</td>
			<td>キャラ名</td>
			<td>キャラ説明</td>
			<td>肩書き</td>
			<td>特徴</td>
			<td>公開日時</td>
			<td>登録日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list_mst_character as $row ) : ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['character_name']; ?></td>
			<td><?php echo mb_strimwidth($row['character_details'], 0, 30, '...'); ?></td>
			<td><?php echo $row['character_skill_name'];?></td>
			<td><?php echo mb_strimwidth($row['character_skill_details'], 0, 30, '...');?></td>
			<td><?php echo $row['publish_start_date'];?></td>
			<td><?php echo $row['reg_date']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h2>キャラクター得意ゲームマスタ登録一覧</h2>

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

<h2>アイテムマスタ登録一覧</h2>
<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>ID</td>
			<td>アイテム名</td>
			<td>カテゴリー</td>
			<td>アイテム説明</td>
			<td>ポイントアップ率</td>
			<td>アイテム有効期限(秒)</td>
			<td>公開日時</td>
			<td>登録日時</td>
			<td></td>
		</tr>
	</thead>
	<tbody class="list">
		<?php foreach ( $list_mst_item as $row ) : ?>
		<tr>
			<td><?php echo $row['id']; ?></td>
			<td><?php echo $row['item_name']; ?></td>
			<td><?php echo $row['item_category_id'] . '：' . $item_category[$row['item_category_id']]; ?></td>
			<td><?php echo mb_strimwidth($row['item_details'], 0, 30, '...'); ?></td>
			<td><?php echo $row['item_point_up_rate'];?>％</td>
			<td><?php echo $row['item_expire_seconds'];?>秒(=<?php echo $row['item_expire_seconds']/86400;?>日)</td>
			<td><?php echo $row['publish_start_date'];?></td>
			<td><?php echo $row['reg_date']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

