<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */
?>

<?php 
if (get_option('blog_isotope_layout') == 'grid' || get_option('blog_isotope_layout') == 'isotope' ) {
	$thumb = 'grid-thumb';
} else { $thumb = 'full'; }
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php if (get_option('blog_isotope_layout') == 'grid' || get_option('blog_isotope_layout') == 'isotope' ) { ?>

			<header class="entry-header">
				
				<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
					<div class="thumbnail-wrapper">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Click to read more about %s', 'plumtree' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
						<?php the_post_thumbnail( $thumb ); ?>
						</a>
					</div>
				<?php endif; // Post Thumbnail ?>

				<h1 class="entry-title pt-article-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Click to read more about %s', 'plumtree' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			</header>

			<div class="entry-meta-grid">
				<?php pt_entry_publication_time(); ?>
				<?php pt_entry_author(); ?>
				<?php pt_entry_comments_counter(); ?>
				<?php pt_entry_post_cats(); ?>
			</div>

			<div class="entry-content">
				<?php the_content( apply_filters( 'pt_more', 'Continue Reading...') ); ?>
			</div><!-- .entry-content -->

		<?php } else { // grid layout ends ?>
		
		<header class="entry-header">

			<?php if ( is_single() ) : // For Single Post view ?>
				
				<h1 class="entry-title pt-article-title"><?php the_title(); ?></h1>

			<?php elseif ( is_search() ) : // Search Results
				$title = get_the_title();
  				$keys = explode(" ",$s);
  				$title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $title);
			?>
				<h1 class="entry-title pt-article-title">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Click to read more about %s', 'plumtree' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php echo $title; ?></a>
				</h1>

			<?php else : // For Blog Page & Archive Page ?>

				<?php $title = get_the_title();
				if ( empty($title) || $title = '' ) { 
					$output = '<h1 class="entry-title pt-article-title">';
					$output .= '<a href="'.get_permalink().'" title="'.__( 'Click here to read more', 'plumtree' ).'" rel="bookmark">'. __( 'Click here to read more', 'plumtree' ).'</a>';
					$output .= '</h1>'; 
					echo $output;
				} else { ?>

					<h1 class="entry-title pt-article-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Click to read more about %s', 'plumtree' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

				<?php } ?>

			<?php endif; // is_single() ?>

		</header>

		<div class="entry-meta-top">

			<?php pt_entry_author(); ?>
			<?php pt_entry_post_cats(); ?>
			<?php pt_entry_comments_counter(); ?>
			<?php pt_entry_post_views(); ?>

		</div><!-- .entry-meta -->

		<?php if ( is_search() ) : // Only display Excerpts for Search 
  			$excerpt = get_the_excerpt();
  			$keys = explode(" ",$s);
  			$excerpt = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-excerpt">\0</strong>', $excerpt);
		?>

		<div class="entry-summary">
			<?php echo $excerpt; ?>
		</div><!-- .entry-summary -->

		<?php else : ?>
		<div class="entry-content">

			<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
				<div class="thumbnail-wrapper"><?php the_post_thumbnail( $thumb ); ?></div>
			<?php endif; // Post Thumbnail ?>

			<?php the_content( apply_filters( 'pt_more', 'Continue Reading...') ); ?>

			<?php wp_link_pages( array( 'before' => '<div class="page-links">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

		</div><!-- .entry-content -->
		<?php endif; ?>

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
