﻿(function () {
    'use strict';

    angular
        .module('app')
        .controller('RegisterController', RegisterController);

    RegisterController.$inject = ['UserService', '$location', '$rootScope', 'FlashService'];
    function RegisterController(UserService, $location, $rootScope, FlashService) {
        var vm = this;

        vm.register = register;

        function register() {
            vm.dataLoading = true;
            UserService.Create(vm.user)
                .then(function (response) {
                    if (response.result) {
                        FlashService.Success('Registration successful', true);
                        $location.path('/login');
                    } else {
                        FlashService.Error(response.resultDesc);
                        vm.dataLoading = false;
                    }
                });
        }
    }

})();