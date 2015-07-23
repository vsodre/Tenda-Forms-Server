<main ng-controller="Questionario as q">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <table class="striped">
                    <thead>
                        <tr><td>Nome do campo</td><td>Pergunta</td><td>Tipo do campo</td><td>&nbsp;</td></tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="f in q.fields">
                            <td>{{f.nome}}</td>
                            <td>{{f.pergunta}}</td>
                            <td>{{f.campo_t}}</td>
                            <td class="right">
                                <a class="waves-effect btn-flat" ng-click="q.edit(f)"><i class="mdi-editor-mode-edit"></i></a>
                                <a class="waves-effect btn-flat" ng-click="q.confirmRemove($index)"><i class="mdi-content-clear"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large" ng-click="q.open()">
            <i class="large mdi-content-add"></i>
        </a>
    </div>
</main>
<!--  -->
