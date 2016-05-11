<script type="text/javascript">
        function LogboekNewCtrl($scope) {
            $scope.newLogData = {};
            $scope.intervalTypes = ['second' + 'minute' + 'hour' + 'day' + 'week' + 'month' + 'year'];

            $scope.saveNewLog = function () {
                console.log($(this));
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

            $scope.toggleNewLog = function () {
                $scope.newLog = !$scope.newLog;
            };
        }

</script>