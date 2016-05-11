<script type="text/javascript">

    function LogboekListCtrl($scope) {
        /**
         *
         * @param logboekId
         * @param showHidden
         * @param showDeleted
         */
        $scope.loadData = function (logboekId, showHidden, showDeleted) {
            console.log('yes');
            $.ajax({
                url: "/logboek/list",
                data: {
                    logId: logboekId,
                    showHidden = showHidden,
                    showDeleted = showDeleted
                },
                type: "POST",
                dataType: "json",
                success: function (r, statusCode) {
                    $scope.logboeken = r.logboeken;

                    $scope.$apply();
                },
                error: function (r) {
                    console.log('Something went wrong');
                }
            });
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
        $scope.loadData(null, null, null);
    }
</script>