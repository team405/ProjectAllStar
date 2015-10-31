(function () {
    'use strict';

    angular
        .module('app')
        .controller('LoginController', LoginController);

    LoginController.$inject = ['$location', 'AuthenticationService', 'FlashService'];
    function LoginController($location, AuthenticationService, FlashService) {
        var vm = this;

        vm.login = login;

        (function initController() {
            AuthenticationService.ClearCredentials();
        })();

        function login() {
            vm.dataLoading = true;
            AuthenticationService.Login(vm.username, vm.password, vm.contentid, function (response) {
                if (response.result) {
                    AuthenticationService.SetCredentials(response.userNumber, vm.username, vm.password, vm.contentid);
                    $location.path('/');
                } else {
                    FlashService.Error(response.resultdesc);
                    vm.dataLoading = false;
                }
            });
        };
    }

})();
