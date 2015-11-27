(function () {
    'use strict';

    angular
        .module('app')
        .controller('MypageController', MypageController);

    MypageController.$inject = ['$location','ContentService', '$rootScope','FlashService'];
    function MypageController($location, ContentService, $rootScope,FlashService) {
        var ct = this;

        //ユーザのすべてのコンテンツ
        ct.contents = [];
        ct.editContents = editContents;
        ct.playContents = playContents;
        ct.goAllrank = goAllrank;


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
        function editContents(contentid) {
           $rootScope.globals["currentContent"] = {
                    contentid: contentid
                };

            $location.path('/ques_register');
        }
        function playContents(contentid) {
           $rootScope.globals["currentContent"] = {
                    contentid: contentid,
                    quesSum: (ct.contents.filter(function(item, index){if (item.contentID == String(contentid)) return true;})[0].quesSum)
                };

            $location.path('/intro');
        }
        function goAllrank(contentid) {
           $rootScope.globals["currentContent"] = {
                    contentid: contentid
                };

            $location.path('/allrank');
        }

    }

})();



