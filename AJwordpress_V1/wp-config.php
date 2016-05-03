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
define('AUTH_KEY',         '7wsk} `Z3UuZ<|$pyzmI9oMJ!ZMb$v#!*>Id_tDYI-Y]EsT;DV)Y(Ss]=>UK=7s8');
define('SECURE_AUTH_KEY',  '3?x7@x^w^;VYv^/:7HQoyk7v8`!f+l~ Kjk>;U38M7*oW=4%>n^b>+Jx2DWEbQ^h');
define('LOGGED_IN_KEY',    'ZqWWd-33MY*feJGT!1?ES>L|=0?,R4`^([g_mDdlj?DtoH5Y$X*!w=|N+lD}`Z=/');
define('NONCE_KEY',        'R>L(LrPJvh(sJu?gf.c|FV*e_@,J67}M*=B&=>8-N#u6C]?[(CCS0]B/}u`v>km;');
define('AUTH_SALT',        'r1o_xTf odE2xH*M;t5*RaU.]F%|{4PY#Ve7(ukl0CIy4Xxr/UzP2xFO.}V)Ll`G');
define('SECURE_AUTH_SALT', '(XFnI3SN*}1lZs~`u=%Fa}2vAk0u;{A-8JB`=3R)nqY]/n -{6J#oB#z@0uA>oJK');
define('LOGGED_IN_SALT',   '&G7!Fl5#+m>q_T![mIR(}7+oSgpmb2k!-(?.;rK#Ds2- uu]M(JrJ`0}A@1hSS%Y');
define('NONCE_SALT',       '&62T_v6c-ZyGnso;vl)cK{l|SjYH4cNN=[?@|0a1ewEHt;zvV*dh#R8F`e~opcI(');

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
