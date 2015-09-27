(function () {
    'use strict';

    angular
        .module('app')
        .controller('AllrankController', AllrankController);

    AllrankController.$inject = ['ContentService', '$rootScope', '$interval','FlashService','$location'];
    function AllrankController(ContentService, $rootScope, $interval, FlashService, $location) {
        var ct = this;

	ct.contentid = $rootScope.globals.currentContent.contentid;
    ct.ranks = [];


        initController();

        function initController() {
            //loadCurrentUser();
            //loadAllUsers();
	    getAllRanking();
        }

    function getAllRanking(){
        ContentService.GetAllRanking($rootScope.globals.currentUser.username, ct.contentid)
		.then(function (response) {
		    if (response.result) {
                ct.ranks = response.allrank;
		    } else {
			FlashService.Error(response.resultdesc);
		    }
		});

    }

    }



})();
