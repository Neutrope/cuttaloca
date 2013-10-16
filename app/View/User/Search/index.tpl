<article id="contentsIn" class="stylistList">

<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><h1>美容師を探す</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/user/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/user/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/user/offer/entry/" title="掲載登録" class="fadeBtn">掲載登録</a></li>
</ul></nav>
<p class="who"><a href="/user/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>




<div id="mainContents">


<!-- left menu -->
<aside id="leftMenu">
{{ form.create('Stylist', {'type':'get'}) }}

<!-- 地域から絞り込み -->
<div class="place">
<h1><a href="">地域から絞り込み</a></h1>
<div class="hideDiv">
<ul class="hideUl">
<li>
	{{ form.select('prefecture', search_prefecture, {'empty':'都道府県'}) }}
</li>
<li>
	{{ form.select('area', {}, {'empty':'エリア'}) }}
</li>
</ul>
</div>
</div>



<!-- 性別から絞り込み -->
<div class="sex">
<h1><a href="">性別から絞り込み</a></h1>
<div class="hideDiv">
<ul class="hideUl">
	<li>{{ form.radio('apply_gender', gender, {'legend':false, 'separator':'</li><li>'}) }}</li>
</ul>
</div>
</div>



<!-- 条件から絞り込み -->
<div class="terms">
<h1><a href="">条件から絞り込み</a></h1>
<div class="hideDiv">
	<div class="hideUl">
		{{ form.select('apply_content', stylelist, {'multiple':'checkbox'}) }}
	</div>
</div>
</div>


<!-- 絞り込み -->
<p class="btn"><a href="#" id="search-refinement"><span>この条件で絞り込む</span></a></p>

{{ form.end() }}
</aside>



<!-- main -->
<div id="rightMain">


<div class="stylistDataBox">


<!-- repeat -->
{% for stylist in stylists %}

<section class="stylistData">

<div class="wrapper">
	<div class="left">
		<figure class="face"><a href="/user/stylist/{{ stylist.Stylist.id }}" class="fadeBtn"><img src="https://graph.facebook.com/{{ stylist.User.facebook_id }}/picture?type=large&width=100&height=100" alt="{{ stylist.User.last_name }}&nbsp;{{ stylist.User.first_name }}" width="100" height="100"></a></figure>
		<div class="name">
			{% include 'Elements/stylist_name.tpl' %}
		</div>

		<div class="link">
			<ul>
				<li class="m1"><a href="/user/stylist/{{ stylist.Stylist.id }}"><span>もっと詳しく</span></a></li>
				<li class="m2"><a href="#"><span>スケジュール</span></a></li>
			</ul>
		</div>
	</div>
	
	{% include 'Elements/stylist_apply.tpl' %}
</div>

{% include 'Elements/schedule.tpl' %}
</section>
{% endfor %}

</div><!-- //.stylistDataBox -->

{% if search_results > constant('SEARCH_DISP_NUM') * page %}
<!-- MORE -->
<p class="shadowButton700"><a href="/user/search/?{{ query }}"><span>もっと見る</span></a></p>
{% endif %}

</div>



</div><!-- //#mainContents -->


</article>