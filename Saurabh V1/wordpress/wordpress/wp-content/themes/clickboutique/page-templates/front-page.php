<?php
/**
 * Template Name: Front Page Template
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

<div class="container-fluid">
    <div class="row-fluid">

    	<section id="content" role="main" class="front-page site-content span12"><!-- Main content -->

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
                <?php endwhile; ?>
            <?php endif; ?>

            <?php // Widgets Area output
            if ( is_active_sidebar( 'front-page-widgets' ) ) : ?>
                <div class="row-fluid front-page-widgets">
                    <?php dynamic_sidebar( 'front-page-widgets' ); ?>
                </div>
            <?php endif; ?>

    	</section><!-- Main content -->

        <?php get_sidebar('front'); ?>
    </div>
</div>

<?php get_footer(); ?>
