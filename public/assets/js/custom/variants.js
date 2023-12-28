var KTFormRepeater = function() {

    var demo1 = function() {

        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {

            },

            show: function() {
                $elem = $(this).slideDown();
                if($("#name").val().toLowerCase() === 'color'){
                    $elem.find('.colorPickerIn').show();
                }else{
                    $elem.find('.colorPickerIn').hide();
                }
                $elem.find('.btn-primary-light').remove();
                $elem.find('.btn-danger-light').show();

            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            },
            isFirstItemUndeletable: true
        });


    }

    return {
        // public functions
        init: function() {
            demo1();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormRepeater.init();
});