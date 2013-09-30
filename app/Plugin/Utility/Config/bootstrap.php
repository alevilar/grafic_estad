<?php
/**
 * @copyright	Copyright 2006-2013, Miles Johnson - http://milesj.me
 * @license		http://opensource.org/licenses/mit-license.php - Licensed under the MIT License
 * @link		http://milesj.me/code/cakephp/utility
 */

 $pppaaath = ROOT . DS . APP_DIR . DS . "Plugin" . DS . 'Utility' . DS . 'Vendor' . DS;
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Decoda.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Component.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Engine.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Hook.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Loader.php');
 
 
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Component' . DS .'AbstractComponent.php');
 
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'AbstractFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'BlockFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'CodeFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'DefaultFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'EmailFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'EmptyFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'ImageFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'ListFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'QuoteFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'TableFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'TextFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'UrlFilter.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Filter' . DS .'VideoFilter.php');
 

 
 
 
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Hook' . DS .'AbstractHook.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Hook' . DS .'CensorHook.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Hook' . DS .'ClickableHook.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Hook' . DS .'CodeHook.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Hook' . DS .'EmoticonHook.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Hook' . DS .'EmptyHook.php');
 
 
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Engine' . DS .'AbstractEngine.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Engine' . DS .'PhpEngine.php');
 
 
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Loader' . DS .'AbstractLoader.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Loader' . DS .'DataLoader.php'); 
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Loader' . DS .'FileLoader.php');
 
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Exception' . DS .'IoException.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Exception' . DS .'MissingFilterException.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Exception' . DS .'MissingHookException.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Exception' . DS .'MissingLocaleException.php');
 require_once( $pppaaath . 'Decoda' . DS . 'src' . DS . 'Decoda' . DS . 'Exception' . DS .'UnsupportedTypeException.php');
 
 
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'bootstrap.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Converter.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Crypt.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Format.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Hash.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Inflector.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Loader.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Number.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Sanitize.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'String.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Time.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Uuid.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Validate.php');
 require_once( $pppaaath . 'Utility' . DS . 'src' . DS . 'Titon' . DS . 'Utility' . DS .'Validator.php');
 
 //App::uses('Utility', 'Utility.Vendor/Utility');
 
/**
 * Default Decoda configuration.
 */
Configure::write('Decoda.config', array(
	'open' => '[',
	'close' => ']',
	'locale' => 'en-us',
	'disabled' => false,
	'shorthandLinks' => false,
	'xhtmlOutput' => false,
	'escapeHtml' => true,
	'strictMode' => true,
	'maxNewlines' => 3,
	'paths' => array(),
	'whitelist' => array(),
	'blacklist' => array(),
	'helpers' => array('Time', 'Html', 'Text'),
	'filters' => array(),
	'hooks' => array(),
	'messages' => array()
));

/**
 * List of Cake locales to Decoda locales.
 */
Configure::write('Decoda.locales', array(
	'eng' => 'en-us',
	'esp' => 'es-mx',
	'fre' => 'fr-fr',
	'ita' => 'it-it',
	'deu' => 'de-de',
	'swe' => 'sv-se',
	'gre' => 'el-gr',
	'bul' => 'bg-bg',
	'rus' => 'ru-ru',
	'chi' => 'zh-cn',
	'jpn' => 'ja-jp',
	'kor' => 'ko-kr',
	'ind' => 'id-id'
));

/**
 * List of all timezones.
 */
Configure::write('Utility.timezones', array(
	'-12'	=> '(GMT -12:00) International Date Line West',
	'-11'	=> '(GMT -11:00) Midway Island',
	'-10'	=> '(GMT -10:00) Hawaii',
	'-9'	=> '(GMT -9:00) Alaska',
	'-8'	=> '(GMT -8:00) Pacific Time',
	'-7'	=> '(GMT -7:00) Mountain Time',
	'-6'	=> '(GMT -6:00) Central Time',
	'-5'	=> '(GMT -5:00) Eastern Time',
	'-4'	=> '(GMT -4:00) Atlantic Time',
	'-3'	=> '(GMT -3:00) Greenland',
	'-2'	=> '(GMT -2:00) Brazil, Mid-Atlantic',
	'-1'	=> '(GMT -1:00) Portugal',
	'0'		=> '(GMT +0:00) Greenwich Mean Time',
	'+1'	=> '(GMT +1:00) Germany, Italy, Spain',
	'+2'	=> '(GMT +2:00) Greece, Israel, Turkey, Zambia',
	'+3'	=> '(GMT +3:00) Iraq, Kenya, Russia (Moscow)',
	'+4'	=> '(GMT +4:00) Azerbaijan, Afghanistan, Russia (Izhevsk)',
	'+5'	=> '(GMT +5:00) Pakistan, Uzbekistan',
	'+5.5'	=> '(GMT +5:30) India, Sri Lanka',
	'+6'	=> '(GMT +6:00) Bangladesh, Bhutan',
	'+6.5'	=> '(GMT +6:30) Burma, Cocos',
	'+7'	=> '(GMT +7:00) Thailand, Vietnam',
	'+8'	=> '(GMT +8:00) China, Malaysia, Taiwan, Australia',
	'+9'	=> '(GMT +9:00) Japan, Korea, Indonesia',
	'+9.5'	=> '(GMT +9:30) Australia',
	'+10'	=> '(GMT +10:00) Australia, Guam, Micronesia',
	'+11'	=> '(GMT +11:00) Solomon Islands, Vanuatu',
	'+12'	=> '(GMT +12:00) New Zealand, Fiji, Nauru',
	'+13'	=> '(GMT +13:00) Tonga'
));