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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pckrMvr_db');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '#ocX2Udu|~*62<4W4)mP[.cUq*[V:XGUT!~x=,K,J}?R8qW$qC9|`^ K1?Xn`Qq:');
define('SECURE_AUTH_KEY',  ')k:5vI;4Eua5<K.rn|s3]VXl1]?>Q<nI|/&RI?6G_GG_ZG[%@,Md qt lh!QXt1^');
define('LOGGED_IN_KEY',    'k&@Vk8Q3PMsA_>IJ7[V06e(ZM%(U2@ZUZEuRkQ-2HuL@hY2Z;Py}9/`]2?f&]r3>');
define('NONCE_KEY',        'a%,Bl9.E{H=~+btwb/mJs9[H,5KC[w1tk 8eWV<%Z7(J~KEdHy=eqe}Eo;x}f}GG');
define('AUTH_SALT',        'RP$XBz8i.>AP1xI>zQ}h>!.k5m#iF#@Qtwk},a<PunDJJjW*ksWcD.oJg9xb~+68');
define('SECURE_AUTH_SALT', '[TP4WF)ZXAqA-[Q89Z=Xymgg~rOTndxlQU0D?Sb$+8j4|o7S1F{Nx Q)^pycJ%9}');
define('LOGGED_IN_SALT',   '.@_A.pMbey [e,^m#Gpiy.(Xl1-J66q;Vp!7!]iSLu]VPWw{_TQMI:NhU:YlHDtl');
define('NONCE_SALT',       'XZdnu0P&9_?vaV[=q9g{* .>[X>DjpE!{AIp_Y]=/DJh J][y<co2i<5nE(k^UmA');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
