(function ($) {
    $(document).ready(function () {

        $('.datepicker').pickadate({
            editable: true,
            format: 'yyyy-mm-dd'
        });

        $('.timepicker').pickatime({
            editable: true,
            format: 'H:i'
        });

        $(".autocomplete:not(.tags)").each(function() {
            var $this = $(this);

            $this.select2({
                data: $this.data('choices'),
                multiple: true,
                minimumInputLength: 1
            })
        });

        $(".tags").each(function() {
            console.log(this);

            var $this = $(this);

            $this.select2({
                tags: $this.data('choices'),
                tokenSeparators: [',', ' ']
            })
        });

    });
})(jQuery);