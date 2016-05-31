<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
exit();

delete_option( 'h5abCustomExternal' );
delete_option( 'h5abCustomStyling' );
delete_option( 'h5abCustomStylingTheme' );
delete_post_meta_by_key( 'h5abMetaStylingExternal' );
delete_post_meta_by_key( 'h5abMetaStylingData' );

?>
