<div id="mainContents">
{{ form.create('User', {'class':'mailForm'}) }}
	<table cellpadding="0" cellspacing="0" summary="カットモデル情報の登録">
		<col width="24%">
		<tr>
			<th><span>mobi名 前</span></th>
			<td>
{% if fb.last_name %}
				{{ form.hidden('last_name', {'value':fb.last_name}) }}
				{{ form.label('last_name', fb.last_name) }}
{% else %}					
				{{ form.text('last_name', {'placeholder':'Yokoo', 'class':'require'}) }}
{% endif %}
{% if fb.first_name %}
				{{ form.hidden('first_name', {'value':fb.first_name}) }}
				{{ form.label('first_name', fb.first_name) }}
{% else %}
				{{ form.text('first_name', {'placeholder':'Yukihiro', 'class':'require'}) }}
{% endif %}
			</td>
		</tr>
		<tr>
			<th><span>性 別</span></th>
			<td>
{% if fb.gender %}
						{{ form.hidden('gender', {'value':fb.gender[0]}) }}
						{{ form.label('gender', fb.gender[1]) }}
{% else %}
				<ul class="clearfix">
					<li>
						{{ form.radio('gender', {'1':'女性', '2':'男性'}, {'legend':false, 'separator':'</li><li>', 'class':'require'}) }}
					</li>
				</ul>
{% endif %}
			</td>
		</tr>
		<tr>
			<th><span>メールアドレス</span></th>
			<td>{{ form.text('email', {'placeholder':'info@cuttaloca.com', 'default':fb.email, 'class':'wid02 require email'}) }}</td>
		</tr>
		<tr>
			<th><span>カット希望地域</span></th>
			<td>
				<div class="area">
					{{ form.select('CutModel.prefecture01', prefecture, {'empty':'都道府県', 'class':'prefecture require'}) }}
					<select name="data[CutModel][city01]" disabled="disabled" class="require">
						<option value="">市区町村</option>
					</select>
				</div>
{% if 1 == 0 %}
				<div class="area">
					{{ form.select('CutModel.prefecture02', prefecture, {'empty':{'0':'都道府県'}, 'class':'prefecture'}) }}
					<select name="data[CutModel][city02]" disabled="disabled">
						<option value="">市区町村</option>
					</select>
				</div>
				<div class="area last">
					{{ form.select('CutModel.prefecture03', prefecture, {'empty':{'0':'都道府県'}, 'class':'prefecture'}) }}
					<select name="data[CutModel][city03]" disabled="disabled">
						<option value="">市区町村</option>
					</select>
				</div>
{% endif %}
			</td>
		</tr>
		<tr>
			<th><span>ご希望</span></th>
			<td>
				<div class="style">
					{{ form.select('CutModel.style', cutmodelstyle, {'empty':{'0':'-選択-'}, 'class':'require'}) }}
				</div>
				<div class="select select1">
					カット&nbsp;&nbsp;{{ form.select('CutModel.cut_before', cut_before, {'class':'userSelect', 'empty':{'0':'現在'}, 'class':'require'}) }}<span class="arrow">→</span>&nbsp;&nbsp;{{ form.select('CutModel.cut_after', cut_after, {'class':'userSelect', 'empty':{'0':'希望'}, 'class':'require'}) }}
				</div>
				<div class="select select2">
					カラー&nbsp;&nbsp;{{ form.select('CutModel.color_before', color_before, {'class':'userSelect', 'empty':{'0':'現在'}, 'class':'require'}) }}<span class="arrow">→</span>&nbsp;&nbsp;{{ form.select('CutModel.color_after', color_after, {'class':'userSelect', 'empty':{'0':'希望'}, 'class':'require'}) }}
				</div>
				<div class="select select3">
					パーマ&nbsp;&nbsp;{{ form.select('CutModel.perm_before', perm_before, {'class':'userSelect', 'empty':{'0':'現在'}, 'class':'require'}) }}<span class="arrow">→</span>&nbsp;&nbsp;{{ form.select('CutModel.perm_after', perm_after, {'class':'userSelect', 'empty':{'0':'希望'}, 'class':'require'}) }}
				</div>
			</td>
		</tr>
		<tr>
			<th><span>スタイルの詳細（自由記入）</span></th>
			<td>
				{{ form.textarea('detail', {'placeholder':'電話番号、URL、メールアドレスは記載不可','rows':2,'cols':2}) }}
			</td>
		</tr>
		<tr>
			<th><span>サロンにいつ行きたいですか？</span></th>
			<td>
				<div class="cut week">
				{{ form.select('CutModel.cut_week', cut_week, {'empty':false, 'class':'require'}) }}
				</div>
			</td>
		</tr>
	</table>
	<div class="conditions clearfix">
		<p><a href="/terms/use" target="_blank">とても大事な利用規約</a><br><label><input type="checkbox" value="on" name="data[agree]" class="require" checked>利用規約に同意する</label></p>
		<ul class="submit clearfix">
			<li>{{ form.submit('登録する') }}</li>
		</ul>
	</div>
{{ form.end() }}
</div>