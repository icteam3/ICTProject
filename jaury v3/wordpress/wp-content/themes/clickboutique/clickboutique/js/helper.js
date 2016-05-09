jQuery(document).ready(function($){
	$(window).load(function(){

		var settings = {
		    interval: 100,
		    timeout: 200,
		    over: mousein_triger,
		    out: mouseout_triger
		};
		function mousein_triger(){
			$(this).addClass('hovered').find('.widget_shopping_cart_content').fadeIn(250, "easeInSine");
		}
		function mouseout_triger() {
			$(this).removeClass('hovered').find('.widget_shopping_cart_content').fadeOut(150, "easeOutSine");
		}

		$('header .widget_shopping_cart').hoverIntent(settings);

	});
});


// Categories widget accordion animation
jQuery(document).ready(function($){
	$(window).load(function(){

		var liParent = $('.widget').find('.children').parent().addClass('has-submenu');

		if (liParent) {

			$('.widget').find('ul:not(.children)>li').addClass('top');
			$('.widget').find('.children').hide();
			liParent.prepend( '<span class="show-subs"></span>' );
			var showSubcats = liParent.children(".show-subs");

			showSubcats.each(function(){
				$(this).on( 'click', (function() {
					if ( $(this).parent().hasClass('show') ) {
						$(this).parent().children('.children').slideUp(600, 'easeInOutQuint');
						$(this).parent().removeClass('show');
					}  else {
						$(this).parent().children('.children').slideDown(600, 'easeInOutQuint');
						$(this).parent().addClass('show');
					}
				}));
			});

		};

	});
});


// Products flipping animation
jQuery(document).ready(function($){
	$(window).load(function(){

		$('.animation-section').hoverIntent(mousein_triger , mouseout_triger);
		function mousein_triger(){
			if ( $(this).parent().hasClass('flip-enabled') ) { $(this).find('.product-img-wrapper').addClass('flip'); };
			$(this).find('.product-controls-wrapper').addClass('show');
		}
		function mouseout_triger() {
			$(this).find('.product-img-wrapper').removeClass('flip');
			$(this).find('.product-controls-wrapper').removeClass('show');
		}

	});
});


// Adding ios slider to woocommerce recently-viewed widget
jQuery(document).ready(function($){

		$('.widget_recently_viewed_products').each(function(){

			var slider = $(this).find('.product_list_widget');
			var slides = slider.find('li');
			slider.attr("data-slider","ios");
            slider.attr("data-parent-controls",".cell");
			slides.each(function(){
				$(this).attr("data-item","ios");
			});

		});

});


// Adding ios slider to woocommerce shortcodes
jQuery(document).ready(function($){

		$('.shortcode-with-slider').each(function(){

			var slider = $(this).find('.products');
			var slides = slider.children();
			slider.attr("data-slider","ios");
            slider.attr("data-parent-controls",".cell");
			slides.each(function(){
				$(this).attr("data-item","ios");
			});

		});

});

jQuery(document).ready(function($){

    $('.multistep-checkout .validate-required').each(function(){
        $(this).find('input, textarea, select').attr('required','true');
    });

    $('.multistep-checkout [data-toggle="tab"]').on('click', function(e){
        e.preventDefault();
        var _self = this;
        var error = false;
        $(_self).parents('.tab-pane').find('.validate-required').each(function(){
            var el = $(this).find('input, select, textarea');

            el.each(function(){

                if ( $(el).attr('id') == 'account_password' && !($('#createaccount').prop('checked')) ) return true;

                if ( ($(_self).parents('.tab-pane').attr('id') != 'shipping') ) {
                 $('form.woocommerce-checkout').validate().element($(this));
                    if ( ! $(el).valid() ){
                       error = true;
                    }
                } else {
                    if ( ( $('#ship-to-different-address-checkbox').prop('checked'))) {
                        $('form.woocommerce-checkout').validate().element($(this));
                        if ( ! $(el).valid() ){
                            error = true;
                        }
                    } else {
	                    error = false;
                    }
                }
            });


        });

        if ( !error ) {

            $('.tab-pane').each(function(){
                if ( $(this).hasClass('active') ) {
                    $(this).removeClass('active');

                }
            });

            $('.checkout-nav li').each(function(){
                if ( $(this).hasClass('active') ) {
                    $(this).removeClass('active');
                    $(this).addClass('finished');
                } else {
                    if ( $(this).find('a').attr('href') == '#'+$(_self).data('show') ){
                        $(this).addClass('active');
                    }
                }

            });

            $('#'+$(_self).data('show')).addClass('active');
        }

    });



});

