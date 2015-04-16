window.taveo_dashboard_ajax = (function(window, document, $) {
	var app = {};
	
	app.cache = function() {
		app.$dtable = $('#taveo_links');
	};
    
    app.init = function() {
        app.cache();
        //check if we had a API error or not
        if (app.$dtable.find('tr:last').html() != '') {
        	app.$dtable.DataTable(); 
        }
		
    };
	
    $(document).ready(app.init);
    return app;
})(window, document, jQuery);
