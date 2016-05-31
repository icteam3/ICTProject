<?php


if ( ! class_exists( 'IG_Category_Items' ) ) {

	class IG_Category_Items extends IG_Pb_Shortcode_Parent {

		public function __construct() {
			//parent::__construct();
		}

		public function element_config() {
			//$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['shortcode'] = strtolower( __CLASS__ );
			$this->config['name']      = __( 'Category Items',  'plumtree' );
			$this->config['cat']       = __( 'WooCommerce',  'plumtree' );
			$this->config['icon']      = 'icon-paragraph-text';
			$this->config['exception'] = array(
				'default_content'  => __( 'Category Items',  'plumtree' ),
				'require_js'       => array('catslider', 'catslider-init'),
				'data-modal-title' => __( 'Category Items',  'plumtree' )
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
						'std'     => __( 'Category Items',  'plumtree' ),
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
						'name'       => __( 'Items Selection',  'plumtree' ),
						'id'         => 'itemselection',
						'type'       => 'select',
						'std'        => 'featured',
						'options'    => array(
								'featured' => 'Fetured Products',
								'top_rated' => 'Top Rated Products',
								'random' => 'Random Products',
								'recent' => 'Recent Products',
								'bestsellers' => 'Bestselling Products'
				
							),
						'tooltip'    => __( 'Set the items selection type',  'plumtree' ),
					),
					
					array(
						'name'       => __( 'Number of Items',  'plumtree' ),
						'id'         => 'items_number',
						'type'       => 'text_append',
						'type_input' => 'number',
						'std'        => '4',
						
						'tooltip'    => __( 'Set the items selection type',  'plumtree' ),
					),
					
					array(
						'name'       => __( 'Category Items Mode',  'plumtree' ),
						'id'         => 'items_mode',
						'type'       => 'select',
						'std'        => 'defaulat',
						'options'    => array(
								'default' => 'Default',
								'slider' => 'Slider'
				
							),
						'tooltip'    => __( 'Set the items display mode',  'plumtree' ),
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
			$itemselection = $atts['itemselection'];
			$limit = (int) $items_number;
			$mode = $atts['items_mode'];
			
			
			$atts = array('number' => $number, 'order' => $order, 'itemselection' => $itemselection, 'limit' => $limit, 'mode' => $mode);
			
			$html_element = $this->categoryitems_short($atts);

			return $this->element_wrapper( $html_element . $script, $arr_params );
		}
		
		public function print_scripts_styles(){
				wp_enqueue_script( 'catslider', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/js/jquery.catslider.js', array('jquery'), '1.1', true);
				wp_enqueue_script( 'catslider-init', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/js/helper.js', array('jquery'), '1.1', true);
				wp_enqueue_style( 'catslider', get_template_directory_uri() .''.str_replace(str_replace('\\', '/', get_template_directory()), '',str_replace('\\', '/', __DIR__)).'/css/style.css');
			}
		
		public function categoryitems_short( $atts ) {
				global $woocommerce_loop, $woocommerce;
		
				extract( shortcode_atts( array (
					'number'     => 4,
					'orderby'    => 'name',
					'order'      => 'ASC',
					'columns' 	 => '4',
					'hide_empty' => 1,
					'parent'     => '',
					'itemselection' => 'featured',
					'limit' => 4,
					'mode' => ''
					), $atts ) );
		
				if ( isset( $atts[ 'ids' ] ) ) {
					$ids = explode( ',', $atts[ 'ids' ] );
				  	$ids = array_map( 'trim', $ids );
				} else {
					$ids = array();
				}
				
				$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;
		
				// get terms and workaround WP bug with parents/pad counts
			  	$cat_args = array(
			  		'orderby'    => $orderby,
			  		'order'      => $order,
			  		'hide_empty' => $hide_empty,
					'include'    => $ids,
					'pad_counts' => true,
					'child_of'   => $parent
				);
		
			  	$product_categories = get_terms( 'product_cat', $cat_args );
		
			  	if ( $parent !== "" )
			  		$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		
			  	if ( $number )
			  		$product_categories = array_slice( $product_categories, 0, $number );
		
			  	$woocommerce_loop['columns'] = $columns;
			  	
			  	$this->print_scripts_styles();
			  	
			  	ob_start();
			  	
				$html = '<nav>';
				
			  	if ( $product_categories ) {
				  	
				  	echo '<div class="main">
							<div '.($mode == 'slider' ? ' ' : ' id="mi-slider" class="mi-slider" ').' >';
							if ($mode == 'slider') echo '<ul data-slider="ios" class="ios-products">';
					foreach ( $product_categories as $category ) {
						$html .= '<a href="#">'.$category->name.'</a>';
						if ($mode != 'slider') echo '<ul>';
						$this->products($category->slug, $itemselection, array('per_page' => $limit, 'mode' => $mode, 'cat_name' => $category->name));	
						if ($mode != 'slider') echo '</ul>';
					}
					
					$html .= '</nav>';
					
					if ($mode != 'slider') echo $html;
					if ($mode == 'slider') echo '</ul>';
					echo '	
						</div>
					</div>';
				}
				return '<div class="woocommerce">' . ob_get_clean() . '</div>';
			}
			
			public function products( $cat_slug, $_query, $atts = array()  ) {
				
				global $woocommerce_loop, $woocommerce;
				
				extract(shortcode_atts(array(
					'per_page' 	=> '-1',
					'orderby' => 'date',
					'order' => 'desc',
					'mode' => '',
					'cat_name' => ''
				), $atts));
				
				
		
				
				switch($_query){
					case 'featured':
						$meta = array(
							'key' => '_featured',
							'value' => 'yes');
						break;
					case 'top_rated': 
						add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
						$meta = $woocommerce->query->get_meta_query();
						break;
					case 'random': 
						
						if ( isset($instance) && (!$instance['show_variations']) ) {
							$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
							$query_args['post_parent'] = 0;
						}
						
						$query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
						$query_args['meta_query']   = array_filter( $query_args['meta_query'] );
						$meta = $woocommerce->query->get_meta_query();
						break;
					
					case 'recent':
						
						$meta[] = $woocommerce->query->stock_status_meta_query();
					break;
					case 'bestsellers':
						$meta = array(
							'key'     => '_price',
						    'value'   => 0,
						    'compare' => '>',
						    'type'    => 'DECIMAL'); 
					    break;
					default: break;
				}
				
				
				$args = array(
					'post_type'	=> 'product',
					'post_status' => 'publish',
					'ignore_sticky_posts'	=> 1,
					'product_cat' => $cat_slug,
					'posts_per_page' => $per_page,
					'orderby' => $orderby,
					'order' => $order,
					'meta_query' => array(
						array(
							'key' => '_visibility',
							'value' => array('catalog', 'visible'),
							'compare' => 'IN'
						), 
						
						$meta
						
					)
				);
		
		
				$products = new WP_Query( $args );
				
				if ( $products->have_posts() ) { 
		
					 while ( $products->have_posts() ) : $products->the_post();
		
						   global $product;
						   
						   if ( ! $product->is_visible() ) continue; 		
						   ?>
						   		<li <?php echo ($mode == 'slider' ? 'data-item="ios"' : '' ); ?> >
						   			<div class="item-product">
							   			<a href="<?php the_permalink() ?>" class="catitem-thumb">
							   				<?php if ( $mode == 'slider') echo woocommerce_get_product_thumbnail('homepage-thumb'); else echo woocommerce_get_product_thumbnail(); ?>
							   			</a>
							   			<div class="item-panel">
							   				<div class="item-cont">
								   				<?php if ($mode == 'slider') : ?> <div class="item-cat"><?php echo $cat_name; ?></div> <?php endif; ?>
									   			<a href="<?php the_permalink() ?>" class="item-title"><?php the_title(); ?></a>
									   			<span class="price"><?php echo $product->get_price_html(); ?></span>
									   			<a href="<?php the_permalink() ?>" class="button"><?php _e('View', 'plumtree'); ?></a>
							   				</div>
							   				<?php if ($mode == 'slider') : ?> <div class="dumm"></div> <?php endif; ?>
							   			</div>
							   			
						   			</div>
						   		</li>
						   <?php
						   
					 endwhile;
		
				 }
		
				wp_reset_postdata();
				
			}

	}

}