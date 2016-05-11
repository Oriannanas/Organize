<?php
/**
 * Created by PhpStorm.
 * User: marijn
 * Date: 14-2-16
 * Time: 2:00
 */
?>
<script type="text/javascript">

    var siteApp = angular.module('siteApp');
    siteApp.controller('LogboekBaseCtrl', LogboekBaseCtrl);

    function LogboekBaseCtrl($scope) {
        $(document).ready(function () {
            $scope.loadLogs(null);
        });

        $scope.toggleNewLog = function () {
            $scope.newLog = !$scope.newLog;
        };

        $scope.setNotification = function (message) {
            $scope.notification = message;
            //@todo find a way to make the timeout universal so notifications within the 2500 ms don't get deleted.
            setTimeout(function () {
                    $scope.notification = null;
                },
                2500)
        };
        $scope.timer = function (timerObject, time) {
            timerObject = time;
            setTimeout(function () {
                    $scope.timer(timerObject, time - 1);
                },
                1000);
        };
        /**
         * @param logboekId null|int
         */
        $scope.loadLogs = function (logboekId) {
            $.ajax({
                url: "/logboek/logs",
                data: {
                    logId: logboekId
                },
                type: "POST",
                dataType: "json",
                success: function (r, statusCode) {
//                    console.log(r.logboeken);
                    $scope.logboeken = r.logboeken;

                    $scope.$apply();
                },
                error: function (r) {

                }
            });
        };

        $scope.loadEntries = function (logboekId) {
            $.ajax({
                url: "/logboek/entries",
                data: {
                    logId: logboekId
                },
                type: "POST",
                dataType: "json",
                success: function (r, statusCode) {
                    $scope.logboeken[logboekId].entries = r.entries;

                    $scope.$apply();
                },
                error: function (r) {

                }
            });
        };

        $scope.removeLog = function (logId) {
            if (confirm('Do you really want to delete this log?')) {
                $.ajax({
                    url: "/logboek/remove",
                    data: {
                        logId: logId
                    },
                    type: "POST",
                    dataType: "json",
                    success: function (r, statusCode) {
                        console.log(r);
                        $(document).find('#logboek-' + logId).remove();
//                    switch (r.code) {
//                        case 200:
//                            $scope.setNotification(r.message);
//                            break;
//                        default:
//                            $scope.setNotification(r.message);
//                    }

                        // Apply changes
                        $scope.$apply();
                    },
                    error: function(r){
                        console.log('Something went wrong');
                    }
                });
            }
        }

        $scope.generateLog = function (logId) {
//            console.log($scope.logboek.entries);
            $.ajax({
                url: "/logboek/generate",
                data: {
                    logId: logId
                },
                type: "POST",
                dataType: "json",
                success: function (r, statusCode) {
                    alert(statusCode);
                    $scope.logboeken[logId].entries = r.entries;

                    $scope.$apply();
                    // Apply changes
                    $scope.$apply();
                }
            });
        };

        $scope.newLogData = {};
        $scope.intervalTypes = ['seconds' + 'minutes' + 'hours' + 'days' + 'weeks' + 'months' + 'years'];

        $scope.saveNewLog = function () {
            $.ajax({
                url: "/logboek/new",
                data: {
                    newLogData: $scope.newLogData
                },
                type: "POST",
                dataType: "json",
                success: function (r, statusCode) {
                    alert(statusCode);
//                    switch (r.code) {
//                        case 200:
//                            $scope.setNotification(r.message);
//                            break;
//                        default:
//                            $scope.setNotification(r.message);
//                    }

                    // Apply changes
                    $scope.$apply();
                }
            });
        };

//        $scope.loadLogs = function (logboekId) {
//            $.ajax({
//                url: "/logboek/list",
//                data: {
//                    logId: logboekId
//                },
//                type: "POST",
//                dataType: "json",
//                success: function (r, statusCode) {
//                    $scope.logboeken = r.logboeken;
//
//                    $scope.$apply();
//                },
//                error: function (r) {
//
//                }
//            });
//        };
    }

</script>
<div ng-app="siteApp">
    <div>
        <h1>test</h1>

        <div class="logboekList" ng-controller="LogboekBaseCtrl">
            <?php $this->renderPartial('logboek/list'); ?>
        </div>
    </div>
</div>