(function(){
    var app = angular.module('pages', ['ngTouch', 'ngRoute']);

    var pages = [
        {'label':'Sobre', 'href':'/sobre.html', 'active':false},
        {'label':'No seu Museu', 'href':'/no-seu-museu.html', 'active':false},
        {'label':'Problemas Comuns', 'href':'/problemas.html', 'active':false},
        // {'label':'Contato', 'href':'/contato.html', 'active':false},
    ];

    app.controller('Main', ['$scope', '$rootScope', '$location', function(scope, root, location){
        var ctrl = this;
        scope.pages = pages;
        root.$on('$locationChangeSuccess', function(){
            if(scope.page){
                scope.page.active = false;
            }
            for(var i in pages){
                if(pages[i].href == location.path()){
                    scope.page = pages[i];
                    scope.page.active = true;
                    break;
                }
            }
        });
        root.$on('$viewContentLoaded', function(){
            angular.element('.collapsible').collapsible();
        });
    }]);

    app.config(['$routeProvider', function(route){
        route.when('/', {
            redirectTo:'sobre.html'
        });
        for(var i=0; i<pages.length; i++){
            route.when(pages[i].href, {
                templateUrl:'tpl' + pages[i].href
            });
        }
        route.otherwise('sobre.html');
    }]);

})();
