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

                if (jqXHR.status == 201) {
                    window.location.reload();
                    return;
                }

                $('.my-modal').remove();
                $('.modal-backdrop').remove();

                var $modal = $(data);

                $modal.appendTo('body');

                complete($modal);

                setTimeout(function() {
                    $modal.addClass('open');
                }, 100);

                $modal.find('form').submit(function(e) {

                    e.preventDefault();

                    jQuery.fn.modalAjaxForm.showModal(
                        $(this).attr('action'),
                        $(this).serialize(),
                        complete,
                        "POST"
                    );
                });

                $modal.find('.btn-modal-close').click(function() {
                    $modal.removeClass('open');
                    setTimeout(function () {
                        $modal.remove();
                    }, 500);
                });
            }
        });
    };
})(jQuery, jQuery);