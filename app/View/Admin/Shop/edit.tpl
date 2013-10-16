<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<div class="row">
    <div class="span2">
        <div class="well">
            <ul class="nav nav-list">
                <li class="nav-header">メニュー</li>
                <li><a href="/admin/menu/">メニューへ戻る</a></li>
                <li class="divider"></li>
		        <li><a href="/admin/shop/">ショップ一覧</a></li>
		        <li class="active"><a href="#">{{ title }}</a></li>
		        {% if action == 'edit' %}<li><a href="/admin/galu/delete/{{ data.Shop.id }}>/">削除</a></li>{% endif %}
            </ul>
        </div>
    </div>
    
    <div class="span10">
        {{ form.create(null, {'class':'form-horizontal well'}) }}
	        <fieldset>
    		    <legend>{{ title }}</legend>
                <input type="hidden" name="data[Shop][id]" value="{{ data.Shop.id }}" />

                <div class="control-group">
                    <label class="control-label" for="name">ショップ名</label>
                    <div class="controls">
                        <input type="text" name="data[Shop][name]" value="{{ data.Shop.name }}" id="name" />
                        {% if errors.name %}<span class="help-inline">{{ errors.name }}</span>{% endif %}
                    </div>
                </div>
<!--
                <div class="control-group">
                    <label class="control-label" for="map">地図</label>
                    <div class="controls">
                        <div id="map">&nbsp;</div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="address">住所</label>
                    <div class="controls">
                        <input id="address" class="input-xlarge" type="text" name="data[Shop][address]" value="{{ data.Shop.address }}" />
                        <button class="btn btn-success" id="map_confirm">地図を確認する</button>
                        {% if errors.address %}<span class="help-inline">{{ errors.address }}</span>{% endif %}
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="tel">電話番号</label>
                    <div class="controls">
                        <input type="text" name="data[Shop][tel]" value="{{ data.Shop.tel }}" id="tel" />
                        {% if errors.tel %}<span class="help-inline">{{ errors.tel }}</span>{% endif %}
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email">ショップメールアドレス（ショップ宛のお問い合わせが届きます）</label>
                    <div class="controls">
                        <input type="text" name="data[Shop][email]" value="{{ data.Shop.email }}" id="email" />
                        {% if errors.email %}<span class="help-inline">{{ errors.email }}</span>{% endif %}
                     </div>
                </div>
-->
                <button class="btn btn-primary btn-large offset2">保存する</button>
            </fieldset>
        {{ form.end() }}
    </div>
</div>