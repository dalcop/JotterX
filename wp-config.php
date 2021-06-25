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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'jotterx_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'nEB%b]-6G=}9Wlsd(3&;_<ncuAOM63sV}lxFhL1HKDg{t&.u P0@Cdi7=/k$Qhl4' );
define( 'SECURE_AUTH_KEY',  'x7/BdFo:i1h+kzvwy]Q/8gQ  <=!=2Gn&xFK^KVr`vlI5JLei:EUHcgq#U&#R+)9' );
define( 'LOGGED_IN_KEY',    't9{D{x00Y#o4<@(+RU|{-jC6yfvXq$MtvV3;[#OG`g_D,x`4LsHN?]}/_biiXh&P' );
define( 'NONCE_KEY',        'cr^!|,sd3B94I,0<><sy! WmtSKL r?Di*~MrsF4-#DF,)2;=yq=:e[>JAUgm/U=' );
define( 'AUTH_SALT',        'm7hD,dIgSt)4OcNl&_?$TD?Y5.%%/#wdz9Viz@L19ER8!> /Qy1B>-0 ia<f.I>o' );
define( 'SECURE_AUTH_SALT', 'yiWt1hP@fi+2_ocTa5tCDu^=#bh0#=SjE{VoJNxxq0h5-`2()#<,cX#?X&LC[iKF' );
define( 'LOGGED_IN_SALT',   'oeSp7>BK&6L)g;WFQnR%%]?ImZpt+]PL:}cLHHTBV<&RJ-ys3o9{`(ae9Mq~8gZ~' );
define( 'NONCE_SALT',       '?iF)`r<*Qh~QsE%.szcb[vZlF[!V<`>Nz+L8zqsA|y[BtqA19g#Rvl^>YRa$O:DS' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
