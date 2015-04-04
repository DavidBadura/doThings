(function($, jQuery) {
    jQuery.fn.modalAjaxForm = function(options) {
        options = jQuery.extend({}, jQuery.fn.modalAjaxForm.defaults, options);
        return $(this).each(function() {
            $(this).click(function(e) {
                e.preventDefault();

                var url = $(this).attr('href');
                jQuery.fn.modalAjaxForm.showModal(url, {}, options.onComplete, "GET");
            });
        });
    };
    jQuery.fn.modalAjaxForm.defaults = {
        onComplete: function (){}
    };

    jQuery.fn.modalAjaxForm.showModal = function(url, data, complete, method){

        $.ajax(url, {
            dataType: 'html',
            data: data,
            type: method,
            success: function(data, textStatus, jqXHR) {

                console.log(jqXHR.status);

                if (jqXHR.status == 201) {
                    window.location.reload();
                    return;
                }

                $('#ajax-form-modal').remove();
                $('.modal-backdrop').remove();

                var $modal = $('<div class="modal" id="ajax-form-modal" />');

                $modal.appendTo('body');

                $modal.modal();
                $modal.html(data);

                complete($modal);

                $modal.find('form').submit(function(e) {

                    e.preventDefault();

                    jQuery.fn.modalAjaxForm.showModal(
                        $(this).attr('action'),
                        $(this).serialize(),
                        complete,
                        "POST"
                    );
                });
            }
        });
    };
})(jQuery, jQuery);