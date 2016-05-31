<?php
/*
Plugin Name: WooCommerce Cloud Zoom Image Plugin
Plugin URI: http://mrova.com
Description: Zoom Image on mouse hover
Version: 0.1
Author: mRova
Author URI: http://www.mrova.com
 */

/*  Copyright 2012 mRova (email : info@mrova.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */


// ------------------------------------------------------------------------
// REQUIRE MINIMUM VERSION OF WORDPRESS:
// ------------------------------------------------------------------------
function requires_wordpress_version() {
    global $wp_version;
    $plugin = plugin_basename( __FILE__ );
    $plugin_data = get_plugin_data( __FILE__, false );

    if ( version_compare($wp_version, "3.3", "<" ) ) {
        if( is_plugin_active($plugin) ) {
            deactivate_plugins( $plugin );
            wp_die( "'".$plugin_data['Name']."' requires WordPress 3.3 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>." );
        }
    }
}
register_activation_hook(__FILE__, 'wcz_add_defaults');
register_uninstall_hook(__FILE__, 'wcz_delete_plugin_options');
add_action( 'admin_init', 'requires_wordpress_version' );
add_action('admin_init', 'wcz_init');
add_action('admin_menu', 'wcz_add_options_page');
add_action('wp_footer', 'wcz_head',30);
add_action('wp_enqueue_scripts', 'wcz_enqueue_scripts');
function wcz_get_defaults(){

    return array("zoomWidth" => "auto",
        "zoomHeight" => "auto",
        "position" => "right",
        "adjustX" => "0",
        "adjustY" => "0",
        "tint" => "false",
        "tintOpacity" => "0.5",
        "lensOpacity" => "0.5",
        "softFocus" => "false",
        "smoothMove" => "3",
        "showTitle" => "false",
        "titleOpacity" => "0.5",

    );

}
function wcz_add_defaults(){
    $tmp = get_option('wcz_options');
    if(($tmp['chk_default_options_db']=='1')||(!is_array($tmp))) {
        delete_option('wcz_options'); // so we don't have to reset all the 'off' checkboxes too! (don't think this is needed but leave for now)
        $arr = wcz_get_defaults();
        update_option('wcz_options', $arr);
    }

}

function wcz_delete_plugin_options(){
    delete_option('wcz_options');
}

function wcz_init(){
    register_setting( 'wcz_plugin_options', 'wcz_options', 'wcz_validate_options' );
}

function wcz_add_options_page(){
    add_options_page('Cloud Zoom Plugin For WooCommerce By mRova', 'mCloud Zoom', 'manage_options', __FILE__, 'wcz_render_form');
}

function wcz_render_form(){
?>
    <div class="wrap">

        <!-- Display Plugin Icon, Header, and Description -->
        <div class="icon32" id="icon-options-general"><br></div>
        <h2>Cloud Zoom For WooCommerce By <a href="http://mrova.com">mRova</a></h2>
        <p>Cloud zoom for woocommerce uses <a href="http://www.professorcloud.com/mainsite/cloud-zoom.htm">Cloud Zoom</a> jQuery image zoom plugin</p>
        <form method="post" action="options.php">
            <?php settings_fields('wcz_plugin_options'); ?>
<?php $options = get_option('wcz_options');
?>
<table class="form-table">
<tr>
                    <th scope="row">zoomWidth</th>
                    <td>
                        <input name="wcz_options[zoomWidth]" type='text' value='<?php echo $options['zoomWidth']?>'/><br /><span style="color:#666666;margin-left:2px;">The width of the zoom window in pixels.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">zoomHeight</th>
                    <td>
                        <input name="wcz_options[zoomHeight]" type='text' value='<?php echo $options['zoomHeight']?>'/><br /><span style="color:#666666;margin-left:2px;">The height of the zoom window in pixels.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">position</th>
                    <td>
                        <select name='wcz_options[position]'>
                            <option value='left' <?php selected('left', $options['position']); ?>>Left</option>
                <option value='right' <?php selected('right', $options['position']); ?>>Right</option>
<option value='top' <?php selected('top', $options['position']); ?>>Top</option>
<option value='bottom' <?php selected('bottom', $options['position']); ?>>Bottom</option>
</select><br /><span style="color:#666666;margin-left:2px;">Specifies the position of the zoom window relative to the small image. Allowable values are 'left', 'right', 'top', 'bottom', 'inside' or you can specifiy the id of an html element to place the zoom window in e.g. position: 'element1'</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">adjustX</th>
                    <td>
                        <input name="wcz_options[adjustX]" type='text' value='<?php echo $options['adjustX']?>'/><br /><span style="color:#666666;margin-left:2px;">Allows you to fine tune the x-position of the zoom window in pixels.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">adjustY</th>
                    <td>
                        <input name="wcz_options[adjustY]" type='text' value='<?php echo $options['adjustY']?>'/><br /><span style="color:#666666;margin-left:2px;">Allows you to fine tune the y-position of the zoom window in pixels.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">tint</th>
                    <td>
                        <input name="wcz_options[tint]" type='text' value='<?php echo $options['tint']?>'/><br /><span style="color:#666666;margin-left:2px;">Specifies a tint colour which will cover the small image. Colours should be specified in hex format, e.g. '#aa00aa'. Does not work with softFocus.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">tintOpacity</th>
                    <td>
                        <input name="wcz_options[tintOpacity]" type='text' value='<?php echo $options['tintOpacity']?>'/><br /><span style="color:#666666;margin-left:2px;">Opacity of the tint, where 0 is fully transparent, and 1 is fully opaque.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">lensOpacity</th>
                    <td>
                        <input name="wcz_options[lensOpacity]" type='text' value='<?php echo $options['lensOpacity']?>'/><br /><span style="color:#666666;margin-left:2px;">Opacity of the lens mouse pointer, where 0 is fully transparent, and 1 is fully opaque. In tint and soft-focus modes, it will always be transparent.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">softFocus</th>
                    <td><select name='wcz_options[softFocus]'>
                            <option value='false' <?php selected('false', $options['softFocus']); ?>>False</option>
<option value='true' <?php selected('true', $options['softFocus']); ?>>True</option></select>
                        <br /><span style="color:#666666;margin-left:2px;">Applies a subtle blur effect to the small image. Set to true or false. Does not work with tint.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">smoothMove</th>
                    <td>
                        <input name="wcz_options[smoothMove]" type='text' value='<?php echo $options['smoothMove']?>'/><br /><span style="color:#666666;margin-left:2px;">Amount of smoothness/drift of the zoom image as it moves. The higher the number, the smoother/more drifty the movement will be. 1 = no smoothing.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">showTitle</th>
                    <td><select name='wcz_options[showTitle]'>
                            <option value='false' <?php selected('false', $options['showTitle']); ?>>False</option>
<option value='true' <?php selected('true', $options['showTitle']); ?>>True</option></select>
                        <br /><span style="color:#666666;margin-left:2px;">Shows the title tag of the image. True or false.</span>
                    </td>
                </tr>
<tr>
                    <th scope="row">titleOpacity</th>
                    <td>
                        <input name="wcz_options[titleOpacity]" type='text' value='<?php echo $options['titleOpacity']?>'/><br /><span style="color:#666666;margin-left:2px;">Specifies the opacity of the title if displayed, where 0 is fully transparent, and 1 is fully opaque.</span>
                    </td>
                </tr>
</table>
            <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            </p>
</form>

    </div>
<?php
}

