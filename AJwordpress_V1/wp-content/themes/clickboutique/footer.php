		</div><!-- Main section wrapper -->

		<?php if ( (get_option('blog_pagination') == 'getmore') && is_home() ) {
			$additional_margin = 'style="margin-top: 100px;"';
		} else { $additional_margin = ''; } ?>
		<footer id="colophon" role="contentinfo" class="row-fluid" <?php echo $additional_margin; ?>>

            <div class="container-fluid">
                <div class="row-fluid">

                    <div class="span3">
                        <?php if ( is_active_sidebar( 'footer-sidebar-1' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
                        <?php endif; ?>
                    </div>

                    <div class="span3">
                        <?php if ( is_active_sidebar( 'footer-sidebar-2' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-sidebar-2' ); ?>
                        <?php endif; ?>
                    </div>

                    <div class="span3">
                        <?php if ( is_active_sidebar( 'footer-sidebar-3' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-sidebar-3' ); ?>
                        <?php endif; ?>
                    </div>

                    <div class="span3">
                        <?php if ( is_active_sidebar( 'footer-sidebar-4' ) ) : ?>
                            <?php dynamic_sidebar( 'footer-sidebar-4' ); ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

			<div id="footer-bottom">
				<div class="container-fluid">
					<div class="row-fluid">

						<?php if (has_nav_menu('footer-navigation')) : ?><!-- Primary aside navigation -->
							<nav id="site-navigation-footer" class="nav footer-navigation span6" role="navigation">
								<div class="desktop-menu visible-desktop visible-tablet main-menu">
									<?php  wp_nav_menu( array('theme_location'  => 'footer-navigation', 'container' => false, 'items_wrap'=> '<ul id="%1$s" class=" sf-menu %2$s">%3$s</ul>', 'walker'  => new PTMenuWalker()) ); ?>
								</div>
							</nav>
						<?php endif; ?><!-- Primary aside navigation -->

						<div class="site-info span6">
							<?php echo $copyright = get_option('site_copyright'); ?>
						</div>

					</div>
				</div>
			</div>

		</footer><!-- Footer content -->

	</div><!-- Site content -->

<?php wp_footer(); ?>
</body>
</html>