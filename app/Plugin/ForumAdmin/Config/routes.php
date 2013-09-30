<?php
/**
 * @copyright	Copyright 2006-2013, Miles Johnson - http://milesj.me
 * @license		http://opensource.org/licenses/mit-license.php - Licensed under the MIT License
 * @link		http://milesj.me/code/cakephp/admin
 */

if (Configure::check('Admin.menu')){
    foreach (Configure::read('Admin.menu') as $section => $menu) {
            Router::connect('/forum_admin/'. $section . '/:action/*', $menu['url'], array('section' => $section));
            Router::connect('/forum_admin/'. $section, $menu['url'] + array('action' => 'index'), array('section' => $section));
    }
}
/*
Router::connect('/forum_admin/:model/:action/*',
	array('plugin' => 'forum_admin', 'controller' => 'crud'),
	array('model' => '[_a-z0-9]+\.[_a-z0-9]+'));

Router::connect('/forum_admin/:action/*', array('plugin' => 'forum_admin', 'controller' => 'admin'));
*/