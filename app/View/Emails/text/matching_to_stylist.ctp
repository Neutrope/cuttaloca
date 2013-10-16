<?= $data['StylistUser']['last_name'] ?> <?= $data['StylistUser']['first_name'] ?>さん、こんにちは！

カットモデルの<?= $data['CutModelUser']['last_name'] ?> <?= $data['CutModelUser']['first_name'] ?>さんとマッチングが成立しました！
=====================
日時： <?= date('Y/m/d', strtotime($data['OfferSchedule']['date'])) ?> <?= $data['OfferSchedule']['starttime'] ?> 
募集内容：<?= $data['Offer']['style'] ?> 
カットモデル名：<?= $data['CutModelUser']['last_name'] ?> <?= $data['CutModelUser']['first_name'] ?> 
=====================

以下のURLからマッチングの詳細を確認し、「カットモデルへ連絡する」より事前にメッセージが送れます。
http://cuttaloca.com/stylist/offer/approve/

-----
美容師アシスタントとカットモデルのマッチングサイト【CUTTALOCA】
■ Facebook　　　
https://www.facebook.com/Cuttaloca