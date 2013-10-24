<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8" />
    <title>メニュー | Hogusu会員システム</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="/common/css/bootstrap.min.css" media="screen,print" />
    <link rel="stylesheet" type="text/css" href="/common/css/bootstrap-responsive.min.css" media="screen,print" />
    <link rel="stylesheet" type="text/css" href="/common/css/layout.css" media="screen,print" />
<?php if ($header['css']) { ?>
    <link rel="stylesheet" type="text/css" href="/css/<?php echo $header['css']; ?>.css" media="screen,print" />
<?php } ?>
    <script type="text/javascript" src="/common/js/jquery-1.9.1.min.js" ></script>
    <script type="text/javascript" src="/common/js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="/common/js/script.js"></script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-target=".nav-collapse" data-toggle="collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="/user/menu/">メニュー</a>
                <div class="nav-collapse collapse">
                    <ul class="nav">
                        <li></li>
                    </ul>
                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" href="#" data-toggle="dropdown"><strong class="text-warning"><?php echo $logindata['User']['last_name'].'&nbsp;'.$logindata['User']['first_name']; ?></strong>でログイン中<b class="caret"></b></a>
                            <?php echo $this->element('selfmenu'); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
        	<?= $this->Session->flash('flash', ['params' => ['class' => 'alert alert-success']]); ?>
            <?= $this->fetch('content'); ?>
        </div>
        
        <div class="text-center">
            &copy; Hogusu
        </div>
    </div>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>
