<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

get_header(); ?>

<?php if ( is_home() ) : 
	$blog_title = __('Blog', 'plumtree');
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
				<h1 class="spacer-title" data-stellar-ratio="0.93"><?php echo $blog_title; ?></h1>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="container-fluid">
	<div class="row-fluid">

		<?php 
		if (get_option('blog_isotope_layout') == 'grid' || get_option('blog_isotope_layout') == 'isotope' ) {
			 $custom_class = 'grid-layout';
		} else { $custom_class = ''; }
		?>

		<section id="content" class="site-content span12 <?php echo $custom_class;?>" role="main">
			<?php if ( have_posts() ) : ?>

				<?php if ( get_option('blog_isotope_layout') == 'isotope' ) : ?>
					<?php global $query_string; query_posts( $query_string . '&posts_per_page=-1' ); ?>

					<?php // Get isotope filters

					$filters = array();

					if ( get_option('blog_isotope_filters') == 'cats' ) : $filters = get_categories(); endif;
					if ( get_option('blog_isotope_filters') == 'tags' ) : $filters = get_tags(); endif;
                        
    				if (!empty($filters)) {
    					$output_filters = '<p class="grid-msg">'.__('Filter blog posts by:', 'plumtree').'</p>';
        				$output_filters .= '<ul data-isotope="filter" id="pt-blog-filters" class="filter"><li data-filter="*" class="selected"><a href="#">'.__('All', 'plumtree').'</a></li>';
				        foreach($filters as $filter){
				            $output_filters .= '<li data-filter="'.$filter->slug.'"><a href="#">'.$filter->name.'</a></li>';
				        }
				        $output_filters .= '</ul>';
				        echo $output_filters;
    				} ?>

					<div data-layout="masonry" data-isotope="container" class="isotope">
				<?php endif; ?>
				
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if ( get_option('blog_isotope_layout') == 'isotope' ) :  ?>
					<?php $cat_list = wp_get_post_categories( get_the_ID(), array('fields' => 'slugs')); ?>
					<?php $tag_list = wp_get_post_tags( get_the_ID(), array('fields' => 'slugs')); ?>

					<div data-element="<?php echo implode($cat_list, ' '); ?> <?php echo implode($tag_list, ' '); ?>"> <?php endif; ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php if ( get_option('blog_isotope_layout') == 'isotope' ) : ?> </div> <?php endif; ?>
				<?php endwhile; ?>
				
				<?php if ( get_option('blog_isotope_layout') == 'isotope' ) : ?> </div> <?php endif; ?>

				<?php global $wp_query;

				$blog_pagination = get_option('blog_pagination');
				if ( ($wp_query->max_num_pages > 1) && ($blog_pagination == 'getmore') ) : ?>
					<button class="pt-button pt-get-more-posts"><?php _e('Show More Posts', 'plumtree'); ?></button>

				<?php else : ?>
					<?php pt_content_nav(); ?>
				<?php endif; ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</section><!-- #content -->

		<?php get_sidebar(); ?>
		
	</div>
</div>

<?php get_footer(); ?>