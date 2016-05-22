/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 */


( function( $ ) {
	
	//--------- Do not Edit, use the following code for reference ----------------
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).html( to );
		} );
	} );
	
	
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).html( to );
		} );
	} );
	
	// Hook into background color change and adjust body class value as needed.
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			if ( '#ffffff' == to || '#fff' == to )
				$( 'body' ).addClass( 'custom-background-white' );
			else if ( '' == to )
				$( 'body' ).addClass( 'custom-background-empty' );
			else
				$( 'body' ).removeClass( 'custom-background-empty custom-background-white' );
		} );
	} );
	
	//--------- Do not edit end -------------------------------------------------
	
	
	wp.customize( 'your_number', function( value ) {
		value.bind( function( to ) {
			
			$('.site-phone').html( to );
			
		} );
	} );
	
	wp.customize( 'your_email', function( value ) {
		value.bind( function( to ) {
			
			$('.site-email').html( to );
			
		} );
	} );
	
	
	wp.customize( 'your_name', function( value ) {
		value.bind( function( to ) {
			
			$('.site-name').html( to );
			
		} );
	} );
	
	wp.customize( 'main_font', function( value ) {
		value.bind( function( to ) {
		
			$('#the-title').removeClass('merriweather');
			$('#the-title').removeClass('economica');
			$('#the-title').removeClass('galdeano');
			$('#the-title').removeClass('nixieone');
			$('#the-title').addClass( to );
			
		} );
	} );

	wp.customize( 'your_textarea', function( value ) {
		value.bind( function( to ) {
			
			$('.your_textarea').html( to );
			
		} );
	} );
	
	wp.customize( 'site_place', function( value ) {
		value.bind( function( to ) {
			
			if (to) $('#body-container').addClass('container-fluid');
			else $('#body-container').removeClass('container-fluid');
			
		} );
	} );
	
	wp.customize( 'site_media', function( value ) {
		value.bind( function( to ) {
			
			$('#header-media').attr('src', to);
			
		} );
	} );
	
	wp.customize('site_position', function(value){
		
		value.bind( function( to ) {
			
			$('#the-title').removeClass('text-align-center');
			$('#the-title').removeClass('text-align-left');
			$('#the-title').removeClass('text-align-right');
			
			$('#the-title').addClass('text-align-'+to);
			
		} );
		
	});
	
	wp.customize( 'site_pattern', function( value ) {
		value.bind( function( to ) {
			
			console.log(to);
			
			$('#body-container').removeClass('marble');
			$('#body-container').removeClass('stone');
			$('#body-container').removeClass('gold');
			$('#body-container').removeClass('silver');
			
			$('#body-container').addClass(to);
			
			
		} );
	} );
	
	
} )( jQuery );


	