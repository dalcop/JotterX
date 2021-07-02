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
define( 'AUTH_KEY',         'VL!UNkr6fz9Ywd~0Yyo#Ovxts|(Z)2%/lgi%,lU=Rl~d9:S4qcG|;SKXgIT)sG?A' );
define( 'SECURE_AUTH_KEY',  'A~!0WAf t5=i9@X=-5#O@)pOgz>F{Pas0|QN!-s(/7a%2EsSpDkNbrh4^X3Gyp2,' );
define( 'LOGGED_IN_KEY',    '6SLYc53YOu%&THHSxEJ9S H;^syzr(77^@*GdvcN7zuRdBrMIj%I$j#GY@9lMqg(' );
define( 'NONCE_KEY',        'BS%$`a-YS61.19>Ijs?)t>8o88wJgWNBeFz%g,<l2>r dLy]#,OzaJ.w0UIyy(8f' );
define( 'AUTH_SALT',        'vZ/9[V~)_~oo5j,jYLQi[-po%p,LwK/E~fa@&rJ6m?)98zEa $>BnjZmp 3_Y?D<' );
define( 'SECURE_AUTH_SALT', '5gByjrOdxp:? 4A{ *BMlwvLKrptOrLp7+@biv9cL!{rgT)}Qyj5^u&Ukhre2#c&' );
define( 'LOGGED_IN_SALT',   '@7*)F3Z)&XUd_RzRTpgz5BC@SzszJ@@dAa@jFD%*5I?g(y=w ~m.yZ;io{E#1GSk' );
define( 'NONCE_SALT',       '/rYkS5UK8tZ[9y+oopPB<* )TasCrVe!){7OR(?-jO)7c(2-]y#Z6KoZ!i;QBh]r' );

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
