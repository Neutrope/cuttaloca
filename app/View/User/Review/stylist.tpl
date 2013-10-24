<article id="contentsIn" class="stylist"> 
	{% include 'Elements/subheader.tpl' with {'subtitle':'レビュー', 'roledir':'user'} %}
	<div id="mainContents"> 
		
		<!-- main -->
		<ul class="photoList clearfix" id="photoList">
{% for review in reviews %}
			<li>
				<div class="inner clearfix">
					<div class="photoBox"><img src="http://graph.facebook.com/{{ review.CutModelUser.facebook_id }}/picture" width="65" height="65" alt="{{ review.CutModelUser.last_name}}&nbsp;{{ review.CutModelUser.first_name }}"></div>
					<div class="textBox">
						<p class="title">{{ review.CutModelUser.last_name }}&nbsp;{{ review.CutModelUser.first_name }}</p>
						<p>{{ gender[review.CutModelUser.gender] }}</p>
					</div>
				</div>
				<div class="box">
					<div class="subBox">
						<p>{{ review.Review.review }}</p>
					</div>
				</div>
			</li>
{% endfor %}
		</ul>
	</div>
	<!-- //#mainContents --> 
</article>
