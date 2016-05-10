<?php
/**
 * The template for displaying posts in the Chat post format.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if (get_option('blog_isotope_layout') == 'grid' || get_option('blog_isotope_layout') == 'isotope' ) { ?>

			<header class="entry-header">
				
				<?php if ( is_single() ) : ?>
				<h1 class="entry-title pt-article-title"><?php the_title(); ?></h1>
				<?php else : ?>
				<h1 class="entry-title pt-article-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h1>
				<?php endif; // is_single() ?>

			</header>

			<div class="entry-meta-grid">
				<?php pt_entry_publication_time(); ?>
				<?php pt_entry_author(); ?>
				<?php pt_entry_comments_counter(); ?>
				<?php pt_entry_post_cats(); ?>
			</div>

			<div class="entry-content">
				<?php the_content( apply_filters( 'pt_more', 'Continue Reading...') ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			</div><!-- .entry-content -->

		<?php } else { // grid layout ends ?>

		<header class="entry-header">
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title pt-article-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title pt-article-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->

		<div class="entry-meta-top">

			<?php pt_entry_author(); ?>
			<?php pt_entry_post_cats(); ?>
			<?php pt_entry_post_tags(); ?>
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
