<?php
/**
 * Template Name: Wide Page Template 
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

get_header(); ?>

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>

			    <?php 
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

				<section id="content" role="main" class="site-content"><!-- Main content -->


                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->

                <?php endwhile; ?>
            <?php endif; ?>

        </section><!-- Main content -->

<?php get_footer(); ?>


