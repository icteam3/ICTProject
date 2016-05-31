<?php


if ( ! class_exists( 'IG_Pricing' ) ) {

	class IG_Pricing extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		public function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['name']      = __( 'Pricing Table',  'plumtree' );
			$this->config['cat']       = __( 'Typography',  'plumtree' );
			$this->config['icon']      = 'icon-paragraph-text';
			$this->config['exception'] = array(
				'default_content'  => __( 'Pricing Table',  'plumtree' ),
				'require_js'       => array( ),
				'data-modal-title' => __( 'Pricing Table',  'plumtree' )
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
						'std'     => __( 'Pricing',  'plumtree' ),
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily',  'plumtree' )
					),
					array(
						'id'      => 'pb_title',
						'name'    => __( 'Pricing Title',  'plumtree' ),
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => __( 'Title',  'plumtree' ),
						'tooltip' => __( 'Set the title',  'plumtree' )
					),
					array(
						'name'       => __( 'Pricing Table Type',  'plumtree' ),
						'id'         => 'box_type',
						'type'       => 'select',
						'std'        => 'regular',
						'options'    => array('regular' => 'Regular', 'hero' => 'Hero'),
						'tooltip'    => __( 'Set the box type',  'plumtree' ),
					),
					
					array(
						'id'      => 'pb_price',
						'name'    => __( 'Price',  'plumtree' ),
						'type'    => 'text_field',
						'class'   => 'jsn-input-small-fluid',
						'std'     => __( 'Price',  'plumtree' ),
						'tooltip' => __( 'Set the price',  'plumtree' )
					),
					
					array(
						'id'      => 'pb_currency',
						'name'    => __( 'Currency Sign',  'plumtree' ),
						'type'    => 'text_field',
						'class'   => 'jsn-input-small-fluid',
						'std'     => __( 'Currency Sign',  'plumtree' ),
						'tooltip' => __( 'Set the currency sign',  'plumtree' )
					),
					
					array(
						'id'      => 'pb_info',
						'name'    => __( 'Pricing Info',  'plumtree' ),
						'type'    => 'text_field',
						'class'   => 'jsn-input-medium-fluid',
						'std'     => __( 'Pricing Table Info',  'plumtree' ),
						'tooltip' => __( 'Set the pricing table info',  'plumtree' )
					),
					
					array(
						'id'      => 'pb_content',
						'role'    => 'content',
						'name'    => __( 'Content',  'plumtree' ),
						'type'    => 'editor',
						'rows'    => '12',
						'std'     => IG_Pb_Helper_Type::lorem_text(),
						'tooltip' => __( 'Set Content',  'plumtree' )
					),
					array(
						'name'    => __( 'Button Title',  'plumtree' ),
						'id'      => 'pb_button_title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => 'Button Title',
						'tooltip' => __( 'Set Button Title',  'plumtree' )
					),
					array(
						'name'       => __( 'Button Link',  'plumtree' ),
						'id'         => 'link_type',
						'type'       => 'select',
						'std'        => 'url',
						//'options'    => IG_Pb_Helper_Type::get_link_types(),
						'tooltip'    => __( 'Set the link to access',  'plumtree' ),
						'has_depend' => '1',
					),
					array(
						'name'       => __( 'URL',  'plumtree' ),
						'id'         => 'pb_button_url',
						'type'       => 'text_field',
						'class'      => 'jsn-input-xxlarge-fluid',
						'std'        => 'http://',
						'tooltip'    => __( 'URL of button link',  'plumtree' ),
						'dependency' => array( 'link_type', '=', 'url' )
					),
					/*array(
						'name'  => __( 'Single Item',  'plumtree' ),
						'id'    => 'single_item',
						'type'  => 'type_group',
						'std'   => '',
						'items' => IG_Pb_Helper_Type::get_single_item_button_bar(
							'link_type', array(
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
						'id'         => 'pb_button_open_in',
						'type'       => 'select',
						'std'        => IG_Pb_Helper_Type::get_first_option( IG_Pb_Helper_Type::get_open_in_options() ),
						'options'    => IG_Pb_Helper_Type::get_open_in_options(),
						'tooltip'    => __( 'Open in',  'plumtree' ),
						'dependency' => array( 'link_type', '!=', 'no_link' )
					),
				),
				'styling' => array(
					
					
					
					
					
					array(
						'name'    => __( 'Elements',  'plumtree' ),
						'id'      => 'elements',
						'type'    => 'items_list',
						'std'     => 'title__#__content__#__button',
						'options' => array(
							'title'   => __( 'Title',  'plumtree' ),
							'content' => __( 'Content',  'plumtree' ),
							'button'  => __( 'Button',  'plumtree' )
						),
						'options_type'    => 'checkbox',
						'popover_items'   => array( 'title', 'button' ),
						'tooltip'         => __( 'Select elements which you want to display in the promotion box',  'plumtree' ),
						'style'           => array( 'height' => '200px' ),
						'container_class' => 'unsortable',
					),
					
															
					
					
					
				)
			);
		}

		public function element_shortcode_full( $atts = null, $content = null ) {
			$html_element = '';
			$arr_params   = shortcode_atts( $this->config['params'], $atts );
			extract( $arr_params );
			$styles       = array();
			if ( $pb_bg_color ) {
				$styles[] = 'background-color:' . $pb_bg_color;
			}
			if ( intval( $pb_border_top ) > 0 ) {
				$styles[] = 'border-top-width:' . ( int ) $pb_border_top . 'px';
				$styles[] = 'border-top-style: solid';
			}
			if ( intval( $pb_border_left ) > 0 ) {
				$styles[] = 'border-left-width:' . ( int ) $pb_border_left . 'px';
				$styles[] = 'border-left-style: solid';
			}
			if ( intval( $pb_border_bottom ) > 0 ) {
				$styles[] = 'border-bottom-width:' . ( int ) $pb_border_bottom . 'px';
				$styles[] = 'border-bottom-style: solid';
			}
			if ( intval( $pb_border_right ) > 0 ) {
				$styles[] = 'border-right-width:' . ( int ) $pb_border_right . 'px';
				$styles[] = 'border-right-style: solid';
			}
			if ( $pb_border_color ) {
				$styles[] = 'border-color:' . $pb_border_color;
			}

			$elements = explode( '__#__', $elements );
			$class    = '';
			if ( $pb_show_drop == 'yes' ) {
				$class .= 'promo-box-shadow';
			}
			$single_item = explode( '__#__', $single_item );
			$single_item = $single_item[0];
			$script      = $cls_button_fancy = $target = $button = '';
			if ( in_array( 'button', $elements ) ) {
				$taxonomies = IG_Pb_Helper_Type::get_public_taxonomies();
				$post_types = IG_Pb_Helper_Type::get_post_types();
				// single post
				if ( array_key_exists( $link_type, $post_types ) ) {
					$permalink   = home_url() . "/?p=$single_item";
					$button_href = "href='{$permalink}'";
				}
				// taxonomy
				else if ( array_key_exists( $link_type, $taxonomies ) ) {
					$permalink = get_term_link( intval( $single_item ), $link_type );
					if ( ! is_wp_error( $permalink ) )
						$button_href = "href='{$permalink}'";
				}
				else {
					switch ( $link_type ) {
						case 'no_link':
							$button_href = '';
							break;
						case 'url':
							$button_href = "href='{$pb_button_url}'";
							break;
					}
				}

				if ( $pb_button_open_in AND $link_type != 'no_link' ) {
					switch ( $pb_button_open_in ) {
						case 'current_browser':
							$target = '';
							break;
						case 'new_browser':
							$target = ' target="_blank"';
							break;
						case 'lightbox':
							$cls_button_fancy = ' pt-pb-button-fancy';
							break;
					}
				}

				$pb_button_size = ( isset( $pb_button_size ) && $pb_button_size != 'default' ) ? $pb_button_size : '';
				$pb_button_color = ( isset( $pb_button_color ) && $pb_button_color != 'default' ) ? $pb_button_color : '';
				
			}
			$styles = implode( ';', $styles );
			//$styles = ( $styles ) ? "style='{$styles}'" : '';
			$html_element .= "<div class='pricing block {$box_type}'>";
			
			$html_element .= $button;
			if ( in_array( 'title', $elements ) ) {
				$html_element .= "<h5 class='title'>{$pb_title}</h5>";
			}
			$html_element .= "<span class=\"price-box\"><span class=\"price\"><span class=\"currency\">$pb_currency</span>	$pb_price</span><span class=\"rp\">$pb_info</span></span>";
			
			$content = ( ! $content ) ? '' : $content;
			if ( in_array( 'content', $elements ) )
				$html_element .= "<div class=\"features\">{$content}</div>";
			$html_element .= "<a {$target} href=\"{$button_href}\" class=\"button\">{$pb_button_title}</a>";
			
			$html_element .= '</div>';

			return $this->element_wrapper( $html_element . $script, $arr_params );
		}

	}

}