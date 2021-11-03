app.controller('auth_controller', function($scope, $http, $state, ui_manager) {

    ui_manager.menubars('auth');

    $scope.user = {};
    $scope.user.email = 'christian@smdtechnologies.com'; //testing. Please remove!!!
    $scope.loader_label = 'Create Account';

    $scope.register = function () {

        $scope.loader_label = 'Creating your account...';

        $http.post(`services/api/user/create.php`, { 
            'user' :   $scope.user 
        })
        .then(function mySuccess(e) {

            $scope.loader_label = 'Account created';
            $scope.loader_label = 'Saving your password...';
            
            $http.post(`services/api/password/create.php`, { 
                'user' :   $scope.user 
            })
            .then(function mySuccess(e) {
    
                $scope.loader_label = 'Account created successfully';
                $state.go('dashboard');

                let notification = {};
                notification.text = "Welcome to Workflow. Thank you for signing up.";

                $http.post(`services/api/notification/create.php`, { 
                    'notification' :   notification 
                })
                .then(function mySuccess(e) {
                    console.log('notification created');
                }, function myError(e) {
                    console.log('failed to create notification');
                });
                    
            }, function myError(e) {

                $state.go('dashboard');
                $scope.loader_label = 'Failed to save your password. Please contact your administrator';

            });
                
        }, function myError(e) {

            $scope.loader_label = 'Account creation failed. Please contact your administrator';
            console.log(e.statusText);

        });

    }

    $scope.login = function () {

        $scope.user.action = "read_single";

        $http.post(`services/api/user/read.php`, { 
            'user' :   $scope.user 
        })
        .then(function mySuccess(e) {

                console.log(e.data);

                if(e.data.num > 0) {
                    $state.go('dashboard');
                } else {
                    alert("Incorrect email or password. Please try again.");
                }
               
            }, function myError(e) {
                alert('Failed to login. Please contact your administrator.');
            });

    }
    
});