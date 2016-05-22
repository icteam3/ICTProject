<?php


if ( ! class_exists( 'IG_Recent_Comments' ) ) {

	class IG_Recent_Comments extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		public function element_config() {
			//$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['name']      = __( 'Recent Comments',  'plumtree' );
			$this->config['cat']       = __( 'Blog',  'plumtree' );
			$this->config['icon']      = 'icon-paragraph-text';
			$this->config['exception'] = array(
				'default_content'  => __( 'Recent Comments',  'plumtree' ),
				'data-modal-title' => __( 'Recent Comments',  'plumtree' ),
				
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
						'std'     => __( 'Recent Comments',  'plumtree' ),
						'role'    => 'title',
						'tooltip' => __( 'Set title for current element for identifying easily',  'plumtree' )
					),
					
					array(
						'name'       => __( 'Items Order',  'plumtree' ),
						'id'         => 'cat_order',
						'type'       => 'select',
						'std'        => 'ASC',
						'options'    => array('ASC' => 'Asccending', 'DESC' => 'Desccending'),
						'tooltip'    => __( 'Set the box type',  'plumtree' ),
					),
					
					
					
					array(
						'name'       => __( 'Number of Items',  'plumtree' ),
						'id'         => 'items_number',
						'type'       => 'text_append',
						'type_input' => 'number',
						'std'        => '4',
						
						'tooltip'    => __( 'Set the items selection type',  'plumtree' ),
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
			
			$script      = $cls_button_fancy = $target = $button = '';
			
			
			
			$styles = implode( ';', $styles );
			//$styles = ( $styles ) ? "style='{$styles}'" : '';
			
			$elements = explode( '__#__', $elements );
			
			$order = $atts['cat_order'];
			$number = (int) $items_number;
			
			
			
			$atts = array('number' => $number, 'order' => $order);
			
			$html_element = $this->comments_short( $atts );
			
			return $this->element_wrapper( $html_element . $script, $arr_params );
		}
		
		
		function comments_short($attr){
		
			extract(shortcode_atts(array(
				'number'	=> '4'
			), $attr));
			
			$html = '';
			
			$recent_comments = get_comments( array(
			    'number'    => (int) $number,
			    'status'    => 'approve'
			) );
			
			if ($recent_comments){
				
				$html .= '<ul class="pt-recent-comments">';
				
				foreach($recent_comments as $comment) {
				
				
				$html .= '<li>'.$comment->comment_author.' <span class="pt-on">'.__('on', 'plumtree').'</span> <a href="'.get_permalink($comment->comment_post_ID).'">'.$comment->post_title.'</a></li>';
				
				}
				$html .= '</ul>';
				
			}
		
			return $html;
			
		}
		
	}	

}