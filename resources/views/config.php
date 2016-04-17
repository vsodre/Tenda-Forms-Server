<!-- <main> -->
<main>
    <div class="container">
        <div class="row">
            <div class="col s12 m6">
                <div class="card" ng-controller="Camera as c">
                    <div class="card-content ">
                        <span class="card-title black-text">Foto e impressão</span>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="clearfix">
                                    <span class="left">Proporção de redimencionamento:</span>
                                    <span class="left editable">
                                        <input ng-model="c.form.rfactor" ng-change="c.compare('rfactor')" type="text" />
                                    </span>
                                    <span class="left">%</span>
                                </div>
                                <p class="range-field">
                                    <input type="range" ng-model="c.form.rfactor" ng-change="c.compare('rfactor')" id="rfactor" min="0" max="100" />
                                </p>
                            </li>
                            <li class="collection-item">
                                <div class="clearfix">
                                    <span class="left">Distância do topo:</span>
                                    <span class="left editable">
                                        <input ng-model="c.form.vpadcm" class="center-align" ng-change="c.compare('vpadcm')" type="text" />
                                    </span>
                                    <span class="left">cm</span>
                                </div>
                                <p class="range-field">
                                    <input type="range" ng-model="c.form.vpadcm" ng-change="c.compare('vpadcm')" id="vpad" min="0" max="15" step="0.1" />
                                </p>
                            </li>
                            <li class="collection-item">
                                <div class="clearfix">
                                    <span class="left">Distância da direita: </span>
                                    <span class="left editable">
                                        <input ng-model="c.form.hpadcm" ng-change="c.compare('hpadcm')" type="text" />
                                    </span>
                                    <span class="left">cm</span>
                                </div>
                                <p class="range-field">
                                    <input type="range" ng-model="c.form.hpadcm" ng-change="c.compare('hpadcm')" id="hpad" min="0" max="15" step="0.1" />
                                </p>
                            </li>
                            <li class="collection-item">
                                <p>
                                    <a href="{{c.form.frame_url}}" target="_blank">Moldura</a>
                                </p>
                                <p>
                                    A imagem deve estar em formato PNG e obrigatóriamente com 1052px de largura por 744px de altura
                                </p>
                                <span class="secondary-content">
                                    <div class="file-field input-field">
                                        <div ng-hide="!loading" class="preloader-wrapper small active">
                                            <div class="spinner-layer spinner-blue-only">
                                                <div class="circle-clipper left">
                                                    <div class="circle"></div>
                                                </div><div class="gap-patch">
                                                    <div class="circle"></div>
                                                </div><div class="circle-clipper right">
                                                    <div class="circle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn" ng-class="{disabled:loading}">
                                            <span>Alterar</span>
                                            <input file="moldura" type="file" accept="image/png" />
                                        </div>
                                    </div>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-action">
                        <a href="#visualizar" ng-click="c.setPreview()" modal>Visualizar</a>
                        <a href="#" ng-hide="same" ng-click="!saving && c.save()">Salvar</a>
                    </div>
                    <div id="visualizar" class="modal big">
                        <div class="modal-content">
                            <img ng-src="{{preview}}"  class="responsive-img" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card" ng-controller="Telas as t">
                    <div class="card-content">
                        <span class="card-title black-text">Telas do Formulário</span>
                        <ul class="collection">
                            <li class="collection-item">
                                Câmera
                                <span class="secondary-content">
                                    <div class="switch right">
                                        <label>
                                            Desligada
                                            <input ng-model="t.form.camera" ng-change="t.save()" type="checkbox">
                                            <span class="lever"></span>
                                            Ligada
                                        </label>
                                    </div>
                                </span>
                            </li>
                            <li class="collection-item">
                                <a href="#disclaimer" modal>Termos de aceitação da pesquisa</a>
                                <span class="secondary-content">
                                    <div class="switch right">
                                        <label>
                                            Desligado
                                            <input ng-model="t.form.disclaimer.active" ng-change="t.save()" type="checkbox">
                                            <span class="lever"></span>
                                            Ligado
                                        </label>
                                    </div>
                                </span>
                                <div id="disclaimer" class="modal">
                                    <div class="modal-content">
                                        <textarea ng-model="t.form.disclaimer.text"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#!" class="modal-action waves-effect btn-flat" ng-click="t.save() && $('#disclaimer').closeModal">Salvar</a>
                                    </div>
                                </div>
                            </li>
                            <li class="collection-item">
                                Imagem inicial
                                <span class="secondary-content">
                                    <div class="file-field input-field">
                                        <div ng-hide="!loading" class="preloader-wrapper small active">
                                            <div class="spinner-layer spinner-blue-only">
                                                <div class="circle-clipper left">
                                                    <div class="circle"></div>
                                                </div><div class="gap-patch">
                                                    <div class="circle"></div>
                                                </div><div class="circle-clipper right">
                                                    <div class="circle"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn" ng-class="{disabled:loading}">
                                            <span>Alterar</span>
                                            <input file="abertura" type="file" accept="image/png" />
                                        </div>
                                    </div>
                                </span>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
