<?php
/**
 * Plumtree Recent Posts/Products
 *
 * Configurable recent posts/products output widget.
 *
 * @author TransparentIdeas
 * @package Plum tree
 * @subpackage Widgets
 * @since 0.01
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'widgets_init', create_function( '', 'register_widget( "pt_recent_post_widget" );' ) );

class pt_recent_post_widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
	 		'pt_recent_post_widget', // Base ID
			__('PT Recent Posts', 'plumtree'), // Name
			array('description' => __( "Plum Tree special widget. Displaying number of recent posts on your site.", "plumtree" ), ) 
		);
	}

	public function form($instance) {
		$defaults = array(
			'title' => 'Recent Posts',
			'post-quantity' => 5,
			'post-type' => 'post',
			'sort-by' => 'date',
			'sort-order' => false,  // DESC 
			'date' => false,
			'comments' => false,
			'category' => '',
			'thumb' => false,
			'excerpt' => false,
			'excerpt-length' => 10,
			'excerpt-more' => '...read more',
			'price' => false,
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title: ', 'plumtree' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('post-quantity'); ?>"><?php _e( 'How many posts to display: ', 'plumtree' ) ?></label>
			<input size="3" id="<?php echo esc_attr( $this->get_field_id('post-quantity') ); ?>" name="<?php echo esc_attr( $this->get_field_name('post-quantity') ); ?>" type="number" value="<?php echo esc_attr( $instance['post-quantity'] ); ?>" />
		</p>
		<p>
            <label for="<?php echo $this->get_field_id('post-type'); ?>"><?php _e('Show Posts for next Post Type:', 'plumtree');?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('post-type'); ?>" name="<?php echo $this->get_field_name('post-type'); ?>">
                <?php
                    global $wp_post_types;
                    $post_type = isset($instance['post-type']) ? strip_tags($instance['post-type']) : 'post';
                    foreach($wp_post_types as $k=>$sa) {
                        if($sa->exclude_from_search) continue;
                        echo '<option value="'.$k.'"' .selected($k,$post_type).'>'.$sa->labels->name.'</option>';
                    }
                ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("sort-by"); ?>"><?php _e('Sort by:', 'plumtree'); ?></label>
        	<select class="widefat" id="<?php echo $this->get_field_id("sort-by"); ?>" name="<?php echo $this->get_field_name("sort-by"); ?>">
          		<option value="date" <?php selected( $instance["sort-by"], "date" ); ?>>Date</option>
          		<option value="title" <?php selected( $instance["sort-by"], "title" ); ?>>Title</option>
          		<option value="comment_count" <?php selected( $instance["sort-by"], "comment_count" ); ?>>Number of comments</option>
				<option value="author" <?php selected( $instance["sort-by"], "author" ); ?>>Author</option>
				<option value="menu_order" <?php selected( $instance["sort-by"], "menu_order" ); ?>>Menu Order (if specified only for pages)</option>
           		<option value="rand" <?php selected( $instance["sort-by"], "rand" ); ?>>Random</option>
        	</select>
        </p>
        <p>
    	    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("sort-order"); ?>" name="<?php echo $this->get_field_name("sort-order"); ?>" <?php checked( (bool) $instance["sort-order"] ); ?> />
            <label for="<?php echo $this->get_field_id("sort-order"); ?>"><?php _e( 'Reverse sort order (ascending)?', 'plumtree' ); ?></label>
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php checked( (bool) $instance["date"] ); ?> />
            <label for="<?php echo $this->get_field_id("date"); ?>"><?php _e( 'Show publish date?', 'plumtree' ); ?></label>
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comments"); ?>" name="<?php echo $this->get_field_name("comments"); ?>"<?php checked( (bool) $instance["comments"] ); ?> />
            <label for="<?php echo $this->get_field_id("comments"); ?>"><?php _e( 'Show number of comments?', 'plumtree' ); ?></label>
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e( 'Specify ID of category (categories) to show: ', 'plumtree' ) ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('category') ); ?>" name="<?php echo esc_attr( $this->get_field_name('category') ); ?>" type="text" value="<?php echo esc_attr( $instance['category'] ); ?>" />
		</p>              
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("thumb"); ?>" name="<?php echo $this->get_field_name("thumb"); ?>"<?php checked( (bool) $instance["thumb"] ); ?> />
            <label for="<?php echo $this->get_field_id("thumb"); ?>"><?php _e( 'Show post thumbnail?', 'plumtree' ); ?></label>
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>" name="<?php echo $this->get_field_name("excerpt"); ?>"<?php checked( (bool) $instance["excerpt"] ); ?> />
            <label for="<?php echo $this->get_field_id("excerpt"); ?>"><?php _e( 'Show post excerpt?', 'plumtree' ); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("excerpt-length"); ?>"><?php _e( 'Excerpt length (in words):', 'plumtree' ); ?></label>
            <input type="text" id="<?php echo $this->get_field_id("excerpt-length"); ?>" name="<?php echo $this->get_field_name("excerpt-length"); ?>" value="<?php echo esc_attr( $instance['excerpt-length'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id("excerpt-more"); ?>"><?php _e( 'Excerpt read more text:', 'plumtree' ); ?></label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id("excerpt-more"); ?>" name="<?php echo $this->get_field_name("excerpt-more"); ?>" value="<?php echo esc_attr( $instance['excerpt-more'] ); ?>" size="10" />
        </p>
        <p>
            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("price"); ?>" name="<?php echo $this->get_field_name("price"); ?>"<?php checked( (bool) $instance["price"] ); ?> />
            <label for="<?php echo $this->get_field_id("price"); ?>"><?php _e( 'Show price? (products only)', 'plumtree' ); ?></label>
        </p>
	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post-quantity'] = intval( $new_instance['post-quantity'] );
		$instance['post-type'] = strip_tags( $new_instance['post-type'] );
		$instance['sort-by'] = strip_tags( $new_instance['sort-by'] );
		$instance['sort-order'] = $new_instance['sort-order'];
		$instance['date'] = $new_instance['date'];
		$instance['comments'] = $new_instance['comments'];
		$instance['category'] = strip_tags( $new_instance['category'] );
		$instance['thumb'] = $new_instance['thumb'];
		$instance['excerpt'] = $new_instance['excerpt'];
		$instance['excerpt-length'] = absint( $new_instance['excerpt-length'] );
		$instance['excerpt-more'] = strip_tags( $new_instance['excerpt-more'] );
		$instance['price'] = $new_instance['price'];

		return $instance;
	}

	public function widget($args, $instance) {
		extract($args);
		global $wpdb, $post;

		$title = apply_filters('widget_title', $instance['title'] );
		$post_num = ( isset($instance['post-quantity']) ? $instance['post-quantity'] : 5 );
		$post_type = ( isset($instance['post-type']) ? $instance['post-type'] : 'post' );
		$sort_by = ( isset($instance['sort-by']) ? $instance['sort-by'] : 'date' );
		$sort_order = ( isset($instance['sort-order']) ? $instance['sort-order'] : false );

			if ($sort_order) { $order = 'ASC'; } else { $order = 'DESC'; }

		$show_date = ( isset($instance['date']) ? $instance['date'] : false );
		$show_comments = ( isset($instance['comments']) ? $instance['comments'] : false );
		$categories = ( isset($instance['category']) ? $instance['category'] : '' );
		$show_excerpt = ( isset($instance['excerpt']) ? $instance['excerpt'] : false );
		$excerpt_length = ( isset($instance['excerpt-length']) ? $instance['excerpt-length'] : 10 );
		$excerpt_more = ( isset($instance['excerpt-more']) ? $instance['excerpt-more'] : '...read more' );

			// Excerpt filters
			$new_excerpt_more = create_function('$more', 'return " ";');	
			add_filter('excerpt_more', $new_excerpt_more);

			$new_excerpt_length = create_function('$length', 'return "'.$excerpt_length.'";');
				if ( $excerpt_length > 0 ) add_filter('excerpt_length', $new_excerpt_length);

		$show_thumb = ( isset($instance['thumb']) ? $instance['thumb'] : false );
		$show_price = ( isset($instance['price']) ? $instance['price'] : false );
		$cur_postID = $post->ID;
         
        // The Query
        $query_args = array (
        	'ignore_sticky_posts' => 1,
			'posts_per_page' => $post_num,
			'orderby' => $sort_by,
			'order' => $order,
			'post_type' => $post_type,
			'post_status' => 'publish',
			'cat' => $categories
		);

		$the_query = new WP_Query( $query_args );

		echo $before_widget;
		if ($title) { echo $before_title . $title . $after_title; }

		echo '<ul class="recent-post-list">';
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			
			// Frontend Output
			?> 
			<li class="recent-post-item">

				<?php if ( $show_thumb && has_post_thumbnail() ) : ?>
				<div class="thumb-wrapper">
					<a class="recent-posts-img-link" rel="bookmark" href="<?php the_permalink(); ?>" title="Click to learn more about <?php the_title(); ?>">
						<?php the_post_thumbnail('shortcode-thumb-short'); ?>
					</a>
				</div>
				<?php endif; // Post Thumbnail ?>

				<h4>
					<a href="<?php the_permalink(); ?>" class="nav-button" rel="bookmark" title="Click to learn more about <?php the_title(); ?>"><?php the_title(); ?></a>
				</h4>

				<?php if ($show_date || $show_comments) : ?>
				<div class="recent-posts-entry-meta">

					<?php if ($show_date) :?>
						<div class="post-date"><?php the_time('F jS, Y'); ?><span class="post-author"> by <?php the_author_posts_link(); ?></span></div>
					<?php endif; // Post Date & Author ?>

					<?php if ($show_comments) :?>
						<div class="comments-qty"><?php comments_popup_link( 'No comments yet', '1 comment', '% comments', 'comments-link', 'Comments are off for this post'); ?></div>
					<?php endif; // Post Comments ?>

				</div>
				<?php endif; ?>

				<?php if ($show_excerpt) : ?>
				<div class="recent-posts-entry-content"><?php the_excerpt(); ?>
					<a href="<?php the_permalink(); ?>" class="more-link" rel="bookmark" title="Read more about <?php the_title(); ?>"><?php echo $excerpt_more; ?></a>
				</div> 
				<?php endif; // Post Content ?>

				<?php
				if ( $show_price && ($post_type != 'product') ) {
					continue;
				} else {
					if ( $post_type === 'product' ) :
						echo '<div class="product-price">'; 
						woocommerce_template_single_price();  
						echo '</div>'; // Product Price if WOO
					elseif ( $post_type === 'wpsc-product' ) :
						echo '<div class="product-price">'; 
						wpsc_the_product_price_display();  
						echo '</div>'; // Product Price if WPEC
					else : continue; 
					endif; 
				}?>

			</li>
		<?php
		endwhile;
		echo '</ul>';
		echo $after_widget;
		wp_reset_postdata();
	}
}
?>
