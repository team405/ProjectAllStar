(function () {
    'use strict';

    angular
        .module('app')
        .controller('QuesRegisterController', QuesRegisterController);

    QuesRegisterController.$inject = ['ContentService','UserService', '$location', '$rootScope', 'FlashService'];
    function QuesRegisterController(ContentService, UserService, $location, $rootScope, FlashService) {
        var ct = this;

        (function initController() {
            // reset login status
        })();


        ct.result = null;
        ct.errorMsg = "";
        ct.demo = false;
        ct.preText = "";
        ct.prePic = null;
        ct.preIntro = null;
        ct.preMovie = null;
        ct.quesText = "";
        ct.preKind = "text";
        ct.choiceKind = "text";
        ct.choiceText1 = "";
        ct.choiceText2 = "";
        ct.choiceText3 = "";
        ct.choiceText4 = "";
        ct.ansText1 = "";
        ct.ansText2 = "";
        ct.ansText3 = "";
        ct.ansText4 = "";
        ct.choicePic1 = null;
        ct.choicePic2 = null;
        ct.choicePic3 = null;
        ct.choicePic4 = null;
        ct.correctNum = 1;
        ct.quesSec = 10;
        ct.uploadQuestion = uploadQuestion;

        function uploadQuestion(prePic,preIntro,preMovie,choicePic1,choicePic2,choicePic3,choicePic4) {
            ContentService.UploadQuestion((ct.demo?1:0), ct.preKind,ct.preText,prePic,preIntro,preMovie,ct.quesText,ct.choiceKind,ct.choiceText1,ct.choiceText2,ct.choiceText3,ct.choiceText4,ct.quesSec,choicePic1,choicePic2,choicePic3,choicePic4,ct.ansText1,ct.ansText2,ct.ansText3,ct.ansText4,(ct.correctNum-1),$rootScope.globals.currentContent.contentid, $rootScope.globals.currentUser.username, $rootScope.globals.currentUser.password)
            .then(function (response) {
                if (response.result) {
                	ct.result = true;
                    initializeForm();
                } else {
                FlashService.Error(response.resultdesc);
                }
            });
            
        };


        function initializeForm(){
        	ct.result = "";
        	ct.errorMsg = "";
        	ct.demo = false;
        	ct.preText = "";
        	ct.prePic = null;
        	ct.preIntro = null;
        	ct.preMovie = null;
        	ct.quesText = "";
        	ct.preKind = "text";
        	ct.choiceKind = "text";
        	ct.choiceText1 = "";
        	ct.choiceText2 = "";
        	ct.choiceText3 = "";
        	ct.choiceText4 = "";
        	ct.ansText1 = "";
        	ct.ansText2 = "";
        	ct.ansText3 = "";
        	ct.ansText4 = "";
        	ct.choicePic1 = null;
        	ct.choicePic2 = null;
        	ct.choicePic3 = null;
        	ct.choicePic4 = null;
        	ct.correctNum = 1;
        	ct.quesSec = 10;
        	//prePic=preIntro=preMovie=choicePic1=choicePic2=choicePic3=choicePic4=null;
        }

    }

})();
