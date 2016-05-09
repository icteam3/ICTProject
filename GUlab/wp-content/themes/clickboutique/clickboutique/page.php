<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

get_header(); ?>
			
<?php while ( have_posts() ) : the_post(); ?>

	<?php if ( is_page() ) : 
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
					<h1 class="spacer-title" data-stellar-ratio="0.93"><?php the_title(); ?></h1>
				</div>
			</div>
		</div>
	<?php endif; ?>

<div class="container-fluid">
	<div class="row-fluid">

		<section id="content" role="main" class="site-content span12"><!-- Main content -->

			<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
				<div class="thumbnail-wrapper">
					<?php the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			</div><!-- .entry-content -->

		<?php endwhile; ?>

		</section><!-- Main content -->

	<?php get_sidebar(); ?>
	</div>
</div>

<?php get_footer(); ?>