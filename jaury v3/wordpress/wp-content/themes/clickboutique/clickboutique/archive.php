<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
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
						<h1 class="spacer-title archive-title"><?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: %s', 'plumtree' ), '<span>' . get_the_date() . '</span>' );
							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: %s', 'plumtree' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'plumtree' ) ) . '</span>' );
							elseif ( is_year() ) :
								printf( __( 'Yearly Archives: %s', 'plumtree' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'plumtree' ) ) . '</span>' );
							else :
								_e( 'Archives', 'plumtree' );
							endif;
						?></h1>
					</div>
				</div>
			</div>

<div class="container-fluid">
	<div class="row-fluid">

		<section id="content" role="main" class="site-content span12"><!-- Main content -->

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