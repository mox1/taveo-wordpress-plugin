window.taveo_ajax = (function(window, document, $) {
    var app = {};

    app.cache = function() {
        app.$ajax_button = $('.add_to_taveo_button');
        app.$ajax_button_parent=$('#returned_url');

    };

    app.init = function() {
        app.cache();
        app.$ajax_button.bind('click', app.get_ajax);
        app.$ajax_button.on('click',function(){
            $('.taveo_load').show();
        });
        

    };

    
    app.get_ajax = function() {
        //taveossdata is added by wordpress serverside
        $.get(taveossdata.api_key_url, app.ajax_response);        

    };

    app.ajax_response = function(response_data) {
        $('.taveo_load').hide();
        if (response_data.status=='ok') {  
            
            console.log(response_data.url);
            app.$ajax_button.text('Added');
            app.$ajax_button_parent.append('<input type="text" class="form-input-tip" size="16" value="'+response_data.url+'">').fadeIn("slow", function() {
    // Animation complete
  });
            app.$ajax_button.unbind('click');

        } else {

            app.$ajax_button.text('Error!!');

        }
    };

    

    $(document).ready(app.init);

    return app;

})(window, document, jQuery);
