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
define('DB_NAME', 'wordpress');
define('DB_USER', 'wordpress');
define('DB_PASSWORD', 'wordpress123');
define('DB_HOST', 'db');

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
define('AUTH_KEY',         'vH%*@G@C8IWOg. jhp1>:,p`_Rv6Q3 /cbq-svi+lBzf+I%?6GMZK}jyfjqUp=4r');
define('SECURE_AUTH_KEY',  'ChP(fr0^nW(93|N{d8D6 ?vD*$(8+i=sJ3:C[L~5rK->ZY?&^+FH/^iSsUP2I?Je');
define('LOGGED_IN_KEY',    '!G@xq+,U(_DtE0I|p/Ne_k=cw_kE/NH$N>V7slZ|3Unh]sl5Rm]<<5_hW6!,kVQm');
define('NONCE_KEY',        '@%<XHMoaAs:iiV1`yPTrjz)k_P3Nm/Wr+^,$b*lo4 UlfQ^~=3-bl/d?u(Qw^vAi');
define('AUTH_SALT',        '^ /!O-F$T,%+_EP]?xK4P$Y$V$%*+fYmkziu):|Ihuoh=Tw!go)3--v])ASBE0_!');
define('SECURE_AUTH_SALT', 'WdRYe2JQ7PT1,0;eV;He_s97!2-`HSO1%8=f>q[Dp$@|syMj@U;/!MPhL$jf3Wmw');
define('LOGGED_IN_SALT',   'PaS-E>ahLa=Y!(t9m|70r^s-n/87seSLP@ 1p}RHkR;ayT ~q&N#l}4XlK;d lBj');
define('NONCE_SALT',       '-6g-x{(~P<:`>EisA?E+n1-[7WN$>n/%uFm$dUtzTBND.QA].SDO6FoJtPE]v5xa');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
