﻿(function () {
    'use strict';

    angular
        .module('app')
        .controller('IntroController', IntroController);

    IntroController.$inject = ['ContentService', '$rootScope', '$interval','$timeout','$location'];
    function IntroController(ContentService, $rootScope, $interval, $timeout,  $location) {
        var ct = this;

	ct.contentid = $rootScope.globals.currentContent.contentid;
    ct.phase = 0;
    ct.mobileNames = [];
    ct.titlePicPath = "../../server/data/"+$rootScope.globals.currentUser.username+"/"+$rootScope.globals.currentContent.contentid+"/title.jpg"
    var interval

    ct.clickContainer=clickContainer;

        initController();

    function initController() {
        angular.element(window).off('keyup');
        angular.element(window).on('keyup', function(e) {
            handleKeyUp(e);
        });

        $timeout(function(){
            
            // $('#mobileUserList').scrollbox({
            //   linear: true,
            //   step: 1,
            //   delay: 0,
            //   speed: 150
            // });
            startCountTimer();
        });  

    }

 
    function startContent(){
        $interval.cancel(interval);
        $location.path('/player');
    }

        function clickContainer() {
            ct.phase++;//次の画面にする
            switch (ct.phase){
              case 1://タイトル画面
                break;
              case 2://促し画面
                startContent();

                break;
            }
        }
        function handleKeyUp(e) {//キーが押されたときに実行
                switch (e.which){
                    case 13:
                    clickContainer();
                    break;
                }
            console.log(e);
        }

    function startCountTimer(){

        interval = $interval(function() {
            ContentService.GetMobileUserList(ct.contentid)
            .then(function (response) {
                if (response.result) {
                    ct.mobileNames = response.user
                    
                } else {
                toastr.error(response.resultdesc)
                }
            });
        }, 5000);

    
    }
    $rootScope.$on('$routeChangeStart',function(){
        if(interval){
            $interval.cancel(interval);   
        }
        angular.element(window).off('keyup');
    });

    }


})();
