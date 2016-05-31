<?php
/**
 * The template for displaying Post Format pages.
 *
 * Used to display archive-type pages for posts with a post format.
 * If you'd like to further customize these Post Format views, you may create a
 * new template file for each specific one.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

get_header(); ?>

<div class="container-fluid">
	<div class="row-fluid">

		<section id="content" class="site-content span12" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title pt-page-title"><?php printf( __( '%s Archives', 'plumtree' ), '<span>' . get_post_format_string( get_post_format() ) . '</span>' ); ?></h1>
			</header><!-- .archive-header -->

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