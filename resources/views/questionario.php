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
                                <a href="#form" class="waves-effect btn-flat" ng-click="q.edit($index)" modal><i class="mdi-editor-mode-edit"></i></a>
                                <a href="#confirm" class="waves-effect btn-flat" ng-click="q.confirmRemove($index)" modal><i class="mdi-content-clear"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large" href="#form" modal>
            <i class="large mdi-content-add"></i>
        </a>
    </div>
<div class="modal" id="confirm">
    <div class="modal-content">
        <h4>Tem certeza que deseja remover a seguinte questão?</h4>
        <p>{{q.fields[q._remove].pergunta}}</p>
    </div>
    <div class="modal-footer">
        <a class="waves-effect modal-action btn" ng-click="q.remove()">Remover</a>
        <a class="waves-effect modal-action modal-close btn-flat">Fechar</a>
    </div>
</div>
<div class="modal" id="form">
    <div class="modal-content">
        <h4>Questão</h4>
        <div class="row">
            <form class="col s12">
                <div class="row">
                    <div class="col s12">
                        <div class="input-field">
                            <input id="pergunta" type="text" ng-model="q.form.pergunta" class="validate">
                            <label for="pergunta">Pergunta</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6">
                        <div class="input-field">
                            <input id="nome" type="text" ng-model="q.form.nome" class="validate">
                            <label for="nome">Nome do Campo</label>
                        </div>
                    </div>
                    <div class="col s6">
                        <div class="input-field">
                            <select id="campo_t" material-select ng-model="q.form.campo_t" class="validate">
                                <option value="" disabled selected></option>
                                <option value="Checkbox">Multiplas respostas</option>
                                <option value="Radiobox">Apenas uma resposta</option>
                                <option value="Satisfaction">Satisfação</option>
                            </select>
                            <label for="campo_t">Tipo de Campo</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s10">
                        <div class="input-field">
                            <input id="resposta" type="text" ng-disabled="q.form.campo_t == 'Satisfaction'" ng-model="q.resposta" class="validate">
                            <label for="resposta">Resposta</label>
                        </div>
                    </div>
                    <div class="col s2">
                        <a class="waves-effect btn-floating" ng-click="q.addResponse()"><i class="mdi-content-add"></i></a>
                        <a class="waves-effect btn-floating right" ng-click="q.removeResponse()"><i class="mdi-content-remove"></i></a>
                    </div>
                    <div class="col s12">
                        <ul class="collection">
                            <li ng-repeat="r in q.form.respostas" class="collection-item" ng-click="q.resposta = r" ng-class="{active:q.resposta==r}">{{r}}</li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a class="waves-effect modal-action btn" ng-click="q.save()">Salvar</a>
        <a href="#!" class="waves-effect modal-action modal-close btn-flat" ng-click="(q.form = {})">Fechar</a>
    </div>
</div>
</main>
