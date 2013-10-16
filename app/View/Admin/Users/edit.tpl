<div class="user form">
<{if $action == "add"}>
    <form action="/admin/user/add/" id="UserAddForm" method="post" accept-charset="utf-8">
<{else}>
    <form action="/admin/user/edit/<{$id}>/" id="UserEditForm" method="post" accept-charset="utf-8">
<{/if}>
	<fieldset>
		<legend><{$title}></legend>
        <input type="hidden" name="data[Account][id]" value="<{$data.Account.id}>" />

        <div class="select required">
            <label for="AccountType">アカウントタイプ</label>
            <{html_options name="data[Account][role_id]" id="AccountType" options=$roles selected=$data.Account.role_id}>
        </div>
        <div class="input text required">
            <label for="LoginId">ログインID</label>
            <input type="text" name="data[Account][login_id]" id="LoginId" value="<{$data.Account.login_id}>" />
            <{if $errror.login_id}><p class="error"><{$errors.login_id}></p><{/if}>
        </div>
        <div class="input text required">
            <label for="Password">パスワード</label>
            <input type="password" name="data[Password][password]" id="Password" value="<{$data.Password.password}>" />
            <{if $errors.password}><p class="error"><{$errors.password}></p><{/if}>
        </div>
        <div class="input text required">
            <label for="Name">名前</label>
            <input type="text" name="data[User][name]" id="Name" value="<{$data.User.name}>" />
            <{if $errors.name}><p class="error"><{$errors.name}></p><{/if}>
        </div>
        <div class="input text required">
            <label for="Postcode">郵便番号</label>
            <input type="text" name="data[User][postcode]" id="Postcode" value="<{$data.User.name}>" onkeyup="AjaxZip3.zip2addr(this,'','data[User][prefecture]','data[User][address]');" />
            <{if $errors.postcode}><p class="error"><{$errors.postcode}></p><{/if}>
        </div>
        <div class="select required">
            <label for="Prefecture">都道府県</label>
            <{html_options name="data[User][prefecture]" id="Prefecture" options=$prefectureList selected=$data.User.prefecture}>
            <{if $errors.prefecture}><p class="error"><{$errors.prefecture}></p><{/if}>
        </div>
        <div class="input text required">
            <label for="Address">住所</label>
            <input type="text" name="data[User][address]" id="Address" value="<{$data.User.address}>" />
            <{if $errors.address}><p class="error"><{$errors.address}></p><{/if}>
        </div>
        <div class="input text required">
            <label for="Tel">電話番号</label>
            <input type="text" name="data[User][tel]" id="Tel" value="<{$data.User.tel}>" />
            <{if $errors.tel}><p class="error"><{$errors.tel}></p><{/if}>
        </div>
        <div class="input text">
            <label for="Point">ポイント</label>
            <input type="text" name="data[User][point]" id="Point" value="<{$data.User.point}>" />
            <{if $errors.point}><p class="error"><{$errors.point}></p><{/if}>
        </div>
        <div class="input text">
            <label for="BronzeTicket">ブロンズチケット枚数</label>
            <input type="text" name="data[User][bronze_ticket]" id="BronzeTicket" value="<{$data.User.bronze_ticket}>" />
            <{if $errors.bronze_ticket}><p class="error"><{$errors.bronze_ticket}></p><{/if}>
        </div>
        <div class="input text">
            <label for="PlutinumTicket">プラチナチケット枚数</label>
            <input type="text" name="data[User][plutinum_ticket]" id="PlutinumTicket" value="<{$data.User.plutinum_ticket}>" />
            <{if $errors.plutinum_ticket}><p class="error"><{$errors.plutinum_ticket}></p><{/if}>
        </div>
    </fieldset>
    <div class="submit"><input  type="submit" value="保存する"/></div>
</form>
</div>
<div class="actions">
    <ul>
        <li><a href="/admin/menu/">メニューへ戻る</a></li>
		<li><a href="/admin/user/">ユーザ一覧</a></li>
       <{if $action == "edit"}><li><a href="/admin/user/delete/<{$data.account_id}>/">削除</a></li><{/if}>
	</ul>
</div>