<article id="contentsIn" class="stylist">
<!-- Sub Header -->
{% include 'Elements/subheader.tpl' with {'subtitle':'美容師との連絡', 'roledir':'user'} %}

<div id="mainContents">

<ul id="offer-message">
{% for message in messages %}
{% if message.OfferMessage.direction == constant('DIRECTION_TO_STYLIST') %}
	<li class="left-image clearfix">
		<div class="image"><img src="https://graph.facebook.com/{{ offer.CutModelUser.facebook_id }}/picture" alt="" width="50" height="50" /></div>
{% else %}
	<li class="right-image clearfix">
		<div class="image"><img src="https://graph.facebook.com/{{ offer.StylistUser.facebook_id }}/picture" alt="" width="50" height="50" /></div>
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