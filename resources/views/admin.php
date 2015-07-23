<?php
$pages = [
    'questionario' => [
        'title' => 'Questionário',
        'link' => route('admin.questionario'),
    ],
    'dados' => [
        'title' => 'Importar Respostas',
        'link' => route('admin.dados'),
    ],
    'config' => [
        'title' => 'Configurações',
        'link' => route('admin.config'),
        // 'link' => '#',
    ],
];
?>
<!DOCTYPE html>
<html ng-app="admin">
<head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="/css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="/css/admin.css" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>
<body>
    <header>
        <nav class="top-nav">
            <div class="nav-wrapper">
                <div class="container">
                    <a href="#" data-activates="slide-out" data-sidenav="left" data-menuwidth="300" data-closeonclick="false" class="button-collapse show-on-large"><i class="mdi-navigation-menu"></i></a>
                    <a href="#" class="brand-logo center"><?php echo $pages[$page]['title'] ?></a>
                    <!-- <a href="#" class="brand-logo"><img src="img/logo.png" /></a> -->
                </div>
            </div>
        </nav>
        <ul id="slide-out" class="side-nav">
            <?php foreach($pages as $p => $c): ?>
            <?php if($page == $p): ?>
            <li class="active">
            <?php else: ?>
            <li>
            <?php endif; ?>
                <a href="<?php echo $c['link'] ?>"><?php echo $c['title'] ?></a></li>
            <?php endforeach; ?>
        </ul>
    </header>
    <?php echo view($page) ?>
    <footer>&nbsp;</footer>
    <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/js/angular.js"></script>
    <script type="text/javascript" src="/js/angular-touch.js"></script>
    <script type="text/javascript" src="/js/materialize.min.js"></script>
    <script type="text/javascript" src="/js/angular-materialize.js"></script>
    <script type="text/javascript" src="/js/utils.js"></script>
    <script type="text/javascript" src="/js/admin.app.js"></script>
</body>
</html>
