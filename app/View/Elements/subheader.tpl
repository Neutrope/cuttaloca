<header id="subHeader"><div class="wrapper">
<div class="left"><p class="back"><a href="/{{ roledir }}/search/">戻る</a></p><h1>{{ subtitle }}</h1></div>
<nav class="nav gNavi"><ul>
<li class="m1"><span class="number{% if count_success == 0 %} number01{% endif %}">{{ count_success }}</span><a href="/{{ roledir }}/offer/approve/" title="成立" class="fadeBtn">成立</a></li>
<li class="m2"><span class="number{% if count_offers == 0 %} number01{% endif %}">{{ count_offers }}</span><a href="/{{ roledir }}/offer/" title="オファー" class="fadeBtn">オファー</a></li>
<li class="m3"><a href="/{{ roledir }}/offer/entry/" title="掲載内容 確認＆更新" class="fadeBtn">掲載内容 確認＆更新</a></li>
</ul></nav>
<p class="who"><a href="/{{ roledir }}/mypage/" class="fadeBtn">{{ logindata.User.last_name }}&nbsp;{{ logindata.User.first_name }}</a></p>
</div></header>