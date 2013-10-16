<style>
	.test { width: 600px !important; margin: 0 auto; }
	.test td {
		padding: 0 0 5px !important;
	}
</style>
<div id="mainContents">
{{ form.create('User', {'class':'mailForm'}) }}
<table class="test">
	<tr>
		<th>ユーザID</th>
		<th>ユーザ名</th>
		<th>ユーザステータス</th>
		<th>ユーザタイプ</th>
		<th></th>
	</tr>
{% for user in users %}
{% if user.User.role_id == constant('ROLE_STYLIST') %}
{% if user.User.id >= min_id %}
{% if user.User.id < max_id %}
	<tr>
		<td>{{ user.User.id }}</td>
		<td>{{ user.User.last_name }}&nbsp;{{ user.User.first_name }}</td>
		<td>{{ user.User.status }}</td>
		<td>{% if user.User.role_id == constant('ROLE_CUTMODEL') %}カットモデル{% else %}スタイリスト{% endif %}</td>
		<td>{{ form.radio(user.User.id~'.id', {(user.User.id):''}) }}</td>
	</tr>
{% endif %}
{% endif %}
{% endif %}
{% endfor %}
</table>
<p class="test"><input type="submit" name="submit" value="ログインする" />
{{ form.end() }}
<br>
<br>
<br>
<br>
<a href="/test/sty_login/{{ next_page }}/">＞＞ID{{ next_page * 1000 }}番台のユーザーへ</a>
</div>