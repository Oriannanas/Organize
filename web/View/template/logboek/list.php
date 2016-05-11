<div id="logboeken">
    <div class="table">
        <div class="logboek-headers table row">
            <div class="date col-xs-3">
                Name
            </div>
            <div class="name col-xs-3">
                Start date
            </div>
            <div class="content col-xs-3">
                End date
            </div>
            <div class="actions col-xs-3">
                Options
            </div>
        </div>
        <div class="logboeken row" ng-repeat="logboek in logboeken" id="logboek-{{logboek.id}}">
            <div class="logboek-name col-xs-3">
                <p> {{logboek.name}} </p>
            </div>
            <div class="logboek-date-from col-xs-3">
                <p>{{logboek.beginDate}} </p>
            </div>
            <div class="logboek-date-to col-xs-3">
                <p>{{logboek.endDate}} </p>
            </div>
            <div class="logboek-edit col-xs-3">
                <button ng-click="loadEntries(logboek.id)">Show</button>
                <button ng-click="loadEntries(logboek.id)">Edit</button>
                <button ng-click="removeLog(logboek.id)">Remove</button>
                <button ng-click="generateLog(logboek.id)">Generate</button>
            </div>
            <div class="logboek-entries col-md-12" ng-if="logboek.entries">
                <?php $this->renderPartial('logboek/entries') ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button ng-click="loadData(null, 'true', null)">Show hidden</button>
            <button ng-click="loadData(null, null, 'true')">Show deleted</button>
            <?php $this->renderPartial('logboek/new') ?>
        </div>
    </div>
</div>