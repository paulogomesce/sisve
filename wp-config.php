<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', '697010_site');

/** MySQL database username */
define('DB_USER', '697010_site');

/** MySQL database password */
define('DB_PASSWORD', '91545117');

/** MySQL hostname */
define('DB_HOST', 'fdb3.awardspace.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '|kL5y=g`I<Q4n$9.il/99K{~$S-rk[RY|T=>aq%^2`<RG|&7P?#PTLdeP[il8zv}');
define('SECURE_AUTH_KEY',  'yXp)~dZ$-W6,q$QJ#]#4K|s91tlTv[dU;6&ly42lJK5XXaRwtmF%)2JVL6;k% 3J');
define('LOGGED_IN_KEY',    '5k;*E6:yj2fkbMRq>:2q7.uB|%ck}pdwC:GaILb-jz2TSLH)sksmc6i -xrBgk,|');
define('NONCE_KEY',        'O]$LGJ%gq/N]aO/cZ;+C_Hs)?jz$m0B3Z1$?_nh<_44pp1]ip?4?x]y=cP+QN,uk');
define('AUTH_SALT',        '=]p|u}~Okz<XBJn{uu-4BY;I1Fj.W!Y@!T@O{cC`%8d6#GbzHRI$I[9-s@>#(H3K');
define('SECURE_AUTH_SALT', 'Abt|<s7Zj2eMq.wHfxZ $cPR5}JQP!z&dO,42^TLK0.j#DyEh7(Zp/_rHm%|Pn%L');
define('LOGGED_IN_SALT',   '3)y)YfHt7h{C+6/UV3uD`0:$3 Q{COGBNs.B6|i2|+[X!@l7Pn b69- NXz +[{3');
define('NONCE_SALT',       'X1Ufhb!VBST;oDB|Qe7#8YLQN|/`5;np>t%sb!p(.9)qb?bs|sAC;;*H!5.Yg.;I');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'pt_BR');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
