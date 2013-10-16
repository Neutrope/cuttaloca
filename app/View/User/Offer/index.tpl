<article id="contentsIn" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/user/search/">戻る</a></p><h1>オファー</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/user/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/user/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/user/offer/entry/" title="掲載登録" class="fadeBtn">掲載登録</a></li>
</ul></nav>
<p class="who"><a href="/user/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>

<div id="mainContents">



<!-- main -->
<div id="leftMain">


<div class="stylistDataBox">


<section class="stylistData">

{% for offer in offers %}

{% if offer.Offer.status == constant('STATUS_OFFER') %}
	{% if offer.Offer.direction == constant('DIRECTION_TO_STYLIST') %}
		{% set line = '01' %}
		{% set message = '現在、このスタイリストに<br>オファーを依頼中です。<br><br>オファーが承認されるまで<br>お待ちください。' %}
	{% else %}
		{% set line = '02' %}
		{% set message = 'あなたへのオファーが、<br>届いています！' %}
	{% endif %}
{% elseif offer.Offer.status == constant('STATUS_ADJUST') %}
	{% if offer.Offer.direction == constant('DIRECTION_TO_STYLIST') %}
		{% set line = '01' %}
		{% set message = '現在、このスタイリストに<br>オファーを依頼中です。<br><br>オファーが承認されるまで<br>お待ちください。' %}
	{% else %}
		{% set line = '02' %}
		{% set message = '日程の調整依頼がきています。' %}
	{% endif %}
{% elseif offer.Offer.status == constant('STATUS_CANCEL') %}
	{% set line = '03' %}
	{% set message = '残念ながら、<br>成立しませんでした。<br><br>他のスタイリストを、<br>探してみましょう。' %}
{% elseif offer.Offer.status == constant('STATUS_SUCCESS') %}
		{% set line = '11' %}
	{% if offer.Offer.paid == 0 %}
		{% set message = '決済が未完了です。<br><br>オファーを確定させて<br>サロンへ行こう！<br>※ 決済はお早めに！' %}
	{% elseif offer.Offer.paid == 2 %}
		{% set message = '入金待ちの状態です。<br>コンビニ決済を済ませてください。' %}
	{% endif %}
{% endif %}

{% set stylist = offer %}

<div class="stylistDataIn heightLine-{{ line }}">
<div class="wrapper clearfix">
	<div class="profile clearfix">
		<div class="left">
			<figure class="face"><a href="/user/stylist/{{ offer.Offer.stylist_id }}"><img class="fadeBtn" src="https://graph.facebook.com/{{ offer.User.facebook_id }}/picture?type=large&width=100&height=100" alt="face" width="100"></a></figure>
			<div class="name">
				{% include 'Elements/stylist_name.tpl' %}
{% if offer.Offer.direction == constant('DIRECTION_TO_STYLIST') %}
				<p class="prof">あなたがオファーした希望日時</p>
				<ul class="weekUl">
{% if offer.Offer.schedules.OfferSchedule is empty %}
{% for schedule in offer.Offer.schedules %}
					<li class="{{ schedule.OfferSchedule.day_of_week|lower }}"><span class="dateSpan"><strong>{{ schedule.OfferSchedule.day_of_week|title }}</strong>{{ schedule.OfferSchedule.date|date('m.d') }}</span><span class="timeSpan">{{ schedule.OfferSchedule.starttime|slice(0,5) }}</span></li>
{% endfor %}
{% else %}
{% set schedule = offer.Offer.schedules %}
					<li class="{{ schedule.OfferSchedule.day_of_week|lower }}"><span class="dateSpan"><strong>{{ schedule.OfferSchedule.day_of_week|title }}</strong>{{ schedule.OfferSchedule.date|date('m.d') }}</span><span class="timeSpan">{{ schedule.OfferSchedule.starttime|slice(0,5) }}</span></li>
{% endif %}
				</ul>
{% endif %}
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
{% if line == '02' %}
{{ form.create('OfferSchedule', {'url':'/user/offer/settlement/'~offer.Offer.id~'/', 'class':'form-accept'}) }}
			{{ form.hidden('offer_id', {'value':offer.Offer.id}) }}
				<p class="prof">オファーされている日時</p>
				<ul class="weekUl">
{% for schedule in offer.Offer.schedules %}
					<li class="{{ schedule.OfferSchedule.day_of_week }}"><span class="dateSpan"><strong>{{ schedule.OfferSchedule.day_of_week|title }}</strong>{{ schedule.OfferSchedule.date|date('m.d') }}</span><input type="radio" name="data[OfferSchedule][id]" value="{{ schedule.OfferSchedule.id }}" id="schedule{{ schedule.OfferSchedule.id }}" /><label for="schedule{{ schedule.OfferSchedule.id }}">{{ schedule.OfferSchedule.starttime|slice(0,5) }}</label></li>
{% endfor %}
				</ul>
			{{ form.end() }}
			<p class="rep">承認する場合は希望日程を選択して「承認する」をクリックして下さい。</p>
			<ul class="offerLink clearfix">
				<li class="of01"><a href="#" class="offer-accept"><span>承認する</span></a></li>
				<li class="of02">
					{{ form.create('Offer', {'url':'/user/offer/cancel/', 'class':'form-cancel'}) }}
						{{ form.hidden('id', {'value':offer.Offer.id}) }}
						<a href="#" class="offer-cancel"><span>今回はやめておく</span></a>
					{{ form.end() }}
				</li>
			</ul>
			<p class="schedule"><a href="#dateList-{{ offer.Offer.stylist_id }}" id="stylist-{{ offer.Offer.stylist_id }}-{{ offer.Offer.id }}" class="adjust-cutmodel"><span>日程調整をする</span></a></p>
{% elseif line == '03' %}
			<p class="schedule schedule01"><a href="/user/search/"><span>美容師を探す</span></a></p>
{% elseif line == '11' %}
	{% if offer.Offer.paid == 0 %}
			<p class="schedule schedule01"><a href="/user/offer/settlement/{{ offer.Offer.id }}"><span>オファー内容の承認/決済</span></a></p>
	{% endif %}
{% endif %}
		</aside>
	</div>
</div>
</div>

{% endfor %}

</section>



</div><!-- //.stylistDataBox -->

</div><!-- //#mainContents -->



</div><!-- //#mainContents -->


</article>

{% set checkbox = true %}
{% for stylist in stylists %}
<div id="dateList-{{ stylist.Stylist.id }}" class="stylistData dateList">
	{{ form.create('Offer', {'url':'/user/offer/adjust'}) }}
		{{ form.hidden('id', {'class':'fancy-offer-id'}) }}
		{% include 'Elements/schedule.tpl' %}
		<!-- 希望日時を送付する -->
		<p class="shadowButton700"><a href="" class="offer-adjust"><span>希望日時を送付する</span></a></p>
	{{ form.end() }}
</div>
{% endfor %}