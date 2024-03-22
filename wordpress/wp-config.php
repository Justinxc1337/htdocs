<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp-database' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3308' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'u6APy`UH&7V4o#.GXvTM.QdV#g[[@|7}{t>0*+SP/=HC5 sk&P[C#q?dA;oq.rU=' );
define( 'SECURE_AUTH_KEY',  '5~::2UT/|CC&d3LuG5y@6o$@*s^uAZxw6ztyv%TDVIRoO.jHyVVv2mO%.1F}T-]L' );
define( 'LOGGED_IN_KEY',    'S~sDWM{f[mvT+.drj*oITTHI|~CV/d wR]S0sYncOP1?d4g5Hd79tRWPiP;!T@9e' );
define( 'NONCE_KEY',        '2wdZLC=r}fXb`Q]f$!MR1O?602:04_6N=*x`kHjcd^$!&zr6np&iNG<qQ9@2t43p' );
define( 'AUTH_SALT',        '.PD/tH18]:^3M2:V>KG)E-!4Xde61W*s^581-[gkOd s-S|Zu]3BUBf)#Xt4RQ=O' );
define( 'SECURE_AUTH_SALT', 's_~rv=;F2;@2[<+i~I!30Y?76R3-t_MMs:Of&D4c?#YsM]zk24)Na,,QyMU:yQm+' );
define( 'LOGGED_IN_SALT',   'D;a+s3/n&+*%{9c{C6fZV&rBrGjy{b{0_Pprfou?sW!`S.XksD}AWfUY <|-h,#l' );
define( 'NONCE_SALT',       '0O:lA9!Efsz:7x:w H;^&l6v]!1I1J;F= Zp[jo.5AzM~KAj6q0gG^WA@wD~j&V<' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
