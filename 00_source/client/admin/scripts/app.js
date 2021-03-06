﻿(function () {
    'use strict';

    angular
        .module('app', ['ngRoute', 'ngCookies', 'ngAnimate','ngFileUpload'])
        .config(config)
        .run(run);

    config.$inject = ['$routeProvider', '$locationProvider'];
    function config($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                controller: 'MypageController',
                templateUrl: 'views/mypage.view.html',
                controllerAs: 'ct'
            })

            .when('/login', {
                controller: 'LoginController',
                templateUrl: 'views/login.view.html',
                controllerAs: 'vm'
            })

            .when('/register', {
                controller: 'RegisterController',
                templateUrl: 'views/register.view.html',
                controllerAs: 'vm'
            })

            .when('/cont_register', {
                controller: 'ContRegisterController',
                templateUrl: 'views/cont_register.view.html',
                controllerAs: 'ct'
            })

            .when('/ques_register', {
                controller: 'QuesRegisterController',
                templateUrl: 'views/ques_register.view.html',
                controllerAs: 'ct'
            })

            .when('/ques_editor', {
                controller: 'QuesEditorController',
                templateUrl: 'views/ques_editor.view.html',
                controllerAs: 'ct'
            })

            .when('/intro', {
                controller: 'IntroController',
                templateUrl: 'views/intro.view.html',
                controllerAs: 'ct'
            })

            .when('/player', {
                controller: 'PlayerController',
                templateUrl: 'views/player.view.html',
                controllerAs: 'ct'
            })

            .when('/allrank', {
                controller: 'AllrankController',
                templateUrl: 'views/allrank.view.html',
                controllerAs: 'ct'
            })

            .otherwise({ redirectTo: '/login' });
    }

    run.$inject = ['$rootScope', '$location', '$cookieStore', '$http'];
    function run($rootScope, $location, $cookieStore, $http) {
        // keep user logged in after page refresh
        $rootScope.globals = $cookieStore.get('globals') || {};
        if ($rootScope.globals.currentUser) {
            $http.defaults.headers.common['Authorization'] = 'Basic ' + $rootScope.globals.currentUser.authdata; // jshint ignore:line
        }

        $rootScope.$on('$locationChangeStart', function (event, next, current) {
            // redirect to login page if not logged in and trying to access a restricted page
            var restrictedPage = $.inArray($location.path(), ['/login', '/register']) === -1;
            var loggedIn = $rootScope.globals.currentUser;
            if (restrictedPage && !loggedIn) {
                $location.path('/login');
            }//else if(restrictedPage && !$rootScope.globals.currentContent){
            //    $location.path('/');
            //}
        });
    }

})();
