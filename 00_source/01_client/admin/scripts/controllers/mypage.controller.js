(function () {
    'use strict';

    angular
        .module('app')
        .controller('MypageController', MypageController);

    MypageController.$inject = ['ContentService', '$rootScope'];
    function MypageController(ContentService, $rootScope) {
        var ct = this;

        //現在のコンテンツ
        //ct.content = null;

        //ユーザのすべてのコンテンツ
        ct.contents = [];
        ct.test = null;

        initController();

        function initController() {
            loadContents();
        }

        function loadContents() {
            ContentService.GetByUserId($rootScope.globals.currentUser.username)
                .then(function (response) {
                    console.log(response.contents)
                    if (response.result) {
                        ct.contents = response.contents;
                    } else {
                        FlashService.Error(response.resultdesc);
                    }

                    
                });
        }
    }

})();