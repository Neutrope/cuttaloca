<div class="upload form">
    <{if $error == "error"}>
        <form action="/admin/supervisor/error_download/" method="post">
            <fieldset>
                <div class="submit">
                    <label>エラーのあった情報をダウンロードする</label>
                    <input type="submit" value="ダウンロード" />
                </div>
                <p class="error">※エラーのあった情報のみが表示されます。<br />表示されていないものに関しては、保存が完了しています。</p>
            </fieldset>
        </form>
    <{/if}>
</div>
<div class="actions">
    <ul>
        <li><a href="/admin/menu/">メニューへ戻る</a></li>
        <li><a href="/admin/supervisor/">協力弁護士一覧</a></li>
    </ul>
</div>