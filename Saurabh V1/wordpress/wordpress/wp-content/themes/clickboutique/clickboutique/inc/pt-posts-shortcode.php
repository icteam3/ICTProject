<?php // Recent Posts shortcode

function pt_recent_posts_shortcode($atts, $content = null){

	extract(shortcode_atts( array(
		'posts_qty' => '5',
 	), $atts ) );

	$the_query = new WP_Query(
		array( 
			'orderby' => 'date',
			'order' => 'DESC',
			'post_type' => 'post',
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $posts_qty,
		)
	);

	// Excerpt filters
	$new_excerpt_more = create_function('$more', 'return "&nbsp;[....]";');	
	add_filter('excerpt_more', $new_excerpt_more);

	$new_excerpt_length = create_function('$length', 'return 16;');
	add_filter('excerpt_length', $new_excerpt_length);

	ob_start();

	echo '<div class="pt-from-blog-section shortcode-with-slider">';

	echo '<div class="head-wrap"><div class="cell" id="pt-from-blog">';
	if ($content) { echo '<h3 class="pt-shortcode-title">'.$content.'</h3>'; }
	echo '<div class="sep"></div></div></div>';
		
	echo '<ul id="from-blog-ul" class="recent-posts" data-slider="ios" data-info="true" data-parent-controls="#pt-from-blog" >';

	while( $the_query->have_posts() ) : $the_query->the_post(); ?>

	<?php $post_title = strip_tags( get_the_title( $post->ID ) ); ?>

			<li class="recent-post-item" data-item="ios">

					<?php if ( has_post_thumbnail() ) : ?>
						<a class="recent-posts-img-link" rel="bookmark" href="<?php the_permalink(); ?>" title="Click to learn more about <?php echo $post_title; ?>">
							<div class="thumbnail-wrapper"><?php the_post_thumbnail('shortcode-thumb-short'); ?></div>
						</a>
					<?php endif; // Post Thumbnail ?>

					<div class="description">
						<h4>
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Click to learn more about <?php echo $post_title; ?>"><?php the_title(); ?></a>
						</h4>

						<div class="recent-posts-entry-content">
							<?php  the_excerpt(); ?>
						</div>

						<div class="recent-posts-entry-meta">
							<div class="post-date"><?php the_time('M jS, Y'); ?><span class="post-author"> by <?php the_author_posts_link(); ?></span></div><div>&nbsp;|&nbsp;</div>
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="Click to learn more about <?php echo $post_title; ?>"><?php _e('Read More', 'plumtree'); ?></a>
						</div>
					</div>

			</li>

<?php 
	endwhile;
	wp_reset_query();
	echo '</ul></div>';

	$content = ob_get_contents();
	ob_end_clean();
	return $content;

}

add_shortcode('pt-from-blog', 'pt_recent_posts_shortcode');

