<?php


if ( ! class_exists( 'IG_Recent_Posts' ) ) {

	class IG_Recent_Posts extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			parent::__construct();
		}

		public function element_config() {
			//$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['name']      = __( 'Recent Posts',  'plumtree' );
			$this->config['cat']       = __( 'Blog',  'plumtree' );
			$this->config['icon']      = 'icon-paragraph-text';
			$this->config['exception'] = array(
				'default_content'  => __( 'Recent Posts',  'plumtree' ),
				'data-modal-title' => __( 'Recent Posts',  'plumtree' ),
				
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
						'std'     => __( 'Recent Posts',  'plumtree' ),
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
			
			
			
			$atts = array('posts' => $number, 'order' => $order);
			
			$html_element = $this->the_shortcode($atts);
			
			return $this->element_wrapper( $html_element . $script, $arr_params );
		}
		
		
		function the_shortcode($atts, $content = null){
		
			global $more; $more = 0;
			
			$effect = (get_option('hover_effect') == '' ? 'circle' : get_option('hover_effect'));
			
			extract(shortcode_atts(array(
				'posts' => 3,
				'order' => 'DESC',
				'orderby' => 'date',
				'role' => 'meteor',
				'effect' => $effect
				), $atts));
			
			$html = '';
			
			if ($content) $html .= '<h2 class="title">'.$content.'</h2>';
			
			query_posts(array('orderby' => $orderby, 'order' => $order , 'showposts' => $posts, 'ignore_sticky_posts' => 1));
			
			if (have_posts()) :
				$html .= '<div class="posts grid">';
				while(have_posts()): the_post();
					
					$img = str_replace( '<img ', '<img '.(isset($role) ? ' data-role="'.$role.'" ' : '' ).'  '.(isset($effect) ? ' data-effect="'.$effect.'" ' : '').' ', get_the_post_thumbnail(get_the_ID(), 'grid-thumb', array('data-role' => 'meteor', 'data-effect'=>'circle')) );
					
					$html .= '<article class="post">';
					$html .= '<a href="'.get_permalink(get_the_ID()).'">'.$img.'</a>';
					$html .= '';
					$html .= '<header class="entry-header"><div class="entry-meta"><time class="entry-date" datetime="'.esc_attr( get_the_date( 'c' ) ).'">'.get_the_date('d.m', '', '', FALSE).'</time></div><h1 class="post-title"><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></h1></header>';
					$html .= '<div class="entry-content">'.get_the_content( __( 'Read More', 'plumtree' ) ).'</div>';
					$html .= '<footer class="entry-meta">'.get_the_category_list( __( ', ', 'plumtree' ) ).'</footer>';
					$html .= '';
					$html .= '</article>';
				endwhile;
				$html .= '</div>';
			 
			endif;
			wp_reset_query();
			//$html = 
			
			return $html;
		}
		
	}	

}