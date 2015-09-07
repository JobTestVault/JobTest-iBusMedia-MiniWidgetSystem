function getFormValues(form) {
    var values = {},
        tmp = form.serializeArray();

    for (var x in tmp) {
        values[tmp[x].name] = tmp[x].value;
    }
    return values;
}

$(function () {
    var form = $('.widget-generator'),
        elements = form.find('input, select'),
        resultArea = form.find('textarea').first();
    
    if (form.length < 0) 
        return;
        
    form.submit(function (e) {
        e.preventDefault();
        return false;
    });
    form.find('[name="width"], [name="height"]').change(function () {
        var obj = $(this),
            val = obj.val();
        if (!val || isNaN(parseInt(val))) {
            obj.val(100);
        } else if (parseInt(val) < 0) {
            obj.val(Math.abs(parseInt(val)));
        }
    });
    var regen_on = -1,
        regen_func = function() {                        
            if (regen_on-- > 0) {
                setTimeout(regen_func, 500);
                return;
            }            
            
            if (regen_on < -1) {
                return;
            }
            
            var values = getFormValues(form),
            el = '',
            base_url = location.protocol + '//' + location.host + location.pathname
            url = base_url + '/widget';        
        
            switch (values['method']) {
                case 'js':
                    var id = 'nw_' + Math.random().toString(36).substr(2);
                    el = $('<script></script>');
                    el.attr({
                        src: url + "." + id + ".js",
                        id: id,
                        "data-width": parseInt(values['width']) + values['width_units'],
                        "data-height": parseInt(values['height']) + values['height_units'],
                        "data-css": base_url + "/css/widget.css",
                        "data-js": base_url + "/js/widget.js"
                    });
                    el.append('<noscript>You must turn JavaScript on in your browser settings to see this widget</noscript>');
                    break;
                case 'iframe':
                    el = $('<iframe>Your browser doesn\'t have a iframe support. You need to update to see this widget</iframe>');
                    el.attr({
                        width: parseInt(values['width']) + values['width_units'],
                        height: parseInt(values['height']) + values['height_units'],
                        src: url + ".html"
                    });
                    el.css({
                        border: 'solid 2px rgba(100, 100, 100, 0.5)'
                    });
                    break;
            }
            
            resultArea.val(el[0].outerHTML);
            resultArea.select();
            
            $('#preview').closest('.form-group').removeAttr('hidden');
            $('#preview').html(el[0].outerHTML);
        };
    elements.change(function () {
                
        if (regen_on++ > 0) {
            return;
        }        
        
        setTimeout(regen_func, 500);                       
    });
    elements.first().change();
    resultArea.select();
});
