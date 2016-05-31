<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$wholeSiteStyling = get_option( 'h5abCustomStyling' );
$wholeSiteExternal = get_option( 'h5abCustomExternal' );
$allowedHTML = wp_kses_allowed_html( 'post' );

$customCSSTheme = get_option('h5abCustomStylingTheme');

if (empty($customCSSTheme)) {
update_option('h5abCustomStylingTheme', 'default');
}

?>

<div>

    <h1>Custom CSS - Whole Site</h1>

    <p>Visit <a href="https://www.html5andbeyond.com/custom-css-whole-site-and-per-post-wordpress-plugin/">HTML5andBeyond</a> for instruction and a couple of useful CSS snippets to use</p>

	<form method="post" enctype="multipart/form-data">

		<div id="table">
		    <table width="100%" cellpadding="10">
                <tbody>

                    <tr>
                    <td scope="row" align="left">
                        <p>Add Additional External Stylesheets (<strong>Include link tags</strong>): </p>
<div style="max-width: 550px; width: 90%;">
<textarea name="h5ab-whole-site-custom-external" id="h5ab-custom-external">
<?php echo wp_kses(stripslashes($wholeSiteExternal), H5AB_Custom_Styling::$h5ab_custom_styling_kses) ?>
</textarea>
</div>
                    </td>
                    </tr>

                    <tr>
                    <td scope="row" align="left">
                    <p>Enter Custom Whole Site CSS Styling Below (without <strong>Style</strong> tags): </p>
<div style="max-width: 550px; width: 90%; min-height: 300px;">
<textarea name="h5ab-whole-site-custom-styling" id="h5ab-custom-styling">
<?php echo wp_kses(stripslashes($wholeSiteStyling), $allowedHTML); ?>
</textarea>
</div>
                    </td>
                    </tr>

                    <tr>
                    <td scope="row" align="left">
                    <p>Change the CSS Editor Theme (Admin Only)</p>
                    <select name="h5ab-css-custom-theme">
                        <option value="default" <?php if ($customCSSTheme == 'default') { echo 'selected'; }  ?>>Default</option>
                        <option value="blackboard" <?php if ($customCSSTheme == 'blackboard') { echo 'selected'; }  ?>>Blackboard</option>
                        <option value="mdn-like" <?php if ($customCSSTheme == 'mdn-like') { echo 'selected'; }  ?>>Mdn-Like</option>
                        <option value="eclipse" <?php if ($customCSSTheme == 'eclipse') { echo 'selected'; }  ?>>Eclipse</option>
                        <option value="material" <?php if ($customCSSTheme == 'material') { echo 'selected'; }  ?>>Material</option>
                    </select>
                    </td>
                    </tr>

                </tbody>
            </table>


		</div>

		<br/>
		<br/>

		<?php
			wp_nonce_field( 'h5ab_custom_styling_site_n', 'h5ab_custom_styling_site_nonce' );
			if ( ! is_admin() ) {
			echo 'Only Admin Users Can Update These Options';
			} else {
			echo '<input type="submit"  class="button button-primary show_field" id="h5ab_custom_styling_site_submit" name="h5ab_custom_styling_site_submit" value="Save Custom Styling" />';
			}

		?>

	</form>

</div>


<div class="h5ab-affiliate-advert" style="width: 170px;">
                    <p style="margin: 0; text-align: center;">Advertisement</p>
                    <a href="http://www.nativespace.com/mynative/aff.php?aff=383" target="_blank"><img src="<?php echo esc_url(plugins_url( '../images/2012_160x600_skyscraper_nativespace.gif', __FILE__ )) ?>" border="0" style="max-width: 100%; height: auto;" /></a>
                    <p style="margin: 0;">*Affiliate Link</p>

</div>

<hr/>

<div style="width: 98%; padding: 0 5px;">
<p>*Affiliate Link - We (Plugin Authors) earn commission on sales generated through this link.</p>
</div>
