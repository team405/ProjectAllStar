(function () {
    'use strict';

    angular
        .module('app')
        .controller('PlayerController', PlayerController);

    PlayerController.$inject = ['ContentService', '$rootScope'];
    function PlayerController(ContentService, $rootScope) {
        var ct = this;

	ct.contentid = $rootScope.globals.currentContent.contentid;
	ct.quesid = 0;
	ct.contents = [];

        initController();

        function initController() {
            //loadCurrentUser();
            //loadAllUsers();
	    loadContents();
        }

	function loadContents(){
	    ContentService.GetQuestion($rootScope.globals.currentUser.username, ct.contentid, ct.quesid)
		.then(function (response) {
		    if (response.result) {
			ct.contents = response;
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
