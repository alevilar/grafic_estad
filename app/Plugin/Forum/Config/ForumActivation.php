<?php
/**
 * Kms Activation
 *
 * Activation class for Example plugin.
 * This is optional, and is required only if you want to perform tasks when your plugin is activated/deactivated.
 *
 * @package  Croogo
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */

 
 
class ForumActivation {

/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeActivation(&$controller) {
		return true;
	}

/**
 * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onActivation(&$controller) {

/**
 * Current version.
 */
Configure::write('Forum.version', file_get_contents(dirname(__DIR__) . '/version.md'));

/**
 * Customizable layout; defaults to the plugin layout.
 */
Configure::write('Forum.viewLayout', 'forum');

/**
 * List of settings that alter the forum system.
 */
Configure::write('Forum.settings', array(
	'name' => __d('forum', 'Forum'),
	'email' => 'forum@cakephp.org',
	'url' => 'http://kms.shivankrc.com',
	'securityQuestion' => __d('forum', 'What framework does this plugin run on?'),
	'securityAnswer' => 'cakephp',
	'titleSeparator' => ' - ',

	// Topics
	'topicsPerPage' => 20,
	'topicsPerHour' => 3,
	'topicFloodInterval' => 300,
	'topicPagesTillTruncate' => 10,
	'topicDaysTillAutolock' => 21,

	// Posts
	'postsPerPage' => 15,
	'postsPerHour' => 15,
	'postsTillHotTopic' => 35,
	'postFloodInterval' => 60,

	// Subscriptions
	'enableTopicSubscriptions' => true,
	'enableForumSubscriptions' => true,
	'autoSubscribeSelf' => true,

	// Misc
	'whosOnlineInterval' => '-15 minutes',
	'enableQuickReply' => true,
	'enableGravatar' => true,
	'censoredWords' => array(),
	'defaultLocale' => 'eng',
	'defaultTimezone' => '-8',
));

/**
 * Add forum specific user field mappings.
 */
$f1 = Configure::read('User.fieldMap');
$f2 = array(
	'totalTopics'	=> 'topic_count',
	'totalPosts'	=> 'post_count',
	'signature' 	=> 'signature'
);
Configure::write('User.fieldMap', (empty($f1)?array():$f1) +$f2 );

/**
 * Add model callbacks for admin panel.
 */
$f1 = Configure::read('Admin.modelCallbacks');
$f2 = array(
	'Forum.Forum' => array(
		'open' => 'Open %s',
		'close' => 'Close %s'
	),
	'Forum.Topic' => array(
		'open' => 'Open %s',
		'close' => 'Close %s',
		'sticky' => 'Sticky %s',
		'unsticky' => 'Unsticky %s'
	)
);
Configure::write('Admin.modelCallbacks', (empty($f1)?array():$f1) + $f2);

/**
 * Add overrides for admin CRUD actions.
 */
$f1 = Configure::read('Admin.actionOverrides');
$f2 =  array(
	'Forum.Forum' => array(
		'delete' => array('plugin' => 'forum', 'controller' => 'stations', 'action' => 'admin_delete')
	)
);
Configure::write('Admin.actionOverrides',  (empty($f1)?array():$f1) + $f2);
                
        }

/**
 * onDeactivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeDeactivation(&$controller) {
		return true;
	}

/**
 * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onDeactivation(&$controller) {
		 $controller->Setting->deleteKey('Admin');
		
	}
}
