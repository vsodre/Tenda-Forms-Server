(function() {
    var app = angular.module('admin', ['ui.materialize']);
    questoes = {
        fields: []
    };

    app.directive('file', ['$http', function(http) {
        return {
            restrict: 'A',
            scope: {
                file: '='
            },
            link: function(scope, el, attrs) {
                el.bind('change', function(event) {
                    scope.file = event.target.files[0];
                    scope.$apply();
                });
            }
        };
    }]);

    app.controller('Telas', ['$http', function(http) {
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
        http.get('/admin/questionario.json')
            .success(function(response) {
                q = response;
                if(q.config){
                    angular.copy(q.config, ctrl.form);
                } else {
                    angular.copy(ctrl.conf, q.config);
                }
            });
    }]);

    app.controller('Camera', ['$http', '$scope', '$window', function(http, scope, w) {
        var ctrl = this;
        ctrl.form = {};
        ctrl.conf = {
            rfactor: 65,
            vpad: 240,
            hpad: 310,
            camera: false
        };
        scope.loading = false;
        scope.saving = false;
        scope.same = true;
        scope.preview = "";
        ctrl.setPreview = function() {
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
        ctrl.sendImage = function() {
            var form = new FormData();
            form.append('moldura', scope.moldura);
            http.post('/admin/moldura.save', form, {
                transformRequest: angular.identity,
                headers: {
                    'Content-Type': undefined
                }
            }).success(function(data) {
                scope.loading = false;
                scope.moldura = undefined;
                if (data.ok)
                    w.Materialize.toast('Arquivo aceito.', 4000);
                else
                    w.Materialize.toast('Rejeitado. ' + data.reason, 4000);
            }).error(function() {
                scope.loading = false;
                scope.moldura = undefined;
                w.Materialize.toast('Falha no servidor. Tente novamente.', 4000);
            });
        };
        ctrl.save = function() {
            scope.saving = true;
            http.post('/admin/camera-conf.save', ctrl.form, {
                'Content-Type': 'application/x-www-form-urlencoded'
            }).success(function(response) {
                ctrl.form = response;
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
                ctrl.sendImage();
            } else {
                scope.loading = false;
            }
        });
        http.get('/admin/camera-conf.json').success(function(response) {
            for (var k in response) {
                ctrl.form[k] = response[k];
            }
            if (angular.equals(ctrl.form, {})) {
                ctrl.form = angular.copy(ctrl.conf);
                scope.same = false;
            }
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
        	console.log('send');
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
