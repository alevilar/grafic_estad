<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */



// croogo``s role Public ID
define('PUBLIC_ROLE', 3);
define('REGISTERED_ROLE', 2);
define('ADMIN_ROLE', 1);

CakePlugin::load('Croogo', array('bootstrap' => true));
//CakePlugin::load('Kms', array('routes' => true));
CakePlugin::load('DebugKit');

//CakePlugin::load('Utility', array('bootstrap' => true, 'routes' => true));

//CakePlugin::load('Sky');



//CakePlugin::load('AuditLog', array('bootstrap' => true));


// Optional constants before plugin loading
//define('USER_MODEL', 'User'); // Name of the user model (supports plugin syntax)
//define('FORUM_PREFIX', 'forum_'); // Table prefix, must not be empty
//define('FORUM_DATABASE', 'default'); // Database config to create tables in

/*
// The Utility and Admin plugin must be loaded before the Forum
CakePlugin::load('Utility', array('bootstrap' => true, 'routes' => true));
CakePlugin::load('ForumAdmin', array('bootstrap' => true, 'routes' => true));
CakePlugin::load('Forum', array('bootstrap' => true, 'routes' => true));
*/


Configure::write('Admin.aliases.administrator', 'Role-admin');






Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));




function crear_fechas($desde, $hasta) {
     $arr = array();
     $td = strtotime($desde);
     $th = strtotime($hasta);
     
     if ($th < $td) {
         $taux = $td;
         $td = $th;
         $th = $taux;
     }
     
     $dcurr = date('Y-m-d', $td);
     $tcurr = $td;
     while ( $tcurr <= $th ) {
         $arr[] = $dcurr;
         $dcurr = date('Y-m-d', strtotime('1 day',$tcurr));
         $tcurr = strtotime($dcurr);
         
     }     
     return $arr;
}