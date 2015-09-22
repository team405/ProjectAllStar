(function () {
    'use strict';

    angular
        .module('app')
        .controller('PlayerController', PlayerController);

    PlayerController.$inject = ['ContentService', '$rootScope'];
    function PlayerController(ContentService, $rootScope) {
        var ct = this;

	ct.contents_id = 0;
	ct.ques_id = 0;
	ct.contents = [];

        initController();

        function initController() {
            //loadCurrentUser();
            //loadAllUsers();
        }

	function loadContents(){
	    ContentService.GetQuestion($rootScope.globals.currentUser.username, ct.contents_id, ct.ques_id)
		.then(function (response) {
		    if (response.result) {
			ct.contents = response.contents;
		    } else {
			FlashService.Error(response.resultdesc);
		    }
		});
	}

        function loadCurrentUser() {
            UserService.GetByUsername($rootScope.globals.currentUser.username)
                .then(function (user) {
                    vm.user = user;
                });
        }
    }

})();
