/**
 * @version    $Id$
 * @package    IG PageBuilder
 * @author     InnoGears Team <support@innogears.com>
 * @copyright  Copyright (C) 2012 innogears.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innogears.com
 * Technical Support:  Feedback - http://www.innogears.com
 */
(function ($) {
	$(document).ready(function () {
		var count_time = 0;
		$('body').bind('ig_after_popover', function (e) {
			// Make bind action only run one time
			if ( count_time < 1 ) {
				$('#param-title_font').on('change', function () {
					var current_top = parseFloat( $('#control-action-title').css('top') );
					if ($(this).val() == 'inherit') {
						$('#control-action-title').css('top', parseInt( current_top + 105 ) + 'px' );
					} else {
						$('#control-action-title').css('top', parseInt( current_top - 105 ) + 'px' );
					}
				});
			}
			count_time += 1;
		});
	});
})(jQuery);