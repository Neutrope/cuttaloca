<div id="mainContents">
{{ form.create('User', {'class':'mailForm'}) }}
	<table cellpadding="0" cellspacing="0" summary="スタイリスト情報の登録">
		<col width="24%">
		<tr>
			<th><span>名 前</span></th>
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
			<th><span>店舗名</span></th>
			<td><ul class="clearfix">
					<li>{{ form.text('Stylist.shop_name', {'class':'wid02 require'}) }}</li>
					<li><label>{{ form.radio('Stylist.disp_shop_name', {'0':'非公開'}) }}</label></li>
					<li><label>{{ form.radio('Stylist.disp_shop_name', {'1':'公開'}, {'default':'1'}) }}</label></li>
				</ul>
			</td>
		</tr>
		<tr>
			<th><span>店舗の地域</span></th>
			<td>
				{{ form.select('Stylist.prefecture', prefecture, {'empty':'都道府県', 'class':'prefecture'}) }}
				<select name="data[Stylist][city]" disabled="disabled" class="require">
					<option value="">市区町村</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><span>店舗の最寄り駅</span></th>
			<td>
				{{ form.text('Stylist.station', {'class':'require'}) }}&nbsp;&nbsp;駅
			</td>
		</tr>
		<tr>
			<th><span>店舗のURL</span></th>
			<td>
				{{ form.text('Stylist.url', {'class':'wid02'}) }}
			</td>
		</tr>
		<tr>
			<th><span>募集内容</span></th>
			<td>
				<ul id="list01" class="list01 staffList clearfix">
{% for key,style in stylelist %}
					<li>
						<label>{{ form.checkbox('Stylist.apply_content.', {'label':false, 'value':key, 'class':'pricecheck'}) }}{{ style }}</label>
						{{ form.text('Stylist.apply_price.', {'disabled':'disabled', 'class':'price'}) }}<span class="unit" style="display:none;">円</span>
					</li>
{% endfor %}
				</ul>
			</td>
		</tr>
		<tr>
			<th><span>募集対象</span></th>
			<td>
				<ul class="clearfix">
					<li>
						{{ form.radio('Stylist.apply_gender', apply_gender, {'legend':false, 'separator':'</label></li><li>'}) }}
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th><span>希望のスタイル（仕上がりの長さ）</span></th>
			<td>
				<div class="checkbox">{{ form.checkbox('Stylist.apply_style_all', {'value':'1', 'class':'style-all'}) }}{{ form.label('Stylist.apply_style_all', 'ご希望に合わせます') }}
				</div>
				{{ form.select('Stylist.apply_style', apply_style, {'multiple':'checkbox'}) }}
			</td>
		</tr>
		<tr>
			<th><span>募集内容の詳細（任意）</span></th>
			<td>
				{{ form.textarea('detail', {'placeholder':'電話番号、URL、メールアドレスは記載不可','rows':2,'cols':2}) }}
			</td>
		</tr>
		<tr>
			<th><span class="mb20">施術可能日</span>
			<td>
				{% include 'Elements/calendar.tpl' %}
			</td>
		</tr>
		<tr>
			<th><span>施術可能な時間</span></th>
			<td>
				平日&nbsp;&nbsp;&nbsp;&nbsp;{{ form.select('Stylist.ordinary_start', apply_cutmodel, {'class':'staffSelect', 'empty':{'0':'-選択-'}}) }}<span class="arrow">～</span>{{ form.select('Stylist.ordinary_end', {'0':''}, {'class':'staffSelect time-end', 'empty':{'0':''}}) }}&nbsp;&nbsp;スタート<br><br><br>
				土曜&nbsp;&nbsp;&nbsp;&nbsp;{{ form.select('Stylist.saturday_start', apply_cutmodel, {'class':'staffSelect', 'empty':{'0':'-選択-'}}) }}<span class="arrow">～</span>{{ form.select('Stylist.saturday_end', {'0':''}, {'class':'staffSelect time-end', 'empty':{'0':''}}) }}&nbsp;&nbsp;スタート<br><br><br>
				日祝&nbsp;&nbsp;&nbsp;&nbsp;{{ form.select('Stylist.holiday_start', apply_cutmodel, {'class':'staffSelect', 'empty':{'0':'-選択-'}}) }}<span class="arrow">～</span>{{ form.select('Stylist.holiday_end', {'0':''}, {'class':'staffSelect time-end', 'empty':{'0':''}}) }}&nbsp;&nbsp;スタート
			</td>
		</tr>
	</table>
	<div class="conditions clearfix">
		<p><a href="/terms/use" target="_blank">とても大事な利用規約</a><br><label><input type="checkbox" value="on" name="data[agree]" class="require">利用規約に同意する</label></p>
		<ul class="submit clearfix">
			<li>{{ form.submit('登録する') }}</li>
		</ul>
	</div>
{{ form.end() }}
</div>