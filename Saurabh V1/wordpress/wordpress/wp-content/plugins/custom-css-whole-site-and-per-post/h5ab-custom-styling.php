<?php

/**
 * Plugin Name: Custom CSS - Whole Site and Per Post
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: Add Custom CSS Styling to your WordPress Site - Style the Whole Site or Specific Posts / Pages. Easily Add Styling and External Stylesheets.
 * Version: 1.4
 * Author: HTML5andBeyond
 * Author URI: https://www.html5andbeyond.com/
 * License: GPL2 or Later
 */

	if ( ! defined( 'ABSPATH' ) ) exit;

	define( 'H5AB_CUSTOM_STYLING_DIR', plugin_dir_path( __FILE__ ) );
	define( 'H5AB_CUSTOM_STYLING_URL', plugin_dir_url( __FILE__ ) );

    include_once( H5AB_CUSTOM_STYLING_DIR . 'includes/h5ab-custom-styling-functions.php');

	if(!class_exists('H5AB_Custom_Styling')) {

			class H5AB_Custom_Styling {

			    private $formResponse = "";

                public static $h5ab_custom_styling_kses = array(
                    'link' => array(
                        'href' => array(),
                        'rel' => array(),
                        'type' => array(),
                        'id' => array(),
                        'class' => array()
                    )
                );

				public function __construct() {

					add_action('admin_menu', array($this, 'add_menu'));

					add_action('init', array($this, 'load_scripts'), 1);
                    add_action('init', array($this, 'validate_form_callback'), 2);
                    add_action('admin_enqueue_scripts', array($this, 'admin_init'), 3);

                    add_action( 'wp_head', array($this, 'add_custom_styling_all'), 100);
                    add_action( 'wp_head', array($this, 'add_custom_styling_single'), 100);

                    add_action( 'load-post.php', array($this, 'wp_custom_styling_meta_construct'), 1);
                    add_action( 'load-post-new.php', array($this, 'wp_custom_styling_meta_construct'), 2);

				}

				public function add_menu() {

					add_menu_page('Custom CSS', 'Custom CSS','administrator', 'H5AB_Custom_Styling_Settings',
					array($this, 'plugin_settings_page'), H5AB_CUSTOM_STYLING_URL . 'images/icon.png');

				}

                public function admin_init() {

                    wp_enqueue_style('h5ab-custom-styling-line-css', H5AB_CUSTOM_STYLING_URL . 'css/codemirror.css');

                    wp_enqueue_style('h5ab-css-theme-blackboard', H5AB_CUSTOM_STYLING_URL . 'css/blackboard.css');
                    wp_enqueue_style('h5ab-css-theme-mdn-like', H5AB_CUSTOM_STYLING_URL . 'css/mdn-like.css');
                    wp_enqueue_style('h5ab-css-theme-eclipse', H5AB_CUSTOM_STYLING_URL . 'css/eclipse.css');
                    wp_enqueue_style('h5ab-css-theme-material', H5AB_CUSTOM_STYLING_URL . 'css/material.css');

                    wp_enqueue_style('h5ab-custom-styling-affiliate', H5AB_CUSTOM_STYLING_URL . 'css/h5ab-custom-style.css');

                    if (is_plugin_active('nextgen-gallery/nggallery.php')) {
                        global $pagenow;
                        if( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) || get_current_screen()->id == 'toplevel_page_H5AB_Custom_Styling_Settings' ) {
                            wp_enqueue_script('h5ab-custom-styling-line-js', H5AB_CUSTOM_STYLING_URL . 'js/codemirror.js', array('jquery'), '', true);
                            wp_enqueue_script('h5ab-code-mirror-css', H5AB_CUSTOM_STYLING_URL . 'js/codemirror-css.js', array('jquery'), '', true);
                        }
                    } else {
                        wp_enqueue_script('h5ab-custom-styling-line-js', H5AB_CUSTOM_STYLING_URL . 'js/codemirror.js', array('jquery'), '', true);
                        wp_enqueue_script('h5ab-code-mirror-css', H5AB_CUSTOM_STYLING_URL . 'js/codemirror-css.js', array('jquery'), '', true);
                    }

                    $customCSSThemeSelect = array(
                        'theme' => esc_attr(get_option('h5abCustomStylingTheme'))
                    );
                    wp_localize_script( 'h5ab-code-mirror-css', 'cm_theme', $customCSSThemeSelect );

                }

				public function plugin_settings_page() {

					if(!current_user_can('administrator')) {
						  wp_die('You do not have sufficient permissions to access this page.');
					}

					include_once(sprintf("%s/templates/h5ab-custom-styling-settings.php", H5AB_CUSTOM_STYLING_DIR));

				}

				public function load_scripts() {

				}

				public function setFormResponse($response) {
					$class = ($response['success']) ? 'updated' : 'error';
				    $this->formResponse =  '<div = class="' . $class . '"><p>' . $response['message'] . '</p></div>';
				}

				public function getFormResponse() {
				    $fr = $this->formResponse;
				    echo $fr;
				}

                public function validate_form_callback() {

					if (isset($_POST['h5ab_custom_styling_site_nonce'])) {

							if(wp_verify_nonce( $_POST['h5ab_custom_styling_site_nonce'], 'h5ab_custom_styling_site_n' )) {

								$response = h5ab_custom_styling_site();

								$this->setFormResponse($response);

								add_action('admin_notices',  array($this, 'getFormResponse'));

							} else {
								wp_die("You do not have access to this page");
							}

					}

				}

                public function wp_custom_styling_add_post_meta() {

                $screens = array( 'post', 'page' );

                foreach ( $screens as $screen ) {

                    add_meta_box(
                        'h5ab-custom-styling-textarea',
                        esc_html__( 'Custom Styling', 'example' ),
                        array($this, 'wp_custom_styling_post_meta_box'),
                        $screen,
                        'normal',
                        'default'
                    );

                }

                }

                public function wp_custom_styling_post_meta_box( $object, $box ) { ?>

                  <?php wp_nonce_field( 'wp_styling_post_n', 'wp_styling_post_nonce' );
                    $wp_meta_key_custom_styling_external = get_post_meta( $object->ID, 'h5abMetaStylingExternal', true );
                    $wp_meta_key_custom_styling_data = get_post_meta( $object->ID, 'h5abMetaStylingData', true );
                    $allowedHTML = wp_kses_allowed_html( 'post' );
                  ?>

                  <p>
                    <label>Add Additional External Stylesheets (<strong>Include link tags</strong>):</label>
                    <br/><br/>
<textarea class="widefat" id="h5ab-custom-external" name="h5ab-custom-styling-external">
<?php echo wp_kses(stripslashes($wp_meta_key_custom_styling_external), self::$h5ab_custom_styling_kses) ?>
</textarea>
                  </p>

                  <p>
                    <label>Enter Custom Post CSS Styling Below (without <strong>Style</strong> tags):</label>
                    <br/><br/>
<textarea class="widefat" id="h5ab-custom-styling" name="h5ab-custom-styling-textarea">
<?php echo wp_kses(stripslashes($wp_meta_key_custom_styling_data), $allowedHTML) ?>
</textarea>
                  </p>

                <?php }


                public function wp_custom_styling_meta_construct() {
					add_action( 'add_meta_boxes', array($this, 'wp_custom_styling_add_post_meta') );
					add_action( 'save_post', array($this, 'wp_custom_styling_save_post_meta'), 10, 2 );
                }


				 public function wp_custom_styling_save_post_meta( $post_id, $post ) {

				   global $post;
                   if (isset($_POST['wp_styling_post_nonce'])) {
                       if(wp_verify_nonce($_POST['wp_styling_post_nonce'], 'wp_styling_post_n' ) && is_admin()) {

                            $allowedHTML = wp_kses_allowed_html( 'post' );

                            $new_post_custom_styling = ( isset( $_POST['h5ab-custom-styling-textarea'] ) ? $_POST['h5ab-custom-styling-textarea'] : '' );
                            $new_post_custom_styling_external = ( isset( $_POST['h5ab-custom-styling-external'] ) ? $_POST['h5ab-custom-styling-external'] : '' );

                            if(is_null($_POST['h5ab-custom-styling-textarea'])) {
                            delete_post_meta( $post_id, 'h5abMetaStylingData' );
                            } else {
                            update_post_meta( $post_id, 'h5abMetaStylingData', wp_kses(stripslashes($new_post_custom_styling), $allowedHTML) );
                            }
                            if(is_null($_POST['h5ab-custom-styling-external'])) {
                            delete_post_meta( $post_id, 'h5abMetaStylingExternal' );
                            } else {
                            update_post_meta( $post_id, 'h5abMetaStylingExternal', wp_kses(stripslashes($new_post_custom_styling_external), self::$h5ab_custom_styling_kses));
                            }

                        }
                    }

				}

                public function add_custom_styling_all() {

                    $wholeSiteExternal = get_option( 'h5abCustomExternal' );
                    $wholeSiteStyling = get_option( 'h5abCustomStyling' );

                    if (!is_null($wholeSiteExternal)){
                        echo wp_kses(stripslashes($wholeSiteExternal), self::$h5ab_custom_styling_kses);
                    }

                    if (!is_null($wholeSiteStyling)){
                        echo '<style>' . str_replace("&gt;",">",wp_kses_post($wholeSiteStyling)) . '</style>';
                    }

                }

                public function add_custom_styling_single() {

                    global $post;

                    $postID = $GLOBALS['post']->ID;
                    $wp_meta_key_custom_styling_data = get_post_meta( $postID, 'h5abMetaStylingData', true );
                    $wp_meta_key_custom_styling_external = get_post_meta( $postID, 'h5abMetaStylingExternal', true );

                    if(is_single($postID) && !empty($wp_meta_key_custom_styling_external) || is_page($postID) && !empty($wp_meta_key_custom_styling_external)) {
                        echo wp_kses(stripslashes($wp_meta_key_custom_styling_external), self::$h5ab_custom_styling_kses);
                    }

                    if(is_single($postID) && !empty($wp_meta_key_custom_styling_data) || is_page($postID) && !empty($wp_meta_key_custom_styling_data)) {
                        echo '<style>' . str_replace("&gt;",">",wp_kses_post($wp_meta_key_custom_styling_data))  . '</style>';
                    }

                }

                public static function activate() {
					add_option('h5abCustomStylingTheme', 'default');
				}

            }

	}

	if(class_exists('H5AB_Custom_Styling')) {

        register_activation_hook( __FILE__, array('H5AB_Custom_Styling' , 'activate'));

		$H5AB_Custom_Styling = new H5AB_Custom_Styling();

	}


?>
