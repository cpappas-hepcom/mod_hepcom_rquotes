<?php
/**
 * Rquotes  file to display quotes in bold style
 * 
 * @package    Joomla.Rquotes
 * @subpackage Modules
 * @link www.mytidbits.us
 * @license		GNU/GPL-2
 */
 //no direct access
 defined('_JEXEC') or die('Restricted access'); ?> 

<?php
foreach ($list as $rquote)
{ 
	echo "<strong>";
	modRquotesHelper::renderRquote($rquote, $params);
	echo "</strong>";
}
?>
