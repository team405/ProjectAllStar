(function () {
    'use strict';

    angular
        .module('app')
        .controller('ChoiceController', ChoiceController);

    ChoiceController.$inject = ['RemoconService', '$rootScope'];
    function ChoiceController(RemoconService, $rootScope) {
        var vm = this;

        vm.user = null;
        //vm.sendChoice = sendChoice;
        vm.sendChoice = sendChoice;

        function sendChoice(choice) {
            vm.dataLoading = true;
            RemoconService.SendChoice($rootScope.globals.currentUser.usernum,choice)
                .then(function (response) {
                    if (response.result) {
                        FlashService.Success("Datasend Success");
                    } else {
                        FlashService.Error(response.resultdesc);
                        vm.dataLoading = false;
                    }
                });
        }


    }

})();