<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

get_header(); ?>

	<?php 
		if ( (get_option('blog_spacer_bg_color') != '') && (get_option('blog_spacer_bg_color') != '#fff') ) {
			$spacer_bg = 'style="background:'.get_option('blog_spacer_bg_color').';"';
		} elseif ( get_option('blog_spacer_custom_pattern') != '' ) {
			$spacer_bg = 'style="background: url('.get_option('blog_spacer_custom_pattern').') repeat;"';
		} else {
			$spacer_bg = 'style="background: url('.get_template_directory_uri().'/assets/spacer-'.get_option('blog_spacer_default_pattern').'.png) repeat;"';
		}
	?>

	<div class="spacer" <?php echo $spacer_bg; ?>>
		<div class="container-fluid">
			<div class="row-fluid">
				<h1 class="spacer-title archive-title"><?php _e( 'SEARCH', 'plumtree' ); ?></h1>
			</div>
		</div>
	</div>


<div class="container-fluid">
	<div class="row-fluid">

		<section id="content" class="site-content span12" role="main">

		<?php global $query_string;
			  query_posts( $query_string . "&s=$s" . '&posts_per_page=5' );
			  $key = esc_html($s);
				if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title pt-content-title"><?php printf( __( 'Search Results for: %s', 'plumtree' ), get_search_query() ); ?></h1>
			</header>

			<?php get_search_form(); ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php pt_content_nav(); ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</section><!-- #content -->

	<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>