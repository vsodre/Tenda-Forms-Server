(function() {
    var app = angular.module('client', ['ngTouch']);

    app.controller('PoolStage', ["$scope", "$http", "$timeout", "$window", function($scope, $http, $timeout, $window) {
        var campo = 0;
        var localhost = window.location.host;
        var questionario = {};
        var jQuery = $window.jQuery;

        $scope.counting = false;
        $scope.count = 0;
        $scope.form = {};
        $scope.timeout = $timeout;

        var updateScope = function() {
            $timeout(function() {
                var mod = questionario.fields.length;
                $scope.campo = questionario.fields[campo % mod];
            }, 200);
        };

        var startCount = function() {
            $scope.counting = true;
            $scope.count = 3;
            $timeout(function() {
                $scope.count--;
            }, 1000);
            $timeout(function() {
                $scope.count--;
            }, 2000);
            $timeout(function() {
                $scope.counting = false;
                $scope.released = true;
                snapshot();
            }, 3000);
        };

        $scope.checkboxObserver = function(val, field) {
            if (val) {
                var boxes = [];
                for (var k in val) {
                    if (val[k]) boxes.push(k);
                }
                $scope.form[field.nome] = boxes;
            }
        };

        $scope.snapshot = function() {
            startCount();
        };

        $scope.next = function() {
            campo++;
            $scope.disabled = true;
            jQuery("#stage").empty();
            jQuery("#stage").fadeOut(200, function() {
                updateScope();
                jQuery("#stage").fadeIn(700);
            });
        };

        $scope.doKick = function(k) {
            $timeout(function() {
                if (k === "Camera") {
                    startCam();
                }
            }, 100);
        };

        $scope.imprimir = function() {
            var fd = new FormData();
            var photo = printPhoto();
            fd.append('photo', photo);
            $http.post('http://' + localhost + '/print-photo', fd, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            });
            $http.post('http://' + localhost + '/resposta', $scope.form, {
                'Content-Type': 'application/x-www-form-urlencoded'
            });
            $scope.form = {};
            $scope.count = 0;
            $scope.released = false;
            $scope.next();
        };

        $http.get('http://' + localhost + '/admin/questionario.json').success(function(data) {
            questionario = data;
            var camera = {
                campo_t: "Camera",
                template: "tpl/camera.html"
            };
            var intro = {
                campo_t: 'intro',
                template: "tpl/intro.html"
            };
            var end = {
                campo_t: 'end',
                template: "tpl/end.html"
            };
            for (var i = 0; i < questionario.fields.length; i++) {
                switch (questionario.fields[i].campo_t) {
                    case 'Radiobox':
                        questionario.fields[i].template = '/tpl/radio.html#' + i;
                        break;
                    case 'Checkbox':
                        questionario.fields[i].template = '/tpl/check.html#' + i;
                        break;
                }
            }
            if (questionario.config && questionario.config.camera)
                questionario.fields.push(camera);
            questionario.fields.push(end);
            questionario.fields.unshift(intro);
            updateScope();
        });
    }]);
})();
