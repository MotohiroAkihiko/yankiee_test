<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<h1>ダッシュボード</h1>

<h2>学校情報</h2>
<div class="flakes-key-metrics" data-respond>
	<div title="紅鬼高校の所属ユーザー数">
		<span><?php echo number_format($school_user_count[1]['count'])?>名</span><br>
		紅鬼高校
	</div>
	<div title="青龍高校の所属ユーザー数">
		<span><?php echo number_format($school_user_count[2]['count'])?>名</span><br>
		青龍高校
	</div>
	<div title="白虎高校の所属ユーザー数">
		<span><?php echo number_format($school_user_count[3]['count'])?>名</span><br>
		白虎高校
	</div>
</div>
<table class="flakes-table">
	<colgroup>
		<col span="1" style="width:20px" />
<col span="1" style="width:40%" />
	</colgroup>
	<thead>
		<tr>
			<td>ID</td>
			<td>公開期間（開始）</td>
			<td>公開期間（終了）</td>
			<td>カテゴリー</td>
			<td>アイテム名</td>
			<td>アイテム説明</td>
			<td>アイテム有効期限(秒)</td>
			<td>ポイントアップ率</td>
			<td>アイコン</td>
			<td>最終更新日時</td>
		</tr>
	</thead>
	<tbody id="list">
	</tbody>
</table>
