<?= $data['CutModelUser']['last_name'] ?> <?= $data['CutModelUser']['first_name'] ?>さん、こんにちは！

決済が完了し、美容師の<?= $data['StylistUser']['last_name'] ?> <?= $data['StylistUser']['first_name'] ?>さんとマッチングが成立しました！
=====================
日時： <?= date('Y/m/d', strtotime($data['OfferSchedule']['date'])) ?> <?= $data['OfferSchedule']['starttime'] ?> 
店舗名： <?= $data['Stylist']['shop_name'] ?> 
最寄り駅： <?= $data['Stylist']['station'] ?>駅
店舗のURL： <?= $data['Stylist']['url'] ?> 
美容師名：<?= $data['StylistUser']['last_name'] ?> <?= $data['StylistUser']['first_name'] ?> 
ご希望：<?= $data['Offer']['style'] ?> 
=====================

以下のURLからマッチングの詳細を確認し、「美容師へ連絡する」より事前にメッセージが送れます。
http://cuttaloca.com/user/offer/approve/

-----
美容師アシスタントとカットモデルのマッチングサイト【CUTTALOCA】
■ Facebook　　　
https://www.facebook.com/Cuttaloca