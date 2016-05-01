
// Superfish menus init
jQuery(document).ready(function($){

	$('ul.sf-menu').superfish();
    $('ul.sf-menu li.mega-menu').each(function(){

        var u_width = 0;
        $(this).find('li.submenu').each(function(){
            u_width = u_width + $(this).width();
        });

        var _offset = $(this).find(' > ul.dropdown').data('offset');
        _offset = (_offset != undefined ? _offset : 130 );
        $(this).find(' > ul.dropdown').width(u_width + _offset);

    });
	$('.widget_nav_menu').find('ul.menu').addClass('sf-menu').superfish();

});