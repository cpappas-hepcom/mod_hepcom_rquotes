<?php
/**
 * Rquotes  file to display quotes in italic style
 * 
 * @package    Joomla.Rquotes
 * @subpackage Modules
 * @link www.mytidbits.us
 * @license		GNU/GPL-2
 */
 //no direct access
 defined('_JEXEC') or die('Restricted access');  


foreach ($list as $rquote)
{ 
	echo "<em>";
	modRquotesHelper::renderRquote($rquote, $params);
	echo "</em>";
}
?>
