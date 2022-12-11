jQuery(function () {
    jQuery('.select2').select2({
        placeholder: 'Select an option',
        width: '400px'
    });

    if (jQuery('input.daterangepick').length > 0) {
        jQuery('input.daterangepick').daterangepicker();
    }
})