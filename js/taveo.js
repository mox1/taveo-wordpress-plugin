window.taveo_ajax = (function(window, document, $) {
    var app = {};

    app.cache = function() {
        app.$ajax_button = $('.add_to_taveo_button');
        app.$ajax_button_parent=$('#returned_url');
        app.$prompt_button = $('#taveo_post_btn');

    };

    app.init = function() {
        app.cache();
        app.$ajax_button.bind('click', app.get_ajax);
        app.$ajax_button.on('click',function(){
            $('.taveo_load').show();
        });
        app.$prompt_button.on('click', app.tpopup);      
		//load Taveo data on the page
		app.loadtdata();
		
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

    app.tpopup = function() {
    	var url = decodeURIComponent(taveossdata.page_permalink);
		app.mbox = new Impromptu({state0: {
			title: 'Create Taveo Link?',
			html: 'Destination URL: ' + url + '<br /><label>Comment (optional): <input type="text" name="comment" placeholder="Tweet of post.."></label><br />' +
				  	'<p>Adding a comment in highly encouraged. Make it short and unique. It it used to remember what this Link was used for. </p>',
			buttons: {"Create" : true, "Cancel": false},
			focus: 0,
			submit:function(e,v,m,f){
				if (v==0) {
					//mbox.close();
					return true;
				}
				$.ajax({
					dataType: "json",
					url: taveossdata.create_api_url,
					type: 'GET',
					data: { "apikey": taveossdata.api_key, "destination" : url, "comment" : f.comment },
					success: function(data) {
						if (data.status == "ok") {
							var pmpt = new Impromptu("Success - Link url is: " + data.url);
						}
						else {
							var pmpt = new Impromptu("Fail! - " + data.msg);
						}
					},
					error: function( xhr, textStatus, errorThrown) {
						console.log(xhr.responseText);
						var pmpt = new Impromptu("Error " + xhr.status + " (" + xhr.responseText + ")");
					}
				});
					 
			}
			 
		}});  
	}
	
	app.loadtdata = function() {
		var url = decodeURIComponent(taveossdata.page_permalink);
		$.ajax({
			dataType: "json",
			url: taveossdata.by_dest_url,
			type: 'GET',
			data: { "apikey": taveossdata.api_key, "destination" : url },
			success: function(data) {
				if (data.status == "ok") {
					//success
					console.log(data);
					$("#curtlinks").html(data.count);
					$("#tlinkmsg").show();
					$("#tlinkdata").html(data.links +"YEAA");
				}
				else {
					console.log("Fail! - " + data.msg);
				}
			},
			error: function( xhr, textStatus, errorThrown) {
				console.log("Error " + xhr.status + " (" + xhr.responseText + ")");
			}
		});	
	
	}
    $(document).ready(app.init);

    return app;

})(window, document, jQuery);