function wcz_plugin_action_links(){


}

function wcz_validate_options($input) {

    return $input;
}

function wcz_enqueue_scripts(){
    if(is_product()){
        wp_enqueue_script(
            'cloud-zoom-js',
            plugins_url('/js/cloud-zoom.1.0.2.min.js', __FILE__),
            array('jquery')
        );
        wp_register_style( 'cloud-zoom-css', plugins_url('/css/cloud-zoom.css', __FILE__) );
        wp_enqueue_style( 'cloud-zoom-css' );

    }
}


function wcz_head(){
    if(is_product()){
        $defaults = wcz_get_defaults();
        $options = get_option('wcz_options');

        $zoomWidth = ($options['zoomWidth']=="")?$defaults['zoomWidth']:$options['zoomWidth'];
        $zoomHeight = ($options['zoomHeight']=="")?$defaults['zoomHeight']:$options['zoomHeight'];
        $position = ($options['position']=="")?$defaults['position']:$options['position'];
        $adjustX = ($options['adjustX']=="")?$defaults['adjustX']:$options['adjustX'];
        $adjustY = ($options['adjustY']=="")?$defaults['adjustY']:$options['adjustY'];
        $tint = ($options['tint']=="")?$defaults['tint']:$options['tint'];
        $tintOpacity = ($options['tintOpacity']=="")?$defaults['tintOpacity']:$options['tintOpacity'];
        $lensOpacity = ($options['lensOpacity']=="")?$defaults['lensOpacity']:$options['lensOpacity'];
        $softFocus = ($options['softFocus']=="")?$defaults['softFocus']:$options['softFocus'];
        $smoothMove = ($options['smoothMove']=="")?$defaults['smoothMove']:$options['smoothMove'];
        $showTitle = ($options['showTitle']=="")?$defaults['showTitle']:$options['showTitle'];
        $titleOpacity = ($options['titleOpacity']=="")?$defaults['titleOpacity']:$options['titleOpacity'];


?>
        <script type="text/javascript">
        jQuery(document).ready(function($){
            $('a.zoom').unbind('click.fb');
            $thumbnailsContainer = $('.product .thumbnails');
            $thumbnails = $('a', $thumbnailsContainer);
            $productImages = $('.product .images>a');
            addCloudZoom = function(onWhat){

                onWhat.addClass('cloud-zoom').attr('rel', "zoomWidth:'<?php echo $zoomWidth ?>',zoomHeight: '<?php echo $zoomHeight ?>',position:'<?php echo $position ?>',adjustX:<?php echo $adjustX ?>,adjustY:<?php echo $adjustY ?>,tint:'<?php echo $tint ?>',tintOpacity:<?php echo $tintOpacity ?>,lensOpacity:<?php echo $lensOpacity ?>,softFocus:<?php echo $softFocus ?>,smoothMove:<?php echo $smoothMove ?>,showTitle:<?php echo $showTitle ?>,titleOpacity:<?php echo $titleOpacity ?>").CloudZoom();

            }
            if($thumbnails.length){
             //   $cloneProductImage = $productImages.clone(false);
               // $thumbnailsContainer.append($cloneProductImage);
                $thumbnails.bind('click',function(){
                    $image = $(this).clone(false);
                    $image.insertAfter($productImages);
                    $productImages.remove();
                    $productImages = $image;
                    $('.mousetrap').remove();
                    addCloudZoom($productImages);

                    return false;

                })

            }
            addCloudZoom($productImages);
        });
        </script>



<?php
    }
}

function catalog_thumbnail(){
    $return = 'shop_single';
    return $return;
}
add_filter( 'single_product_small_thumbnail_size', 'catalog_thumbnail',10,2 ) ;

function wcz_add_product_thumb(){
    if(is_product()){
        return 0;
    }
}

//add_filter('get_post_metadata','wcz_add_product_thumb');


