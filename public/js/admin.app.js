(function(){
    var app = angular.module('admin', ['ui.materialize']);

    var questoes = [];

    app.controller('Questionario', ['$modal', function(modal){
        ctrl = this;
        ctrl.form = {};
        ctrl.fields = questoes;
        ctrl.selected = -1;
        ctrl.open = function(){
            modal.open('/tpl/questoes.form.html', {'parent':ctrl});
        };
        ctrl.save = function(){
            if(!ctrl.form._id){
                ctrl.form._id = new Date();
                questoes.push(ctrl.form);
            }
            ctrl.form = {};
            return true;
        };
        ctrl.edit = function(question){
            ctrl.form = question;
            ctrl.open();
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
    }]);
})();
