<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

get_header(); ?>

	<?php if ( is_single() ) : 
		if ( (get_option('blog_spacer_bg_color') != '') && (get_option('blog_spacer_bg_color') != '#fff') ) {
			$spacer_bg = 'style="background:'.get_option('blog_spacer_bg_color').';"';
		} elseif ( get_option('blog_spacer_custom_pattern') != '' ) {
			$spacer_bg = 'style="background: url('.get_option('blog_spacer_custom_pattern').') repeat;"';
		} else {
			$spacer_bg = 'style="background: url('.get_template_directory_uri().'/assets/spacer-'.get_option('blog_spacer_default_pattern').'.png) repeat;"';
		}
	?>
		<div class="spacer" <?php echo $spacer_bg; ?> data-stellar-background-ratio="0.5">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">

					<?php if ( get_option('post_breadcrumbs') === 'on') : pt_blog_breadcrumbs(); endif;?>
					<?php  if ( get_option('posts_pagination') === 'on') : pt_post_nav(); endif;	?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

<div class="container-fluid">
	<div class="row-fluid">

	<section id="content" class="site-content span12" role="main"><!-- Main content -->

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', get_post_format() ); ?>

			<?php pt_related_posts(); ?>

			<?php comments_template( '', true ); ?>

		<?php endwhile; // end of the loop. ?>

	</section><!-- Main content -->

	<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>