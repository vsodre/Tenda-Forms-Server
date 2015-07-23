(function() {
    var app = angular.module('admin', ['ui.materialize', 'ngTouch']);
    questoes = {
        fields: []
    };

    app.directive('file', ['$http', function(http) {
        return {
            restrict: 'A',
            scope:{
                file:'='
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
        ctrl.default = {
            camera: true,
            disclaimer: {
                active: false,
                text: ""
            }
        };
        ctrl.save = function() {
            q.config = ctrl.form;
            http.post('/admin/questionario.save', q, {
                    'Content-Type': 'application/x-form-urlencoded'
                })
                .success(function(data) {
                    q = data;
                    ctrl.form = q.config;
                });
        };
        http.get('/admin/questionario.json')
            .success(function(data) {
                q = data;
                ctrl.form = angular.extend(ctrl.default, q.config);
            });
    }]);

    app.controller('Camera', ['$http', '$scope', '$window', function(http, scope, w) {
        var ctrl = this;
        ctrl.form = {};
        ctrl.conf = {};
        ctrl.default = {
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
                    w.Materialize.toast('Arquivo rejeitado.', 4000);
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
            }).success(function(data) {
                ctrl.conf = data;
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
        http.get('/admin/camera-conf.json').success(function(data) {
            for (var k in data) {
                ctrl.form[k] = data[k];
                ctrl.conf[k] = data[k];
            }
            if (angular.equals(ctrl.form, {})) {
                ctrl.form = ctrl.default;
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
        http.get('/admin/dados.json').success(function(data) {
            ctrl.datas = data;
            for (var k in data) {
                ctrl.form.datas[k] = false;
            }
        });
    }]);

    app.controller('Questionario', ['$modal', '$http', function(modal, http) {
        var ctrl = this;
        ctrl.form = {};
        ctrl.fields = [];
        ctrl.config = [];
        ctrl.selected = -1;
        ctrl.save = function() {
            questoes.fields = ctrl.fields;
            questoes.config = ctrl.config;
            if (!ctrl.form._id) {
                ctrl.form._id = new Date();
                questoes.fields.push(ctrl.form);
            }
            http.post('/admin/questionario.save', questoes, {
                    'Content-Type': 'application/x-form-urlencoded'
                })
                .success(function(data) {
                    if (!angular.equals(data.fields, {})) ctrl.fields = data.fields;
                    ctrl.form = {};
                });
            return true;
        };
        ctrl.open = function() {
            modal.open('/tpl/questoes.form.html', {
                'parent': ctrl
            });
        };
        ctrl.edit = function(question) {
            ctrl.form = question;
            modal.open('/tpl/questoes.form.html', {
                'parent': ctrl
            });
        };
        ctrl.confirmRemove = function(index) {
            modal.open('/tpl/questoes.confirm.html', {
                'parent': ctrl,
                'r_index': index
            });
        };
        ctrl.remove = function(index) {
            questoes.fields = ctrl.fields;
            questoes.fields.splice(index, 1);
            http.post('/admin/questionario.save', questoes, {
                    'Content-Type': 'application/x-form-urlencoded'
                })
                .success(function(data) {
                    if (data.fields) ctrl.fields = data.fields;
                });
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
            .success(function(data) {
                if (!angular.equals(data.fields, {})) ctrl.fields = data.fields;
            });
    }]);
})();
