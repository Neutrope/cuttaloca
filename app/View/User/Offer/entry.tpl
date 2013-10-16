<div id="contents">
<article id="contentsInEntry" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/user/search/">戻る</a></p><h1>掲載登録</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/user/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/user/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/user/offer/entry/" title="掲載登録" class="fadeBtn">掲載登録</a></li>
</ul></nav>
<p class="who"><a href="/user/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>

<div id="mainContents">
{{ form.create('User', {'class':'mailForm'}) }}
	<table cellpadding="0" cellspacing="0" summary="カットモデル情報の登録">
		<col width="24%">
		<tr>
			<th><span>カット希望地域 ※3つまで</span></th>
			<td>
				<div class="area">
					{{ form.select('CutModel.prefecture01', prefecture, {'empty':'都道府県', 'class':'prefecture require', 'default': logindata.CutModel.prefecture01}) }}
					{{ form.select('CutModel.city01', city01, {'empty':'市区町村', 'class':'require', 'default':logindata.CutModel.city01}) }}
				</div>
				<div class="area">
					{{ form.select('CutModel.prefecture02', prefecture, {'empty':{'0':'都道府県'}, 'class':'prefecture'}) }}
{% if city02 is not empty %}
					{{ form.select('CutModel.city02', city02, {'empty':'市区町村', 'class':'require', 'default':logindata.CutModel.city02}) }}
{% else %}
					<select name="data[CutModel][city02]" disabled="disabled">
						<option value="">市区町村</option>
					</select>
{% endif %}
				</div>
				<div class="area last">
					{{ form.select('CutModel.prefecture03', prefecture, {'empty':{'0':'都道府県'}, 'class':'prefecture'}) }}
{% if city03 is not empty %}
					{{ form.select('CutModel.city03', city03, {'empty':'市区町村', 'class':'require', 'default':logindata.CutModel.city03}) }}
{% else %}
					<select name="data[CutModel][city03]" disabled="disabled">
						<option value="">市区町村</option>
					</select>
{% endif %}
				</div>
			</td>
		</tr>
		<tr>
			<th><span>ご希望</span></th>
			<td>
				<div class="style">
					{{ form.select('CutModel.style', cutmodelstyle, {'empty':{'0':'-選択-'}, 'class':'require', 'default':logindata.CutModel.style}) }}
				</div>
				<div class="select select1">
					カット&nbsp;&nbsp;{{ form.select('CutModel.cut_before', cut_before, {'class':'userSelect', 'empty':{'0':'現在'}, 'class':'require', 'default':logindata.CutModel.cut_before}) }}<span class="arrow">→</span>&nbsp;&nbsp;{{ form.select('CutModel.cut_after', cut_after, {'class':'userSelect', 'empty':{'0':'希望'}, 'class':'require', 'default':logindata.CutModel.cut_after}) }}
				</div>
				<div class="select select2">
					カラー&nbsp;&nbsp;{{ form.select('CutModel.color_before', color_before, {'class':'userSelect', 'empty':{'0':'現在'}, 'class':'require', 'default':logindata.CutModel.color_before}) }}<span class="arrow">→</span>&nbsp;&nbsp;{{ form.select('CutModel.color_after', color_after, {'class':'userSelect', 'empty':{'0':'希望'}, 'class':'require', 'default':logindata.CutModel.color_after}) }}
				</div>
				<div class="select select3">
					パーマ&nbsp;&nbsp;{{ form.select('CutModel.perm_before', perm_before, {'class':'userSelect', 'empty':{'0':'現在'}, 'class':'require', 'default':logindata.CutModel.perm_before}) }}<span class="arrow">→</span>&nbsp;&nbsp;{{ form.select('CutModel.perm_after', perm_after, {'class':'userSelect', 'empty':{'0':'希望'}, 'class':'require', 'default':logindata.CutModel.perm_after}) }}
				</div>
			</td>
		</tr>
		<tr>
			<th><span>スタイルの詳細（自由記入）</span></th>
			<td>
				{{ form.textarea('detail', {'placeholder':'電話番号、URL、メールアドレスは記載不可','rows':2,'cols':2, 'default':logindata.User.detail}) }}
			</td>
		</tr>
		<tr>
			<th><span>サロンにいつ行きたいですか？</span></th>
			<td>
				<div class="cut week">
				{{ form.select('CutModel.cut_week', cut_week, {'empty':false, 'class':'require', 'default':logindata.CutModel.cut_week}) }}
				</div>
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