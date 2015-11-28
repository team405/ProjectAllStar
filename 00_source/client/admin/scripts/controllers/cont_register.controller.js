(function () {
    'use strict';

    angular
        .module('app')
        .controller('ContRegisterController', ContRegisterController);

    ContRegisterController.$inject = ['ContentService','UserService', '$location', '$rootScope', 'FlashService'];
    function ContRegisterController(ContentService, UserService, $location, $rootScope, FlashService) {
        var ct = this;

        // ct.login = login;
        // ct.register = register;
        // ct.addNewFile = addNewFile;

        (function initController() {
            // reset login status
        })();

        function login() {
            ct.dataLoading = true;
        };

//        ct.progress = "";
        ct.result= null;
        ct.errorMsg = "";
        ct.contentname = "";
        ct.picFile = null;
        ct.uploadPic = uploadPic;

        function uploadPic(titlePic) {
            ContentService.UploadContent(titlePic, ct.contentname, $rootScope.globals.currentUser.username)
                .then(function (response) {
                    if (response.result) {
                        $location.path('/');
                    } else {
                        FlashService.Error(response.resultdesc);
                    }
                });
            
        };

    }

})();
