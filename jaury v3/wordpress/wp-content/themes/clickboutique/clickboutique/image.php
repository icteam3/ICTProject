<?php
/**
 * The template for displaying image attachments.
 *
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
		<div class="spacer" <?php echo $spacer_bg; ?> data-stallar-background-ratio="0.5">
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">

					<?php  if ( get_option('posts_pagination') === 'on') { ?>

					<nav id="image-navigation" class="navigation image-navigation" role="navigation">
						<?php previous_image_link( false, __( '<i class="fa fa-angle-left"></i>&nbsp;&nbsp;&nbsp;Prev', 'plumtree' ) ); ?>
						<span class="separator">&nbsp;&nbsp;&nbsp;&frasl;&nbsp;&nbsp;&nbsp;</span>
						<?php next_image_link( false, __( 'Next&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>', 'plumtree' ) ); ?>
					</nav><!-- #image-navigation -->

					<?php }	?>

					</div>
				</div>
			</div>
		</div>

<div class="container-fluid">
	<div class="row-fluid">

		<section id="content" role="main" class="site-content span12"><!-- Main content -->

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>

				<div class="attachment">
					<?php pt_the_attached_image(); ?>
				</div>

				<div class="attachment-description">

					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">

						<?php if ( has_excerpt() ) : ?>
						<div class="entry-caption">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>

						<?php if ( ! empty( $post->post_content ) ) : ?>
						<div class="entry-description">
							<?php echo $post->post_content; ?>
						</div><!-- .entry-description -->
						<?php endif; ?>

					</div><!-- .entry-content -->

					<div class="entry-meta">
						<div class="date"><strong><?php _e('Date:&nbsp;&nbsp;&nbsp;', 'plumtree'); ?></strong><?php pt_entry_publication_time();?></div>
						<?php if ( $post->portfolio_filter ) { ?>
						<div class="tags"><strong><?php _e('Tags:&nbsp;&nbsp;&nbsp;', 'plumtree'); ?></strong><?php echo $post->portfolio_filter; ?></div>
						<?php }?>
						<div class="comments"><strong><?php _e('Comments:&nbsp;&nbsp;&nbsp;', 'plumtree'); ?></strong><?php pt_entry_comments_counter(); ?></div>
						<div class="source"><strong><?php _e('Source Image:&nbsp;&nbsp;&nbsp;', 'plumtree'); ?></strong><?php 
							$metadata = wp_get_attachment_metadata();
							printf( '<span class="attachment-meta full-size-link"><a href="%1$s" title="%2$s">%3$s (%4$s &times; %5$s)</a></span>',
								esc_url( wp_get_attachment_url() ),
								esc_attr__( 'Link to full-size image', 'plumtree' ),
								__( 'Full resolution', 'plumtree' ),
								$metadata['width'],
								$metadata['height']
							);
						 ?></div>
						<?php edit_post_link( __( 'Edit this Post', 'plumtree' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-meta -->

					<?php if ( function_exists( 'pusoc_add_post_content' ) ) { echo '<div class="share-btn">'; pusoc_add_post_content(); echo "</div>"; } ?>

				</div>

				<div class="clear"></div>

				<?php comments_template( '', true ); ?>

			</article><!-- #post -->

		</section>

		<?php get_sidebar(); ?>
	
	</div>
</div>

<?php get_footer(); ?>