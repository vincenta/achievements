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
                $.each(data.elements, function(i,image){
                    addImage(image);
                });
            });

            /**
             * Makes element editable
             */
            function addImage(image){
                var span = $('<span class="selectorImage"><img src="'+image.url+'" alt="'+image.title+'" title="'+image.title+'" /></span>');
                span.click(function() {
                    selectImage(image,span);
                });
                selector.append(span);
                if (image.image_id==field.val()) {
                    selectImage(image,span);
                }
            }

            function selectImage(image,element) {
                selector.find('.selected').removeClass('selected');
                element.addClass('selected');
                field.val(image.image_id);
            }

            function loadingError() {
                selector.html('<p class="error">Loading error...</p>');
            }

        });
    }
})();
