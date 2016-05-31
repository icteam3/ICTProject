/**
 * @version    $Id$
 * @package    IG Pagebuilder
 * @author     InnoGearsTeam <support@TI.com>
 * @copyright  Copyright (C) 2012 TI.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.TI.com
 * Technical Support:  Feedback - http://www.TI.com
 */

/**
 * Custom script for Textbox element
 */
( function ($) {
    "use strict";

    $.IGSelectFonts = $.IGSelectFonts || {};

    $.IGColorPicker = $.IGColorPicker || {};

    $.PT_Text = $.PT_Text || {};

    $.PT_Text = function () {
        new $.IGSelectFonts();
        new $.IGColorPicker();
    }

    $(document).ready(function () {
        $.PT_Text();
    });

})(jQuery)