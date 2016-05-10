<?php
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
if ( ! class_exists( 'IG_Ti_Text' ) ) {

	class IG_Ti_Text extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		function element_config() {
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['name']      = __( 'TI Text',  'plumtree' );
			$this->config['cat']       = __( 'Typography',  'plumtree' );
			$this->config['icon']      = 'icon-paragraph-text';

			$this->config['exception'] = array(
				'default_content' => __( 'Text',  'plumtree' ),
				'require_js'       => array( 'pt-colorpicker.js' ),
			);

            $this->config['edit_using_ajax'] = true;
		}

		/**
		 * setting option of element on modal box
		 */
		function element_items() {
			$this->items = array(
				'content' => array(
					array(
						'name'    => __( 'Element Title',  'plumtree' ),
						'id'      => 'el_title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => __( 'No Markup Text',  'plumtree' ),
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily',  'plumtree' )
					),
                    array(
                        'name'    => __( 'Image Type',  'plumtree' ),
                        'id'      => 'text_type',
                        'type'    => 'select',
                        'std'     => 'normal',
                        'options' => array(
                            'normal' => 'Regular Text',
                            'welc' => 'Welcome Text',
                            'qout' => 'Qoute'
                        ),
                        'tooltip' => __( 'Set alt text for image',  'plumtree' ),

                    ),
					array(
						'name' => __( 'Text Content',  'plumtree' ),
						'desc' => __( 'Enter some content for this textblock',  'plumtree' ),
						'id'   => 'text',
						'type' => 'editor',
						'role' => 'content',
                        'mce'  => false,
						'std'  => IG_Pb_Helper_Type::lorem_text(),
						'rows' => 15,
                        'tooltip' => __( 'Set content of element',  'plumtree' ),
					),

				),
				'styling' => array(
					array(
						'type' => 'preview',
					),
					array(
						'name'       => __( 'Enable Dropcap',  'plumtree' ),
						'id'         => 'enable_dropcap',
						'type'       => 'radio',
						'std'        => 'no',
						'options'    => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
						'tooltip'    => __( 'Enable Dropcap',  'plumtree' ),
						'has_depend' => '1',
					),
					array(
						'name' => __( 'Font Face',  'plumtree' ),
						'id'   => 'dropcap_font_family',
						'type' => array(
							array(
								'id'           => 'dropcap_font_face_type',
								'type'         => 'jsn_select_font_type',
								'class'        => 'input-medium',
								'std'          => 'standard fonts',
								'options'      => IG_Pb_Helper_Type::get_fonts(),
								'parent_class' => 'combo-item',
							),
							array(
								'id'           => 'dropcap_font_face_value',
								'type'         => 'jsn_select_font_value',
								'class'        => 'input-medium',
								'std'          => 'Verdana',
								'options'      => '',
								'parent_class' => 'combo-item',
							),
						),
						'dependency'      => array( 'enable_dropcap', '=', 'yes' ),
						'tooltip'         => __( 'Set Font Face',  'plumtree' ),
						'container_class' => 'combo-group',
					),
					array(
						'name' => __( 'Font Attributes',  'plumtree' ),
						'type' => array(
							array(
								'id'           => 'dropcap_font_size',
								'type'         => 'text_append',
								'type_input'   => 'number',
								'class'        => 'input-mini',
								'std'          => '64',
								'append'       => 'px',
								'validate'     => 'number',
								'parent_class' => 'combo-item',
							),
							array(
								'id'           => 'dropcap_font_style',
								'type'         => 'select',
								'class'        => 'input-medium',
								'std'          => 'bold',
								'options'      => IG_Pb_Helper_Type::get_font_styles(),
								'parent_class' => 'combo-item',
							),
							array(
								'id'           => 'dropcap_font_color',
								'type'         => 'color_picker',
								'std'          => '#000000',
								'parent_class' => 'combo-item',
							),
						),
						'dependency'      => array( 'enable_dropcap', '=', 'yes' ),
						'tooltip'         => __( 'Set Font Attribute',  'plumtree' ),
						'container_class' => 'combo-group',
					),
				)
			);
		}

		/**
		 * define shortcode structure of element
		 */
		function element_shortcode_full( $atts = null, $content = null ) {
			$arr_params = shortcode_atts( $this->config['params'], $atts );
			extract( $arr_params );
			$script = $html_element = '';
			if ( isset($enable_dropcap ) && $enable_dropcap == 'yes' ) {
				if ( $content ) {
					$styles = array();
					if ( $dropcap_font_face_type == 'google fonts' AND $dropcap_font_face_value != '' ) {
						$script  .= '<script type="text/javascript">(function ($) {$(document).ready(function () {
	$(\'head\').append("<link rel=\'stylesheet\' href=\'http://fonts.googleapis.com/css?family=' . $dropcap_font_face_value . '\' type=\'text/css\' media=\'all\' />");
});})(jQuery)</script>';
						$styles[] = 'font-family:' . $dropcap_font_face_value;
					} elseif ( $dropcap_font_face_type == 'standard fonts' AND $dropcap_font_face_value ) {
						$styles[] = 'font-family:' . $dropcap_font_face_value;
					}

					if ( intval( $dropcap_font_size ) > 0 ) {
						$styles[] = 'font-size:' . intval( $dropcap_font_size ) . 'px';
						$styles[] = 'line-height:' . intval( $dropcap_font_size ) . 'px';
					}
					switch ( $dropcap_font_style ) {
						case 'bold':
							$styles[] = 'font-weight:700';
							break;
						case 'italic':
							$styles[] = 'font-style:italic';
							break;
						case 'normal':
							$styles[] = 'font-weight:normal';
							break;
					}

					if ( strpos( $dropcap_font_color, '#' ) !== false ) {
						$styles[] = 'color:' . $dropcap_font_color;
					}

					if ( count( $styles ) ) {
						$html_element .= '<style type="text/css">';
						$html_element .= 'div.pt_text p.dropcap:first-letter { float:left;';
						$html_element .= implode( ';', $styles );
						$html_element .= '}';
						$html_element .= '</style>';
					}

					$html_element .= "<p class='dropcap'>{$content}</p>";
				}
			} else {
				$html_element .= '<p>' . $content . '</p>';
			}
			$html  = '<div class="pt_text '.$text_type.' ">';
			$html .= $script;
			$html .= do_shortcode($html_element);
			$html .= '</div>';

			return $this->element_wrapper( $html, $arr_params );
		}

	}

}