<article id="contentsIn" class="stylist">

<!-- Sub Header -->
<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/stylist/search/">戻る</a></p><h1>マイページ</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/stylist/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/stylist/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/stylist/offer/entry/" title="掲載登録" class="fadeBtn">掲載登録</a></li>
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
		<figure class="face"><img src="https://graph.facebook.com/{{ logindata.User.facebook_id }}/picture?type=large&width=100&height=100" alt="{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}" width="100" height="100">
		<p class="creation clearfix"><!-- <a href="/stylist/mypage/edit" class="fadeBtn">設定</a>--></p></figure>
		<div class="name">
			<dl class="nameDl">
				<dt>{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</dt>
				<dd>{{ gender[logindata.User.gender] }}｜{{ prefecture[logindata.Stylist.prefecture] }}</dd>
			</dl>
			<div class="howtime"><h3>カッタロカでの成約回数</h3><p class="count"><strong>{{ logindata.User.cutting }}</strong>回</p></div>
		</div>
	</div>

	{% set stylist = logindata %}
	{% include 'Elements/stylist_apply.tpl' %}
</div>	
</div>

<!--
<aside>
<header class="sceduleHead"><h1>スケジュール</h1></header>

<div class="stylistDataIn">
<div class="hideScedule">

<nav class="navi"><ul>
		<li class="prev prev01"><a href=""><span>PREV WEEK</span></a></li>
		<li class="next next01"><a href=""><span>NEXT WEEK</span></a></li>
</ul></nav>
	
<div class="weeksWrapper">
	<div class="weeks">
		<!++ week ++>
		<div class="week">
			<ol class="day">
				<li class="sun heightLine-01">
					<h1><strong>Sun</strong>1.27</h1>
				</li>
				<li class="mon heightLine-01">
					<h1><strong>Mon</strong>1.28</h1>
					<ol class="hourCut">
						<li class="green">21:00<a href="#">承認待ち</a></li>
					</ol>
				</li>
				<li class="tue heightLine-01">
					<h1><strong>Tue</strong>1.29</h1>
					<ol class="hourCut">
						<li class="red">20:30<a href="#">オファー受信</a></li>
						<li class="green">21:00<a href="#">承認待ち</a></li>
					</ol>
				</li>
				<li class="wed heightLine-01">
					<h1><strong>Wed</strong>1.30</h1>
				</li>
				<li class="thu heightLine-01">
					<h1><strong>Thu</strong>1.31</h1>
					<ol class="hourCut">
						<li class="green">21:00<a href="#">日程調整中</a></li>
					</ol>
				</li>
				<li class="fri heightLine-01">
					<h1><strong>Fri</strong>2.1</h1>
				</li>
				<li class="sat heightLine-01">
					<h1><strong>Sat</strong>2.2</h1>
				</li>
			</ol>
		</div>
		<!++ week ++>
		<div class="week">
			<ol class="day">
				<li class="sun heightLine-02">
					<h1><strong>Sun</strong>1.27</h1>
				</li>
				<li class="mon heightLine-02">
					<h1><strong>Mon</strong>1.28</h1>
					<ol class="hourCut">
						<li class="green">21:00<a href="#">承認待ち</a></li>
					</ol>
				</li>
				<li class="tue heightLine-02">
					<h1><strong>Tue</strong>1.29</h1>
					<ol class="hourCut">
						<li class="red">20:30<a href="#">オファー受信</a></li>
						<li class="green">21:00<a href="#">承認待ち</a></li>
					</ol>
				</li>
				<li class="wed heightLine-02">
					<h1><strong>Wed</strong>1.30</h1>
				</li>
				<li class="thu heightLine-02">
					<h1><strong>Thu</strong>1.31</h1>
					<ol class="hourCut">
						<li class="green">21:00<a href="#">日程調整中</a></li>
					</ol>
				</li>
				<li class="fri heightLine-02">
					<h1><strong>Fri</strong>2.1</h1>
				</li>
				<li class="sat heightLine-02">
					<h1><strong>Sat</strong>2.2</h1>
				</li>
			</ol>
		</div>
	</div>
</div></div>
</div>

</aside>
-->
</section>


</div><!-- //.stylistDataBox -->
</div><!-- //#mainContents -->



<!-- right menu -->
<div id="rightMenu">

{% if logindata.User.gender == 1 %}
<aside class="portfolio mt1">
	<h1>PR</h1>
	<p class="pr">
	<a href="http://smartauction.jp?mid=cut" target="_blank"><img src="/img/pr/smaoku_cuttaloca_220_220.png" alt="TAG index" border="0"></a>
	</p>
</aside>
{% endif %}

<aside class="portfolio mt0">
	<h1>写真</h1>
	<p class="more"><a href="" class="fadeBtn">もっとみる</a></p>
</aside>


</div><!-- //right menu -->

</div><!-- //#mainContents -->

</article>