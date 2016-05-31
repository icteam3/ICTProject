<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Plum_Tree
 * @since Plum Tree 0.1
 */
?>

<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php wp_title( '-', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	
	<div id="page" class="hfeed site"><!-- Site content -->

		<header id="masthead" class="site-header" role="banner"><!-- Site header -->

			<?php if ( is_active_sidebar( 'secondary-panel-sidebar-left' ) || is_active_sidebar( 'secondary-panel-sidebar-right' ) || has_nav_menu( 'secondary' ) ) : ?>
			<div class="secondary-panel-wrapper"><!-- Secondary pannel -->
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="span12 secondary-panel">
							<?php if ( is_active_sidebar( 'secondary-panel-sidebar-left' ) ) : ?>
								<div class="secondary-panel-sidebar left">
									<?php dynamic_sidebar( 'secondary-panel-sidebar-left' ); ?>
								</div>
							<?php endif; ?>
							<?php if ( is_active_sidebar( 'secondary-panel-sidebar-right' ) ) : ?>
								<div class="secondary-panel-sidebar right">
									<?php dynamic_sidebar( 'secondary-panel-sidebar-right' ); ?>
								</div>
							<?php endif; ?>
							<?php if (has_nav_menu( 'secondary' )) : ?>
								<nav class="desktop-menu visible-desktop visible-tablet secondary-menu" role="navigation">
									<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'plumtree' ); ?>"><?php _e( 'Skip to content', 'plumtree' ); ?></a>
									<?php  wp_nav_menu( array('theme_location'  => 'secondary', 'container' => false, 'items_wrap'=> '<ul id="%1$s" class=" sf-menu %2$s">%3$s</ul>', 'walker'  => new PTMenuWalker()) ); ?>
								</nav>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div><!-- Secondary pannel -->
			<?php endif; ?>
            <div id="mobile-area" class="hidden-desktop hidden-tablet">
            <?php if (class_exists('PT_Resmenu')) : ?>

                <div id="dl-menu" class="dl-menuwrapper hidden-desktop hidden-tablet">
                    <button><?php _e('Menu', 'plumtree') ?></button>
                    <?php  wp_nav_menu( array('theme_location'  => 'mobile', 'container' => false, 'items_wrap'=> '<ul id="%1$s" class="dl-menu %2$s">%3$s</ul>', 'walker'  => new PTMenuWalkerDL()) ); ?>
                </div>
                <script>
                    jQuery(function() {
                        jQuery( '#dl-menu' ).dlmenu( {
                            animationClasses : { classin : 'dl-animate-in-3', classout : 'dl-animate-out-3' }
                        });
                    });
                </script>
                <?php if ( is_active_sidebar( 'mobile-sidebar' ) ) : ?>
                    <div class="mobile-sidebar">
                        <?php dynamic_sidebar( 'mobile-sidebar' ); ?>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
            </div>
			<div class="logo-wrapper"><!-- Logo & hgroup -->
				<div class="container-fluid">
					<div class="row-fluid">
						<div class="span12">
							<?php if (get_option('site_logo')): ?>
								<hgroup class="header-group pos-<?php echo get_option('site_logo_position'); ?>">
									<div class="site-logo">
										<?php if ( !is_front_page() ) : ?>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
											<img src="<?php echo get_option('site_logo') ?>" alt="<?php bloginfo( 'description' ); ?>" />
										</a>
										<?php else : ?>
										<img src="<?php echo get_option('site_logo') ?>" alt="<?php bloginfo( 'description' ); ?>" />
										<?php endif; ?>
									</div>
								</hgroup>
							<?php else: ?>
								<hgroup class="header-group pos-<?php echo get_option('site_logo_position'); ?>">
									<h1 id="the-title" class="site-title">
										<?php if ( !is_front_page() ) : ?>
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
											<?php bloginfo( 'name' ); ?>
										</a>
										<?php else : bloginfo( 'name' ); endif; ?>
									</h1>
									<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
								</hgroup>
							<?php endif; ?>
                            <?php if (has_nav_menu('primary-aside') || is_active_sidebar( 'hgroup-sidebar' )) : ?>
                                <div id="aside-logo-container">
                                <?php if (has_nav_menu('primary-aside')) : ?><!-- Primary aside navigation -->
                                    <div class="aside-nav-wrapper">
                                        <nav id="site-navigation-aside" class="nav primary-aside span12" role="navigation">
                                            <a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'plumtree' ); ?>"><?php _e( 'Skip to content', 'plumtree' ); ?></a>
                                            <div class="desktop-menu visible-desktop visible-tablet main-menu">
                                                <?php  wp_nav_menu( array('theme_location'  => 'primary-aside', 'container' => false, 'items_wrap'=> '<ul id="%1$s" class=" sf-menu %2$s">%3$s</ul>', 'walker'  => new PTMenuWalker()) ); ?>
                                            </div>
                                        </nav>
                                    </div>
                                <?php endif; ?><!-- Primary aside navigation -->

                                <?php if ( is_active_sidebar( 'hgroup-sidebar' ) ) : ?>
                                    <div class="hgroup-sidebar hidden-phone">
                                        <?php dynamic_sidebar( 'hgroup-sidebar' ); ?>
                                    </div>
                                <?php endif; ?>
                                </div>
                            <?php endif; ?>


						</div>
					</div>
				</div>
			</div><!-- Logo & hgroup -->

			<?php if( has_nav_menu( 'bottom') || has_nav_menu( 'mobile') || is_active_sidebar( 'header-sidebar' ) ) : ?>
			<div class="bottom-nav-wrapper"><!-- Mobile & primary navigation -->
				<div class="container-fluid">
					<div class="row-fluid">

						<nav id="site-navigation" class="nav bottom-nav span9" role="navigation">
							
							<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'plumtree' ); ?>"><?php _e( 'Skip to content', 'plumtree' ); ?></a>
								
							<?php if (has_nav_menu( 'bottom')) :?>
							<div class="desktop-menu visible-desktop visible-tablet main-menu">
								<?php  wp_nav_menu( array('theme_location'  => 'bottom', 'container' => false, 'items_wrap'=> '<ul id="%1$s" class=" sf-menu %2$s">%3$s</ul>', 'walker'  => new PTMenuWalker()) ); ?>
							</div>
							<?php endif; ?>



						</nav><!-- #site-navigation -->

						<?php if ( is_active_sidebar( 'header-sidebar' ) ) : ?>
							<div class="header-sidebar visible-desktop visible-tablet span3">
								<?php dynamic_sidebar( 'header-sidebar' ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div><!-- Mobile & primary navigation -->
			<?php endif; ?>

		</header><!-- Site header -->
		<div id="main" class="wrapper"><!-- Main section wrapper -->
