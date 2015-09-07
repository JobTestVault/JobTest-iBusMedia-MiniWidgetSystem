window.jQuery || document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"><\/script>');
    
var waiting = null;

function initWidget() {
    window.ibusmedia_test_widget_id = 'widget_<?php echo $id; ?>';
    jQuery(function () {
        var loaderScript = jQuery('#<?php echo $id; ?>');      
        
        if (!window.ibusmedia_test_widget_loaded_framework) {
            
            var link = jQuery('<link>');
            link.attr({
                rel: 'stylesheet',
                type: 'text/css',
                href: loaderScript.attr('data-css'),
                media: 'all'
            });
            jQuery('head').first().append(link);
            
            var script = jQuery('<script><\/script>')
            script.attr({
                src: loaderScript.attr('data-js'),
                type: 'text/javascript'
            });  
            jQuery('head').first().append(script);
                        
            window.ibusmedia_test_widget_loaded_framework = true;           
        }
        
        var el = jQuery('<div></div>');
        el.attr({
            'id': window.ibusmedia_test_widget_id,
            'class': 'script-type container'
        });
        el.css({
            width: loaderScript.attr('data-width'),
            height: loaderScript.attr('data-height'), 
            border: '2px solid rgba(100, 100, 100, 0.498039)',
            overflow: 'auto'
        });
        jQuery.ajax(
            {
                url: './updates.old',
                type: "GET",
                dataType: "html",                
                success: function (data) {
                    if (!data)
                        return;
                    el.html(data);
                    window.ibusmedia_test_update_links();
                }
            }
        );
        loaderScript.after(el);
    });    
}

function waitUntiljQuery() {
    if (window.jQuery) {
        clearInterval(waiting);
        initWidget();
    }
}

waiting = setInterval(waitUntiljQuery, 100);

