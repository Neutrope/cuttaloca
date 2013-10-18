<article id="contentsIn" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/stylist/search/">戻る</a></p><h1>成立</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/stylist/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/stylist/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/stylist/offer/entry" title="掲載内容 確認＆更新" class="fadeBtn">掲載内容 確認＆更新</a></li>
</ul></nav>
<p class="who"><a href="/stylist/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>

<div id="mainContents">



<!-- main -->
<div id="leftMain">


<div class="stylistDataBox">


<section class="stylistData">

{% for offer in offers %}
{% set schedule = offer.Offer.schedules.OfferSchedule %}


{% set stylist = offer %}
{% set today = 'now'|date('Y-m-d') %}

{% if date(schedule.date) == date(today) %}
	{% set line = '12' %}
	{% set message = 'マッチングが成立しました！<br>本日がカット予定日です' %}
{% elseif date(schedule.date) > date(today) %}
	{% set line = '12' %}
	{% set message = 'マッチングが成立しました！' %}
{% elseif 1 == 0 %}
	{% set line = '13' %}
	{% set message = 'カットモデルは<br>いかがでしたか？<br><br>ポートフォリオを<br>アップロードしてみましょう。' %}
{% else %}
	{% set line = '12' %}
	{% set message = 'マッチングが成立しました！' %}
{% endif %}

<div class="stylistDataIn heightLine-{{ line }}">
<div class="wrapper clearfix">
	<div class="profile clearfix">
		<div class="left">
			<figure class="face"><a href="/user/stylist/{{ offer.Offer.stylist_id }}"><img class="fadeBtn" src="https://graph.facebook.com/{{ stylist.User.facebook_id }}/picture?type=large&width=100&height=100" alt="{{ stylist.User.last_name }}&nbsp;{{ stylist.User.first_name }}" width="100" height="100"></a></figure>
			<div class="name">
				{% include 'Elements/cutmodel_name.tpl' %}

				<p class="prof">カット予定日</p>
				<ul class="weekUl">
					<li class="{{ schedule.day_of_week }}"><span class="dateSpan"><strong>{{ schedule.day_of_week|title }}</strong>{{ schedule.date|date('m.d') }}</span><span class="timeSpan">{{ schedule.starttime|slice(0,5) }}</span></li>
				</ul>
			</div>
		</div>
		{% include 'Elements/cutmodel_apply.tpl' %}
	</div>
	<div class="message">
		<aside class="offerfolio">
			<table class="offer-message">
				<tr>
					<td>{{ message }}</td>
				</tr>
			</table>
{% if line == '12' %}
			<p class="schedule schedule01 schedule02"><a href="/stylist/offer/message/{{ offer.Offer.id }}"><span>カットモデルへ連絡する</span></a></p>
{% elseif line == '13' %}

{% if date(schedule.date) >= date(two_weeks_before) %}
			<p class="schedule schedule01 schedule02"><a href="/stylist/offer/message/{{ offer.Offer.id }}"><span>カットモデルへ連絡する</span></a></p>
{% else %}
			<p class="schedule schedule01 schedule03"><a href="/stylist/user/portfolio/{{ stylist.Stylist.id }}"><span>ポートフォリオをアップする</span></a></p>
{% endif %}

{% endif %}
		</aside>
	</div>
</div>	
</div>

{% endfor %}

</section>



</div><!-- //.stylistDataBox -->

</div><!-- //#leftMain -->

</div><!-- //#mainContents -->


</article>