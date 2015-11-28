(function () {
    'use strict';

    angular
        .module('app')
        .controller('PlayerController', PlayerController);

    PlayerController.$inject = ['ContentService', '$rootScope', '$interval','FlashService','$location'];
    function PlayerController(ContentService, $rootScope, $interval, FlashService, $location) {
        var ct = this;

	ct.contentid = $rootScope.globals.currentContent.contentid;
	//サーバに問い合わせる際のカウンタ。
    ct.quesid = 0;
    //でも用のカウンタ。
    ct.quesdemoid =0;
	ct.contents = null;
    ct.phase=0;
    ct.anssum = [];
    ct.quesSec = 0;
    var ranksdata = [];
    ct.ranks = [];
    ct.correctChoice = null;
    //前説が0、質問中が1、答え表示中が2

    ct.prePath="";
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

        angular.element(window).off('keyup');
        angular.element(window).on('keyup', function(e) {
                handleKeyUp(e);
            });
        }

    function loadQuestion(){
        ct.prePath=ct.choicePicPath0=ct.choicePicPath1=ct.choicePicPath2=ct.choicePicPath3=""
        ct.correctChoice = null;
        ContentService.GetQuestion($rootScope.globals.currentUser.username, ct.contentid, ct.quesid)
        .then(function (response) {
            if (response.result) {
            ct.contents = response;
            ct.quesSec = response.quesSec;
            ct.contents.demo = Number(ct.contents.demo);
                if(ct.contents.demo){
                    ct.quesdemoid++;
                }
                if(response.preKind == "picture"){
                    ct.prePath="../../server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/pre.jpg";
                }else if(response.preKind == "intro"){
                    ct.prePath="../../server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/intro.mp3";
                }else if(response.preKind == "movie"){
                    ct.prePath="../../server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/intro.mp4";
                }

                if(response.choiceKind == "picture"){
                    ct.choicePicPath0="../../server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/choicePic0.jpg";
                    ct.choicePicPath1="../../server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/choicePic1.jpg";
                    ct.choicePicPath2="../../server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/choicePic2.jpg";
                    ct.choicePicPath3="../../server/data/"+$rootScope.globals.currentUser.username+"/"+ct.contentid+"/"+ct.quesid+"/choicePic3.jpg";
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
	function getAnswer(newAnswer){
        ContentService.GetAnswer($rootScope.globals.currentUser.username, ct.contentid, ct.quesid, newAnswer)
        .then(function (response) {
            if (response.result) {
                ct.anssum = response.ansSum;
                ct.correctChoice = ct.contents.correctNumber;
                console.log(ct.correctChoice)
            } else {
            FlashService.Error(response.resultdesc);
            }
        });
    }
    function getRanking(){
        ct.ranks = [];
        ContentService.GetRanking($rootScope.globals.currentUser.username, ct.contentid, ct.quesid)
		.then(function (response) {
		    if (response.result) {
                ranksdata = response.rank;
                for (var i = 0; i < ranksdata.length; i++) {
                    ranksdata[i].ranknum = i+1;
                };

                var interval = $interval(function() {
                    if(ranksdata.length > 0){
                        ct.ranks.unshift(ranksdata.pop())
                        $rootScope.$apply()
                    }else{                    
                        $interval.cancel(interval);
                    }
                }, 300);

		    } else {
			FlashService.Error(response.resultdesc);
		    }
		});

    }


        function clickContainer() {
            ct.phase++;//次の画面にする
            switch (ct.phase){
              case 1://問題画面
                startQuestion();
                startCountTimer();
                break;
              case 2://解答画面
                getAnswer();

                break;
              case 3://前説画面。ランキング画面が実装されたらここはランキング画面
                getRanking();

                break;
                case 4://前説画面
                ct.quesid++;
                ct.phase = 0;
                    if(ct.quesid < $rootScope.globals.currentContent.quesSum){
                        loadQuestion();
                    
                    }else{
                        $location.path('/allrank');
                    }
                break;
            }
        }
        function handleKeyUp(e) {//キーが押されたときに実行
            switch (ct.phase){//画面で分岐させる。
              case 0://前説画面
                switch (e.which){//数字キーの1から4のとき
                    case 32:
                    clickContainer();
                    break;
                }
                break;
              case 1://問題画面
                switch (e.which){//数字キーの1から4のとき
                    case 32:
                    clickContainer();
                    break;
                    case 49:
                    case 50:
                    case 51:
                    case 52:
                    ct.phase++
                    var newAnswer = Number(e.which) - 49
                    ct.contents.correctNumber= newAnswer
                    getAnswer(newAnswer);
                    break;
                }
                break;
              case 2://回答画面
                switch (e.which){//数字キーの1から4のとき
                    case 32:
                    clickContainer();
                    break;
                }
                break;
              case 3://ランキング画面
                switch (e.which){//数字キーの1から4のとき
                    case 32:
                    clickContainer();
                    break;
                }
                break;
            }
            console.log(e);
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

        $rootScope.$on('$routeChangeStart',function(){
            angular.element(window).off('keyup');
        });

    }



})();
