<article id="contentsIn" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
{% include 'Elements/subheader.tpl' with {'subtitle':'成立', 'roledir':'user'} %}

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
{% elseif date(schedule.date) <= date(review_date) %}
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
{% elseif line == '13' %}
			<ul class="offerLink approve clearfix">
				<li class="of11"><a href="/user/review/offer/{{ offer.Offer.id }}"><span>レビューを<br>書く</span></a></li>
				<li class="of12"><a href="/user/offer/message/{{ offer.Offer.id }}"><span>美容師へ<br>連絡する</span></a></li>
			</ul>
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