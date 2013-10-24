<input type="hidden" class="cutmodel-id" value="{{ stylist.CutModel.id }}" />

<aside class="right">
	<h2><span>募集内容</span></h2>
	<dl>
{% if (stylist.CutModel.style == 1) or (stylist.CutModel.style == 4) or (stylist.CutModel.style == 5) %}
		<dt>カット</dt><dd>{{ hairlengthlist[stylist.CutModel.cut_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ hairlengthafterlist[stylist.CutModel.cut_after] }}</dd>
{% endif %}
{% if (stylist.CutModel.style == 2) or (stylist.CutModel.style == 4) %}
		<dt>カラー</dt><dd>{{ colorbefore[stylist.CutModel.color_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ colorafter[stylist.CutModel.color_after] }}</dd>
{% endif %}
{% if (stylist.CutModel.style == 3) or (stylist.CutModel.style == 5) %}
		<dt>パーマ</dt><dd>{{ permbefore[stylist.CutModel.perm_before] }}&nbsp;&nbsp;→&nbsp;&nbsp;{{ permafter[stylist.CutModel.perm_after] }}</dd>
{% endif %}
{% if 1 == 0 %}
		<dt>スタイル</dt><dd>{{ cutmodelstyle[stylist.CutModel.style] }}</dd>
		<dt>いつ行きたいか</dt><dd>{{ stylist.CutModel.cutweek|slice(0,4)~'/'~stylist.CutModel.cutweek|slice(4,2)~'/'~stylist.CutModel.cutweek|slice(6,2)~'の週' }}</dd>
{% endif %}
	</dl>
	<h2><span>募集内容の詳細</span></h2>
	<dl>
{% if stylist.User.detail %}
	<div>{{ stylist.User.detail }}</div>
	<div>
	</br>
	</br>
	</br>
	</br>
	</div>
{% else %}
	<div>
	</br>
	</br>
	</br>
	</br>
	</br>
	</br>
	</br>
	</div>
{% endif %}
	</dl>
</aside>