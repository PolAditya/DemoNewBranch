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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'R}@=;D[#1EVu~W391Pw^5Bg;Rd].y[s6)is*9gc ,l`mn!LFRGGtNJxYV))%^Hc&' );
define( 'SECURE_AUTH_KEY',   'CA]B-g;|uIL-g-o9T0c+?1@{32Noj84eVTsi4FX4JK!wcIUSuT$rPQd@/)YE)z3>' );
define( 'LOGGED_IN_KEY',     '9yOn$m?VNEyyD:,*Ub[.tdO~f,N{,3rmb^8XWG@OD]R2vCKj`eh/0wEgR;,xY2/,' );
define( 'NONCE_KEY',         '-;Fjs=og*x}A-P1iA|5?BjZ,dY?3;tIse_H*mc>$h2@[Yia${0)i[i1C0U?CP}hG' );
define( 'AUTH_SALT',         'kU3 $-ZUAI:Fboz $-Q0U-A6DK2I8=>ZDThu+nvRXEcHL<$yZuu8+BKxEiuB3OQM' );
define( 'SECURE_AUTH_SALT',  '7Um+;d?}q>-|$g`A0YqU04/mM%}tzJXgdeHUnF-9j9-p!pZ2-/}4zkm]yWDVGfHk' );
define( 'LOGGED_IN_SALT',    'cL^9jBlR*,qEwMdq/Q 9JbU3Te>3`I2{C~Tmrq%BBVJ6h~PfEN/|at$@DKP}o{d&' );
define( 'NONCE_SALT',        '(UB7svm#z P W)^TPo;{EgO]n^h{o7FWT`i<+[s0y{$}TDH#YQ7TZ7y2s&Y$9]Tc' );
define( 'WP_CACHE_KEY_SALT', '=haqklGW-8EU9-@1^1c|.w,=5s%a`e`Bc=`[rla3~?s=-h%K~F%$#e-]ZtK4IvCV' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
