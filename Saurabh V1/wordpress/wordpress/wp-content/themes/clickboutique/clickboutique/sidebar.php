<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */

?>

	<?php



		$current_layout = pt_get_post_layout( $post->ID );

		if ($current_layout === 'default') {
			if ( is_home() ) { $current_layout = get_option('blog_layout'); }
			if ( is_single() ) { $current_layout = get_option('single_layout'); }
			if ( is_page() ) { $current_layout = get_option('page_layout'); }
			if ( is_front_page() || is_page_template('front-page.php') ) { $current_layout = get_option('front_layout'); }
			if ( is_category() || is_tag() || is_tax() || is_archive() || is_search()  ) { $current_layout = get_option('archive_layout'); }
            if (class_exists('Woocommerce')) :
                if ( is_shop() ) {

                    $current_layout = get_option('shop_layout');
                    if ( isset($_GET['layout']) ) $current_layout = $_GET['layout'];

                }
			    if ( is_product() ) { $current_layout = get_option('product_layout'); }
            endif;
		}
		$sidebar_position = '';
		if ($current_layout === 'two-col-right') { $sidebar_position = 'right'; }
		if ($current_layout === 'two-col-left') { $sidebar_position = 'left'; }

	?>

    <?php if (class_exists('Woocommerce')) : ?>

	<?php
	if ( is_home() ||
	   ( is_single() && !is_product() ) ||
	   ( is_category() && !is_product_category() ) ||
	     is_tag() ||
	   ( is_tax() && !is_product_category() ) ||
	   ( is_archive() && !is_woocommerce() ) ||
	     is_search() ) : ?>

		<?php if ( is_active_sidebar( 'sidebar-blog' ) && ( $current_layout != 'one-col' ) ) : ?>
			<aside id="sidebar-blog" class="widget-area <?php echo $sidebar_position; ?>-sidebar span3" role="complementary">
				<?php dynamic_sidebar( 'sidebar-blog' ); ?>
			</aside>
		<?php endif; ?>

	<?php elseif ( is_front_page() || is_page_template('front-page.php') ) : ?>

		<?php if ( is_active_sidebar( 'sidebar-front' ) && ( $current_layout != 'one-col' ) ) : ?>
			<aside id="sidebar-front" class="widget-area <?php echo $sidebar_position; ?>-sidebar span3" role="complementary">
				<?php dynamic_sidebar( 'sidebar-front' ); ?>
			</aside>
		<?php endif; ?>

	<?php elseif ( is_page() ) : ?>

		<?php if ( is_active_sidebar( 'sidebar-pages' ) && ( $current_layout != 'one-col' ) ) : ?>
			<aside id="sidebar-pages" class="widget-area <?php echo $sidebar_position; ?>-sidebar span3" role="complementary">
				<?php dynamic_sidebar( 'sidebar-pages' ); ?>
			</aside>
		<?php endif; ?>

	<?php elseif ( is_shop() || is_product_category() ) : ?>

		<?php if ( is_active_sidebar( 'sidebar-shop' ) && ( $current_layout != 'one-col' ) ) : ?>
			<aside id="sidebar-shop" class="widget-area <?php echo $sidebar_position; ?>-sidebar span3" role="complementary">
				<?php dynamic_sidebar( 'sidebar-shop' ); ?>
			</aside>
		<?php endif; ?>

	<?php elseif ( is_product() ) : ?>

		<?php if ( is_active_sidebar( 'sidebar-product' ) && ( $current_layout != 'one-col' ) ) : ?>
			<aside id="sidebar-product" class="widget-area <?php echo $sidebar_position; ?>-sidebar span3" role="complementary">
				<?php dynamic_sidebar( 'sidebar-product' ); ?>
			</aside>
		<?php endif; ?>

	<?php endif; ?>

<?php else : ?>

        <?php if ( is_home() || is_single() || is_category() || is_tag() || is_tax() || is_archive()  || is_search() ) : ?>

            <?php if ( is_active_sidebar( 'sidebar-blog' ) && ( $current_layout != 'one-col' ) ) : ?>
                <aside id="sidebar-blog" class="widget-area <?php echo $sidebar_position; ?>-sidebar span3" role="complementary">
                    <?php dynamic_sidebar( 'sidebar-blog' ); ?>
                </aside>
            <?php endif; ?>

        <?php elseif ( is_front_page() || is_page_template('front-page.php') ) : ?>

            <?php if ( is_active_sidebar( 'sidebar-front' ) && ( $current_layout != 'one-col' ) ) : ?>
                <aside id="sidebar-front" class="widget-area <?php echo $sidebar_position; ?>-sidebar span3" role="complementary">
                    <?php dynamic_sidebar( 'sidebar-front' ); ?>
                </aside>
            <?php endif; ?>

        <?php elseif ( is_page() ) : ?>

            <?php if ( is_active_sidebar( 'sidebar-pages' ) && ( $current_layout != 'one-col' ) ) : ?>
                <aside id="sidebar-pages" class="widget-area <?php echo $sidebar_position; ?>-sidebar span3" role="complementary">
                    <?php dynamic_sidebar( 'sidebar-pages' ); ?>
                </aside>
            <?php endif; ?>

        <?php endif; ?>

<?php endif ?>
