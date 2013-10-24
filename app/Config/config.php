<?php
define('CONFIG', APP . DS . 'Config');

define('DOMAIN', 'http://www.cuttaloca.com');
define('FILE_VERSION', 20131022);

$dir = explode('/', $_SERVER['REQUEST_URI'])[1];
if (in_array($dir, ['admin', 'stylist', 'user', 'json'])) {
    $dir = ucfirst($dir);
} else {
    $dir = 'Front';
}

if (preg_match('/cuttaloca.com/', $_SERVER['SERVER_NAME'])) {
	define('TEST_MODE', false);
} else {
	define('TEST_MODE', true);
}


Configure::write('Cache.dir', $dir);
Configure::write('StyleList', [
	1 => 'カット', 2 => 'カラー', 3 => 'パーマ', 4 => 'ダブルカラー', 5 => '縮毛矯正',
	6 => '白髪染め', 7 => 'ストレートパーマ', 8 => 'グラデーションカラー', 9 => 'デジタルパーマ'
]);
Configure::write('CutModelStyle', [
	1 => 'カットのみ', 2 => 'カラーのみ', 3 => 'パーマのみ', 4 => 'カット＋カラー', 5 => 'カット＋パーマ'
]);
Configure::write('ColorBefore', [
	1 => 'カラーしていない', 2 => '1ヶ月以内', 3 => '3ヶ月以内', 4 => '5ヶ月以内'
]);
Configure::write('ColorAfter', [
	1 => 'カラー希望', 2 => 'ダブルカラー希望', 3 => 'グラデーションカラー希望', 4 => '白髪染め希望'
]);
Configure::write('PermBefore', [
	1 => 'パーマしていない', 2 => '1ヶ月以内', 3 => '3ヶ月以内', 4 => '5ヶ月以内'
]);
Configure::write('PermAfter', [
	1 => 'パーマ希望', 2 => 'デジタルパーマ希望', 3 => 'ストレートパーマ希望', 4 => '縮毛矯正希望'
]);
Configure::write('HairLengthList', [
	1 => 'ボブ', 2 => 'ベリーショート', 3 => 'ショート',
	4 => 'セミショート', 5 => 'ミディアム', 6 => 'セミロング', 7 => 'ロング',
	8 => 'スーパーロング'
]);
Configure::write('HairLengthAfterList', [
	-1 => '美容師にお任せ', 1 => 'ボブ', 2 => 'ベリーショート', 3 => 'ショート',
	4 => 'セミショート', 5 => 'ミディアム', 6 => 'セミロング', 7 => 'ロング',
	8 => 'スーパーロング'
]);
Configure::write('ApplyGender', [
	1 => '女性', 2 => '男性', 9 => '男女共'
]);
Configure::write('ApplyCutModel', [
	1 => '08:00', 2 => '08:30', 3 => '09:00', 4 => '09:30', 5 => '10:00', 6 => '10:30', 7 => '11:00', 8 => '11:30', 9 => '12:00',
	10 => '12:30', 11 => '13:00', 12 => '13:30', 13 => '14:00', 14 => '14:30', 15 => '15:00', 16 => '15:30', 17 => '16:00', 18 => '16:30',
	19 => '17:00', 20 => '17:30', 21 => '18:00', 22 => '18:30', 23 => '19:00', 24 => '19:30', 25 => '20:00', 26 => '20:30', 27 => '21:00',
	28 => '21:30', 29 => '22:00'
]);
Configure::write('CutLength', [
	1 => '1cm未満', 2 => '1cm', 3 => '2cm', 4 => '3cm', 5 => '5cm',
	6 => '10cm', 7 => '20cm', 8 => '20cm以上'
]);

define('ROLE_ADMIN', 1);
define('ROLE_STYLIST', 2);
define('ROLE_CUTMODEL', 3);

define('STATUS_OFFER', 1);
define('STATUS_ADJUST', 2);
define('STATUS_SUCCESS', 5);
define('STATUS_END', 6);
define('STATUS_CANCEL', 9);

define('DIRECTION_TO_STYLIST', 1);
define('DIRECTION_TO_CUTMODEL', 2);

define('SEARCH_DISP_NUM', 30);

define('USER_STATUS_ACCEPT', 1);
define('USER_STATUS_PENDING', 2);
define('USER_STATUS_DELETE', 9);

define('LIMIT_REVIEW', 2);
define('LIMIT_PORTFOLIO', 5);

//define('AUTHORITY_NORMAL', 1);
//define('AUTHORITY_BRANCH', 2);
//define('AUTHORITY_ADMIN', 3);

define('STRING_LOGIN_ID', '0123456789');
define('STRING_PASSWORD', '0123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ');