(function () {
    'use strict';

    angular
        .module('app')
        .controller('MypageController', MypageController);

    MypageController.$inject = ['$location','ContentService', '$rootScope'];
    function MypageController($location, ContentService, $rootScope) {
        var ct = this;

        //ユーザのすべてのコンテンツ
        ct.contents = [];
        ct.playContents = playContents;


        initController();

        function initController() {
            loadContents();
        }

        function loadContents() {
            ContentService.GetByUserId($rootScope.globals.currentUser.username)
                .then(function (response) {
                    if (response.result) {
                        ct.contents = response.contents;
                    } else {
                        FlashService.Error(response.resultdesc);
                    }

                    
                });
        }
        function playContents(contentid) {
            console.log(contentid);
            $rootScope.globals["currentContent"] = {
                    contentid: contentid,
                    quesSum: quesSum
                };
                console.log($rootScope.globals);


            $location.path('/player');
        }

    }

})();
