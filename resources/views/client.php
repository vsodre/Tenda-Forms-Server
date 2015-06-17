<!doctype html>
<html lang="en" ng-app="client">
<head>
  <meta charset="utf-8">
  <link rel="manifest" href="manifest.json">
  <title>Tenda Client</title>
  <link rel="stylesheet" href="css/materialize.css"/>
  <link rel="stylesheet" href="css/app.css"/>
</head>
<body ng-controller="PoolStage">
    <div class="container pad">
        <div class="row">
            <div ng-include="campo.template" onload="doKick(campo.campo_t)" id="stage" class="col s12 white z-depth-1"></div>
        </div>
    </div>
  <script src="js/jquery-2.1.1.min.js"></script>
  <script src="js/angular.js"></script>
  <script src="js/materialize.js"></script>
  <script src="js/angular-materialize.js"></script>
  <script src="js/camera.js"></script>
  <script src="js/client.app.js"></script>
</body>
</html>
