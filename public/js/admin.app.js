(function(){
    var app = angular.module('admin', ['ui.materialize', 'ngTouch']);

    var questoes = {
        fields:[]
    };

    app.controller('Questionario', ['$modal', '$http', function(modal, http){
        ctrl = this;
        ctrl.form = {};
        ctrl.fields = [];
        ctrl.selected = -1;
        ctrl.save = function(){
            questoes.fields = ctrl.fields;
            if(!ctrl.form._id){
                ctrl.form._id = new Date();
                questoes.fields.push(ctrl.form);
            }
            http.post('/admin/questionario.save', questoes, {'Content-Type': 'application/x-form-urlencoded'})
            .success(function(data){
                if(data.fields) ctrl.fields = data.fields;
                ctrl.form = {};
            });
            return true;
        };
        ctrl.open = function(){
            modal.open('/tpl/questoes.form.html', {'parent':ctrl});
        };
        ctrl.edit = function(question){
            ctrl.form = question;
            modal.open('/tpl/questoes.form.html', {'parent':ctrl});
        };
        ctrl.confirmRemove = function(index){
            modal.open('/tpl/questoes.confirm.html', {'parent':ctrl, 'r_index': index});
        };
        ctrl.remove = function(index){
            questoes.fields = ctrl.fields;
            questoes.fields.splice(index, 1);
            http.post('/admin/questionario.save', questoes, {'Content-Type': 'application/x-form-urlencoded'})
            .success(function(data){
                if(data.fields) ctrl.fields = data.fields;
            });
            return true;
        };
        ctrl.addResponse = function(){
            if(!ctrl.form.respostas) ctrl.form.respostas = [];
            if(ctrl.form.respostas.indexOf(ctrl.resposta) < 0) ctrl.form.respostas.push(ctrl.resposta);
            ctrl.selected = -1;
            ctrl.resposta = "";
        };
        ctrl.removeResponse = function(){
            if(!ctrl.form.respostas) ctrl.form.respostas = [];
            var element_i = ctrl.form.respostas.indexOf(ctrl.resposta);
            if( element_i >= 0){
                ctrl.form.respostas.splice(element_i, 1);
            }
            ctrl.selected = -1;
            ctrl.resposta = "";
        };
        http.get('/admin/questionario.json')
        .success(function(data){
            if(data.fields) ctrl.fields = data.fields;
        });
    }]);
})();
