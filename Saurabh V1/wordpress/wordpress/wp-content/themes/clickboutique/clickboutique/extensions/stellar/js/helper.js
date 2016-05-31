jQuery(document).ready(function ($) {
    $(document).on('iossliderComplited',function(){

        jQuery(function($) {

            enquire.register("screen and (min-width: 1024px)", {

                match: function() {

                    if ( ! $.browser.msie )
                        $.stellar({
                            horizontalScrolling: false
                        });

                },
                unmatch: function() {
                    $.stellar = null;
                }

            });
        });



    });
});
