jQuery(document).ready(function ($) {
    var slides = $('[data-slider=vertical]');
    $(slides).each(function(){

        var row_height_v = ( $(this).data('row-height') != undefined ) ? $(this).data('row-height') : 100;
        var max_rows_v = ( $(this).data('max-rows') != undefined ) ? $(this).data('max-rows') : 1;
        var duration_v = ( $(this).data('duration') != undefined ) ? $(this).data('duration') : 3000;
        var pause_h = ( $(this).data('pause-h') != undefined ) ? $(this).data('pause-h') : 0;

        $(this).newsTicker({
            row_height: row_height_v,
            max_rows: max_rows_v,
            duration: duration_v,
            pauseOnHover: pause_h,
            movingUp: function(){

            },
        });
    });
});
