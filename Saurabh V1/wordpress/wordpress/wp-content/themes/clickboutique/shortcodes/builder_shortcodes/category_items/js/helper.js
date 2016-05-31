jQuery(document).ready(function($){
	var imgLoad = imagesLoaded('ul li .item-product img');
imgLoad.on( 'always', function() {
		var sliders = $( '.mi-slider' );
		sliders.each(function(){
			
			var products = $(this).find('ul li .item-product');
			
			products.each(function(){
				var img = $(this).find('img');
				var panel = $(this).find('.item-panel');
				panel.width(img.width());
				panel.height(img.height());
				var img_pos = img.position();
				panel.css('top', img_pos.top);
				panel.css('left', img_pos.left);
			});
			
			$(this).catslider();
			
		});
		
	});
});

jQuery(document).ready(function($){
	
	var panel = $('.ios-products .item-panel');
		
		panel.hide();
		
var imgLoad = imagesLoaded('.ios-products ul li .item-product img');
imgLoad.on( 'always', function() {
		var sliders = $( '.ios-products' );
		sliders.each(function(){
			
			var products = $(this).find('ul li.item .item-product');
			
			products.each(function(){
				var img = $(this).find('img');
				var panel = $(this).find('.item-panel');
				panel.show();
				panel.width(img.width());
				panel.height(img.height());
				var img_pos = img.position();
				panel.css('top', img_pos.top);
				panel.css('left', img_pos.left);
			});
			
		});
		
	});
});