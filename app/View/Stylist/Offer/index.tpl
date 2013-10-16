<article id="contentsIn" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/stylist/search/">戻る</a></p><h1>オファー</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/stylist/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/stylist/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/stylist/offer/entry" title="掲載登録" class="fadeBtn">掲載登録</a></li>
</ul></nav>
<p class="who"><a href="/stylist/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>

<div id="mainContents">



<!-- main -->
<div id="leftMain">


<div class="stylistDataBox">


<section class="stylistData">

{% for offer in offers %}

{% if offer.Offer.status == constant('STATUS_OFFER') %}
	{% if offer.Offer.direction == constant('DIRECTION_TO_CUTMODEL') %}
		{% set line = '01' %}
		{% set message = 'このカットモデルに<br>オファーを依頼中です。<br><br>オファーが承認されるまで<br>お待ちください。' %}
	{% else %}
		{% set line = '02' %}
		{% set message = 'あなたへのオファーが、<br>届いています！' %}
	{% endif %}
{% elseif offer.Offer.status == constant('STATUS_ADJUST') %}
	{% if offer.Offer.direction == constant('DIRECTION_TO_CUTMODEL') %}
		{% set line = '01' %}
		{% set message = '現在、このカットモデルに<br>オファーを依頼中です。' %}
	{% else %}
		{% set line = '02' %}
		{% set message = '日程の調整依頼がきています。' %}
	{% endif %}
{% elseif offer.Offer.status == constant('STATUS_CANCEL') %}
	{% set line = '03' %}
	{% set message = '残念ながら、<br>成立しませんでした。<br><br>他のカットモデルを、<br>探してみましょう。' %}
{% elseif offer.Offer.status == constant('STATUS_SUCCESS') %}
	{% set line = '11' %}
	{% set message = 'カットモデルが決済をすると<br>オファーが成立します。<br><br>いましばらくお待ち下さい。' %}
{% endif %}

{% set stylist = offer %}

<div class="stylistDataIn heightLine-{{ line }}">
<div class="wrapper clearfix">
	<div class="profile clearfix">
		<div class="left">
			<figure class="face"><a href="/user/stylist/{{ offer.Offer.stylist_id }}"><img class="fadeBtn" src="https://graph.facebook.com/{{ stylist.User.facebook_id }}/picture?type=large&width=100&height=100" alt="{{ stylist.User.last_name }}&nbsp;{{ stylist.User.first_name }}" width="100" height="100"></a></figure>
			<div class="name">
				{% include 'Elements/cutmodel_name.tpl' %}
{% if offer.Offer.direction == constant('DIRECTION_TO_CUTMODEL') %}
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
		{% include 'Elements/cutmodel_apply.tpl' %}
	</div>
	<div class="message">
		<aside class="offerfolio">
			<table class="offer-message">
				<tr>
					<td>{{ message }}</td>
				</tr>
			</table>
{% if line == '02' %}
			{{ form.create('OfferSchedule', {'url':'/stylist/offer/accept/'~offer.Offer.id~'/', 'class':'form-accept'}) }}
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
					{{ form.create('Offer', {'url':'/stylist/offer/cancel/', 'class':'form-cancel'}) }}
						{{ form.hidden('id', {'value':offer.Offer.id}) }}
						<a href="#" class="offer-cancel"><span>今回はやめておく</span></a>
					{{ form.end() }}
				</li>
			</ul>
			<p class="schedule"><a href="#dateList" id="adjust-{{ offer.Offer.id }}" class="adjust-stylist"><span>日程調整をする</span></a></p>
{% elseif line == '03' %}
		   <p class="schedule schedule01"><a href="/stylist/search/" id="various1"><span>カットモデルを探す</span></a></p>
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

<div id="dateList" class="stylistData dateList">
	{{ form.create('Offer', {'url':'/stylist/offer/adjust'}) }}
		{{ form.hidden('id', {'id':'fancy-offer-id'}) }}
		{% set stylist = my_schedule %}
		{% set checkbox = true %}
		{% include 'Elements/schedule.tpl' %}
		<!-- 希望日時を送付する -->
		<p class="shadowButton700"><a href="" class="offer-adjust"><span>希望日時を送付する</span></a></p>
	{{ form.end() }}
</div>
.