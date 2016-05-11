<div ng-if="newLog">
    <form role="form" ng-submit="saveNewLog()">
        <div class="row">
            <div class="col-md-3">
                <label for="newLogName">Name</label>
                <input id="newLogName" type="datetime" ng-model="newLogData.name" value="now"/>
            </div>
            <div class="col-md-3">
                            <label for="newLogDateFrom">Date from</label>
                            <input id="newLogDateFrom" type="datetime" ng-model="newLogData.dateFrom" value="now"/>
                            <label for="newLogDateTo">Date to</label>
                            <input id="newLogDateTo" type="datetime" ng-model="newLogData.dateTo" value="now"/>
            </div>
            <div class="col-md-3">
                            <label for="interval">Interval</label>
                            <input id="interval" type="number" ng-model="newLogData.interval"/>
                            <select name="newLogIntervalType" ng-model="newLogData.intervalType">
                                <option value="">No interval</option>
                                <option value="seconds">Second</option>
                                <option value="minutes">Minute</option>
                                <option value="hour">Hour</option>
                                <option value="day">Day</option>
                                <option value="month">Month</option>
                                <option value="year">Year</option>
                            </select>
            </div>
            <div class="col-md-3">
                            <input type="submit" value="Create">
                            <button ng-click="toggleNewLog()">Cancel</button>
            </div>
        </div>
    </form>
</div>
<div ng-if="!newLog">
    <button ng-click="toggleNewLog()">Start a new log</button>
</div>