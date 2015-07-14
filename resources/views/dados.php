<main ng-controller="Dados as d">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <ul class="collection with-header">
                    <li class="collection-header">
                        <h4>Últimas datas</h4>
                    </li>
                    <li ng-repeat="data in d.datas" class="collection-item">
                        <input type="checkbox" ng-model="d.form.datas[$index]" ng-change="d.format()" class="filled-in" id="filled-in-box{{$index}}" />
                        <label for="filled-in-box{{$index}}">{{data.date | date:'dd/MM/yyyy'}} ({{data.qty}})</label>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large" ng-class="{disabled:!d.link.length}" ng-href="{{d.link}}">
            <i class="mdi-file-file-download small"></i>
        </a>
    </div>
</main>
