<article id="contentsIn" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/user/search/">戻る</a></p><h1>美容師プロフィール</h1></div>
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

<div class="stylistDataIn">
<div class="wrapper">
	<div class="left">
		<figure class="face"><a href="/user/stylist/{{ stylist.Stylist.id }}" class="fadeBtn"><img src="http://graph.facebook.com/{{ stylist.User.facebook_id }}/picture?type=large&width=100&height=100" alt="face" width="100" height="100"></a></figure>
		<div class="name">
			{% include 'Elements/stylist_name.tpl' %}
			<div class="howtime"><h3>カッタロカでの成約回数</h3><p class="count"><strong>{{ stylist.User.cutting }}</strong>回</p></div>
		</div>
		
	</div>

	{% include 'Elements/stylist_apply.tpl' %}
</div>
</div>

{% if message == 0 and time == false %}
<aside>
<header class="sceduleHead"><h1>スケジュール</h1><h2>候補日を３つまで選べます。</h2></header>

<div class="stylistDataIn">
	{% set checkbox = true %}
	{% include 'Elements/schedule.tpl' %}
</div>

</aside>
{% endif %}
</section>

</div><!-- //.stylistDataBox -->

{% if message > 0 %}
	<p class="shadowButton700"><a href="/user/offer/message/{{ message }}"><span>美容師へ連絡する</span></a></p>
{% elseif time %}
	<p class="shadowButton700"><a href="#" onclick="history.back(); return false;"><span>前のページヘ戻る</span></a></p>
{% else %}
<!-- 希望日時を送付する -->
<p class="shadowButton700"><a href="#hairdresser" class="offer"><span>希望日時を送付する</span></a></p>
{% endif %}
</div><!-- //.leftMenu -->


<!-- right menu -->
<div id="rightMenu">

<aside class="reviews">
	<h1>レビュー（{{ reviews|length }}件）</h1>
{% for review in reviews %}
	<div class="review">
		<div class="wrapper">
			<figure class="left"><img src="http://graph.facebook.com/{{ review.User.facebook_id }}/picture" alt="{{ review.User.last_name}}&nbsp;{{ review.User.first_name }}" width="65" height="65"></figure>
			<div class="right">
			<h2>{{ review.User.last_name }}&nbsp;{{ review.User.first_name }}</h2>
			<p>{{ prefecture[review.CutModel.prefecture01] }}<br>{{ gender[review.User.gender] }}</p>
			</div>
		</div>
		<div class="comment"><div>
			<p>{{ review.Review.review|nl2br }}</p>
		</div></div>
	</div>
{% endfor %}
	<p class="more"><a href="" class="fadeBtn">もっとみる</a></p>
</aside>


<aside class="portfolio">
	<h1>ポートフォリオ（{{ portfolios|length }}件）</h1>
	<ul>
{% for portfolio in portfolios %}
		<li><a href=""><img src="/img/dammy.png" alt="dammy" width="65" height="65" class="fadeBtn"></a></li>
{% endfor %}
	</ul>
	<p class="more"><a href="" class="fadeBtn">もっとみる</a></p>
</aside>



</div><!-- //right menu -->



</div><!-- //#mainContents -->


</article>