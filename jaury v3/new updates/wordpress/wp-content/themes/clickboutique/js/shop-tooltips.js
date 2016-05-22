
jQuery(document).ready(function($){
    $(window).load(function(){

        $.fn.extend({
            hasClasses: function (selectors) {
                var self = this;
                for (var i in selectors) {
                    if ($(self).hasClass(selectors[i])) 
                        return true;
                }
                return false;
            }
        });

        $('.buttons-wrapper a, .buttons-wrapper span').each( function(){
            $(this).hoverIntent(mousein_triger , mouseout_triger);

            function mousein_triger(){

                if ( $(this).hasClass('add_to_cart_button') ) {
                    $(this).parent().find('.product-tooltip').html(msg_cart).show();
                };
                if ( $(this).hasClass('product_type_variable') || $(this).parent().hasClass('product_type_external') || $(this).hasClass('out-of-stock') ) { 
                    $(this).parent().find('.product-tooltip').html(msg_details).show();
                };
                if ( $(this).hasClass('compare') ) { 
                    $(this).parent().find('.product-tooltip').html(msg_compare).show();
                };
                if ( $(this).hasClass('compare') && $(this).hasClass('added') ) { 
                    $(this).parent().find('.product-tooltip').html(msg_added).show();
                };
                if ( $(this).hasClass('add_to_wishlist') ) { 
                    $(this).parent().parent().parent().find('.product-tooltip').html(msg_wish).show();
                };
                if ( $(this).parent().hasClass('yith-wcwl-wishlistaddedbrowse') || $(this).parent().hasClass('yith-wcwl-wishlistexistsbrowse') ) { 
                    $(this).parent().parent().parent().find('.product-tooltip').html(msg_wish_details).show();
                };
                if ( $(this).hasClass('jckqvBtn') ) {

                    $(this).parent().find('.product-tooltip').html($(this).text()).show();
                };

            }

            function mouseout_triger() {

                $(this).parent().find('.product-tooltip').hide().empty();
                if ( $(this).hasClass('add_to_wishlist') || $(this).parent().hasClass('add_to_wishlist') ) { 
                    $(this).parent().parent().parent().find('.product-tooltip').hide().empty();
                };

            }

        });




    });
});


