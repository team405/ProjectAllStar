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



        function SendChoice(usernum,contentid,choice) {
            return $http({
                method : 'POST',
                url : '../../server/choice.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userNumber:usernum,contentID:contentid,choice:choice},
            }).then(handleSuccess, handleError('Error sending Choice'));

        }

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
