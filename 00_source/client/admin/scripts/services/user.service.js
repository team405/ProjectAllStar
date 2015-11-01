(function () {
    'use strict';

    angular
        .module('app')
        .factory('UserService', UserService);

    angular.module('app').config(function ($httpProvider) {
        $httpProvider.defaults.transformRequest = function(data){
            if (data === undefined) {
                return data;
            }
            return $.param(data);
        }
    });


    UserService.$inject = ['$http'];
    function UserService($http) {
        var service = {};

        service.Create = Create;

        return service;

        function Create(user) {
            return $http({
                method : 'POST',
                url : '../../server/register_a.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: user
            }).then(handleSuccess, handleError('Error creating user'));

        }
        // private functions

        function handleSuccess(data) {
            return data.data;
        }

        function handleError(error) {
            return function () {
                return { result: false, resultDesc: error };
            };
        }
    }

})();
