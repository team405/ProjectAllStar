(function () {
    'use strict';

    angular
        .module('app')
        .controller('AllrankController', AllrankController);

    AllrankController.$inject = ['ContentService', '$rootScope', '$interval','FlashService','$location'];
    function AllrankController(ContentService, $rootScope, $interval, FlashService, $location) {
        var ct = this;

	ct.contentid = $rootScope.globals.currentContent.contentid;
    var allranksdata = [];
    ct.allranks = [];
    ct.clickContainer=clickContainer;


        initController();

        function initController() {
            angular.element(window).off('keyup');
            angular.element(window).on('keyup', function(e) {
                    handleKeyUp(e);
                });
    	    getAllRanking();
        }

    function getAllRanking(){
        ContentService.GetAllRanking($rootScope.globals.currentUser.username, ct.contentid)
		.then(function (response) {
		    if (response.result) {
                allranksdata = response.allrank;
                for (var i = 0; i < allranksdata.length; i++) {
                    allranksdata[i].ranknum = i+1;
                };
		    } else {
			FlashService.Error(response.resultdesc);
		    }
		});

    }
    function clickContainer() {
        //Object.keys(JSONオブジェクト).length
        console.log("length"+allranksdata.length)
        console.log("length"+ct.allranks.length)
        if(allranksdata.length > 0){
            //届いた配列の一番最後尾を取り出し、表示の一番上に設置
            ct.allranks.unshift(allranksdata.pop())
            $rootScope.$apply()
            if(allranksdata.length == 0){
                //ランキング最後まで行った後の処理
            }
        }

    }

    function handleKeyUp(e) {//キーが押されたときに実行
        switch (e.which){//数字キーの1から4のとき
            case 32:
            clickContainer();
            break;
        }
    }




}



})();
