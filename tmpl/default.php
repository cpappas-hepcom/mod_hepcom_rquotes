<?php

/**
 * Rquotes default display file
 * 
 * @package    Joomla.Rquotes
 * @subpackage Modules
 * @link www.mytidbits.us
 * @license		GNU/GPL-2
 */

//no direct access
defined('_JEXEC') or die('Restricted access');

foreach ($list as $rquote)

	modRquotesHelper::renderRquote($rquote, $params);


?>