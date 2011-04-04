<?php

/**
 * Rquotes default layout file
 * This file includes quotation marks before and after quote
 * @package    	Joomla.Rquotes
 * @subpackage 	Modules
 * @link 				www.mytidbits.us
 * @license			GNU/GPL-2
 */

/**
 * 	Altered by Chris Pappas <cpappas@hepcom.ca> for Hep Communications
 * 	http://www.hepcommunications.com
 *
 */

//no direct access
defined('_JEXEC') or die('Restricted access');

$quotemarks = $params->get('quotemarks', 0) == 1;

$strip_tags = $params->get('strip_tags', 0);

$max_chars = $params->get('max_quote_chars', 0);

$quote = $rquote->quote;
$author = $rquote->author;

if ($strip_tags != 0) {
  
  $allowed_tags = $params->get('allowed_tags', '');
  
  $quote = strip_tags($quote, $allowed_tags);
  $author = strip_tags($author, $allowed_tags);
}

if ($max_chars > 0 && strlen($quote) > $max_chars) {
  $quote = substr($quote, 0, $max_chars) . '...';
}

if ('' !== $quote) {
	echo "<div class='quote'>";

	if ($quotemarks) {
	  $quote = '"' . $quote . '"';
	}

  echo $quote;
  
	echo "</div>\n";
}

if ('' != $author) {
	echo "<div class='attribution'>{$author}</div>\n";
}

