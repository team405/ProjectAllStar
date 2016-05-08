(function () {
    'use strict';

    angular
        .module('app')
        .controller('AllrankController', AllrankController);

    AllrankController.$inject = ['ContentService', '$rootScope', '$timeout','$location'];
    function AllrankController(ContentService, $rootScope, $timeout,  $location) {
        var ct = this;

	ct.contentid = $rootScope.globals.currentContent.contentid;
    var allranksdata = [];
    ct.allranks = [];
    ct.clickContainer=clickContainer;
    ct.backbutton = false;
    ct.showendtitle = true;

        initController();

        function initController() {
            angular.element(window).off('keyup');
            angular.element(window).on('keyup', function(e) {
                    handleKeyUp(e);
                });
    	    getAllRanking();
            $("#allrankbgm")[0].volume = 0;
            $("#allrankbgm").animate({volume: 0.5},10000);
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
			toastr.error(response.resultdesc)
		    }
		});

    }
    function clickContainer() {
        //Object.keys(JSONオブジェクト).length
        ct.showendtitle=false;
        if(allranksdata.length > 0){

            var drumAudio1 = document.getElementById("drumroll1");
            var drumAudio2 = document.getElementById("drumroll2");
            var drumAudio3 = document.getElementById("drumroll3");

            switch (allranksdata.length){
                case 3://3位
                    // drumAudio.reset();
                    drumAudio3.play();
                    $timeout(function(){
                        ct.allranks.unshift(allranksdata.pop())
                        $rootScope.$apply()
                    },1900);
                break;
                case 2:
                    // drumAudio.reset();
                    drumAudio2.play();
                    $timeout(function(){
                        ct.allranks.unshift(allranksdata.pop())
                        $rootScope.$apply()
                    },3000);
                break;
                case 1://1位
                    // drumAudio.reset();
                    drumAudio1.play();
                    $timeout(function(){
                        ct.allranks.unshift(allranksdata.pop())
                        $rootScope.$apply()
                    },5600);
                    ct.backbutton =true;
                break;
                default:
                    //届いた配列の一番最後尾を取り出し、表示の一番上に設置
                    ct.allranks.unshift(allranksdata.pop())
                    $rootScope.$apply()
                
            }
        }

    }

    function handleKeyUp(e) {//キーが押されたときに実行
        switch (e.which){//数字キーの1から4のとき
            case 13:
            clickContainer();
            break;
        }
    }




}



})();
