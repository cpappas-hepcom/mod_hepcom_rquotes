<?php

 /**
  * Hepcom Rquotes Module
  * Based on the work by Kevin Burke
  *	
  * @author   Chris Pappas <cpappas@hepcom.ca>
  * @version  1.5.4
  * @date     2011-02-10
  */
 

 /**
 * Rquotes main file
 * 
 * @package    Joomla.Rquotes
 * @subpackage Modules
 * @link www.mytidbits.us
 * @license		GNU/GPL-2
 */
 
 //no direct access
defined('_JEXEC') or die('Restricted access'); 

// Create functions if neeeded. 
if(!defined('RQUOTES_LOADED')) {

	define(@RQUOTES_LOADED, 1);

	//include helper file	
	require(dirname(__FILE__).DS.'helper.php'); 
}


$source         = $params->get('source');

//text file params
$filename       = $params->get('filename','rquotes.txt');
$randomtext     = $params->get('randomtext');

//database params
$style          = $params->get('style', 'default'); 
$category       = $params->get('category','');
$rotate         = $params->get('rotate');
$num_of_random  = $params->get('num_of_random');


switch ($source) {
  case 'db':
    
    switch ($rotate) {
      case 'single_random':
        $list = modRquotesHelper::getRandomRquote($category,$num_of_random);
        break;
        
			case 'all_jquery':

				$list = modRquotesHelper::getAllQuotes($category);
				break;
				
      case 'multiple_random':
        $list = modRquotesHelper::getMultyRandomRquote($category,$num_of_random);
        break;
        
      case 'sequential':
        $list = modRquotesHelper::getSequentialRquote($category);
        break;
      
      case 'daily':
      	$x='j';
      	$list= getDailyRquote($category,$x);
      	break;
      	
      case 'weekly':
	      $x='W';
	      $list= getDailyRquote($category,$x);
	      break;
	      
	    case 'monthly':
	      $x='n';
	      $list= getDailyRquote($category,$x);
	      break;
	      
	    case 'yearly':
	      $x='y';
	      $list= getDailyRquote($category,$x);
	      break;
    }

    require(JModuleHelper::getLayoutPath('mod_rquotes_hepcom', $style, 'default'));
    break;

  case 'text':
    if (!$randomtext) {
      $list = getTextFile($params,$filename);
    } else {
      $list=getTextFile2($params,$filename);
    }
    break;

  default:
    echo('Please choose a text file and Daily or Every page load and save it to display information.');
    break;
}

