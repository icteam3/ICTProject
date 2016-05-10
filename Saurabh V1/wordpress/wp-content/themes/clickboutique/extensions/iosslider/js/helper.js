jQuery(document).ready(function($){

    var imgLoad = imagesLoaded('[data-item="ios"]');
    imgLoad.on( 'always', function() {

		$.fn.outerHTML = function(){
			// IE, Chrome & Safari will comply with the non-standard outerHTML, all others (FF) will have a fall-back for cloning
		    return (!this.length) ? this : (this[0].outerHTML || (
		      function(el){
		          var div = document.createElement('div');
		          div.appendChild(el.cloneNode(true));
		          var contents = div.innerHTML;
		          div = null;
		          return contents;
		    })(this[0]));
		}

		/* Products double slider */
		var main_slider = $('.product-gallery');
		var thumb_slider = $('.iosthumbs');

			/* Product Thumbs Slider */
			var c_height = thumb_slider.find('.item').height();
			var c_width = thumb_slider.find('.item').width();


			thumb_slider.height(c_height);
			thumb_slider.addClass('iosSlider').wrap('<div class="ios-container thumb-slider" style="width:'+ (c_width-60) +'px; height:'+ c_height +'px" />');
			thumb_slider.find('.item').css('display', 'inline-block');
			thumb_slider.find('.item:first').addClass('selected');
			thumb_slider.parent().append('<div class = "prev unselectable"><i class="fa fa-chevron-left"></i></div><div class = "next"><i class="fa fa-chevron-right"></i></div>');

			$('.ios-container.thumb-slider').iosSlider({
				desktopClickDrag: true,
				snapToChildren: true,
				snapSlideCenter: true,
				onSlideComplete: slideComplete,
			});

		var prev_btn = $('.ios-container.thumb-slider').find('.prev');
		var next_btn = $('.ios-container.thumb-slider').find('.next');

			/* Main Product Slider */
			var c_height = main_slider.find('.item').height();
			var c_width = main_slider.find('.item').width();

			main_slider.height(c_height);
			main_slider.addClass('iosSlider').wrap('<div class="ios-container main-slider" style="width:'+ c_width +'px; height:'+ c_height +'px" />');
			main_slider.find('.item').css('display', 'inline-block');

			$('.ios-container.main-slider').iosSlider({
				snapToChildren: true,
				desktopClickDrag: true,
				navPrevSelector: prev_btn,
				navNextSelector: next_btn,
				onSliderLoaded: doubleSlider2Load,
				onSlideChange: doubleSlider2Load
			});

		$('.ios-container.thumb-slider .item').each(function(i) {

			$(this).bind('click', function(e) {

				e.preventDefault();
				$('.ios-container.main-slider').iosSlider('goToSlide', i+1);
			});

		});

		function slideComplete(args) {

			$('.ios-container.thumb-slider').find('.next, .prev').removeClass('unselectable');
			if(args.currentSlideNumber == 1) {
				$('.ios-container.thumb-slider').find('.prev').addClass('unselectable');
			} else if(args.currentSliderOffset == args.data.sliderMax) {
				$('.ios-container.thumb-slider').find('.next').addClass('unselectable');
			}

		}

		function doubleSlider2Load(args) {

			currentSlide = args.currentSlideNumber;

			$('.ios-container.thumb-slider').iosSlider('goToSlide', args.currentSlideNumber);

			/* update indicator */
			$('.ios-container.thumb-slider .item').removeClass('selected');
			$('.ios-container.thumb-slider .item:eq(' + (args.currentSlideNumber-1) + ')').addClass('selected');

		}


		/* Custom Sliders */
		var ios_container = $('[data-slider="ios"]');

		ios_container.each(function(){

			var slides = $(this).find('[data-item="ios"]');
			var buttons = $(this).parent().find('[data-item="iosButtons"]');
		    var autoplay = ( $(this).data('autoplay') == true ) ? true : false;
		    
            var infinite = ( $(this).data('infinite') == true ) ? true : false;
            var c_drag = ( $(this).data('drag') == false ) ? false : true;
            var autoplay_timer = isNaN( parseInt($(this).data('timer'))  ) ? 4000 : parseInt($(this).data('timer'));

            var info_c = ( $(this).data('info') == false ) ? false : true;
			var mode = $(this).data('mode');
			var c_height = parseInt($(this).data('height'));
			var c_width = parseInt($(this).data('width'));

			var classes = $(this).attr('class');

			if ( mode == 'inline' ) $(slides).css('display', 'inline-block');

			$(this).css('width', 'auto');

			$(this).addClass('slider');

			slides.each(function(){
				$(this).addClass('item');
			});

			buttons.each(function(){
				$(this).addClass('iosSliderButtons');
			});

			if (!c_height) {
				c_height = $(slides[0]).height();
                $(slides).each(function(){
                    if ( c_height < $(this).height() ) c_height = $(this).height();
                });
            }

			if (!c_width){
				if (mode == 'inline') {
					c_width = $(slides[0]).width();
					$(this).width(c_width);
				}
				else c_width = $(this).width();
			}
			
			$(this).height(c_height);

			$(this).wrap('<div class="iosSlider" style="width:'+ c_width +'px; height:'+ c_height +'px" />');
			$(this).parent().wrap('<div class="ios-container"  />');

			var woo_shortcode = $($(this).data('parent-controls'));

			var iosBlock = $(this).parent().parent().find('.iosSlider');
			var widget = $(this).parent().parent().parent().find('.widget-title');

             if ( !info_c ) {
                    prev_btn = null;
                    next_btn = null;
                }

			$(this).removeAttr('class');
			$(this).parent().parent().addClass(classes);

			$(iosBlock).find('.item').css('display', 'inline-block');

            if (iosBlock.length) {

            	if ( !info_c ) {
                    prev_btn = null;
                    next_btn = null;
                }

                if (info_c && !($($(this).data('parent-controls')).length)) {
                    $(this).parent().after('<div class="ios-navigation"><div class = \'prev unselectable\'></div><div class = \'next\'></div></div>');
                    prev_btn = iosBlock.find('.prev');
                    next_btn = iosBlock.find('.next');
                }

                if ($($(this).data('parent-controls')).length){

                    var h_cont = $(this).parents('.shortcode-with-slider').find($(this).data('parent-controls'));

                    $(h_cont).append('<div class="ios-navigation"><div class = \'prev unselectable\'><i class="fa fa-chevron-left"></i></div><div class = \'next\'><i class="fa fa-chevron-right"></i></div></div>');
                    prev_btn = $(h_cont).find('.prev');
                    next_btn = $(h_cont).find('.next');

                }

                if (widget.length) {
					widget.append('<div class="ios-navigation"><div class = \'prev unselectable\'><i class="fa fa-chevron-left"></i></div><div class = \'next\'><i class="fa fa-chevron-right"></i></div></div>');
					prev_btn = widget.find('.prev');
					next_btn = widget.find('.next');
				} 

                $(iosBlock).iosSlider({
                    snapToChildren: true,
                    desktopClickDrag: true,
                    keyboardControls: true,
                    onSlideComplete: slideComplete,
                    onSlideChange: slideContentChange,
                    onSliderLoaded: slideContentChange,
                    navSlideSelector: $(iosBlock).parent().parent().find('.iosSliderButtons a'),
                    navNextSelector: next_btn,
                    navPrevSelector: prev_btn,
                    autoSlide: autoplay,
                    autoSlideTimer: autoplay_timer,
                    infiniteSlider: infinite,
                    desktopClickDrag: c_drag,
                });



            }

			function slideContentChange(args){


				$(iosBlock).parent().find('.iosSliderButtons .button').removeClass('selected');
        		$(iosBlock).parent().find('.iosSliderButtons .button:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
        		$(iosBlock).parent().find('.ios-navigation .ios-info').html(args.currentSlideNumber+' &nbsp;  <span>/</span>  &nbsp; '+args.data.numberOfSlides);

                $(iosBlock).find('li').removeClass('slide-selected');
                $(iosBlock).find('li:eq(' + (args.currentSlideNumber - 1) + ')').addClass('slide-selected');

			}

			function slideComplete(args) {

				$(iosBlock).parent().find('.next, .prev').removeClass('unselectable');
				if(args.currentSlideNumber == 1) {
				    $(iosBlock).parent().find('.prev').addClass('unselectable');
				} else if(args.currentSliderOffset == args.data.sliderMax) {
				    $(iosBlock).parent().find('.next').addClass('unselectable');
				}

			}

		});

        $.event.trigger({
            type: "iossliderComplited",
            time: new Date()
        });

	});
});