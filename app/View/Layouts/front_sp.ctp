<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>トップページ｜CUTTALOCA</title>
	<meta name="Description" content="美容師アシスタントとカットモデルのマッチングサービスです。美容師アシスタントは無料。髪を切りたい人は500円でサロンに行けるサービス CUTTALOCA">
	<meta name="Keywords" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="start" href="/" title="ホーム">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="stylesheet" href="/css/mobile.css" media="screen">
</head>
<body>

<header>
<a href="/"><img src="../img/common/h_logo.png" alt="CUTTALOCA"></a>
	<hgroup>
		<!--<h1><a href="/">##### SITE NAME #####</a></h1>
		<h2><a href="/howto">CUTTALOCAについて</a></h2>-->
	</hgroup>
</header>
<!-- //#header -->

<div id="contents">
<?php echo $this->fetch('content') ?>
</div><!-- //#contents -->

<!-- #footer -->
<footer>
	<!--<nav>
		<ul>
			<li><a href="DUMMY">ログイン</a></li>
			<li><a href="DUMMY">ホーム</a></li>
			<li><a href="DUMMY">ヘルプ</a></li>
		</ul>
	</nav>-->
	
<nav class="footerNavi">
<ul>
	<li class="m3"><a href="/terms/company" class="fadeBtn">会社概要</a></li>
	<li class="m2"><a href="/terms/use" class="fadeBtn">利用規約</a></li>
	<li class="m9"><a href="/terms/media" class="fadeBtn">掲載情報</a></li>
	</ul>
</nav>
<nav class="footerNavi">
<ul>
	<li class="m8"><a href="/terms/tokusho" class="fadeBtn">特定商取引</a></li>
	<li class="m7"><a href="/terms/recruit" class="fadeBtn">採用情報</a></li>
	<li class="m5"><a href="/terms/privacy" class="fadeBtn">Privacy</a></li>
	</ul>
</nav>

	<p class="copyright"><small>COPYRIGHT (C) 2013 CUTTALOCA<br> ALL RIGHTS RESERVED.</small></p>
</footer>

<!-- Scripts [[[-->
<!-- common scripts [-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="js/iphone.js"></script>
<noscript><p id="msgNoscript">当サイトは、ブラウザのJavaScript設定を有効にしてご覧ください。</p></noscript>
<!--] common scripts -->
<!--]]] Scripts-->

<!--Analytics [-->
<!--] Analytics-->

</body>
</html>