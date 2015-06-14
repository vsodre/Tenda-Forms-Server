<!DOCTYPE html>
<html ng-app="admin">
<head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="/css/materialize.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>
<body>
    <header>
        <nav class="top-nav">
            <div class="nav-wrapper">
                <div class="container">
                    <a href="#" data-activates="slide-out" class="button-collapse show-on-large"><i class="mdi-navigation-menu"></i></a>
                    <a href="#" class="brand-logo center">Questionário</a>
                    <!-- <a href="#" class="brand-logo"><img src="img/logo.png" /></a> -->
                </div>
            </div>
        </nav>
        <ul id="slide-out" class="side-nav">
            <li><a href="#!">Questionário</a></li>
        </ul>
    </header>
    <main ng-controller="Questionario as q">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <table class="striped">
                        <thead>
                            <tr><td>Nome do campo</td><td>Pergunta</td><td>Tipo do campo</td><td>&nbsp;</td></tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="f in q.fields">
                                <td>{{f.nome}}</td>
                                <td>{{f.pergunta}}</td>
                                <td>{{f.campo_t}}</td>
                                <td class="right">
                                    <a class="waves-effect btn-flat" ng-click="q.edit(f)"><i class="mdi-editor-mode-edit"></i></a>
                                    <a class="waves-effect btn-flat" ng-click="q.confirmRemove($index)"><i class="mdi-content-clear"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
            <a class="btn-floating btn-large" ng-click="q.open()">
                <i class="large mdi-content-add"></i>
            </a>
        </div>
    </main>
    <footer>
        &nbsp;
    </footer>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="/js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/js/angular.js"></script>
    <script type="text/javascript" src="/js/materialize.min.js"></script>
    <script type="text/javascript" src="/js/angular-materialize.js"></script>
    <script type="text/javascript" src="/js/admin.app.js"></script>
    <script>
    $(document).ready(function() {
        $('select').material_select();
        $(".button-collapse").sideNav();
    });
    </script>
</body>
</html>
