<!DOCTYPE html>
<html ng-app="admin">
<head>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="#" class="brand-logo"><img src="img/logo.png" /></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li class="active"><a href="cinfig"><i class="mdi-action-settings"></i></a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">

            <div class="col s12 m4 l2"> <!-- Note that "m4 l3" was added -->
                <div class="collection">
                    <a href="#!" class="collection-item">Apresentação</a>
                    <a href="#!" class="collection-item active">Questionário</a>
                    <a href="#!" class="collection-item">Dados</a>
                </div>

            </div>

            <div class="col s12 m8 l10" ng-controller="Questionario as q">
                <div class="section">
                    <h5>Novo campo</h5>
                    <div class="row">
                        <div class="input-field col s3">
                            <input id="nome" ng-model="q.form.nome" type="text" class="validate">
                            <label for="nome">Nome do campo</label>
                        </div>
                        <div class="input-field col s5">
                            <input id="pergunta" ng-model="q.form.pergunta" type="text" class="validate">
                            <label for="pergunta">Pergunta</label>
                        </div>
                        <div class="input-field col s3">
                            <select id="campo_t" ng-model="q.form.campo_t">
                                <option disabled selected></option>
                                <option>Slider</option>
                                <option>Checkbox</option>
                                <option>Listbox</option>
                                <option>MultiCheckbox</option>
                            </select>
                            <label for="campo_t">Tipo de campo</label>
                        </div>
                        <div class="col s1">
                            <a class="btn-floating btn-large waves-effect waves-light" ng-click="q.submit()"><i class="mdi-content-add"></i></a>
                        </div>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="section">
                    <h5>Questionário</h5>
                    <div class="row">
                        <div class="col s12">
                            <table class="striped">
                                <thead>
                                    <tr><td>Nome do campo</td><td>Pergunta</td><td>Tipo do campo</td></tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="f in q.fields"><td>{{f.nome}}</td><td>{{f.pergunta}}</td><td>{{f.campo_t}}</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/angular.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/angular-materialize.js"></script>
    <script type="text/javascript" src="js/admin.app.js"></script>
    <script>
    $(document).ready(function() {
        $('select').material_select();
    });
    </script>
</body>
</html>
