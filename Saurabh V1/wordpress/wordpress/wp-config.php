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
define('AUTH_KEY',         '4BNTADOS3MX`r4:DaFOEHv*3;F5L+AXvO}*pzny^}|A|gFrFXLeM|F,~bPHW/wQ=');
define('SECURE_AUTH_KEY',  'V:SB`E]6L N3fk0s6*N$lN|CAG%alEK[F^7P4KsoH!uTj}JS51Z|ilEO,%TTI/KV');
define('LOGGED_IN_KEY',    'U{XrKu2oThvV,KxwU@&lbHL0AUCy!475X6_e7w8q#:T@VUuR$N|S L{NBY~@Gh4C');
define('NONCE_KEY',        'y=108~%@)*;F.^sM4_vTYsE3[[b@i(DO[B.GE7452=z5*+>;7-?b<&R?Cf[}){.O');
define('AUTH_SALT',        '7 @sf83s3Q_||#*Y9;d9pa4()wiXK8t7~.O.wG^&a9E$Js.:`>T}JkwZ/?D|cEjg');
define('SECURE_AUTH_SALT', 'MPaXv&W9AjT6zN*?x+,*_.9@6D}*JV6/ yePwxJxhUN/RDc,lA^=sW8R#$Y3%gv8');
define('LOGGED_IN_SALT',   'psUhAa33  Pd.Gxwsm%]?HY8Jc:LmY%R/;s{_(R;Jy+qLnjn8Gj-B6[-w`^5<Aqs');
define('NONCE_SALT',       ';Ne+:I?ba6-Ja=eHrQND%01:S-`}l,K:tbZpm2 VJu9,E@Taw(-zU|[X^]r92i- ');

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
