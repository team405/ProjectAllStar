(function () {
    'use strict';

    angular
        .module('app')
        .controller('QuesEditorController', QuesEditorController);

    QuesEditorController.$inject = ['ContentService','UserService', '$location', '$rootScope'];
    function QuesEditorController(ContentService, UserService, $location, $rootScope) {
        var ct = this;

        (function initController() {
            getQuestionList();
        })();

        ct.errorMsg = "";
        ct.ques = null;
        ct.choiceques = 0;

        // ct.demo = false;
        // ct.preText = "";
        // ct.prePic = null;
        // ct.preIntro = null;
        // ct.preMovie = null;
        // ct.quesText = "";
        // ct.preKind = "text";
        // ct.choiceKind = "text";
        // ct.choiceText1 = "";
        // ct.choiceText2 = "";
        // ct.choiceText3 = "";
        // ct.choiceText4 = "";
        // ct.ansText1 = "";
        // ct.ansText2 = "";
        // ct.ansText3 = "";
        // ct.ansText4 = "";
        // ct.choicePic1 = null;
        // ct.choicePic2 = null;
        // ct.choicePic3 = null;
        // ct.choicePic4 = null;
        // ct.correctNum = 1;
        // ct.quesSec = 10;
        //ct.getQuestionList = getQuestionList;
        ct.changeQues = changeQues;
        ct.uploadQuestion = uploadQuestion;

        function getQuestionList() {
            ContentService.GetQuestionList($rootScope.globals.currentContent.contentid, $rootScope.globals.currentUser.username)
            .then(function (response) {
                if (response.result) {
                	//ct.result = true;
                    ct.ques = response.ques;
                    initializeForm();
                    //angular.copy(ct.ques[ct.choiceques],ct.choiceques)
                } else {
                toastr.error(response.resultdesc)
                }
            });
            
        };
        function initializeForm(){
            console.log("test")
            ct.demo = (ct.ques[ct.choiceques].demo==1?true:false);
            ct.preText = ct.ques[ct.choiceques].preText;
            ct.prePicPath = "../../server/data/"+$rootScope.globals.currentUser.username+"/"+$rootScope.globals.currentContent.contentid+"/"+ct.choiceques+"/pre.jpg?rnd="+ Math.floor( Math.random() * 1000000 );
            ct.prePic = null;
            ct.preIntro = null;
            ct.preMovie = null;
            ct.quesText = ct.ques[ct.choiceques].quesText;
            ct.preKind = ct.ques[ct.choiceques].preKind;
            ct.choiceKind = ct.ques[ct.choiceques].choiceKind;
            ct.choiceText1 = ct.ques[ct.choiceques].choiceText[0];
            ct.choiceText2 = ct.ques[ct.choiceques].choiceText[1];
            ct.choiceText3 = ct.ques[ct.choiceques].choiceText[2];
            ct.choiceText4 = ct.ques[ct.choiceques].choiceText[3];
            ct.ansText1 = ct.ques[ct.choiceques].ansText[0];
            ct.ansText2 = ct.ques[ct.choiceques].ansText[1];
            ct.ansText3 = ct.ques[ct.choiceques].ansText[2];
            ct.ansText4 = ct.ques[ct.choiceques].ansText[3];
            ct.choicePic1Path = "../../server/data/"+$rootScope.globals.currentUser.username+"/"+$rootScope.globals.currentContent.contentid+"/"+ct.choiceques+"/choicePic0.jpg?rnd="+ Math.floor( Math.random() * 1000000 );
            ct.choicePic1 = null;
            ct.choicePic2Path = "../../server/data/"+$rootScope.globals.currentUser.username+"/"+$rootScope.globals.currentContent.contentid+"/"+ct.choiceques+"/choicePic1.jpg?rnd="+ Math.floor( Math.random() * 1000000 );
            ct.choicePic2 = null;
            ct.choicePic3Path = "../../server/data/"+$rootScope.globals.currentUser.username+"/"+$rootScope.globals.currentContent.contentid+"/"+ct.choiceques+"/choicePic2.jpg?rnd="+ Math.floor( Math.random() * 1000000 );
            ct.choicePic3 = null;
            ct.choicePic4Path = "../../server/data/"+$rootScope.globals.currentUser.username+"/"+$rootScope.globals.currentContent.contentid+"/"+ct.choiceques+"/choicePic3.jpg?rnd="+ Math.floor( Math.random() * 1000000 );
            ct.choicePic4 = null;
            ct.correctNum = ct.ques[ct.choiceques].correctNum+1;
            ct.quesSec = ct.ques[ct.choiceques].quesSec;
            //prePic=preIntro=preMovie=choicePic1=choicePic2=choicePic3=choicePic4=null;
        }

        function uploadQuestion(prePic,preIntro,preMovie,choicePic1,choicePic2,choicePic3,choicePic4) {
            ct.dataLoading = true;
            ContentService.UploadQuestion((ct.demo?1:0), ct.preKind,ct.preText,prePic,ct.preIntro,ct.preMovie,ct.quesText,ct.choiceKind,ct.choiceText1,ct.choiceText2,ct.choiceText3,ct.choiceText4,ct.quesSec,choicePic1,choicePic2,choicePic3,choicePic4,ct.ansText1,ct.ansText2,ct.ansText3,ct.ansText4,(ct.correctNum-1),$rootScope.globals.currentContent.contentid, ct.choiceques,$rootScope.globals.currentUser.username, $rootScope.globals.currentUser.password)
            .then(function (response) {
                ct.dataLoading = false;
                if (response.result) {
                    toastr.info(response.resultdesc);
                } else {
                    toastr.error(response.resultdesc);
                }
            });
            
        };

        function changeQues(){
            initializeForm();
        }

    }

})();
