(function () {
    'use strict';

    angular
        .module('app')
        .factory('RemoconService', RemoconService);

    angular.module('app').config(function ($httpProvider) {
        $httpProvider.defaults.transformRequest = function(data){
            if (data === undefined) {
                return data;
            }
            return $.param(data);
        }
    });


    RemoconService.$inject = ['$http'];
    function RemoconService($http) {
        var service = {};

        service.SendChoice = SendChoice;
        return service;



        function SendChoice(usernum,choice) {
            return $http({
                method : 'POST',
                url : '../../02_server/choice_test.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userNumber:usernum,choice:choice},
            }).then(handleSuccess, handleError('Error sending Choice'));

        }
    }

})();
