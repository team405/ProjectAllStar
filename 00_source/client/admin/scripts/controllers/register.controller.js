(function () {
    'use strict';

    angular
        .module('app')
        .controller('RegisterController', RegisterController);

    RegisterController.$inject = ['UserService', '$location', '$rootScope'];
    function RegisterController(UserService, $location, $rootScope) {
        var vm = this;

        vm.register = register;

        function register() {
            vm.dataLoading = true;
            UserService.Create(vm.user)
                .then(function (response) {
                    if (response.result) {
                        toastr.info(response.resultdesc)
                        $location.path('/login');
                    } else {
                        toastr.error(response.resultdesc)
                        vm.dataLoading = false;
                    }
                });
        }
    }

})();
