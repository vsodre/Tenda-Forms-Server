(function() {
    var app = angular.module('admin', ['ui.materialize']);
    questoes = {
        fields: []
    };

     var sendImage = function(url, data, http, success, failure) {
        var form = new FormData();
        form.append('image', data);
        http.post(url, form, {
            transformRequest: angular.identity,
            headers: {
                'Content-Type': undefined
            }
        }).success(function(data) {
            success();
            if (data.ok)
                window.Materialize.toast('Arquivo aceito.', 4000);
            else
                window.Materialize.toast('Rejeitado. ' + data.reason, 4000);
        }).error(function() {
            failure();
            window.Materialize.toast('Falha no servidor. Tente novamente.', 4000);
        });
    };

    app.directive('file', function() {
        return {
            restrict: 'A',
            link: function(scope, el, attrs) {
                el.bind('change', function(event) {
                    scope[attrs.file] = event.target.files[0];
                    scope.$apply();
                });
            }
        };
    });

    app.controller('Telas', ['$http', '$scope', function(http, scope) {
        var ctrl = this;
        var q = {};
        ctrl.form = {};
        ctrl.conf = {
            camera: false,
            disclaimer: {
                active: false,
                text: ""
            }
        };
        ctrl.save = function() {
            var container = {};
            angular.copy(q, container);
            container.config = ctrl.form;
            http.post('/admin/questionario.save', container, {
                    'Content-Type': 'application/x-form-urlencoded'
                })
                .success(function(response) {
                    q = response;
                    angular.copy(q.config, ctrl.form);
                    ctrl.form = q.config;
                });
        };
        scope.$watch('abertura', function() {
            if (scope.abertura) {
                scope.loading = true;
                sendImage('/admin/abertura.save', scope.abertura, http, function(){
                    scope.loading = false;
                    scope.abertura = undefined;
                }, function(){
                    scope.loading = false;
                    scope.abertura = undefined;
                });
            } else {
                scope.loading = false;
            }
        });
        http.get('/admin/questionario.json')
            .success(function(response) {
                q = response;
                if(q.config){
                    angular.copy(q.config, ctrl.form);
                } else {
                    angular.copy(ctrl.conf, q.config);
                    angular.copy(q.config, ctrl.form);
                }
            });
    }]);

    app.controller('Camera', ['$http', '$scope', '$window', function(http, scope, w) {
        var ctrl = this;
        ctrl.form = {};
        ctrl.conf = {};
        scope.loading = false;
        scope.saving = false;
        scope.same = true;
        scope.preview = "";
        ctrl.setPreview = function() {
            ctrl.form.vpad = Math.round(ctrl.form.vpadcm*37.79527559);
            ctrl.form.hpad = Math.round(ctrl.form.hpadcm*37.79527559);
            http.post('/admin/camera-conf.preview', ctrl.form, {
                'Content-Type': 'application/x-www-form-urlencoded',
                'responseType': 'arraybuffer'
            }).success(function(data) {
                var img = new Blob([data], {
                    type: 'image/png'
                });
                scope.preview = URL.createObjectURL(img);
            });
        };
        ctrl.save = function() {
            scope.saving = true;
            ctrl.form.vpad = Math.round(ctrl.form.vpadcm*37.79527559);
            ctrl.form.hpad = Math.round(ctrl.form.hpadcm*37.79527559);
            http.post('/admin/camera-conf.save', ctrl.form, {
                'Content-Type': 'application/x-www-form-urlencoded'
            }).success(function(response) {
                angular.copy(response, ctrl.form);
                angular.copy(ctrl.form, ctrl.conf);
                scope.saving = false;
                scope.same = true;
            }).error(function() {
                scope.saving = false;
            });
        };
        ctrl.compare = function(field) {
            scope.same = (ctrl.conf[field] == ctrl.form[field]);
        };
        scope.$watch('moldura', function() {
            if (scope.moldura) {
                scope.loading = true;
                sendImage('/admin/moldura.save', scope.moldura, http, function(){
                    scope.loading = false;
                    scope.moldura = undefined;
                    ctrl.form.frame_url = '/storage/frame.png';
                }, function(){
                    scope.loading = false;
                    scope.moldura = undefined;
                });
            } else {
                scope.loading = false;
            }
        });

        http.get('/admin/camera-conf.json').success(function(response) {
            angular.copy(response, ctrl.form);
            ctrl.form.frame_url = (ctrl.form.frame_path.search('/storage/app/frame.png') > -1)?'/storage/frame.png':'/img/frame.png';
            ctrl.form.vpadcm = (ctrl.form.vpad/37.79527559).toFixed(1);
            ctrl.form.hpadcm = (ctrl.form.hpad/37.79527559).toFixed(1);
            angular.copy(ctrl.form, ctrl.conf);
        });
    }]);

    app.controller('Dados', ['$http', function(http) {
        var ctrl = this;
        ctrl.datas = [];
        ctrl.form = {
            datas: []
        };
        ctrl.link = '';
        ctrl.format = function() {
            var datas = [];
            for (var k in ctrl.form.datas) {
                if (ctrl.form.datas[k]) datas.push(ctrl.datas[k].date);
            }
            if (datas.length) {
                ctrl.link = '/admin/dados/' + datas.join();
            } else {
                ctrl.link = '';
            }
        };
        http.get('/admin/dados.json').success(function(response) {
            ctrl.datas = response;
            for (var k in response) {
                ctrl.form.datas[k] = false;
            }
        });
    }]);

    app.controller('Questionario', ['$http', function(http) {
        var ctrl = this;
        outside = ctrl;
        ctrl.questionario = {};
        ctrl.form = {};
        ctrl.fields = [];
        ctrl.config = [];
        ctrl.selected = -1;
        ctrl._remove = -1;
        ctrl.send = function() {
            http.post('/admin/questionario.save', ctrl.questionario, {
                    'Content-Type': 'application/x-form-urlencoded'
                })
                .success(function(response) {
                	console.log(response);
                    ctrl.questionario = response;
                    angular.copy(response.fields, ctrl.fields);
                    ctrl.form = {};
                });
            return true;
        };
        ctrl.save = function() {
            if (!ctrl.form._id) {
                ctrl.form._id = (new Date()).getTime();
                ctrl.questionario.fields.push(ctrl.form);
            }
            ctrl.send();
            $('#form').closeModal();
        };
        ctrl.edit = function(index) {
            ctrl.form = ctrl.questionario.fields[index];
        };
        ctrl.confirmRemove = function(index) {
        	console.log('remove: ' + index);
            ctrl._remove = index;
        };
        ctrl.remove = function() {
            ctrl.questionario.fields.splice(ctrl._remove, 1);
            ctrl.send();
            $('#confirm').closeModal();
            return true;
        };
        ctrl.addResponse = function() {
            if (!ctrl.form.respostas) ctrl.form.respostas = [];
            if (ctrl.form.respostas.indexOf(ctrl.resposta) < 0) ctrl.form.respostas.push(ctrl.resposta);
            ctrl.selected = -1;
            ctrl.resposta = "";
        };
        ctrl.removeResponse = function() {
            if (!ctrl.form.respostas) ctrl.form.respostas = [];
            var element_i = ctrl.form.respostas.indexOf(ctrl.resposta);
            if (element_i >= 0) {
                ctrl.form.respostas.splice(element_i, 1);
            }
            ctrl.selected = -1;
            ctrl.resposta = "";
        };
        http.get('/admin/questionario.json')
            .success(function(response) {
                ctrl.questionario = response;
                if (ctrl.questionario.fields) {
                    angular.copy(ctrl.questionario.fields, ctrl.fields);
                } else {
                    ctrl.fields = [];
                    ctrl.questionario.fields = [];
                }
            });
    }]);
})();
