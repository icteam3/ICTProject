<?php

if ( ! class_exists( 'IG_Contact' ) ) :

class IG_Contact extends IG_Pb_Shortcode_Parent {

	public function __construct() {
		parent::__construct();
	}


	/**
	 * Configure shortcode.
	 *
	 * @return  void
	 */
	public function element_config() {
		$this->config['shortcode'] = strtolower( __CLASS__ );
		$this->config['name'] = __( 'Contacts Image', 'plumtree' );
		$this->config['cat'] = __( 'Extra', 'plumtree' );
		$this->config['icon'] = 'icon-paragraph-text';
		$this->config['has_subshortcode'] = 'IG_Item_' . str_replace( 'IG_', '', __CLASS__ );
        $this->config['edit_using_ajax'] = true;

	}

	/**
	 * Define shortcode settings.
	 *
	 * @return  void
	 */
	public function element_items() {
		$this->items = array(
			'content' => array(
				array(
					'name'    => __( 'Element Title', 'plumtree' ),
					'id'      => 'el_title',
					'type'    => 'text_field',
					'class'   => 'input-sm',
					'std'     => __( 'Contacts', 'plumtree' ),
					'role'    => 'title',
					'tooltip' => __( 'Set title for current element for identifying easily', 'plumtree' )
				),
				array(
					'name'    => __( 'Image File', 'plumtree' ),
					'id'      => 'image_file',
					'type'    => 'select_media',
					'std'     => '',
					'class'   => 'jsn-input-large-fluid',
					'tooltip' => __( 'Choose image', 'plumtree' )
				),
				array(
					'name'          => __( 'Buttons', 'plumtree' ),
					'id'            => 'button_items',
					'type'          => 'group',
					'shortcode'     => ucfirst( __CLASS__ ),
					'sub_item_type' => $this->config['has_subshortcode'],
					'sub_items'     => array(
						array( 'std' => '' ),
					),
					'tooltip' 		=> __( 'Add social network to your contact', 'plumtree' )
				),

			),
			'styling' => array(
				/*array(
					'type' => 'preview',
				),*/
				/*array(
					'name'    => __( 'Container Style', 'plumtree' ),
					'id'      => 'image_container_style',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => IG_Pb_Helper_Type::get_first_option( IG_Pb_Helper_Type::get_container_style() ),
					'options' => IG_Pb_Helper_Type::get_container_style(),
					'tooltip' => __( 'Set Container Style', 'plumtree' )
				),*/
				/*array(
					'name'    => __( 'Alignment', 'plumtree' ),
					'id'      => 'image_alignment',
					'type'    => 'select',
					'class'   => 'input-sm',
					'std'     => IG_Pb_Helper_Type::get_first_option( IG_Pb_Helper_Type::get_text_align() ),
					'options' => IG_Pb_Helper_Type::get_text_align(),
					'tooltip' => __( 'Setting position: right, left, center, inherit parent style', 'plumtree' )
				),*/
				array(
					'name'            => __( 'Margin', 'plumtree' ),
					'container_class' => 'combo-group',
					'id'              => 'image_margin',
					'type'            => 'margin',
					'extended_ids'    => array( 'image_margin_top', 'image_margin_right', 'image_margin_bottom', 'image_margin_left' ),
						'tooltip'             => __( 'Set margin size', 'plumtree' )
				),
			)
		);
	}

	/**
	 * Generate HTML code from shortcode content.
	 *
	 * @param   array   $atts     Shortcode attributes.
	 * @param   string  $content  Current content.
	 *
	 * @return  string
	 */
	public function element_shortcode_full( $atts = null, $content = null ) {
		$arr_params     = shortcode_atts( $this->config['params'], $atts );
		extract( $arr_params );

		$html_elemments = $script = '';

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


		if ( $image_file ) {

			$html_elemments .= "<div class='contact-img-wrapper {$image_container_style}'>";

			$image_id       = IG_Pb_Helper_Functions::get_image_id( $image_file );
			$attachment     = wp_prepare_attachment_for_js( $image_id );
			$image_file     = ( ! empty( $attachment['sizes'][$image_size]['url'] ) ) ? $attachment['sizes'][$image_size]['url'] : $image_file;
			$html_elemments .= "<img src='{$image_file}'{$alt_text}{$styles}{$class_img} />";
			$script         = '';
			$target         = '';

			$sub_shortcode  = IG_Pb_Helper_Shortcode::remove_autop( $content );
			$items          = explode( '<!--seperate-->', $sub_shortcode );
			$items          = array_filter( $items );

			if ($items) {
				$buttons    = "" . implode( '', $items ) . '';
				$html_elemments .=  "<div class='btns-wrapper'><div class='contact-btns'>"
									.$buttons.
									"</div><div class='vertical-helper'></div></div>";
			}

			$html_elemments .= '</div>';

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

endif;
