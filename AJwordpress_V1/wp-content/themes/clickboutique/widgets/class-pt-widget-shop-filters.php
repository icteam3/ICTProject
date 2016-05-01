<?php
/**
 * Plumtree Shop Filters
 *
 * Shop filters output widget.
 *
 * @author TransparentIdeas
 * @package Plum tree
 * @subpackage Widgets
 * @since 0.01
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'widgets_init', create_function( '', 'register_widget( "pt_shop_filters_widget" );' ) );

class pt_shop_filters_widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
	 		'pt_shop_filters_widget', // Base ID
			__('PT Shop Filters', 'plumtree'), // Name
			array('description' => __( "Plum Tree special widget. Woocommerce shop filters based on attributes of your products.", "plumtree" ), ) 
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => '',
			'show-count' => false,
			'show-select' => false,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title: ', 'plumtree' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'attribute' ); ?>"><?php _e( 'Attribute:', 'plumtree' ) ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'attribute' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'attribute' ) ); ?>">
				<?php
				$attribute_taxonomies = wc_get_attribute_taxonomies();
				if ( $attribute_taxonomies )
					foreach ( $attribute_taxonomies as $tax )
						if ( taxonomy_exists( wc_attribute_taxonomy_name( $tax->attribute_name ) ) )
							echo '<option value="' . $tax->attribute_name . '" ' . selected( ( isset( $instance['attribute'] ) && $instance['attribute'] == $tax->attribute_name ), true, false ) . '>' . $tax->attribute_label . '</option>';
				?></select>
		</p>

		<p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show-count'); ?>" name="<?php echo $this->get_field_name('show-count'); ?>"<?php checked( (bool) $instance['show-count'] ); ?> />
            <label for="<?php echo $this->get_field_id('show-count'); ?>"><?php _e( 'Show products count?', 'plumtree' ); ?></label>
        </p>

        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('show-select'); ?>" name="<?php echo $this->get_field_name('show-select'); ?>"<?php checked( (bool) $instance['show-select'] ); ?> />
            <label for="<?php echo $this->get_field_id('show-select'); ?>"><?php _e( 'Show filters as select with options?', 'plumtree' ); ?></label>
        </p>

	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['attribute'] = stripslashes( $new_instance['attribute'] );
		$instance['show-count'] = $new_instance['show-count'];
		$instance['show-select'] = $new_instance['show-select'];
		return $instance;
	}

	public function widget($args, $instance) {

		global $woocommerce, $wp_query, $_chosen_attributes;

		extract($args);

		if ( ! is_post_type_archive( 'product' ) && ! is_tax( get_object_taxonomies( 'product' ) ) )
			return;

		$current_term 	= is_tax() ? get_queried_object()->term_id : '';
		$current_tax 	= is_tax() ? get_queried_object()->taxonomy : '';

		$title 			= apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
		$taxonomy 		= isset( $instance['attribute'] ) ? wc_attribute_taxonomy_name($instance['attribute']) : '';
		$taxonomy_label	= $instance['attribute'];
		$show_count     = ( isset($instance['show-count']) ? $instance['show-count'] : false );
		$show_select    = ( isset($instance['show-select']) ? $instance['show-select'] : false );

		if ( ! taxonomy_exists( $taxonomy ) )
			return;

		$terms = get_terms( $taxonomy, array( 'hide_empty' => '1' ) );

		// Get id's of displayed products
		$product_list = $wp_query->get_posts(); 
		$product_ids = array();
		foreach ($product_list as $product) {
		   $product_ids[] += $product->ID;
		}

		// Output data
		if ( count( $terms ) == 0 ) {
			echo $before_widget;
			echo '<p>'.__('No attributes specified', 'plumtree').'</p>';
			echo $after_widget;
		}
		elseif ( count( $terms ) > 0 ) {

			echo $before_widget;

			$container_class = '';
			if ( $show_select ) {
				$container_class = ' select-styled';
			}

			echo '<div class="product-filters'.$container_class.'">';

			if ( !empty( $title ) ) {
				echo $before_title . $title . $after_title;
			}
			$str = mb_strtolower($taxonomy_label);

			if ( $show_select ) {
				echo '<select data-isotope="filter" class="filter '.$str.'">';
				echo '<option value="*">All</option>';						
			} else {
				echo '<ul data-isotope="filter" class="filter '.$str.'">';
				echo '<li data-filter="*" class="selected"><span class="bullet">&nbsp;</span>All</li>';						
			}

			foreach ( $terms as $term ) {

				// Get count based on current view - uses transients
				$transient_name = 'wc_ln_count_' . md5( sanitize_key( $taxonomy ) . sanitize_key( $term->term_taxonomy_id ) );
				if ( false === ( $_products_in_term = get_transient( $transient_name ) ) ) {
					$_products_in_term = get_objects_in_term( $term->term_id, $taxonomy );
					set_transient( $transient_name, $_products_in_term, YEAR_IN_SECONDS );
				}
				$count = sizeof( array_intersect( $_products_in_term, $product_ids ) );

				if ( $count > 0 ) {
					if ( $show_select ) {
						echo '<option value="'.$term->slug.'">'.$term->name;
						if ($show_count) {
							echo ' ('.$count.')';
						}
						echo '</option>';
					} else {
						if (!$show_count) { $additioal_class = ' grid'; } else { $additioal_class = ''; }
						echo '<li class="'.$term->slug.''.$additioal_class.'" data-filter="'.$term->slug.'">';
						echo '<span class="bullet">&nbsp;</span>';
						echo '<span>'.$term->name.'</span>';
						if ($show_count) {
							echo '<span class="counter">'.$count.'</span>';
						}
						echo '</li>';	
					}
				}

			}

			if ( $show_select ) {
				echo '</select>';
			} else {
				echo '</ul>';
			}

			echo '</div>';

			echo $after_widget;

		}

	}
}
