<?php
/**
 * Rquotes  file to rotate all quotes using jquery
 * 
 * @package    Joomla.Rquotes
 * @subpackage Modules
 * @link www.mytidbits.us
 * @license		GNU/GPL-2
 */
//no direct access
defined('_JEXEC') or die('Restricted access');
// include the rotator plugin in the Joomla head element
$filename = 'jquery.rotator.js';
$path = 'modules/mod_rquotes_hepcom/assets/'; // add the path parameter if the path is different than : 'media/system/js/'
JHTML::script($filename, $path, false); // MooTools will not load

// get the rquotes container classname from the parameters
$classname = $params->get('container_classname');
$num = $params->get('num_per_block');

// get the duration between transitions
$duration = $params->get('display_duration', 5000);

echo <<<EOJS
<script type="text/javascript">
  jQuery(function($) {
    
    // start the plugin
    $(".{$classname}").rotateQuotes({
      displayDuration: {$duration}
    });
  });
</script>

EOJS;


echo "<div class='{$classname}'>";
$i = 0;
foreach ($list as $rquote) { 
	
	// if this is the first one per block, then display the opening div
	if ($num == 1 || $i % $num == 0) {
		$hide_style = ($i != 0 ? 'display: none;' : '');
		echo "\n\t<div class='rquote-block' style='{$hide_style}'>\n";
	}
	
	// if the current index is less than the count then display the rquote, otherwise output nothing
	if ($i < count($list)) {
		modRquotesHelper::renderRquote($rquote, $params);
	}
	
	// if it's the last one per block, then display the closing div
	if ($num == 1 || $i % $num == ($num - 1)) {
		echo "\n\t</div>\n";
	}
	
	$i++;
}
echo "</div>\n";
?>
