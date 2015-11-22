﻿(function () {
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

    var dir="server";



    ContentService.$inject = ['$http','Upload'];
    function ContentService($http, Upload) {
        var service = {};

        service.GetByUserId = GetByUserId;
        service.GetQuestion = GetQuestion;
        service.StartQuestion = StartQuestion;
        service.GetAnswer = GetAnswer;
        service.GetRanking = GetRanking;
        service.GetAllRanking = GetAllRanking;
        service.GetMobileUserList = GetMobileUserList;
        service.UploadContent = UploadContent;

        return service;

        function GetByUserId(userid) {
            return $http({
                method : 'POST',
                url : '../../'+dir+'/mypage.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid},
            }).then(handleSuccess, handleError('Error getting Content'));

        }

        function GetQuestion(userid,contentid,quesid) {
            return $http({
                method : 'POST',
                url : '../../'+dir+'/ques.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid,contentID:contentid,quesID:quesid},
            }).then(handleSuccess, handleError('Error getting Content'));

        }
        function StartQuestion(userid,contentid,quesid) {
            return $http({
                method : 'POST',
                url : '../../'+dir+'/start.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid,contentID:contentid,quesID:quesid},
            }).then(handleSuccess, handleError('Error getting Content'));

        }
        function GetAnswer(userid,contentid,quesid,newAnswer) {
            var data = {userID:userid,contentID:contentid,quesID:quesid}
            
            if(newAnswer != null){
                data["newAnswer"] = newAnswer;
            }
            return $http({
                method : 'POST',
                url : '../../'+dir+'/ans.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: data,
            }).then(handleSuccess, handleError('Error getting Content'));

        }
        function GetRanking(userid,contentid,quesid) {
            return $http({
                method : 'POST',
                url : '../../'+dir+'/rank.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid,contentID:contentid,quesID:quesid},
            }).then(handleSuccess, handleError('Error getting Rank'));

        }
        function GetAllRanking(userid,contentid) {
            return $http({
                method : 'POST',
                url : '../../'+dir+'/allrank.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {userID:userid,contentID:contentid},
            }).then(handleSuccess, handleError('Error getting Allrank'));

        }

        function GetMobileUserList(contentid) {
            return $http({
                method : 'POST',
                url : '../../'+dir+'/viewuser.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {contentID:contentid},
            }).then(handleSuccess, handleError('Error getting Allrank'));
        }

        function UploadContent(titlePic,contentName,adminID){
            Upload.upload({
                url: '../../'+dir+'/content_create.php',
                data: {titlePic: titlePic, contentName: contentName,adminID: adminID}
            }).then(function (resp) {
                console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.data);
                ct.result = resp.data;
            }, function (resp) {
                console.log('Error status: ' + resp.status);
                if (resp.status > 0){
                  ct.errorMsg = resp.status + ': ' + resp.data;
                }
            }, function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
                ct.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
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
