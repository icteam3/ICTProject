<?php
/**
 * Template Name: Front Page Template Wide
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

        <section id="content" role="main" class="front-page site-content"><!-- Main content -->

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
                <?php endwhile; ?>
            <?php endif; ?>

            <?php // Widgets Area output
            if ( is_active_sidebar( 'front-page-widgets' ) ) : ?>
                <div class="container-fluid">
                    <div class="row-fluid front-page-widgets">
                        <div class="span12">
                            <?php dynamic_sidebar( 'front-page-widgets' ); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </section><!-- Main content -->

<?php get_footer(); ?>


