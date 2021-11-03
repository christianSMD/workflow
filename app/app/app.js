var app = angular.module("app", ['ui.router', 'angularMoment']);

app.config(['$stateProvider', function($stateProvider) {
    $stateProvider
    .state("dashboard", {
        url:'/dashboard',
        templateUrl: 'pages/dashboard/dashboard.html',
        controller: 'dashboard_controller',
    })
    .state("login", {
        url:'/login',
        templateUrl: 'pages/auth/login.html',
        controller: 'auth_controller',
    })
    .state("register", {
        url:'/register',
        templateUrl: 'pages/auth/register.html',
        controller: 'auth_controller',
    })
    .state("404", {
        url:'/*path',
        template: "Can't find what you looking for. <a ui-sref='home'>Go back</a>"
    });

  }
]);