jQuery(document).ready(function($){
    $('body').on('checkout_error', function(){

        $('.tab-pane').each(function(){
            if ( $(this).hasClass('active') ) {
                $(this).removeClass('active');

            }
        });

        $('.checkout-nav li').each(function(){
            if ( $(this).hasClass('active') ) {
                $(this).removeClass('active');
                $(this).addClass('finished');
            } else {
                if ( $(this).find('a').attr('href') == '#billing' ){
                    $(this).addClass('active');
                }
            }

        });

        $('#billing').addClass('active');

    })


});

jQuery(document).ready(function($){
	$(window).load(function(){

		$('p.stars span').replaceWith( '<span><a href="#" class="star-5">5</a><a href="#" class="star-4">4</a><a href="#" class="star-3">3</a><a href="#" class="star-2">2</a><a href="#" class="star-1">1</a></span>' );

	});
});


/* List/grid view switcher */
jQuery(document).ready(function($){
	$(window).load(function(){

		$('.pt-view-switcher span').on('click', function(e) {
			e.preventDefault();
			var products_ul = $('.site-content .products');
			if ( (e.currentTarget.className == 'pt-grid active' && products_ul.hasClass('grid-layout')) || (e.currentTarget.className == 'pt-list active' && products_ul.hasClass('list-layout')) ) {
				return false;
			}
			if ( $(this).hasClass('pt-grid') && $(this).not('.active') ) {
				products_ul.animate( {opacity:0}, 'slow' ,function(){
		            $('.pt-view-switcher .pt-list').removeClass('active');
		            $('.pt-view-switcher .pt-grid').addClass('active');
		            products_ul.removeClass('list-layout').addClass('grid-layout');
		            products_ul.find('.product').each(function(){
		            	$(this).find('.product-description-wrapper').children('.buttons-wrapper').remove();
		            	$(this).find('.product-description-wrapper').children('.star-rating').remove();
		            });
		            products_ul.isotope('reloadItems').isotope().stop().animate({opacity:1});
		        });
			}
			if ( $(this).hasClass('pt-list') && $(this).not('.active') ) {
				products_ul.animate( {opacity:0}, 'slow' ,function(){
		            $('.pt-view-switcher .pt-grid').removeClass('active');
		            $('.pt-view-switcher .pt-list').addClass('active');
		            products_ul.removeClass('grid-layout').addClass('list-layout');
		            products_ul.find('.product').each(function(){
		            	var list_description = $(this).find('.product-description-wrapper');
		            	var prod_title = $(this).find('.product-title');
		            	var alone_btn = $(this).find('.product-description-wrapper').children('.button');
		            	if (alone_btn.length > 0) {
		            		$(this).find('.buttons-wrapper').clone().insertBefore(alone_btn);
		            	} else {
		            		$(this).find('.buttons-wrapper').clone().appendTo(list_description);
		            	}
		            	$(this).find('.star-rating').clone().insertAfter(prod_title);
		            });
		            products_ul.isotope('reloadItems').isotope().stop().animate({opacity:1});
		        });
			}

		});

	});
});


jQuery(document).ready(function($){
    $('[data-product-link]').on('click',function(e){
        if ( ( e.target.className == 'animation-section' ) || ( e.target.className == 'product-controls-wrapper show' ) || (e.target.className == 'attachment-shop_catalog') ){
            window.location = $(this).data('product-link');
        }
    });

   $('.flipper img').on('click', function(e){
        if (e.target.className == 'attachment-shop_catalog wp-post-image') {
            var lnk = $(this).parents('[data-product-link]').data('product-link');
            if ( lnk != 'undefined' ) window.location = lnk;
        }
    });

		$('.widget .widget-title').each(function(){
	    var me = $(this), t = me.text().split(' ');
	    me.html( '<span>'+t.shift()+'</span> '+t.join(' ') );
  	});
});
