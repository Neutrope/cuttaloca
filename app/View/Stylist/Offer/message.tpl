<article id="contentsIn" class="stylist">
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/stylist/search/">戻る</a></p><h1>カットモデルとの連絡</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/stylist/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/stylist/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="" title="掲載登録" class="fadeBtn">掲載登録</a></li>
</ul></nav>
<p class="who"><a href="/stylist/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>

<div id="mainContents">

<ul id="offer-message">
{% for message in messages %}
{% if message.OfferMessage.direction == constant('DIRECTION_TO_CUTMODEL') %}
	<li class="left-image clearfix">
		<div class="image"><img src="https://graph.facebook.com/{{ offer.StylistUser.facebook_id }}/picture" alt="" width="50" height="50" /></div>
{% else %}
	<li class="right-image clearfix">
		<div class="image"><img src="https://graph.facebook.com/{{ offer.CutModelUser.facebook_id }}/picture" alt="" width="50" height="50" /></div>
{% endif %}
		<div class="message">{{ message.OfferMessage.message }}</div>
	</li>
{% endfor %}
	<li class="send">
		{{ form.create('OfferMessage') }}
			{{ form.textarea('message', {'placeholder':'メッセージはここに記載してください'}) }}
			<p class="shadowButton700" style="margin: 10px auto;"><a href="" onclick="$(this).closest('form').submit(); return false;"><span>メッセージを送信する</span></a></p>
		{{ form.end() }}
	</li>
</ul>


</div><!-- //#mainContents -->


</article>