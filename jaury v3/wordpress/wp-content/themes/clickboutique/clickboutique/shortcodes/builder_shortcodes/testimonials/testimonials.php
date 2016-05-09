<?php

if ( ! class_exists( 'IG_Testimonials' ) ) {

	class IG_Testimonials extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode']        = strtolower( __CLASS__ );
			$this->config['name']             = __( 'Testimonials',  'plumtree' );
			$this->config['cat']              = __( 'Typography',  'plumtree' );
			$this->config['icon']             = 'icon-paragraph-text';
			$this->config['has_subshortcode'] = 'IG_Item_' . str_replace( 'IG_', '', __CLASS__ );
            $this->config['edit_using_ajax'] = true;
		}

		/**
		 * DEFINE setting options of shortcode
		 */
		public function element_items() {
			$this->items = array(

				'content' => array(
					array(
						'name'    => __( 'Element Title',  'plumtree' ),
						'id'      => 'el_title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => __( 'Testimonials',  'plumtree' ),
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily',  'plumtree' )
					),

                    array(
                        'name' => __( 'Testimonials Text',  'plumtree' ),
                        'desc' => __( 'Enter testimonials title',  'plumtree' ),
                        'id'   => 'test_text',
                        'type' => 'editor',
                        'std'  => '',
                        'mce' => false,
                        'rows' => 15,
                        'tooltip' => __( 'Set content of element',  'plumtree' ),
                    ),

					array(
						'id'            => 'testimonials_items',
						'type'          => 'group',
						'shortcode'     => ucfirst( __CLASS__ ),
						'sub_item_type' => $this->config['has_subshortcode'],
						'sub_items'     => array(
							array('std' => ''),
							array('std' => ''),
						),
					),
				),
				'styling' => array(
					array(
						'type' => 'preview',
					),


					array(
						'name'       => __( 'Autoplay',  'plumtree' ),
						'id'         => 'autoplay',
						'type'       => 'radio',
						'std'        => 'false',
						'options'    => array( 'true' => __( 'Yes',  'plumtree' ), 'false' => __( 'No',  'plumtree' ) ),
						'has_depend' => '1',
                        'tooltip' => __( 'Whether to running your carousel automatically or not',  'plumtree' ),
					),


					/*array(
						'name' => __( 'Cycling Interval',  'plumtree' ),
						'type' => array(
							array(
								'id'         => 'cycling_interval',
								'type'       => 'text_append',
								'type_input' => 'number',
								'class'      => 'input-mini',
								'std'        => '5',
								'append'     => 'second(s)',
								'validate'   => 'number',
							),
						),
						'dependency' => array('autoplay', '=', 'yes'),
                        'tooltip' => __( 'Set interval for each cycling',  'plumtree' ),
					),
					array(
						'name'       => __( 'Pause on mouse over',  'plumtree' ),
						'id'         => 'pause_mouseover',
						'type'       => 'radio',
						'std'        => 'yes',
						'options'    => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
						'dependency' => array( 'autoplay', '=', 'yes' ),
                        'tooltip' => __( 'Pause cycling on mouse over',  'plumtree' ),
					),*/
				)
			);
		}

		/**
		 * DEFINE shortcode content
		 *
		 * @param type $atts
		 * @param type $content
		 */
		public function element_shortcode_full( $atts = null, $content = null ) {
			$arr_params    = shortcode_atts( $this->config['params'], $atts );
			extract( $arr_params );
			$random_id     = uniqid();
			$testimonials_id   = "testimonials_$random_id";

			$interval_time = ! empty( $cycling_interval ) ? intval( $cycling_interval ) * 1000 : 5000;
			$interval      = @( $automatic_cycling == 'yes' ) ? $interval_time : 'false';
			$pause         = @( $pause_mouseover == 'yes' ) ? 'pause : "hover"' : '';
			$script        = "";
			
			

			$testimonials_indicators   = array();
			$testimonials_indicators[] = '<ol class="testimonials-indicators">';

			$sub_shortcode         = IG_Pb_Helper_Shortcode::remove_autop( $content );
			$items                 = explode( '<!--seperate-->', $sub_shortcode );
			$items                 = array_filter( $items );
			$initial_open          = isset( $initial_open ) ? ( ( $initial_open > count( $items ) ) ? 1 : $initial_open ) : 1;
			foreach ( $items as $idx => $item ) {
				$active                = ($idx + 1 == $initial_open) ? 'active' : '';
				$item                  = str_replace( '{active}', $active, $item );
				$item                  = @str_replace( '{WIDTH}', 'width : '. $dimension_width . $dimension_width_unit .';', $item );
				$item                  = @str_replace( '{HEIGHT}', 'height : '. $dimension_height .'px;', $item );
				$items[$idx]           = $item;
				$active_li             = ($idx + 1 == $initial_open) ? "class='active'" : '';
                $testimonials_indicators[] = "<li data-target='#$testimonials_id'></li>";
			}
			$testimonials_content      = "" . implode( '', $items ) . '';


			$html = "<div class=\"testimonials\"><div class=\"test-welcome\"><div class=\"cont\">".$test_text."</div></div>
				    <div class=\"test-cont\">
				        <ul data-slider=\"ios\" data-infinite=\"true\" data-drag=\"true\" data-autoplay=\"$autoplay\" data-info=\"false\" data-height=\"100\" id=\"$testimonials_id\" class=\"v-slider\">
				            $testimonials_content
				        </ul>
				    </div>
				 </div>";

			return $this->element_wrapper( $html . $script, $arr_params );
		}

	}

} 