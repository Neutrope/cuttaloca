<input type="hidden" class="apply-content" value="{{ stylist.Stylist.apply_content|join(',') }}" />
<input type="hidden" class="apply-style" value="{{ stylist.Stylist.apply_style|join(',') }}" />
<input type="hidden" class="cut-start" value="{{ stylist.Stylist.cut_start }}" />
<input type="hidden" class="cut-end" value="{{ stylist.Stylist.cut_end }}" />
<input type="hidden" class="stylist-id" value="{{ stylist.Stylist.id }}" />

<aside class="right">
	<h2><span>募集内容</span></h2>
	<dl>
		<dt>対象</dt><dd>{{ gender[stylist.Stylist.apply_gender] }}</dd>
		<dt>価格</dt><dd>
{% set separator = '' %}
{% for key, content in stylist.Stylist.apply_content %}
{{ separator }}{{ stylelist[content] }}{% if stylist.Stylist.apply_price[key] == 0 %}無料{% else %}({{ stylist.Stylist.apply_price[key] }}円){% endif %}
{% set separator = '、' %}
{% endfor %}
		</dd>
	</dl>
	<h2><span>募集条件</span></h2>
	<dl>
		<dt>カット後の長さ</dt><dd>
{% if stylist.Stylist.apply_style_all == 1 %}
		ご希望に合わせます
{% else %}
{% set separator = '' %}
{% for key, content in stylist.Stylist.apply_style %}
{{ separator }}{% if stylist.Stylist.apply_style[key] == 0 %}ご希望に合わせます{% else %}{{ cut_after[stylist.Stylist.apply_style[key]] }}{% endif %}
{% set separator = '、' %}
{% endfor %}
{% endif %}
		</dd>
		<dt>募集内容の詳細</dt><dd>{{ stylist.User.detail }}
		</dd>
	</dl>
</aside>