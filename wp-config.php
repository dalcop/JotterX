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
define( 'AUTH_KEY',         'J|P8KHZ%1`,9K&DXV@e@ as+]ql|.Rnmbs#s* l8Vy>i8ny6/;2P0l?=7d-= FcS' );
define( 'SECURE_AUTH_KEY',  'DY2n!kLvq<o^lyE4gY9H|s?qy&~2HcJA/0Q]kb.9^:3LXm%d:Cn=ejU2z$QJ3WVm' );
define( 'LOGGED_IN_KEY',    'V?lWTf[xAWC-*Sq$TjGc~Ol],5je2MyW#CF(5q,:jeD,6)RKO/FZIu2sm5vb&O0#' );
define( 'NONCE_KEY',        'P8:l> ff3u{FKGFIQfVkLE?ejj;cZbSl$Kmy#ssO@wxx)<S{[p^Cz:FpiYu<^IX1' );
define( 'AUTH_SALT',        'B*T#>.{uXOG5{pq.>*82EtK@hJ$OYV<,@(BpYy|-^;|g/RcvbC}@z.n2<5[DHU![' );
define( 'SECURE_AUTH_SALT', 'ySziz^[,K-g^_=7Yq0k=DA/i:+tL$4]<qZ8,+VQ=waZW&(t1K?nU3] Sl9);P<.P' );
define( 'LOGGED_IN_SALT',   'LOO?Y~7v2>Yi+Yx0*|{|lTOwxM R|M Vo>(bBeKP0xa3% #EhQ*h9wnGebbi}Y~c' );
define( 'NONCE_SALT',       'R|b=T*ZjL5f/?_J,k#}3iUem. Ta17o?O_9>uylWF+]I%bBOwS5Ul*Nu,}$SjAWc' );

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
