<?php
/**
 * The template for displaying Author Archive pages.
 *
 * Used to display archive-type pages for posts by an author.
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
						<h1 class="spacer-title archive-title"><?php printf( __( 'Author Archives: %s', 'plumtree' ), get_the_author() ); ?></h1>
					</div>
				</div>
			</div>

<div class="container-fluid">
	<div class="row-fluid">

		<section id="content" role="main" class="site-content span12"><!-- Main content -->

			<?php
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
			?>

			<?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
			?>

			<?php
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>

				<div class="author-info">
					<div class="author-avatar">
						<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'plumtree_author_bio_avatar_size', 60 ) ); ?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2 class="author-title pt-content-title"><?php printf( __( 'About %s', 'plumtree' ), get_the_author() ); ?></h2>
						<p class="author-bio">
							<?php the_author_meta( 'description' ); ?>
							<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'plumtree' ), get_the_author() ); ?>
							</a>
						</p>
					</div><!-- .author-description -->
				</div><!-- .author-info -->

			<?php endif; ?>

			<?php /* Start the Loop */ ?>
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
