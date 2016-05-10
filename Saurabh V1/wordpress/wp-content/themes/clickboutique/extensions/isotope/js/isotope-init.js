jQuery(document).ready(function($) {

    var imgLoad = imagesLoaded('[data-isotope=container] img');
    imgLoad.on( 'always', function() {

        var iContainer = $('[data-isotope=container]').not('.front-page-content-wrapper [data-isotope=container]');

        var iFilters = $('[data-isotope=filter]').not('.front-page-content-wrapper [data-isotope=filter]');

        var iSorter = $('[data-isotope=sorter]').not('.front-page-content-wrapper [data-isotope=sorter]');

        var iLayout = ($.trim($(iContainer).data('layout'))).toLowerCase();

        var layout = 'fitRows';

        $(iContainer).width($(iContainer).parent().width());

        $(iContainer).addClass('clearfix');

        switch(iLayout){
            case 'fitrows'          : layout = 'fitRows'; break;
            case 'masonry'          : layout = 'masonry'; break;
            case 'cellsbyrow'       : layout = 'cellsByRow'; break;
            case 'straightdown'     : layout = 'straightDown'; break;
            case 'masonryhorizontal': layout = 'masonryHorizontal'; break;
            case 'fitcolumns'       : layout = 'fitColumns'; break;
            case 'cellsbycolumns'   : layout = 'cellsByColumns'; break;
            case 'straightacross'   : layout = 'straightAcross'; break;
            default                 : layout = 'fitRows'; break;
        }

        if(iSorter.length){
            var sorters = $(iSorter).find('[data-sortby]').click(function(){
                if ($(this).data('sortby') != '*') iContainer.isotope({ sortBy: $(this).data('sortby') });
                else iContainer.isotope({ sortBy: 'original-order' });
            });
            var sortData = {};
            var tmpObj = {};
            sorters.each(function(index, item){
                var select = $(item).data('selector');
                var sortby = $(item).data('sortby');
                switch($(this).data('type')){
                    case 'int':
                         tmpObj[$(this).data('sortby')] = function( elem ) {
                            return parseInt(elem.find(select).data(sortby), 10);
                         };
                         $.extend(sortData, tmpObj );
                        break;
                    case 'float':
                        tmpObj[$(this).data('sortby')] = function( elem ) {
                        return parseFloat(elem.find(select).data(sortby));
                    };
                    $.extend(sortData, tmpObj);
                    break;
                    case 'string':
                    tmpObj[$(this).data('sortby')] = function( elem ) {
                            return elem.find(select).data(sortby);
                        };
                    $.extend(sortData, tmpObj);
                    break;
                    default:
                        tmpObj[$(this).data('sortby')] = function( elem ) {
                            return elem.find(select).data(sortby);
                        };
                        $.extend(sortData, tmpObj);
                        break;
                }

            });


        }


        $(iContainer).find('[data-element]').each(function(){
            $(this).addClass('isotope-item');
        });

        $(iContainer).isotope({
          itemSelector : $('.isotope-item'),
          layoutMode : layout,
          getSortData: sortData
        });

        var $select = $('select.filter');

        $select.change(function() {
            var filters = $(this).val();
            if ( filters != '*' ) iContainer.isotope({ filter: '[data-element*=' + filters + ']'  });
            else iContainer.isotope({ filter: '*' });
            return false;
        });

        $(iFilters).find('[data-filter]').click(function(){
          var active_selector = $('.filter').find('.selected');
          var selector = $(this).attr('data-filter');
          active_selector.removeClass('selected');
          $(this).addClass('selected');
          if ( selector != '*' ) iContainer.isotope({ filter: '[data-element*=' + selector + ']'  });
          else iContainer.isotope({ filter: '*' });
          return false;
        });
    });
});