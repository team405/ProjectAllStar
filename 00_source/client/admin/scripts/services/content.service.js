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
        service.GetQuestionList = GetQuestionList;
        service.UploadContent = UploadContent;
        service.UploadQuestion = UploadQuestion;

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
            }).then(handleSuccess, handleError('Error getting UserList'));
        }
        function GetQuestionList(contentid,userID) {
            return $http({
                method : 'POST',
                url : '../../'+dir+'/viewques.php',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                data: {contentID:contentid,userID: userID},
            }).then(handleSuccess, handleError('Error getting quesList'));
        }

        function UploadContent(titlePic,contentName,userID){
            return Upload.upload({
                url: '../../'+dir+'/content_create.php',
                data: {titlePic: titlePic, contentName: contentName,userID: userID}
            }).then(handleSuccess, handleError('Error Upload')
            , function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                console.log('progress: ' + progressPercentage + '% ');
                //ct.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }

        function UploadQuestion(demo,preKind,preText,prePic,preIntro,preMovie,quesText,choiceKind,choiceText1,choiceText2,choiceText3,choiceText4,quesSec,choicePic1,choicePic2,choicePic3,choicePic4,ansText1,ansText2,ansText3,ansText4,correctNum,contentid,quesid,username,password){
            var sendObj = {demo:demo, preKind: preKind, preText: preText, quesText: quesText, choiceKind: choiceKind, quesSec: quesSec, ansText1: ansText1, ansText2: ansText2, ansText3: ansText3, ansText4: ansText4,correctNum: correctNum,contentID: contentid,userID: username,password: password}
            if(quesid){
                sendObj.quesID = quesid;
            }

            switch(preKind){
                case "text":
                break;
                case "picture":
                if(prePic){
                    sendObj.prePic = prePic;
                }
                break;
                case "intro":
                if(preIntro){
                    sendObj.preIntro = preIntro;            
                }
                break;
                case "movie":
                if(preMovie){
                    sendObj.preMovie = preMovie;
                }
                break;
            }
            switch(choiceKind){
                case "text":
                sendObj.choiceText1 = choiceText1;
                sendObj.choiceText2 = choiceText2;
                sendObj.choiceText3 = choiceText3;
                sendObj.choiceText4 = choiceText4;
                break;
                case "picture":
                if(choicePic1){
                    sendObj.choicePic1 = choicePic1;
                }
                if(choicePic2){
                    sendObj.choicePic2 = choicePic2;
                }
                if(choicePic3){
                    sendObj.choicePic3 = choicePic3;
                }
                if(choicePic4){
                    sendObj.choicePic4 = choicePic4;
                }
                break;
            }
            return Upload.upload({
                url: '../../'+dir+'/ques_create.php',
                data: sendObj
            }).then(handleSuccess, handleError('Error Upload')
            , function (evt) {
                var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                console.log('progress: ' + progressPercentage + '% ' );
                //ct.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
            });
        }

        //preKind,preText,prePic,preIntro,preMovie,quesText,choiceKind,choiceKind,choiceText1,choiceText2,choiceText3,choiceText4,quesSec,choicePic1,choicePic2,choicePic3,choicePic4,ansText1,ansText2,ansText3,ansText4,correctNum,$rootScope.globals.currentContent.contentid, $rootScope.globals.currentUser.username, $rootScope.globals.currentUser.password



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
