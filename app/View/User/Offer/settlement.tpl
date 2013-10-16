<div id="mainContents">
	<div class="comfirmWrapper">
		<div class="comfirmLeft">
			<div class="comfirmBox01">
				<figure class="face"><a href=""><img class="fadeBtn" src="https://graph.facebook.com/{{ offer.User.facebook_id }}/picture?type=large&width=100&height=100" alt="{{ offer.User.last_name }}&nbsp;{{ offer.User.first_name }}" width="100" height="100"></a></figure>
				<div class="name">
					<h1>{{ offer.User.last_name }}&nbsp;{{ offer.User.first_name }}</h1>
					<p>{{ gender[offer.User.gender] }}｜{{ prefecture[offer.Stylist.prefecture] }}</p>
					<div class="shop">
{% if offer.Stylist.disp_shop_name %}
						<h2><a href="{{ offer.Stylist.url }}" target="_blank">{{ offer.Stylist.shop_name }}</a></h2>
{% endif %}
						<p>{{ offer.Stylist.station }}駅</p>
					</div>
					<div class="clearfix">
{% if offer_schedule_id %}
						<p class="prof">あなたが選んだ日時</p>
						<ul class="weekUl">
							{% for schedule in offer.Offer.schedules %}
							{% if offer_schedule_id == schedule.OfferSchedule.id %}
							<li class="{{ schedule.OfferSchedule.day_of_week|lower }}"><span class="dateSpan"><strong>{{ schedule.OfferSchedule.day_of_week|title }}</strong>{{ schedule.OfferSchedule.date|date('m.d') }}</span><span class="timeSpan">{{ schedule.OfferSchedule.starttime|slice(0,5) }}</span></li>
							{% endif %}
							{% endfor %}
{% else %}
						<p class="prof">あなたがオファーした希望日時</p>
						<ul class="weekUl">
							{% set schedule = offer.Offer.schedules.OfferSchedule %}
							<li class="{{ schedule.day_of_week|lower }}"><span class="dateSpan"><strong>{{ schedule.day_of_week|title }}</strong>{{ schedule.date|date('m.d') }}</span><span class="timeSpan">{{ schedule.starttime|slice(0,5) }}</span></li>
{% endif %}
						</ul>
					</div>
				</div>
			</div>

			<div class="formBox">
				<h2><span>あなたの希望</span></h2>
				<dl>
{% if (logindata.CutModel.style == 1) or (logindata.CutModel.style == 4) or (logindata.CutModel.style == 5) %}
					<dt>カット</dt><dd><span>:</span>{{ hairlengthlist[logindata.CutModel.cut_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ hairlengthafterlist[logindata.CutModel.cut_after] }}</dd>
{% endif %}
{% if (logindata.CutModel.style == 2) or (logindata.CutModel.style == 4) %}
					<dt>カラー</dt><dd><span>:</span>{{ colorbefore[logindata.CutModel.color_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ colorafter[logindata.CutModel.color_after] }}</dd>
{% endif %}
{% if (logindata.CutModel.style == 3) or (logindata.CutModel.style == 5) %}
					<dt>パーマ</dt><dd><span>:</span>{{ permbefore[logindata.CutModel.perm_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ permafter[logindata.CutModel.perm_after] }}</dd>
{% endif %}
				</dl>
			</div>
		</div>
		<div class="comfirmRight">
			<div class="comfirmBox02">
				<p>決済が完了すると美容師とのマッチングが成立し、直接メッセージのやり取りができるようになります。</p>
				
				<p>決済方法は、カード決済とコンビニ決済がございます。</br>※コンビニ決済をご利用の場合、コンビニエンスストアでのマッチング料お支払いが確認できた後に、マッチング成立となります。</p>
				<p class="mb0">美容師アシスタントの技術向上の為のモデルであるため、施術には通常よりお時間がかかる場合がございます。</p>
				<p>施術後は、スタイリストのチェックが入りますのでご安心下さい。</p>
			</div>
			<div class="tableBox">
				<table cellspacing="0" cellpadding="0" summary="承認内容の確認" class="table01">
					<col width="32%"><col width="68%">
{% set total = 0 %}
{% for key, content in offer.Stylist.apply_content %}
{% if content in offer.Offer.content %}
					<tr>
						<th>{{ stylelist[content] }}代</th>
						<td>{% if offer.Stylist.apply_price[key] == 0 %}無料{% else %}{% set total = total + offer.Stylist.apply_price[key] %}{{ offer.Stylist.apply_price[key] }}円{% endif %}</td>
					</tr>
{% endif %}
{% endfor %}
			</table>
			</div>
			<div class="formBox">
				<h2><span>お店のメニュー</span></h2>
	<dl>
		<dt>対象</dt><dd><span>:</span>&nbsp;{{ gender[offer.Stylist.apply_gender] }}</dd>
		<dt>価格</dt><dd><span>:</span>
{% set yuryo = '0' %}
{% set separator = '' %}
{% for key, content in offer.Stylist.apply_content %}
{{ separator }}{{ stylelist[content] }}{% if offer.Stylist.apply_price[key] == 0 %}無料{% else %}({{ offer.Stylist.apply_price[key] }}円){% set yuryo = '1' %}{% endif %}
{% set separator = '、' %}
{% endfor %}
		</dd>
{% if yuryo == 1 %}
	<p class="notice">カラー・パーマを実施する場合は（）内の金額を</br>美容師さまへ直接手渡しでお支払い下さい</p>
{% endif %}
	</dl>
	</div>		
{% if 0 == 1 %}
			<div class="tableBox01">
				<table cellspacing="0" cellpadding="0" summary="承認内容の確認" class="table01">
					<col width="32%"><col width="68%">
					<tr>
						<th>お店でのお支払い</th>
						<td>{{ total }}円</td>
					</tr>
				</table>
			</div>
			<p class="notice">こちらのお金は、美容師さまへ直接手渡しでお支払い下さい。</p>
{% endif %}
			<div class="tableBox01">
				<table cellspacing="0" cellpadding="0" summary="承認内容の確認" class="table01">
					<col width="32%"><col width="68%">
					<tr>
						<th>マッチング料</th>
						<td>500円</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<ul class="comfirmBtn clearfix">
		<li><a href="/user/offer/" title="やっぱりやめておく"><span>やっぱりやめておく…</span></a></li>
		<li class="lastBtn">{{ form.create() }}<a href="" title="決済へ進む" onclick="$(this).closest('form').submit(); return false;"><span>決済へ進む</span></a>{{ form.end() }}</li>
	</ul>
</div>