(function () {
    'use strict';

    angular
        .module('app')
        .factory('ContentService', ContentService);

    ContentService.$inject = ['$http'];
    function ContentService($http) {
        var service = {};

        service.GetAll = GetAll;
        service.GetByUserId = GetByUserId;
        service.GetByContentname = GetByContentname;
        service.Create = Create;
        service.Update = Update;
        service.Delete = Delete;

        return service;

        function GetAll() {
            return $http.get('/api/Contents').then(handleSuccess, handleError('Error getting all Contents'));
        }

        function GetByUserId(userid) {
            return $http.get('/api/Contents/' + userid).then(handleSuccess, handleError('Error getting Content by id'));
        }

        function GetByContentname(contentname) {
            return $http.get('/api/Contents/' + contentname).then(handleSuccess, handleError('Error getting Content by Contentname'));
        }

        function Create(content) {
            return $.ajax({
              type: 'POST',
              url: "http://192.168.0.10:8000/02_server/register_a.php",
              data: content,
              datatype: "json",
              success: function (response) {
                  handleSuccess;
              },
              error: function (response) {
                  handleError('Error creating Content');
              }
            });

        }

        function Update(Content) {
            return $http.put('/api/Contents/' + content.id, content).then(handleSuccess, handleError('Error updating Content'));
        }

        function Delete(id) {
            return $http.delete('/api/Contents/' + id).then(handleSuccess, handleError('Error deleting Content'));
        }

        // private functions

        function handleSuccess(data) {
            return data;
        }

        function handleError(error) {
            return function () {
                return { success: false, message: error };
            };
        }
    }

})();
