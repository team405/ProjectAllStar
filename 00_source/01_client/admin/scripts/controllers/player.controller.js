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
    ct.pre=0;
    //前説が0、質問中が1、答え表示中が2
    ct.clickContainer=clickContainer;

        initController();

        function initController() {
            //loadCurrentUser();
            //loadAllUsers();
	    loadContents();
        }

	function loadContents(){
	    ContentService.GetQuestion($rootScope.globals.currentUser.username, ct.contents_id, ct.ques_id)
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

        function clickContainer() {
            if(ct.pre){
                ct.pre=false;
            }else{
                ct.pre=true;
            }
        }

    }



})();
