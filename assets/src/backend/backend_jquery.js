jQuery(function () {
    jQuery('.select2').select2({
        placeholder: 'Select an option',
        width: '400px'
    });

    var queryString = window.location.search;
    var params = new URLSearchParams(queryString);

    if (jQuery('input.daterangepick').length) {
        jQuery('input.daterangepick').daterangepicker({
            autoUpdateInput: params.has('daterange') ? true : false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        jQuery('input.daterangepick').on('apply.daterangepicker', function (ev, picker) {
            jQuery(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        jQuery('input.daterangepick').on('cancel.daterangepicker', function (ev, picker) {
            jQuery(this).val('');
        });

        if (params.has('daterange')) {
            var daterange = params.get('daterange').split('-');
            jQuery('input.daterangepick').daterangepicker({ startDate: daterange[0], endDate: daterange[1] });
        }
    }


})