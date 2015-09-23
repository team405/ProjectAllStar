(function () {
    'use strict';

    angular
        .module('app')
        .controller('PlayerController', PlayerController);

    PlayerController.$inject = ['ContentService', '$rootScope', '$interval','FlashService'];
    function PlayerController(ContentService, $rootScope, $interval, FlashService) {
        var ct = this;

	ct.contentid = $rootScope.globals.currentContent.contentid;
	ct.quesid = 0;
	ct.contents = null;
    ct.pre=0;
    ct.anssum = [];
    ct.quesSec = 0;
    //前説が0、質問中が1、答え表示中が2

    ct.prePicPath="";
    ct.choicePicPath0="";
    ct.choicePicPath1="";
    ct.choicePicPath2="";
    ct.choicePicPath3="";

    ct.clickContainer=clickContainer;

        initController();

        function initController() {
            //loadCurrentUser();
            //loadAllUsers();
	    loadQuestion();
        }

    function loadQuestion(){
        ct.prePicPath=ct.choicePicPath0=ct.choicePicPath1=ct.choicePicPath2=ct.choicePicPath3=""
        ContentService.GetQuestion($rootScope.globals.currentUser.username, ct.contentid, ct.quesid)
        .then(function (response) {
            if (response.result) {
            ct.contents = response;
            ct.quesSec = response.quesSec;
                if(response.preKind == "picture"){
                    ct.prePicPath="../../02_server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/pre.jpg";
                }
                if(response.choiceKind == "picture"){
                    ct.choicePicPath0="../../02_server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/choicePic0.jpg";
                    ct.choicePicPath1="../../02_server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/choicePic1.jpg";
                    ct.choicePicPath2="../../02_server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/choicePic2.jpg";
                    ct.choicePicPath3="../../02_server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/choicePic3.jpg";
                }



            } else {
            FlashService.Error(response.resultdesc);
            }
        });
    }
    function startQuestion(){
        ContentService.StartQuestion($rootScope.globals.currentUser.username, ct.contentid, ct.quesid)
        .then(function (response) {
            if (response.result) {

            } else {
            FlashService.Error(response.resultdesc);
            }
        });
    }
	function getAnswer(){
	    ContentService.GetAnswer($rootScope.globals.currentUser.username, ct.contentid, ct.quesid)
		.then(function (response) {
		    if (response.result) {
                ct.anssum = response.ansSum;
		    } else {
			FlashService.Error(response.resultdesc);
		    }
		});
	}


        function clickContainer() {
            ct.pre++;
            switch (ct.pre){
              case 1://問題画面
                startQuestion();
                startCountTimer();
                break;
              case 2://解答画面
                getAnswer();

                break;
              case 3://前説画面。ランキング画面が実装されたらここはランキング画面
                ct.quesid++;
                ct.pre = 0;
                    if(ct.quesid < $rootScope.globals.currentContent.quesSum){
                        loadQuestion;
                    
                    }else{
                        $location.path('/mypage');
                    }
                break;
                case 4://前説画面
                break;
            }
        }

        function startCountTimer(){


            var interval = $interval(function() {
                if (ct.quesSec < 1){
                    $interval.cancel(interval);
                }else{
                    ct.quesSec--;
                }
            }, 1000);

        
        }

    }



})();
