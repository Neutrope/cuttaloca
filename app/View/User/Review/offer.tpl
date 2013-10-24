<article id="contentsIn" class="stylist">
<!-- Sub Header -->
{% include 'Elements/subheader.tpl' with {'subtitle':'レビューを書く', 'roledir':'user'} %}
{% set schedule = offer.Offer.schedules.OfferSchedule %}

<div id="mainContents">
<section class="stylistData">
<div class="stylistDataIn heightLine-12">
<div class="wrapper clearfix">
	<div class="profile">
		<div class="left">
			<figure class="face"><a href="/user/stylist/{{ offer.Offer.stylist_id }}"><img class="fadeBtn" src="https://graph.facebook.com/{{ stylist.User.facebook_id }}/picture?type=large&width=100&height=100" alt="{{ stylist.User.last_name }}&nbsp;{{ stylist.User.first_name }}" width="100" height="100"></a></figure>
			<div class="name">
				{% include 'Elements/stylist_name.tpl' %}
				<p class="prof">カット実施日</p>
				<ul class="weekUl">
					<li class="{{ schedule.day_of_week|lower }}"><span class="dateSpan"><strong>{{ schedule.day_of_week|title }}</strong>{{ schedule.date|date('m.d') }}</span><span class="timeSpan">{{ schedule.starttime|slice(0,5) }}</span></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="right">
		<h2><span>レビューを書く</span></h2>
{{ form.create('Review') }}
		{{ form.textarea('review') }}
		<div class="schedule schedule01 clearfix"><a href="#" id="send-review"><span>レビューを送信する</span></a></div>
{{ form.end() }}
	</div>
</div>
</div>
</section>
</div><!-- //#mainContents -->

</article>