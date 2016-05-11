<div class="row logboek-entries-headers">
    <div class="date col-xs-2">
        Date
    </div>
    <div class="name col-xs-3">
        Name
    </div>
    <div class="content col-xs-7">
        Content
    </div>
</div>
<div class="row logboek-entry" ng-repeat="entry in logboek.entries">
    <div class="col-xs-2">
        <p>{{entry.date}}</p>
    </div>
    <div class="col-xs-3">
        <p>{{entry.name}}</p>
    </div>

    <div class="col-xs-7">
        <p> {{entry.content}}</p>
    </div>
</div>
