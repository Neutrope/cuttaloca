<article id="contentsIn" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/user/search/">戻る</a></p><h1>成立</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/user/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/user/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/user/offer/entry/" title="掲載内容 確認＆更新" class="fadeBtn">掲載内容 確認＆更新</a></li>
</ul></nav>
<p class="who"><a href="/user/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>

<div id="mainContents">



<!-- main -->
<div id="leftMain">


<div class="stylistDataBox">


<section class="stylistData">

{% for offer in offers %}
{% set schedule = offer.Offer.schedules.OfferSchedule %}
{% set date = schedule.date~' '~schedule.starttime %}

{% set stylist = offer %}
{% set today = 'now'|date('Y-m-d') %}

{% if date(schedule.date) == date(today) %}
	{% set line = '12' %}
	{% set message = '<br>本日がカット予定日です<br>新しい髪型を考えながら、<br>お待ち下さい！' %}
{% elseif date(schedule.date) > date(today) %}
	{% set line = '12' %}
	{% set message = 'カット日まで、<br>新しい髪型を考えながら、<br>お待ち下さい！' %}
{% elseif 1 == 0 %}
	{% set line = '13' %}
	{% set message = '新しい髪型はどうですか？<br>美容師にレビューを<br>書いてみませんか？' %}
{% else %}
	{% set line = '12' %}
	{% set message = '新しい髪型はどうですか？<br>またのご利用お待ちしております。' %}
{% endif %}

<div class="stylistDataIn heightLine-{{ line }}">
<div class="wrapper clearfix">
	<div class="profile">
		<div class="left">
			<figure class="face"><a href="/user/stylist/{{ offer.Offer.stylist_id }}"><img class="fadeBtn" src="https://graph.facebook.com/{{ stylist.User.facebook_id }}/picture?type=large&width=100&height=100" alt="{{ stylist.User.last_name }}&nbsp;{{ stylist.User.first_name }}" width="100" height="100"></a></figure>
			<div class="name">
				{% include 'Elements/stylist_name.tpl' %}
				<p class="prof">カット予定日</p>
				<ul class="weekUl">
					<li class="{{ schedule.day_of_week|lower }}"><span class="dateSpan"><strong>{{ schedule.day_of_week|title }}</strong>{{ schedule.date|date('m.d') }}</span><span class="timeSpan">{{ schedule.starttime|slice(0,5) }}</span></li>
				</ul>
			</div>
		</div>

		{% include 'Elements/stylist_apply.tpl' %}
	</div>
	<div class="message">
		<aside class="offerfolio">
			<table class="offer-message">
				<tr>
					<td>{{ message }}</td>
				</tr>
			</table>
{% if line == '12' %}
			<p class="schedule schedule01 schedule02"><a href="/user/offer/message/{{ offer.Offer.id }}"><span>美容師へ連絡する</span></a></p>
{% else %}

{% if date(schedule.date) >= date(two_weeks_before) %}
			<p class="schedule schedule01 schedule02"><a href="/user/offer/message/{{ offer.Offer.id }}"><span>美容師へ連絡する</span></a></p>
{% else %}
			<p class="schedule schedule01 schedule03"><a href="/user/stylist/review/{{ stylist.Stylist.id }}"><span>レビューを書く</span></a></p>
{% endif %}

{% endif %}
		</aside>
	</div>
</div>	
</div>

{% endfor %}

</section>



</div><!-- //.stylistDataBox -->

</div><!-- //#leftMenu -->

</div><!-- //#mainContents -->


</article>