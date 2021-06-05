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
define( 'DB_NAME', 'e-commerce' );

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
define( 'AUTH_KEY',         '`qfA#8;kT+}:2@Di$:}X^^Qt(Gyt1F9KVhcJ5rnCc@r6NR~WubV}$C-22NTgmZ!J' );
define( 'SECURE_AUTH_KEY',  '3jm~aG}Cf.ubxb9,qIb*Sv7=Dk9O9Pnc,j2eruo==/pG>(?k:AJ0a6$lK)$.DkI:' );
define( 'LOGGED_IN_KEY',    'nmpitBu5[9[9^y5:NK~o!zRDO-ap&S!p[uL,c[u<<{pFB+QG0sLbplZ,6m:UzOhr' );
define( 'NONCE_KEY',        'W^z,Oe s^Y#Sh::KC^-Oi%<lcHTOo%<x:UH!T|pUodkv-9QZFN%v}zCfoi4<~E ]' );
define( 'AUTH_SALT',        ',+EyHw#Yq9I; Zs&t}8lbMGdw$n|&mSR)@ny`c(S}IY.xA|<_fxt)C>7>XnU9rk3' );
define( 'SECURE_AUTH_SALT', 'IBHIur0HYFQI#70 h-Law@M#ad><qLJQgs4.~8*@jI0(WQ]Jd%K)UV8a2>FuWLAY' );
define( 'LOGGED_IN_SALT',   'Rs=2QV?(~a2&T?&qry0;N49UWH4]X5uB*/p_D@m0l|3:86FR[+|P)(.D.v&Z11aw' );
define( 'NONCE_SALT',       'f_YqWZm(7[+ERWO}3uciteuP19Yvb!#3#y.-V:yJ#@.`Zy&IblN%,r59CH{]XC-@' );

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
