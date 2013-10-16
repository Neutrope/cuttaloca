<?= $data['StylistUser']['last_name'] ?> <?= $data['StylistUser']['first_name'] ?>さん、こんにちは！

カットモデルの<?= $data['CutModelUser']['last_name'] ?> <?= $data['CutModelUser']['first_name'] ?>さんから新着メッセージが届きました。

メッセージ内容
=====================
<?= $data['OfferMessage']['message'] ?> 
=====================

返信は下記にログインしてから行えます。
http://cuttaloca.com/stylist/offer/message/<?= $data['Offer']['id'] ?> 

※こちらのメールに返信しても、カットモデルへの返信は行われませんので、上記URLからご返信お願いします。

-----
美容師アシスタントとカットモデルのマッチングサイト【CUTTALOCA】
■ Facebook　　　
https://www.facebook.com/Cuttaloca