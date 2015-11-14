(function () {
    'use strict';

    angular
        .module('app')
        .controller('ChoiceController', ChoiceController);

    ChoiceController.$inject = ['RemoconService', '$rootScope' ,'FlashService'];
    function ChoiceController(RemoconService, $rootScope, FlashService) {
        var vm = this;

        vm.user = null;
        //vm.sendChoice = sendChoice;
        vm.sendChoice = sendChoice;

        function sendChoice(choice) {
            vm.dataLoading = true;
            RemoconService.SendChoice($rootScope.globals.currentUser.usernum,$rootScope.globals.currentUser.contentid,choice)
                .then(function (response) {
                    if (response.result) {
                        FlashService.Success("Datasend Success");
                        vm.dataLoading = false;
                    } else {
                        FlashService.Error(response.resultdesc);
                        vm.dataLoading = false;
                    }
                });
        }


    }

})();