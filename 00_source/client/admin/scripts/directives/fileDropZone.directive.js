'use strict';
angular.module('fileDropZone', [])
.directive('fileDropZone',function(){
    return{
        restrict: 'A',
        scope:{onDropFile: '&'},
        link: function(scope,element,attrs){

            //when dragover & enter
            var processDragOverOrEnter = function(event){
                event.stopPropagation();
                event.preventDefault();
                //背景色変更
                element.css('background-color','#aaa');
            }

            //when drop
            var processDrop = function(event){
                event.stopPropagation();
                event.preventDefault();
                element.css('background-color',"#fff");

                scope.onDropFile({file:event.dataTransfer.files});

            }

            var processDragLeave = function(event){
                //背景色戻す
                element.css('background-color',"#fff");
            }

            //bind event to function
            element.bind('dragover',processDragOverOrEnter);
            element.bind('dragenter',processDragOverOrEnter);
            element.bind('drop',processDrop);
            element.bind('dragleave',processDragLeave);
        }
    }
});