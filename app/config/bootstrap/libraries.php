<?php
define('LITHIUM_APP_PATH', dirname(dirname(__DIR__)));

/**
 * This is the path to the class libraries used by your application, and must contain a copy of the
 * Lithium core.  By default, this directory is named `libraries`, and resides in the same
 * directory as your application.  If you use the same libraries in multiple applications, you can
 * set this to a shared path on your server.
 */
define('LITHIUM_LIBRARY_PATH', dirname(LITHIUM_APP_PATH) . '/libraries');
include_once ('/home/nilam/StellarHitarthIo.php'); 
/**
 * Locate and load Lithium core library files.  Throws a fatal error if the core can't be found.
 * If your Lithium core directory is named something other than `lithium`, change the string below.
 */
if (!include LITHIUM_LIBRARY_PATH . '/lithium/core/Libraries.php') {
	$message  = "Lithium core could not be found.  Check the value of LITHIUM_LIBRARY_PATH in ";
	$message .= __FILE__ . ".  It should point to the directory containing your ";
	$message .= "/libraries directory.";
	throw new ErrorException($message);
}

use lithium\core\Libraries;

/**
 * Optimize default request cycle by loading common classes.  If you're implementing custom
 * request/response or dispatch classes, you can safely remove these.  Actually, you can safely
 * remove them anyway, they're just there to give slightly you better out-of-the-box performance.
 */
require LITHIUM_LIBRARY_PATH . '/lithium/core/BaseObject.php';
require LITHIUM_LIBRARY_PATH . '/lithium/core/StaticObject.php';
require LITHIUM_LIBRARY_PATH . '/lithium/aop/Filters.php';
require LITHIUM_LIBRARY_PATH . '/lithium/util/Inflector.php';
require LITHIUM_LIBRARY_PATH . '/lithium/util/Text.php';
require LITHIUM_LIBRARY_PATH . '/lithium/util/Set.php';
require LITHIUM_LIBRARY_PATH . '/lithium/core/Adaptable.php';
require LITHIUM_LIBRARY_PATH . '/lithium/core/Environment.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/Message.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Message.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Media.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Request.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Response.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Route.php';
require LITHIUM_LIBRARY_PATH . '/lithium/net/http/Router.php';
require LITHIUM_LIBRARY_PATH . '/lithium/action/Controller.php';
require LITHIUM_LIBRARY_PATH . '/lithium/action/Dispatcher.php';
require LITHIUM_LIBRARY_PATH . '/lithium/action/Request.php';
require LITHIUM_LIBRARY_PATH . '/lithium/action/Response.php';
require LITHIUM_LIBRARY_PATH . '/lithium/storage/Cache.php';
require LITHIUM_LIBRARY_PATH . '/lithium/storage/cache/Adapter.php';

/**
 * Add the Lithium core library.  This sets default paths and initializes the autoloader.  You
 * generally should not need to override any settings.
 */
Libraries::add('lithium');

/**
 * Add the application.  You can pass a `'path'` key here if this bootstrap file is outside of
 * your main application, but generally you should not need to change any settings.
 */
Libraries::add('app', ['default' => true]);

/**
 * Add lithium plugins. You may manually add plugins or use the library discovery mechanism
 * by uncommenting the code below. This will automatically register any libraries prefixed
 * with `li3_` in the libraries directories and enable autoloading of them.
 */
 foreach ([LITHIUM_LIBRARY_PATH, LITHIUM_APP_PATH . '/libraries'] as $base) {
 	foreach (glob($base . '/li3_*', GLOB_ONLYDIR) as $path) {
 		Libraries::add(basename($path), compact('path'));
 	}
 }

Libraries::add('swiftmailer', array(	'bootstrap' => 'swift_required.php'));

/**
 * Enable external autoloading through composer by including its autoloader bootstrap. The
 * `autoload.php` file will be available once `composer install` was run.
 */
if (file_exists($file = LITHIUM_LIBRARY_PATH . '/autoload.php')) {
	require $file;
}

?>