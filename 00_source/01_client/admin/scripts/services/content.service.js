(function () {
    'use strict';

    angular
        .module('app')
        .factory('ContentService', ContentService);

    angular.module('app').config(function ($httpProvider) {
        $httpProvider.defaults.transformRequest = function(data){
            if (data === undefined) {
                return data;
            }
            return $.param(data);
        }
    });



    ContentService.$inject = ['$http'];
    function ContentService($http) {
        var service = {};

        service.GetByUserId = GetByUserId;
        service.GetQuestion = GetQuestion;

        return service;

        function GetByUserId(userid) {
            return $http({
                method : 'POST',
                url : '../../02_server/mypage.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid},
            }).then(handleSuccess, handleError('Error getting Content'));

        }

        function GetQuestion(userid,contentid,quesid) {
            return $http({
                method : 'POST',
                url : '../../02_server/ques.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid,contentID:contentid,quesID:quesid},
            }).then(handleSuccess, handleError('Error getting Content'));

        }
        function StartQuestion(userid,contentid,quesid) {
            return $http({
                method : 'POST',
                url : '../../02_server/start.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid,contentID:contentid,quesID:quesid},
            }).then(handleSuccess, handleError('Error getting Content'));

        }
        function GetAnswer(userid,contentid,quesid) {
            return $http({
                method : 'POST',
                url : '../../02_server/ans.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid,contentID:contentid,quesID:quesid},
            }).then(handleSuccess, handleError('Error getting Content'));

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
