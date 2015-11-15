'use strict';
angular.module('thinglue.directives', [])
.directive('autoScroll', function($window,$document){
  return function(scope){
    scope.$watch(function(){
angular.element($window).scrollTop($document[0].body.scrollHeight - angular.element($window)[0].innerHeight);
    });
  };
});