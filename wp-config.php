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
define( 'AUTH_KEY',         'Pm|$9y*<{jq=$tuEj6ft07lKzkm,|+xI[1vEo>LY;DF*ju7,(c!=+*Fvr&N3rg4h' );
define( 'SECURE_AUTH_KEY',  '/WtiYALg.`1}Ktk[w:)tjra5]VEPQ4P0eiMk#BCbNTH/Jjxa,M58Bi/*Qfds*:7(' );
define( 'LOGGED_IN_KEY',    'cWnJ6$hMvQWyNt&>N0jl(9OE^I{6j-}P:FSPyu]mu.SmQ:,=K^W-|l85gVP`@/s]' );
define( 'NONCE_KEY',        'L=FxVAY3QI[GUbji>,ohU%;`Bb|blmZIPN9MaI+C 2?MbgKB}r^t:C-tFRn*BjQ<' );
define( 'AUTH_SALT',        '>h#05u<cHLwHe[CbK83|+c]j{(7L:Mv /d`kP&SM_][*C7,P=5{;Bm>$>fPy^h4}' );
define( 'SECURE_AUTH_SALT', '>sB^bZ?F#/mklTb.?dkg%*A>@`=Kg0+aHY3Wg{sB6vRO-/%[v2[80@4mVkdbN>|0' );
define( 'LOGGED_IN_SALT',   '+d<uS!kfKLG;;Mnhp[k)P{e^+6 kN5mNOy$Nbf=]S.O$*h:OgxJyiO(jObK3k[Qn' );
define( 'NONCE_SALT',       'O:#!v(qwJeAc/5WM?w.189s5n)%:Wv7P;Ev]SeX)bETvE*,q~~|Q-|V(JYtLW,b&' );

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
