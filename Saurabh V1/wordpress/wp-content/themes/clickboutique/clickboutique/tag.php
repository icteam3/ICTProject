<?php
/**
 * The template for displaying Tag pages.
 *
 * Used to display archive-type pages for posts in a tag.
 *
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

get_header(); ?>

		<?php if ( have_posts() ) : ?>

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
						<h1 class="spacer-title archive-title"><?php printf( __( 'Tag Archives: %s', 'plumtree' ), single_tag_title( '', false ) ); ?></h1>
					</div>
				</div>
			</div>

<div class="container-fluid">
	<div class="row-fluid">

		<section id="content" role="main" class="site-content span12"><!-- Main content -->

			<?php if ( tag_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo tag_description(); ?></div>
			<?php endif; ?>


			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'content', get_post_format() );

			endwhile;

			pt_content_nav();
			
			?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</section><!-- #content -->

	<?php get_sidebar(); ?>

	</div>
</div>

<?php get_footer(); ?>

