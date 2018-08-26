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
define('DB_NAME', 'teenitas');

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
define('AUTH_KEY',         'N FADRh7!`c=5O,KSwx0dzP&P91`ha3w*=ATGHk]=Wz9Lv4#7)).Kc_J.4_q&~1@');
define('SECURE_AUTH_KEY',  '-kIAF}TI_dX{zq0=jdT%6T2vquTgN`3I`Z631~v^+,Nwgj]9+A|@X2KZwP}|[goB');
define('LOGGED_IN_KEY',    ';(.t{z9r/;SbeoHOE^Rni#8NKYdbRf7Hh4xyu6&KoQr6GA^)ds:?W~_hP9~T*^m{');
define('NONCE_KEY',        'RFBi8{Y~pT8vHLK@xIWu!ns~Y5c $y6ms1c0n*Nx0OA6!N}m%1;m;tqdqy%zcfB{');
define('AUTH_SALT',        'kq=_TYu=QHzNd0QwChMOc#Ye=HX{+]/*~C=W~IhgtfZyR GY||6X6JR=8[svw~9:');
define('SECURE_AUTH_SALT', 'IPC)AEj@Q&j*ht`RbKs@mzlt>+nl#~~DQ;q{[S0;wzK5zO8}A!CBo$#5i<1O!o M');
define('LOGGED_IN_SALT',   'hEVSMDSTm0`Ro`6//9Opd-ZL = Njv&5J:2`SJZ,HNYO]#ueS8$06q$u4B7hmEbO');
define('NONCE_SALT',       '7xyoVCIa$%5yhGzE5gp6nkHAz$xm+z;;p~t%:h~?~{UqNKPLOyf[Hm22t}hDO6x[');

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
