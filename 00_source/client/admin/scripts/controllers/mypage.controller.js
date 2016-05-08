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
        ct.addContents = addContents;
        ct.editContents = editContents;
        ct.playContents = playContents;
        ct.goAllrank = goAllrank;


        initController();

        function initController() {
            angular.element(window).off('keydown');
            loadContents();
        }

        function loadContents() {
            ContentService.GetByUserId($rootScope.globals.currentUser.username)
                .then(function (response) {
                    if (response.result) {
                        ct.contents = response.contents;
                    } else {
                        toastr.error(response.resultdesc)
                    }

                    
                });
        }
        function addContents(contentid) {
           $rootScope.globals["currentContent"] = {
                    contentid: contentid
                };

            $location.path('/ques_register');
        }
        function editContents(contentid) {
           $rootScope.globals["currentContent"] = {
                    contentid: contentid
                };

            $location.path('/ques_editor');
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



