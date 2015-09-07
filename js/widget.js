jQuery(function () {
   var parent = (typeof ibusmedia_test_widget_id === 'undefined')?'.widget':'#' + ibusmedia_test_widget_id;   
   
   window.ibusmedia_test_update_links = function () {
        var links = $(parent + ' a');
        links.click(function (e) {
            jQuery.post('./click', {
                link: $(this).attr('href'),
            });
        });
   };   
   
   window.ibusmedia_test_update_links();
   
   if (typeof EventSource == 'undefined') {
        setInterval(function () {
            $.ajax(
                    {
                        url: './updates.old',
                        type: "GET",
                        dataType: "html",
                        success: function (data) {
                            if (!data || ($(parent).html() == data))
                                return;
                            $(parent).html(data);
                            window.ibusmedia_test_update_links();
                        }
                    }
            );
        }, 60);
   } else {
        window.ibusmedia_test_server_events = new EventSource("./updates");
        window.ibusmedia_test_server_events.onmessage = function (e) {
            if (!e.data || ($(parent).html() == e.data))
                return;
            e.data = decodeURIComponent(e.data);       
            $(parent).html(e.data);
            window.ibusmedia_test_update_links();
        };
   }   
   
});