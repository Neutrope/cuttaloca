<div id="contents">
<article id="contentsInEntry" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/stylist/search/">戻る</a></p><h1>掲載登録</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/stylist/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/stylist/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/stylist/offer/entry" title="掲載登録" class="fadeBtn">掲載登録</a></li>
</ul></nav>
<p class="who"><a href="/stylist/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>

<div id="mainContents">
{{ form.create('User', {'class':'mailForm'}) }}
	<table cellpadding="0" cellspacing="0" summary="スタイリスト情報の登録">
		<col width="24%">
		<tr>
			<th><span>募集内容</span></th>
			<td>
				<ul id="list01" class="list01 staffList clearfix">
{% for key,style in stylelist %}
					<li>

{% set checked = '' %}
{% set disabled = 'disabled' %}
{% set price = '' %}
{% set price_style = 'display: none;' %}

{% for apply_content_key, apply_content_value in logindata.Stylist.apply_content %}
	{% if key == apply_content_value %}
		{% set checked = 'checked' %}
		{% set disabled = '' %}
		{% set price = logindata.Stylist.apply_price[apply_content_key] %}
		{% set price_style = '' %}
	{% endif %}
{% endfor %}
						<label>{{ form.checkbox('Stylist.apply_content.', {'label':false, 'value':key, 'class':'pricecheck', 'checed':checked}) }}{{ style }}</label>
						{{ form.text('Stylist.apply_price.', {'disabled':disabled, 'class':'price', 'default':price}) }}<span class="unit" style="{{ price_style }}">円</span>
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
						{{ form.radio('Stylist.apply_gender', apply_gender, {'legend':false, 'separator':'</label></li><li>', 'default':logindata.Stylist.apply_gender}) }}
					</li>
				</ul>
			</td>
		</tr>
		<tr>
			<th><span>希望のスタイル（仕上がりの長さ）</span></th>
			<td>
				<div class="checkbox">{{ form.checkbox('Stylist.apply_style_all', {'value':'1', 'class':'style-all', 'default':logindata.Stylist.apply_style_all}) }}{{ form.label('Stylist.apply_style_all', 'ご希望に合わせます') }}
				</div>
				{{ form.select('Stylist.apply_style', apply_style, {'multiple':'checkbox', 'default':logindata.Stylist.apply_style}) }}
			</td>
		</tr>
		<tr>
			<th><span>募集内容の詳細（任意）</span></th>
			<td>
				{{ form.textarea('detail', {'placeholder':'電話番号、URL、メールアドレスは記載不可','rows':2,'cols':2, 'default':logindata.User.detail}) }}
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
				平日&nbsp;&nbsp;&nbsp;&nbsp;{{ form.select('Stylist.ordinary_start', apply_cutmodel, {'class':'staffSelect', 'empty':{'0':'-選択-'}, 'default':logindata.Stylist.ordinary_start}) }}<span class="arrow">～</span>{{ form.select('Stylist.ordinary_end', apply_cutmodel, {'class':'staffSelect time-end', 'empty':{'0':''}, 'default':logindata.Stylist.ordinary_end}) }}&nbsp;&nbsp;スタート<br><br><br>
				土曜&nbsp;&nbsp;&nbsp;&nbsp;{{ form.select('Stylist.saturday_start', apply_cutmodel, {'class':'staffSelect', 'empty':{'0':'-選択-'}, 'default':logindata.Stylist.saturday_start}) }}<span class="arrow">～</span>{{ form.select('Stylist.saturday_end', apply_cutmodel, {'class':'staffSelect time-end', 'empty':{'0':''}, 'default':logindata.Stylist.saturday_end}) }}&nbsp;&nbsp;スタート<br><br><br>
				日祝&nbsp;&nbsp;&nbsp;&nbsp;{{ form.select('Stylist.holiday_start', apply_cutmodel, {'class':'staffSelect', 'empty':{'0':'-選択-'}, 'default':logindata.Stylist.holiday_start}) }}<span class="arrow">～</span>{{ form.select('Stylist.holiday_end', apply_cutmodel, {'class':'staffSelect time-end', 'empty':{'0':''}, 'default':logindata.Stylist.holiday_end}) }}&nbsp;&nbsp;スタート
			</td>
		</tr>
	</table>
	<div class="conditions clearfix">
		<p><label></label></p>
		<ul class="submit clearfix">
			<li>{{ form.submit('更新する') }}</li>
		</ul>
	</div>
{{ form.end() }}
</div></div><!-- //#contents -->