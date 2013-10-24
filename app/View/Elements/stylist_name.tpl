<h1><a href="/user/stylist/{{ stylist.Stylist.id }}">{{ stylist.User.last_name }}&nbsp;{{ stylist.User.first_name }}</a></h1>
<p>{{ gender[stylist.User.gender] }}&nbsp;&nbsp;|&nbsp;&nbsp;{{ prefecture[stylist.Stylist.prefecture] }}</p>
<div class="shop">
{% if stylist.Stylist.disp_shop_name == 1 %}
	<h2><a href="{{ stylist.Stylist.url }}" target="_blank">{{ stylist.Stylist.shop_name }}</a></h2>
{% endif %}
	<p>{{ stylist.Stylist.station }}</p>
</div>
