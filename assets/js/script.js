var doThings = {};

(function ($) {

    doThings.register = function($el) {
        $el.find('.datepicker').pickadate({
            editable: true,
            format: 'yyyy-mm-dd'
        });

        $el.find('.timepicker').pickatime({
            editable: true,
            format: 'H:i'
        });

        $el.find(".autocomplete:not(.tags)").each(function() {
            var $this = $(this);

            $this.select2({
                data: $this.data('choices'),
                multiple: true,
                minimumInputLength: 1
            })
        });

        $el.find(".tags").each(function() {
            console.log(this);

            var $this = $(this);

            $this.select2({
                tags: $this.data('choices'),
                tokenSeparators: [' ']
            })
        });

        $el.find('.modal-ajax').modalAjaxForm({
            onComplete: function($element){
                doThings.register($element);
            }
        });

        $el.find('[data-toggle="tooltip"]').tooltip()
    };

    $(document).ready(function () {
        doThings.register($('body'));


        var $container = $('#st-container');

        $('.btn-nav').click(function(event) {
            event.stopPropagation();

            $container.addClass('st-menu-open');
        });

        $('.st-pusher').click(function() {
            console.log('remove');
            $container.removeClass('st-menu-open');
        });

        $(document).resize(function() {
            console.log('resize');
            $container.removeClass('st-menu-open');
        });

    });

})(jQuery);