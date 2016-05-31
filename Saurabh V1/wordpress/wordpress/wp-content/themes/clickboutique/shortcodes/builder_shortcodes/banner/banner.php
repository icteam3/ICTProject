<?php

/**
 * @version	$Id$
 * @package	IG Pagebuilder
 * @author	 InnoGearsTeam <support@TI.com>
 * @copyright  Copyright (C) 2012 TI.com. All Rights Reserved.
 * @license	GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.TI.com
 * Technical Support:  Feedback - http://www.TI.com
 */
if ( ! class_exists( 'IG_Banner' ) ) {

	class IG_Banner extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['name'] = __( 'Banner',  'plumtree' );
			//$this->config['cat'] = __( 'Media',  'plumtree' );
			$this->config['icon'] = 'icon-paragraph-text';
            $this->config['exception'] = array(
                'admin_assets' => array(
                    // Link Type
                    'ig-linktype.js',

                    // Shortcode initialization
                    'image.js',
                ),

                'frontend_assets' => array(
                    // Bootstrap 3
                    'ig-pb-bootstrap-css',
                    'ig-pb-bootstrap-js',

                    // Fancy Box
                    'ig-pb-jquery-fancybox-css',
                    'ig-pb-jquery-fancybox-js',

                    // Lazy Load
                    'ig-pb-jquery-lazyload-js',

                    // Shortcode initialization
                    'image_frontend.js',
                ),
            );

            $this->config['edit_using_ajax'] = true;

		}

		public function element_items() {

			$this->items = array(
				'content' => array(
					array(
						'name'    => __( 'Element Title',  'plumtree' ),
						'id'      => 'el_title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => __( 'Banner',  'plumtree' ),
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily',  'plumtree' )
					),
					array(
						'name'    => __( 'Image File',  'plumtree' ),
						'id'      => 'image_file',
						'type'    => 'select_media',
						'std'     => '',
						'class'   => 'jsn-input-large-fluid',
						'tooltip' => __( 'Choose image',  'plumtree' )
					),
                    array(
                        'name'    => __( 'Image Size', 'plumtree' ),
                        'id'      => 'image_size',
                        'type'    => 'large_image',
                        'tooltip' => __( 'Set image size', 'plumtree' )
                    ),
					array(
						'name'    => __( 'Alt Text',  'plumtree' ),
						'id'      => 'image_alt',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => '',
						'tooltip' => __( 'Set alt text for image',  'plumtree' )
					),
                    array(
                        'name'    => __( 'Image Type',  'plumtree' ),
                        'id'      => 'image_type',
                        'type'    => 'select',
                        'std'     => 'normal',
                        'options' => array(
                            'normal' => 'Regular Image',
                            'banner' => 'Banner Image',
                            'banner_wel' => 'Welcome Banner'
                        ),
                        'tooltip' => __( 'Set alt text for image',  'plumtree' ),
                        'has_depend' => '1',
                    ),

                    array(
                        'name'    => __( 'Banner Image Text',  'plumtree' ),
                        'id'      => 'banner_text',
                        'type'    => 'text_field',
                        'class'   => 'jsn-input-xxlarge-fluid',
                        'std'     => '',
                        'tooltip' => __( 'Set banner text for image',  'plumtree' ),
                        'dependency' => array( 'image_type', '=', 'banner' ),
                    ),


                    array(
                        'name' => __( 'Welcome Text',  'plumtree' ),
                        'desc' => __( 'Enter some content for the welcome block',  'plumtree' ),
                        'id'   => 'welcome_text',
                        'type' => 'editor',
                        'mce' => true,
                        'std'  => '',
                        'rows' => 15,
                        'tooltip' => __( 'Set content of element',  'plumtree' ),
                        'dependency' => array( 'image_type', '=', 'banner_wel' ),
                    ),


					array(
						'name'       => __( 'Link Type',  'plumtree' ),
						'id'         => 'link_type',
						'type'       => 'select',
						'std'        => IG_Pb_Helper_Type::get_first_option( IG_Pb_Helper_Type::get_image_link_types() ),
						'options'    => IG_Pb_Helper_Type::get_image_link_types(),
						'tooltip'    => __( 'Set link type of image',  'plumtree' ),
						'has_depend' => '1',
					),
					array(
						'name'       => __( 'Large Image Size',  'plumtree' ),
						'id'         => 'image_image_size',
						'type'       => 'large_image',
						'tooltip'    => __( 'Choose image size',  'plumtree' ),
						'dependency' => array( 'link_type', '=', 'large_image' )
					),
					array(
						'name'       => __( 'URL',  'plumtree' ),
						'id'         => 'image_type_url',
						'type'       => 'text_field',
						'class'      => 'jsn-input-xxlarge-fluid',
						'std'        => 'http://',
						'dependency' => array( 'link_type', '=', 'url' ),
                        'tooltip'    => __( 'Url of link when click on image',  'plumtree' ),
					),
					/*array(
						'name'  => __( 'Single Item',  'plumtree' ),
						'id'    => 'single_item',
						'type'  => 'type_group',
						'std'   => '',
						'items' => IG_Pb_Helper_Type::get_single_item_button_bar(
							'link_type',
							array(
								'type'         => 'items_list',
								'options_type' => 'select',
								'class'        => 'select2-select',
								'ul_wrap'      => false,
							)
						),
                        'tooltip' => __( 'Choose item to link to',  'plumtree' ),
					),*/
					array(
						'name'       => __( 'Open in',  'plumtree' ),
						'id'         => 'open_in',
						'type'       => 'select',
						'std'        => IG_Pb_Helper_Type::get_first_option( IG_Pb_Helper_Type::get_open_in_options() ),
						'options'    => IG_Pb_Helper_Type::get_open_in_options(),
						'dependency' => array( 'link_type', '!=', 'no_link' ),
                        'tooltip'    => __( 'Select type of opening action when click on element',  'plumtree' ),
					),
				),
				'styling' => array(

					array(
						'name'    => __( 'Container Style',  'plumtree' ),
						'id'      => 'image_container_style',
						'type'    => 'select',
						'std'     => IG_Pb_Helper_Type::get_first_option( IG_Pb_Helper_Type::get_container_style() ),
						'options' => IG_Pb_Helper_Type::get_container_style(),
						'tooltip' => __( 'Set Container Style',  'plumtree' )
					),
					array(
						'name'    => __( 'Alignment',  'plumtree' ),
						'id'      => 'image_alignment',
						'type'    => 'select',
						'std'     => IG_Pb_Helper_Type::get_first_option( IG_Pb_Helper_Type::get_text_align() ),
						'options' => IG_Pb_Helper_Type::get_text_align(),
						'tooltip' => __( 'Setting position: right, left, center, inherit parent style',  'plumtree' )
					),
					array(
						'name'            => __( 'Margin',  'plumtree' ),
						'container_class' => 'combo-group',
						'id'              => 'image_margin',
						'type'            => 'margin',
						'extended_ids'    => array( 'image_margin_top', 'image_margin_right', 'image_margin_bottom', 'image_margin_left' ),
						'tooltip'         => __( 'Set margin size',  'plumtree' )
					),
					array(
						'name'    => __( 'Fade in Animations',  'plumtree' ),
						'id'      => 'image_effect',
						'type'    => 'radio',
						'std'     => 'no',
						'options' => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
						'tooltip' => 'Whether to fading in or not',
					),
				)
			);
		}

		public function element_shortcode_full( $atts = null, $content = null ) {
			$arr_params     = shortcode_atts( $this->config['params'], $atts );
			extract( $arr_params );
			$html_elemments = $script = '';
			$alt_text       = ( $image_alt ) ? " alt='{$image_alt}'" : 'alt=""';
			$image_styles   = array();
			if ( $image_margin_top )
				$image_styles[] = "margin-top:{$image_margin_top}px";
			if ( $image_margin_bottom )
				$image_styles[] = "margin-bottom:{$image_margin_bottom}px";
			if ( $image_margin_right )
				$image_styles[] = "margin-right:{$image_margin_right}px";
			if ( $image_margin_left )
				$image_styles[] = "margin-left:{$image_margin_left}px";
			$styles    = ( count( $image_styles ) ) ? ' style="' . implode( ';', $image_styles ) . '"' : '';
			$class_img = ( $image_container_style != 'no-styling' ) ? $image_container_style : '';
			$class_img = ( $image_effect == 'yes' ) ? $class_img . ' image-scroll-fade' : $class_img;
			$class_img = ( ! empty( $class_img ) ) ? ' class="' . $class_img . '"' : '';


            if ( $image_type == 'banner' ) $img_banner = ' data-image-type="banner" data-image-text="'.$banner_text.'" ';

			if ( $image_file ) {
				$image_id       = IG_Pb_Helper_Functions::get_image_id( $image_file );
				$attachment     = wp_prepare_attachment_for_js( $image_id );
				$image_file     = ( ! empty( $attachment['sizes'][$image_size]['url'] ) ) ? $attachment['sizes'][$image_size]['url'] : $image_file;

                if ( $image_type != 'banner_wel' ) $html_elemments .= "<img src='{$image_file}'{$alt_text}{$styles}{$class_img}{$img_banner} />";
                else $html_elemments .= "<div class=\"wel-banner\"><img src='{$image_file}'{$alt_text}{$styles}{$class_img} />
                    <div class=\"wel-b-overlay\">{$welcome_text}</div>
                   </div>";

                $script         = '';
				$target         = '';


				if ( $open_in ) {
					switch ( $open_in ) {
						case 'current_browser':
							$target = '';
							break;
						case 'new_browser':
							$target = ' target="_blank"';
							break;
						case 'lightbox':
							$cls_button_fancy = ' pt-image-fancy';
                            $img_gal = ' rel="prettyPhoto" ';
							break;
					}
				}

				$class       = ( ! empty( $cls_button_fancy ) ) ? "class='{$cls_button_fancy}'" : '';
                $img_gal     = ( ! empty( $img_gal ) ) ? $img_gal : '';
				// get Single Item and check type to get right link
				@$single_item = explode( '__#__', $single_item );
				$single_item = $single_item[0];
				$taxonomies  = IG_Pb_Helper_Type::get_public_taxonomies();
				$post_types  = IG_Pb_Helper_Type::get_post_types();
				// single post
				if ( array_key_exists( $link_type, $post_types ) ) {
					$permalink      = home_url() . "/?p=$single_item";
					$html_elemments = "<a href='{$permalink}'{$target}{$class}{$img_gal}>" . $html_elemments . '</a>';
				}
				// taxonomy
				else if ( array_key_exists( $link_type, $taxonomies ) ) {
					$permalink = get_term_link( intval( $single_item ), $link_type );
					if ( ! is_wp_error( $permalink ) )
						$html_elemments = "<a href='{$permalink}'{$target}{$class}{$img_gal}>" . $html_elemments . '</a>';
				}
				else {
					switch ( $link_type ) {
						case 'url':
							$html_elemments = "<a href='{$image_type_url}'{$target}{$class}{$img_gal}>" . $html_elemments . '</a>';
							break;
						case 'large_image':
							$image_id       = IG_Pb_Helper_Functions::get_image_id( $image_file );
							$attachment     = wp_prepare_attachment_for_js( $image_id );
							$image_url      = ( ! empty( $attachment['sizes'][$image_image_size]['url'] ) ) ? $attachment['sizes'][$image_image_size]['url'] : $image_file;
							$html_elemments = "<a href='{$image_url}'{$target}{$class}{$img_gal}>" . $html_elemments . '</a>';
							break;
					}
				}

				if ( strtolower( $image_alignment ) != 'inherit' ) {
					if ( strtolower( $image_alignment ) == 'left' )
						$cls_alignment = 'pull-left';
					if ( strtolower( $image_alignment ) == 'right' )
						$cls_alignment = 'pull-right';
					if ( strtolower( $image_alignment ) == 'center' )
						$cls_alignment = 'text-center';
					$html_elemments = "<div class='{$cls_alignment}'>" . $html_elemments . '</div>';
				}
			}

			return $this->element_wrapper( $html_elemments . $script, $arr_params );
		}

	}

}