<?php

if ( ! class_exists( 'IG_Carousel' ) ) {

	class IG_Carousel extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		/**
		 * DEFINE configuration information of shortcode
		 */
		public function element_config() {
			$this->config['shortcode']        = strtolower( __CLASS__ );
			$this->config['name']             = __( 'Carousel',  'plumtree' );
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
				/*'action' => array(
					array(
						'id'      => 'btn_convert',
						'type'    => 'button_group',
						'bound'   => 0,
						'actions' => array(
							array(
								'std'         => __( 'Tab',  'plumtree' ),
								'action_type' => 'convert',
								'action'      => 'carousel_to_tab',
							),
							array(
								'std'         => __( 'Accordion',  'plumtree' ),
								'action_type' => 'convert',
								'action'      => 'carousel_to_accordion',
							),
							array(
								'std'         => __( 'List',  'plumtree' ),
								'action_type' => 'convert',
								'action'      => 'carousel_to_list',
							),
						)
					),
				),*/
				'content' => array(
					array(
						'name'    => __( 'Element Title',  'plumtree' ),
						'id'      => 'el_title',
						'type'    => 'text_field',
						'class'   => 'jsn-input-xxlarge-fluid',
						'std'     => __( 'Carousel',  'plumtree' ),
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily',  'plumtree' )
					),
					array(
						'id'            => 'carousel_items',
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
						'name'    => __( 'Alignment',  'plumtree' ),
						'id'      => 'align',
						'type'    => 'select',
						'std'     => 'center',
						'options' => IG_Pb_Helper_Type::get_text_align(),
						'tooltip' => __( 'Setting position: right, left, center, inherit parent style',  'plumtree' )
					),
					array(
						'name'                 => __( 'Dimension',  'plumtree' ),
						'container_class'      => 'combo-group',
						'id'                   => 'dimension',
						'type'                 => 'dimension',
						'extended_ids'         => array( 'dimension_width', 'dimension_height', 'dimension_width_unit' ),
						'dimension_width'      => array( 'std' => '' ),
						'dimension_height'     => array( 'std' => '' ),
						'dimension_width_unit' => array(
							'options' => array( 'px' => 'px', '%' => '%' ),
							'std'     => 'px',
						),
                        'tooltip' => __( 'Set width and height of element',  'plumtree' ),
					), /*
					array(
						'name'    => __( 'Show Indicator',  'plumtree' ),
						'id'      => 'show_indicator',
						'type'    => 'radio',
						'std'     => 'yes',
						'options' => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
                        'tooltip' => __( 'Show/hide navigation buttons inside your carousel',  'plumtree' ),
					),
					array(
						'name'    => __( 'Show Arrows',  'plumtree' ),
						'id'      => 'show_arrows',
						'type'    => 'radio',
						'std'     => 'yes',
						'options' => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
                        'tooltip' => __( 'Show/hide arrow buttons',  'plumtree' ),
					),*/
					array(
						'name'       => __( 'Autoplay',  'plumtree' ),
						'id'         => 'autoplay',
						'type'       => 'radio',
						'std'        => 'false',
						'options'    => array( 'true' => __( 'Yes',  'plumtree' ), 'false' => __( 'No',  'plumtree' ) ),
						'has_depend' => '1',
                        'tooltip' => __( 'Whether to running your carousel automatically or not',  'plumtree' ),
					),
					
					array(
						'name'       => __( ' Type',  'plumtree' ),
						'id'         => 'car_mode',
						'type'       => 'select',
						'std'        => 'block',
						'options'    => array('block' => 'Block', 'inline' => 'Inline'),
						'tooltip'    => __( 'Set the carousel mode',  'plumtree' ),
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
						'dependency' => array('automatic_cycling', '=', 'yes'),
                        'tooltip' => __( 'Set interval for each cycling',  'plumtree' ),
					),
					array(
						'name'       => __( 'Pause on mouse over',  'plumtree' ),
						'id'         => 'pause_mouseover',
						'type'       => 'radio',
						'std'        => 'yes',
						'options'    => array( 'yes' => __( 'Yes',  'plumtree' ), 'no' => __( 'No',  'plumtree' ) ),
						'dependency' => array( 'automatic_cycling', '=', 'yes' ),
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
			$random_id     = IG_Pb_Utils_Common::random_string();
			$carousel_id   = "carousel_$random_id";

			$interval_time = ! empty( $cycling_interval ) ? intval( $cycling_interval ) * 1000 : 5000;
			$interval      = ( $automatic_cycling == 'yes' ) ? $interval_time : 'false';
			$pause         = ( $pause_mouseover == 'yes' ) ? 'pause : "hover"' : '';
			$script        = "";

			/*$styles        = array();
			if ( ! empty( $dimension_width ) )
				$styles[] = "width : {$dimension_width}{$dimension_width_unit};";
			if ( ! empty( $dimension_height ) )
				$styles[] = "height : {$dimension_height}px;";

			if ( in_array( $align, array( 'left', 'right', 'inherit') ) ) {
				$styles[] = "float : $align;";
			} else if ( $align == 'center' )
				$styles[] = 'margin : 0 auto;';

			$styles = trim( implode( ' ', $styles ) );
			$styles = ! empty( $styles ) ? "style='$styles'" : '';

			*/
			
			
			
			$carousel_indicators   = array();
			$carousel_indicators[] = '<ol class="carousel-indicators">';

			$sub_shortcode         = IG_Pb_Helper_Shortcode::remove_autop( $content );
			$items                 = explode( '<!--seperate-->', $sub_shortcode );
			$items                 = array_filter( $items );
			$initial_open          = isset( $initial_open ) ? ( ( $initial_open > count( $items ) ) ? 1 : $initial_open ) : 1;
			foreach ( $items as $idx => $item ) {
				$active                = ($idx + 1 == $initial_open) ? 'active' : '';
				$item                  = str_replace( '{active}', $active, $item );
				$item                  = str_replace( '{WIDTH}', 'width : '. $dimension_width . $dimension_width_unit .';', $item );
				$item                  = str_replace( '{HEIGHT}', 'height : '. $dimension_height .'px;', $item );
				$items[$idx]           = $item;
				$active_li             = ($idx + 1 == $initial_open) ? "class='active'" : '';
				$carousel_indicators[] = "<li data-target='#$carousel_id' data-slide-to='$idx' $active_li></li>";
			}
			$carousel_content      = "" . implode( '', $items ) . '';



			
		
		
			$html = "<div class='content-carousel' $styles id='$carousel_id'> 
				 <div class=\"slider\" data-slider=\"ios\" data-autoplay=\"$autoplay\" data-mode=\"$car_mode\"   ".( $dimension_width != "" ? "data-width=\"$dimension_width\"" : "" )." ".( $dimension_height != "" ? "data-height=\"$dimension_height\"" : "").">
				 $carousel_content
				 </div>
				 </div>";

			return $this->element_wrapper( $html . $script, $arr_params );
		}

	}

} 