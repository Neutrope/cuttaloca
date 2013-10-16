※スタイリストが新規登録されました。以下の内容を本人確認をして問題なければユーザーのステータスを変更してください。

User ID 	<?= $data['Stylist']['user_id']?>　
名 前 	<?= $data['User']['last_name']?> <?= $data['User']['first_name'] ?>　
性 別(1女2男) 	<?= $data['User']['gender']?>　
メールアドレス 	<?= $data['User']['email']?>　
Facebook ID 	<?= $data['User']['facebook_id']?>　
Facebook Pic 	https://graph.facebook.com/<?= $data['User']['facebook_id']?>/picture?type=large　
Facebook 	http://www.facebook.com/<?= $data['User']['facebook_id']?>　
店舗名 	<?= $data['Stylist']['shop_name']?>　
店舗公開可否(0否1可) 	<?= $data['Stylist']['disp_shop_name']?>　
店舗の都道府県 	<?= $data['Stylist']['prefecture']?>　
店舗の市町村 	<?= $data['Stylist']['city']?>　
店舗の最寄り駅 	<?= $data['Stylist']['station']?>　
店舗のURL 	<?= $data['Stylist']['url']?>　
募集対象(1女2男9男女) 	<?= $data['Stylist']['apply_gender']?>　
募集内容↓　
<?= $data['User']['detail']?>　

※以下、スタイリストへ送付されたメール
-----

<?= $data['User']['last_name']?> <?= $data['User']['first_name'] ?>さん、こんにちは。

カッタロカ運営事務局です。
カッタロカにユーザー登録していただきありがとうございます。

ただいま、本人確認中です。今暫くおまちください。
確認完了次第ご連絡差し上げますのでよろしお願い致します。

※登録完了メールが受信されない場合がございます。
support@cuttaloca.com からのメールの受信設定をお願い致します。


ご要望、ご質問がある場合は、お気軽にこのメールにご連絡ください。
スタッフ一同全力でサポートさせていただきます！
今後ともよろしくお願いします。

-----
美容師アシスタントとカットモデルのマッチングサイト【CUTTALOCA】
■ Facebook　　　
https://www.facebook.com/Cuttaloca