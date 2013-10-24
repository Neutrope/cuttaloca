<article id="contentsIn" class="stylist">

<!-- Sub Header -->
{% include 'Elements/subheader.tpl' with {'subtitle':'マイページ', 'roledir':'user'} %}



<div id="mainContents">



<!-- main -->
<div id="leftMain">


<div class="stylistDataBox">


<section class="stylistData">

<div class="stylistDataIn">
<div class="wrapper">

	<div class="left">
		<figure class="face"><img src="https://graph.facebook.com/{{ logindata.User.facebook_id }}/picture?type=large&width=100&height=100" alt="face" width="100" height="100">
		  <p class="creation clearfix"><!--<a href="" class="fadeBtn">設定</a>--></p></figure>
		<div class="name">
			<dl class="nameDl">
					<dt>{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</dt>
					 <dd>{{ gender[logindata.User.gender] }}｜{{ prefecture[logindata.CutModel.prefecture01] }}</dd>
				</dl>
			<div class="howtime"><h3>カッタロカでの成約回数</h3><p class="count"><strong>{{ logindata.User.cutting }}</strong>回</p></div>
		</div>
		
	</div>
	
	
	<aside class="right">
		<h2><span>募集内容</span></h2>
		<dl>
{% if (logindata.CutModel.style == 1) or (logindata.CutModel.style == 4) or (logindata.CutModel.style == 5) %}
			<dt>カット</dt><dd>{{ hairlengthlist[logindata.CutModel.cut_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ hairlengthafterlist[logindata.CutModel.cut_after] }}</dd>
{% endif %}
{% if (logindata.CutModel.style == 2) or (logindata.CutModel.style == 4) %}
			<dt>カラー</dt><dd>{{ colorbefore[logindata.CutModel.color_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ colorafter[logindata.CutModel.color_after] }}</dd>
{% endif %}
{% if (logindata.CutModel.style == 3) or (logindata.CutModel.style == 5) %}
			<dt>パーマ</dt><dd>{{ permbefore[logindata.CutModel.perm_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ permafter[logindata.CutModel.perm_after] }}</dd>
{% endif %}
		</dl>
	<h2><span>スタイルの詳細</span></h2>
	<dl>
{% if logindata.User.detail %}
	<div>{{ logindata.User.detail }}</div>
	<div>
	</br>
	</div>
{% else %}
	<div>
	</br>
	</br>
	</br>
	</div>
{% endif %}
	</dl>
	</aside>

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

<aside class="portfolio mt0">
	<h1>写真</h1>
	<p class="more"><a href="" class="fadeBtn">もっとみる</a></p>
</aside>




</div><!-- //right menu -->



</div><!-- //#mainContents -->


</article>