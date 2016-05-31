<?php
/**
 * The template for displaying posts in the Status post format
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if (get_option('blog_isotope_layout') == 'grid' || get_option('blog_isotope_layout') == 'isotope' ) { ?>

			<div class="entry-header">
				<header>
					<h1><?php the_author(); ?></h1>
					<?php if ( !is_singular() ) : ?>
					<h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'plumtree' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a></h2>
					<?php endif; ?>
				</header>
				<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'plumtree_status_avatar', '74' ) ); ?>
			</div><!-- .entry-header -->

			<div class="entry-meta-grid">
				<?php //pt_entry_publication_time(); ?>
				<?php pt_entry_author(); ?>
				<?php pt_entry_comments_counter(); ?>
				<?php pt_entry_post_cats(); ?>
			</div>

			<div class="entry-content">
				<?php the_content( apply_filters( 'pt_more', 'Continue Reading...') ); ?>				
				<?php wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			</div><!-- .entry-content -->

		<?php } else { // grid layout ends ?>
		
		<div class="entry-header">
			<header>
				<h1><?php the_author(); ?></h1>
				<?php if ( !is_singular() ) : ?>
				<h2><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'plumtree' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo get_the_date(); ?></a></h2>
				<?php endif; ?>
			</header>
			<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'plumtree_status_avatar', '74' ) ); ?>
		</div><!-- .entry-header -->

		<div class="entry-meta-top">

			<?php pt_entry_author(); ?>
			<?php pt_entry_post_cats(); ?>
			<?php pt_entry_comments_counter(); ?>
			<?php pt_entry_post_views(); ?>

		</div><!-- .entry-meta -->

		<div class="entry-content">
			<?php the_content( apply_filters( 'pt_more', 'Continue Reading...') ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .entry-content -->

		<div class="entry-meta-left">
			<?php pt_entry_publication_time(); ?>
			<?php pt_entry_post_format(); ?>
			<?php edit_post_link( __( '<i class="fa fa-pencil-square-o"></i>', 'plumtree' ), '<span class="edit-link" title="Edit this Post">', '</span>' ); ?>
		</div>

		<?php } ?>

	</article><!-- #post -->

	<?php if ( is_singular() ) : ?>
		<div class="entry-meta-bottom">
			<?php pt_entry_post_tags();?>
			<?php if ( function_exists( 'pusoc_add_post_content' ) ) { pusoc_add_post_content(); } ?>
		</div>
		<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
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
	<?php endif; ?>

