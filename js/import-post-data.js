jQuery(function($) {
    $(document).ready(function(){
        console.log('ready');

        import_handler();
        delete_handler();
    })

    function import_handler(){
        $("#form-import-post-to-wp").submit(function( event ) {

            console.log(event);
            var _this = $(this);
            var _submitted_data = _this.serializeArray();
            event.preventDefault();

            var values = { 'action': _this.attr('action') };
            
            $.each(_submitted_data, function(i, field) {
                values[field.name] = field.value;
                console.log(field.value);
            });
            
            imp_data_request_ajax(values);

            return false;
        });
    }

    function delete_handler(){
        $("#form-delete-post-to-wp").submit(function( event ) {

            console.log(event);
            var _this = $(this);
            var _submitted_data = _this.serializeArray();
            event.preventDefault();

            var values = { 'action': _this.attr('action') };
            
            $.each(_submitted_data, function(i, field) {
                values[field.name] = field.value;
                console.log(field.value);
            });
            
            imp_data_request_ajax(values);

            return false;
        });
    }

    function imp_data_request_ajax(data){
        var percentage = 0;
        
        var request = $.post(ajax_object.ajax_url, data);

        request.done(function(response){
            percentage = 100;
            $('#import-loader .progress-bar').css('width', percentage + "%");
            $('#import-loader .progress-bar').text(percentage);
            console.log(response);
            /*setTimeout(() => {
                imp_data_request_ajax(data);
            }, 100); 
            */
        });
    }
});