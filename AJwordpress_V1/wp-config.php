<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', 'C:\xampp\htdocs\wordpress\wp-content\plugins\wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'ict_wp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '%OmH|e?(LzEj@o1[]r`IzXRKHTroojl?vD$4 Bl,IaN~msN0?`z2^5srU<ikg4?n');
define('SECURE_AUTH_KEY',  'q5SMh?VGxM3@]OL_5-+gX:;4^qM%!E{BM.ZqFgl[Szn4 xsb$vl/P%OR/A:z/WPw');
define('LOGGED_IN_KEY',    'ke1_@+BKPD/ws}d18u-}k8|zPn{#osGepdJW!W,0 a#*N]:aE1J5,-B}0&)@Tm|%');
define('NONCE_KEY',        'LK<52Rel&)u t{ilYk$l^+/V1l]e9<#y*8,d;|}l/ $r<-a%)&4*.<6X%wG+8`xD');
define('AUTH_SALT',        '+!mRJT8GK*q UgK80eP4cJM~[AxM qwZuaCak!qUoJN{O,!8>Z0aU1~JFiyKSkt:');
define('SECURE_AUTH_SALT', '/4K2.33lUiZ&+KhWhID?Mb@b2{T/C:gA6bh;7U]+fNpxB^/?7]Svbe[j1$UbFT5<');
define('LOGGED_IN_SALT',   'H~|4=`,5[->bn`_&)E3S[j>TmTt}aW-}v>B*vMhip2LMYTO14?zdAG9{$[8&3DHg');
define('NONCE_SALT',       '&pzytQ7*rs+VE&)Zku3RRNsMpMc<3`-Z1ra#&5?]U|EF^aYFqV4%#j[/-FQ6.)u~');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
