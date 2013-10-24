<article id="contentsIn" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
{% include 'Elements/subheader.tpl' with {'subtitle':'美容師プロフィール', 'roledir':'stylist'} %}

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
	<h1>レビュー（{{ review_count }}件）</h1>
{% for review in reviews %}
	<div class="review">
		<div class="wrapper">
			<figure class="left"><img src="http://graph.facebook.com/{{ review.CutModelUser.facebook_id }}/picture" alt="{{ review.CutModelUser.last_name}}&nbsp;{{ review.CutModelUser.first_name }}" width="65" height="65"></figure>
			<div class="right">
			<h2>{{ review.CutModelUser.last_name }}&nbsp;{{ review.CutModelUser.first_name }}</h2>
			<p>{{ prefecture[review.CutModel.prefecture01] }}<br>{{ gender[review.CutModelUser.gender] }}</p>
			</div>
		</div>
		<div class="comment"><div>
			<p>{{ review.Review.review }}</p>
		</div></div>
	</div>
{% endfor %}
{% if review_count > constant('LIMIT_REVIEW') %}
	<p class="more"><a href="/user/review/stylist/{{ stylist.Stylist.id }}" class="fadeBtn">もっとみる</a></p>
{% endif %}
</aside>


<aside class="portfolio">
	<h1>ポートフォリオ（{{ portfolios|length }}件）</h1>
	<ul>
{% for portfolio in portfolios %}
		<li><a href=""><img src="/img/dammy.png" alt="dammy" width="65" height="65" class="fadeBtn"></a></li>
{% endfor %}
	</ul>
{% if portfolio_count > constant('LIMIT_PORTFOLIO') %}
	<p class="more"><a href="" class="fadeBtn">もっとみる</a></p>
{% endif %}
</aside>



</div><!-- //right menu -->



</div><!-- //#mainContents -->


</article>