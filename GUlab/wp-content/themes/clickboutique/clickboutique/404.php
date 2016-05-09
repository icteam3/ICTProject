<?php
/**
 * The template for displaying 404 pages (Not Found).
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
				<h1 class="spacer-title archive-title"><?php _e( 'Not found', 'plumtree' ); ?></h1>
			</div>
		</div>
	</div>

<div class="container-fluid">
	<div class="row-fluid">

	<section id="content" class="site-content span12" role="main">

		<article id="post-0" class="post error404 no-results not-found">

			<header class="entry-header">
				<h2 class="pt-content-title"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'plumtree' ); ?></h2>
			</header>

			<div class="entry-content">
				<p style="font-size:18px;padding-bottom:20px;"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'plumtree' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
			
		</article><!-- #post-0 -->

	</section><!-- #content -->

	</div>
</div>

<?php get_footer(); ?>