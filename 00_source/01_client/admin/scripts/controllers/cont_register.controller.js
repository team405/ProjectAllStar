(function () {
    'use strict';

    angular
        .module('app')
        .controller('ContRegisterController', ContRegisterController);

    ContRegisterController.$inject = ['UserService', '$location', '$rootScope', 'FlashService'];
    function ContRegisterController(UserService, $location, $rootScope, FlashService) {
        var vm = this;

        vm.register = register;
    }

})();
