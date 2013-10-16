<div class="row">
    <div class="span2">
        <div class="well">
            <ul class="nav nav-list">
                <li class="nav-header">メニュー</li>
                <li><a href="/admin/menu/">メニューへ戻る</a></li>
                <li class="divider"></li>
        		<li><a href="/admin/account/">アカウント一覧</a></li>
        		<li class="active"><a href="#">{{ title }}</a></li>
               {% if action == 'edit' %}<li><a href="/admin/account/delete/{{ data.account_id }}>/">削除</a></li>{% endif %}
        	</ul>
        </div>
	</div>
    <div class="span10">
        {{ form.create(null, {'class':'form-horizontal well'}) }}
        	<fieldset>
        		<legend>{{ title }}</legend>
                <input type="hidden" name="data[Account][id]" value="{{ data.Account.id }}" />

                <div class="control-group">
                    <label class="control-label" for="role_id">アカウントタイプ</label>
                    <div class="controls constant">
                        <input type="hidden" name="data[Account][role_id]" value="{{ constant('ROLE_ADMIN') }}" id="role_id" />
                        アクション
                    </div>
                </div>

                <div class="control-group{% if errors.login_id %} error{% endif %}">
                    <label class="control-label" for="login_id">ログインID</label>
                    <div class="controls">
                        <input type="text" name="data[Account][login_id]" value="{{ data.Account.login_id }}" id="login_id" />
                        {% if errors.login_id %}<span class="help-inline">{{ errors.login_id }}</span>{% endif %}
                    </div>
                </div>

                <div class="control-group{% if errors.email %} error{% endif %}">
                    <label class="control-label" for="email">メールアドレス</label>
                    <div class="controls">
                        <input type="text" name="data[Account][email]" value="{{ data.Account.email }}" />
                        {% if errors.email %}<span class="help-inline">{{ errors.email }}</span>{% endif %}
                    </div>
                </div>

                <div class="control-group{% if errors.password %} error{% endif %}">
                    <label class="control-label" for="password">パスワード</label>
                    <div class="controls">
                        <input type="password" name="data[Account][password]" value="" id="password" />
                        {% if errors.password %}<span class="help-inline">{{ errors.password }}</span>{% endif %}
                    </div>
                </div>

                <div class="control-group{% if errors.password %} error{% endif %}">
                    <label class="control-label" for="password2">パスワード(確認)</label>
                    <div class="controls">
                        <input type="password" name="data[Account][password2]" value=""  id="password2" />
                    </div>
                </div>
                <button class="btn btn-primary btn-large offset2">保存する</button>
            </fieldset>
        {{ form.end() }}
    </div>
</div>