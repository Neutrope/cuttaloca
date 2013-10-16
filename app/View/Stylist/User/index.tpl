<article id="contentsIn" class="stylist">
<input type="hidden" id="style-list" value="{{ stylelist|join(',') }}" />
<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/stylist/search/">戻る</a></p><h1>カットモデル</h1></div>
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

<div class="stylistDataIn">
<div class="wrapper">

	<div class="left">
		<figure class="face"><a href="/user/stylist/{{ stylist.Stylist.id }}" class="fadeBtn"><img src="https://graph.facebook.com/{{ stylist.User.facebook_id }}/picture?type=large&width=100&height=100" alt="{{ stylist.User.last_name }}&nbsp;{{ stylist.User.first_name }}" width="100" height="100"></a></figure>
		<div class="name">
			{% include 'Elements/cutmodel_name.tpl' %}
		</div>
		
	</div>
	
	{% include 'Elements/cutmodel_apply.tpl' %}

</div>
</div>



<aside>
<header class="sceduleHead"><h1>スケジュール</h1><h2>候補日を３つまで選べます。</h2></header>


<div class="stylistDataIn">

{% set stylist = my_schedule %}
{% set checkbox = true %}
{% include 'Elements/schedule.tpl' %}
</div>

</aside>


</section>


</div><!-- //.stylistDataBox -->



<!-- 希望日時を送付する -->
<p class="shadowButton700"><a href="#hairdresser" class="offer"><span>希望日時を送付する</span></a></p>


</div><!-- //#mainContents -->


<!-- right menu -->
<div id="rightMenu">

<aside class="reviews">
	<h1>レビュー（{{ reviews|length }}件）</h1>
{% for review in reviews %}
	<div class="review">
		<div class="wrapper">
			<figure class="left"><img src="/img/dammy.png" alt="dammy" width="65" height="65"></figure>
			<div class="right">
			<h2>{{ review.CutModelUser.last_name }}&nbsp;{{ review.CutModelUser.first_name }}</h2>
			<p>{{ prefecture[review.CutModelUser.residence] }}<br>{{ gender[CutModelUser.gender] }}</p>
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