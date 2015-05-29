(function(){
    var app = angular.module('admin', ['ui.materialize']);

    app.controller('Questionario', [function(){
        ctrl = this;
        ctrl.form = {};
        ctrl.fields = [];

        ctrl.submit = function(){
            // if(ctrl.fields.length == 3){}
            console.log(ctrl.fields)
            ctrl.fields.push(ctrl.form);
            ctrl.form = {};
        };
    }]);
})();
