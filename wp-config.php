<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'web' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'N]17ucII.6_r,9S$9HCdqyH?MJaUC,EWI]NH5|n/?v#n@} 28/F^?an.waOL@IMx' );
define( 'SECURE_AUTH_KEY',  '/xWY%H3@?tVmavPoyg:}9>8aXT)^;jo$%T&l18E iv[TDdZ5GMK$G3H bg$9$O{4' );
define( 'LOGGED_IN_KEY',    'M8Xqus4wiIr?.>/NWLE|FU`Zn]kTV`rMET~g=*zjarO>$TYFEq;)$8pE)2Xful?|' );
define( 'NONCE_KEY',        'Jr(4+O^jHkYBJGvX1oNy*|@|k,?$s/Yhc;6Nl2DOa3rxKc$2Zg>1$)3V5_VxBFfk' );
define( 'AUTH_SALT',        'zMeFZLjPdNOXfGjk33|ZiCyJ+(kJ)j;Xk&/[8ysA{VP`O+mM.tv]<&/WG1</mh_l' );
define( 'SECURE_AUTH_SALT', 'Gf@5`.PfRPT7>p#Sw1M9$TkC6Es<19aG=@ p=.pTJuSrbQgvu<]dj1Ff &8Z7Qw*' );
define( 'LOGGED_IN_SALT',   '@}@Zi@jtLm.i%[-Z`sG`sNYn}tG!Db)1ODOSj6XPTESPfh(QGpzZkBf[l]gxFA(b' );
define( 'NONCE_SALT',       'O9uM#lk3o*HTk9kT||z7Fm*3I)*VW77lP?@jn7;L7|UY4/Q)eS?!@=V7FC].R~1:' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
