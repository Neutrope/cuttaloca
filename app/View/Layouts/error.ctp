<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="imagetoolbar" content="no">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $header['title']; ?>｜CUTTALOCA</title>
<meta name="description" content="美容師アシスタントとカットモデルのマッチングサービスです。美容師アシスタントは無料。髪を切りたい人は500円でサロンに行けるサービス CUTTALOCA">

<!-- og -->
<meta property="og:title"       content="<?php echo $header['title']; ?> | CUTTALOCA">
<meta property="og:url"		 content="http://cuttaloca.com">
<meta property="og:image"	   content="http://cuttaloca.com/img/logo_for_sns.png">
<meta property="og:site_name"   content="CUTTALOCA">
<meta property="fb:app_id"	  content="202894476528576">
<meta property="og:type"		content="website">
<meta property="og:description" content="美容師アシスタントとカットモデルのマッチングサービスです。美容師アシスタントは無料。髪を切りたい人は500円でサロンに行けるサービス CUTTALOCA">

<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="/css/reset.css" media="all">
<link rel="stylesheet" href="/css/styles.css?v=<?= FILE_VERSION ?>" media="all">
<link rel="stylesheet" href="/css/error.css?v=<?= FILE_VERSION ?>" media="all">


<!--[if IE]><link rel="stylesheet" href="/css/ie.css" media="all"><![endif]-->
<!--[if lt IE 9]>
<link rel="stylesheet" href="css/ie8.css" media="all">
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="/js/easing.js"></script>
<script src="/js/common.js?v=<?= FILE_VERSION ?>"></script>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-43431365-1', 'cuttaloca.com');
ga('send', 'pageview');

</script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div id="container">

<!-- #header -->
<header id="header"><div class="wrapper">
<h1 class="left"><a href="/" title="CUTTALOCA" class="fadeBtn">CUTTALOCA</a></h1>
<nav class="right">
<ul>
<li class="m0"><a href="/howto" title="CUTTALOCAについて" class="fadeBtn">CUTTALOCAについて</a></li>
</ul>
<!-- 
<ul>
<li class="m1"><a href="#" title="使い方" class="fadeBtn">使い方</a></li>
<li class="m2"><a href="#" title="CUTTALOCAについて" class="fadeBtn">CUTTALOCAについて</a></li>
<li class="m3"><a href="#" title="ブログ" class="fadeBtn">ブログ</a></li>
<li class="m4"><a href="#" title="よくある質問" class="fadeBtn">よくある質問</a></li>
</ul>
<p class="facebookLogin"><a href="/login" title="Facebookでログイン"><span>Facebookでログイン</span></a></p>
 -->
</nav>
</div></header><!-- //#header -->

<?php if ($top) : ?>
	<div class="loading"><p>LOADING</p></div>
<?php endif; ?>

<div id="contents">
	<?php echo $this->fetch('content') ?>
</div><!-- //#contents -->

<!-- #footer -->
<footer id="footer">

<div class="wrapper">
<div class="left">
	<div class="fb-like-box" data-href="https://www.facebook.com/Cuttaloca" data-width="448" data-height="330" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
</div>

<div class="right">
<!-- 
<div class="form">
	<form action="" id="commentSend">
		<textarea form="commentSend" placeholder="CUTTALOCAについてのご意見を伺わせて下さい。"></textarea>
		<p class="send"><a href="#" title="送信する"><span>送信する</span></a></p>
	</form>
</div>
 -->
<nav class="footerNavi">
<ul><!-- 
	<li class="m1"><a href="#" class="fadeBtn">使い方</a></li>
	<li class="m2"><a href="/terms/use" class="fadeBtn">利用規約</a></li>
	<li class="m3"><a href="#" class="fadeBtn">会社概要</a></li>
	<li class="m4"><a href="#" class="fadeBtn">CUTTALOCAについて</a></li>
	<li class="m5"><a href="#" class="fadeBtn">プライバシーポリシー</a></li>
	<li class="m6"><a href="#" class="fadeBtn">採用情報</a></li>
	<li class="m7"><a href="#" class="fadeBtn">ブログ</a></li>
	<li class="m8"><a href="#" class="fadeBtn">特定商取引に関する表記</a></li>
	<li class="m9"><a href="#" class="fadeBtn">メディア掲載情報</a></li>
	<li class="m10"><a href="#" class="fadeBtn">よくある質問</a></li>
	 -->
	<li class="m3"><a href="/terms/company" class="fadeBtn">会社概要</a></li>
	<li class="m2"><a href="/terms/use" class="fadeBtn">利用規約</a></li>
	<li class="m7"></li>
	<li class="m9"><a href="http://www.side-tail.com/#press" target="_blank" class="fadeBtn">メディア掲載情報</a></li>
	<li class="m8"><a href="/terms/tokusho" class="fadeBtn">特定商取引に関する表記</a></li>
	<li class="m7"></li>
	<li class="m7"><a href="/terms/recruit" class="fadeBtn">採用情報</a></li>
	<li class="m5"><a href="/terms/privacy" class="fadeBtn">プライバシーポリシー</a></li>
	</ul>

<p class="pagetop"><a href="javascript:void(0);">PAGE TOP</a></p>

</nav>

</div>

</div><!-- //.wrapper -->

<div class="bottom"><div class="wrapper">
<p><small class="copyright">COPYRIGHT (C) 2013 CUTTALOCA ALL RIGHTS RESERVED.</small></p>

<ul class="shere">
<li class="facebook"><a href="https://www.facebook.com/Cuttaloca" target="_blank"><span>Share on Facebook</span></a></li>
<li class="twitter"><a href="https://twitter.com/cuttaloca" target="_blank"><span>Share on Twitter</span></a></li>
<li class="google"><a href="https://plus.google.com/u/0/105541360865541579361/about" target="_blank"><span>Share on Google+</span></a></li>
</ul>

</div></div>

</footer><!-- //#footer -->

<?= $this->element('sql_dump'); ?>

</body>
</html>
