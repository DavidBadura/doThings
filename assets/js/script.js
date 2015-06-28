var doThings = {};

(function ($) {

    doThings.register = function($el) {
        $el.find('.datepicker').pickadate({
            format: 'yyyy-mm-dd'
        });

        $el.find('.timepicker').pickatime({
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

        $el.find('[data-toggle="tooltip"]').tooltip();

        $el.find('date').each(function() {

            var dateString = $(this).text();
            var date = moment(dateString);
            
            if (!date.isValid()) {
                return;
            }

            $(this).text(date.fromNow());
            $(this).attr('title', dateString).tooltip();
        });

        $el.find('[data-hotkey]').each(function() {
            var $this = $(this);
            Mousetrap.bind($this.data('hotkey'), function(e) {
                $this.val('').focus().click();
                return false;
            });
        });

        $el.find('[autofocus]').focus();
    };

    $(document).ready(function () {
        doThings.register($('body'));

        var $container = $('#st-container');

        $('.btn-nav').click(function(event) {
            event.stopPropagation();

            $container.addClass('st-menu-open');
        });

        $('.st-pusher').click(function() {
            $container.removeClass('st-menu-open');
        });

        $(document).resize(function() {
            $container.removeClass('st-menu-open');
        });

    });

})(jQuery);