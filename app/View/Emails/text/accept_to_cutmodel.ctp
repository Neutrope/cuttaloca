<?= $data['User']['last_name'] ?> <?= $data['User']['first_name'] ?>さん、こんにちは！

美容師の<?= $data['Stylist']['name'] ?>さんからオファーが承認されました。

希望日：<?= date('Y/n/j', strtotime($data['OfferSchedule']['date'])) ?> <?= $data['OfferSchedule']['starttime'] ?> 

以下のURLからオファーを確定させ、髪を切りに行きましょう！
http://cuttaloca.com/user/offer/

※ 決済後、事前に美容師とメッセージで打ち合わせができます。

-----
美容師アシスタントとカットモデルのマッチングサイト【CUTTALOCA】
■ Facebook　　　
https://www.facebook.com/Cuttaloca