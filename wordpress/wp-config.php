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
define( 'DB_NAME', 'store' );

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
define( 'AUTH_KEY',         'I$=A@A%O$;c>FLVDdmQD(td+<*6X:GZh7@VYP(a!oUf&1<uo%@oTC^.UJqe`PRD}' );
define( 'SECURE_AUTH_KEY',  '*_/@-jNoW!8Pnt#p /raR>ig0?8T!BlGaXnT8+80UVSmG,+WQwGaznpeQ|,?/Yps' );
define( 'LOGGED_IN_KEY',    '{7<U[=}Z%;@L;g}fls|(Lyf;kW*Y.gpB,`#>wEHmt7Gj9(4:x1(t&wQN2AZ~J@9#' );
define( 'NONCE_KEY',        'MVeSVEu/cJI0i)+9C >T*F5OC00^yQ+xp}S-y2z3{i4|qp_|?;f;7pi:ULFW-] d' );
define( 'AUTH_SALT',        'S5SlJR!&5+h^E?6g]#v102Dj,ml1WSt^RbA2z}hUBdM/t@uOso{n3*-NKRHI_c13' );
define( 'SECURE_AUTH_SALT', '_u&XAJi<X@1wd6%.dYX!X196OoiWkx=[8lO{@plt@m&Z99KMi4lb!LMN{qvSx0Nf' );
define( 'LOGGED_IN_SALT',   '}-!mS@Ng`z5TiI6#cY1-E3K9$3!6[{F:Y$gFw-SWHkh5p_!eiU,VB6D?`[FS8vf)' );
define( 'NONCE_SALT',       'ht$Uzr~l/9HpW.V;B4)~v(5oF8I*P7P}rH|N2fLWyL,xK7P[.vpuDX>ipgk5&7x`' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define( 'SMTP_USER', 'abdessamadsouilem1@gmail.com' );
define( 'SMTP_PASS', 'GITHUB2010' );
define( 'SMTP_HOST', 'smtp.gmail.com' );
define( 'SMTP_FROM', 'abdessamadsouilem1@gmail.com' );
define( 'SMTP_NAME', 'abdessamad souilem' );
define( 'SMTP_PORT', '587' );
define( 'SMTP_SECURE', 'tls' );
define( 'SMTP_AUTH', true );
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
