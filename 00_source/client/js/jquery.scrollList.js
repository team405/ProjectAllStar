(function($) {
    $.fn.extend({
       
        /*
         * scrollList: 
         * Scrolls an ordered or unordered list in a given direction.
         *
         * Example calls:
         * Scroll up at 20 pixels/second pausing for a half second (500ms) between each
         * $('#scroll_list').scrollList('up', 20, 500); 
         *
         * Scroll right at 30 pixels/second not pausing
         * $('#scroll_list').scrollList('right', 30);
         *
         * Example html:
         * <div id="scroll_list_container">
         *     <ul>
         *         <li>Item 1</li>
         *         <li>Item 2</li>
         *         <li>Item 3</li>
         *     </ul>
         * </div>
         *         
         * Example css:
         * - up/down
         * ul { margin:0; padding:0; }
         * #scroll_list_container { max-height:30px; overflow:hidden; }
         *
         * -left/right
         * ul { margin:0; padding:0; }
         * #scroll_list_container { max-height:18px; max-width:100px; overflow:hidden; }
         * #scroll_list_container ul { width:1000px; }
         * #scroll_list_container li { display:inline-block; }
         */
        scrollList : function(direction, pixels_per_second, delay) {
            if ('undefined' == typeof(pixels_per_second)) {
                pixels_per_second = 20;
            }
            
            if ('undefined' == typeof(delay)) {
                delay = 1000;
            }
            
            if ('undefined' == typeof(direction) || -1 == $.inArray(direction, ['up', 'down', 'left', 'right'])) {
                direction = 'up';
            }

            var $list = $(this);
            var $lis = $list.children('li');
            var $current_li;
            var pixels_per_millisecond = pixels_per_second / 1000;
            var easing = (delay == 0) ? 'linear' : 'swing';

            // Set position relative if position is currently static so top/left properties will affect it's position            
            if ('static' == $list.css('position')) {
                $list.css('position', 'relative');
            }
            
            /*
             * Remove text nodes between lis since they add spacing that 
             * will be removed when shifting lis from end to end
             */
            if ('left' == direction || 'right' == direction) {
                var text = [];
            	this.each(function() {
            		var children = this.childNodes;
            		for (var i = 0; i < children.length; i++) {
            			var child = children[i];
            			if (child.nodeType == 3) {
            			    text.push(child);
            			}
            		}
            	});
            	
            	$(this.pushStack(text)).remove();
            }
            
            if ('up' == direction || 'left' == direction) {
                $current_li = $lis.filter(':first');
            }
            else {

                /* 
                 * If right or down, move the last li to the beginning and move the entire
                 * list up/left to allow the next li to scroll into view rather than just appear.
                 */
                var $last_li = $lis.filter(':last');
                if ('down' == direction) {
                    $list.css('top', '-' + $last_li.outerHeight() + 'px');
                }
                else {
                    $list.css('left', '-' + $last_li.outerWidth() + 'px');
                }
                $last_li.remove();
                $lis.filter(':first').before($last_li);
                $lis = $list.children('li');
                $current_li = $lis.filter(':last');
            }

            
            function scrollListNext() {
                var distance, property;
                var css = {};

                if ('up' == direction || 'down' == direction) {
                    property = 'top';             
                    distance = $current_li.outerHeight();
                }
                else {
                    property = 'left';             
                    distance = $current_li.outerWidth();
                }

                switch (direction) {
                    case 'up':   
                        css.top = '-' + distance + 'px';
                        break;
                        
                    case 'right':                
                        css.left = 0;
                        break;

                    case 'down':                
                        css.top = 0;
                        break;
                        
                    case 'left':                
                        css.left = '-' + distance + 'px';
                        break;
                };
                
                var duration = distance / pixels_per_millisecond;
                $list.animate(css, duration, easing, function() {
                    $current_li.remove();
                    if ('up' == direction || 'left' == direction) {
                        $list.css(property, 0);
                        $lis.filter(':last').after($current_li);
                        $lis = $list.children('li');
                        $current_li = $lis.filter(':first');
                    }
                    else {
                        $list.css(property, '-' + distance + 'px');
                        $lis.filter(':first').before($current_li);
                        $lis = $list.children('li');
                        $current_li = $lis.filter(':last');
                    }

                    setTimeout(scrollListNext, delay);
                });
            };
            
            setTimeout(scrollListNext, delay);
        }
    });
})(jQuery);