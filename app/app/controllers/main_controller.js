app.controller('main_controller', function($rootScope, $scope, $state, $http) {

     $scope.notifications = {};
    $scope.notifications_count = 0;

    function get_session() {

        $http.get(`services/api/session/get_session.php`)
        .then(function mySuccess(e) {

            console.log(e.data.state);
            $rootScope.name = e.data.name;
            $rootScope.surname = e.data.surname;
            $rootScope.email = e.data.email;
            if(e.data.state > 0) {
                get_notifications();
            } else {
               // $state.go('login');
            }

        }, function myError(e) {

            console.log('Could not load notifications: ', e);
            $state.go('login');

        });
    }

    get_notifications = function () {

        $http.get(`services/api/notification/read.php`)
        .then(function mySuccess(e) {

            console.log(e.data);
            $scope.notifications = e.data.list;
            $scope.notifications_count = e.data.rows;
               
            }, function myError(e) {
                console.log('Could not load notifications: ', e);
            });

    }

   get_session();
   

    $scope.logout = function() {

        const user = {}
        let r = confirm("Logout?");

        user.action = 'logout';

        if (r == true) {

            $scope.loader_label = 'Logging out...';

            $http.post(`services/api/user/read.php`, { 
                'user' :   user 
            })
            .then(function mySuccess(e) {

            $state.go('login');
                    
            }, function myError(e) {

                alert('There was an issue logging out. Please contact your administrator.');

            });
        } else {
            console.log('Logout cancelled');
        }

        
    }
});