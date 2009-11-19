/**
 * imageSelector plugin
 */
(function(){

    var $ = jQuery;

    $.fn.imageSelector = function(datasource_url) {
        
        return this.each(function(){
            var field = $(this);
            var selector = $('<div class="selectorBox"></div>').insertAfter(field);
 
            if (!datasource_url) {
                loadingError();
                return false;
            }
            //else
            $.getJSON(datasource_url, function(data){
                if (data.error) {
                    loadingError();
                    return false;
                }
                $.each(data.images, function(i,image){
                    addImage(image);
                });
            });

            /**
             * Makes element editable
             */
            function addImage(image){
                var span = $('<span class="selectorImage"><img src="'+image.url+'" alt="'+image.title+'" /></span>');
                span.click(function() {
                    selector.find('.selected').removeClass('selected');
                    span.addClass('selected');
                    field.val(image.image_id);
                });
                selector.append(span);
            }

            function loadingError() {
                selector.html('<p class="error">Loading error...</p>');
            }

        });
    }
})();
