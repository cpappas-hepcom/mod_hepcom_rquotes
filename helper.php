<?php 

/**
 * Rquotes helper file
 * 
 * @package    Joomla.Rquotes
 * @subpackage Modules
 * @link www.mytidbits.us
 * @license		GNU/GPL-2
 */
 
//no direct access
defined('_JEXEC') or die('Restricted access');



class modRquotesHelper
{
//-----------------------------------------------------------------------------------------------------------------------------
function renderRquote(&$rquote, &$params)
	{	
	require(JModuleHelper::getLayoutPath('mod_rquotes_hepcom','_rquote'));
	}
//---------------------------------------------------------------------------------------------------------------------------------------------------	

// handles splitting a pipe-delimited set of category id's into an array
// and then generating a set of catid = x OR catid = y clauses to the SQL query
function getCatSelect($category) {

  $cats = explode('|', $category);
  
  $cats_sel = array();
  foreach($cats as $cat) {
    $cats_sel[] = ' catid = ' . $cat;
  }
  
  return implode(' OR ', $cats_sel);
}

function getAllQuotes($category) {
  
  $cats = self::getCatSelect($category);
  
	$db =& JFactory::getDBO(); 	
	$query = "SELECT * FROM #__rquotes WHERE published = '1' AND ({$cats})";
	
	$db->setQuery( $query );
	$rows = $db->loadObjectList();
	
	return $rows;
}


function getRandomRquote($category) 
{
		$db =& JFactory::getDBO(); 
		$x = count($category);
	
	if($x =='1') // get quote when one category is selected 	
	{		
		$query = "SELECT * from	#__rquotes WHERE published ='1' AND catid=$category";
		
	}
	

	else // get quote when more than one category is selected 	
		{
			$value= array($category);

			$rand_keys=array_rand($category,$x);
			$catid =	$category[$rand_keys[1]];

			$query = "SELECT * from	#__rquotes WHERE published='1' and catid = $catid";

		}	

		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		
		$i = rand(0, count($rows) - 1 );

		$row = array( $rows[$i] );
		
		
		
		return $row;
		
	}
	
//----------------------------------------------------------------------------------------------------
function getMultyRandomRquote($category,$num_of_random)
	{
		$db =& JFactory::getDBO();
		$x= count($category);
	if($x =='1')  // get multible quotes when one category is selected 	
		{
		$query = "SELECT * from	#__rquotes WHERE published ='1' AND catid=$category";
		}
	

	else  // get multible quotes when more than one category is selected 	
		{
			$x= count($category);

			$value= array($category);

			$rand_keys=array_rand($category,$x);
			$catid=	$category[$rand_keys[1]];

			$query = "SELECT * from	#__rquotes WHERE published='1' and catid = $catid";
		}	
		$db->setQuery( $query );
		$rows = $db->loadObjectList();

			/**
			* create array based on number of rows.
			*/
			$cnt = count($rows);
			$numbers = array_fill(0, $cnt,'');

			/**
			* Get  unique random keys from $numbers array.
			* change  to number of desired random quotes
			*/
			
			$rand_keys = array_rand($numbers,"$num_of_random");

			/**
			* create array of data rows to return.
			*/
			$qrows = array();

			foreach ($rand_keys as $key => $value) {

			$qrows[] = $rows[$value];
			}
		return $qrows;
		}
//-----------------------------------------------


		
			
	
//--------------------------------------------------------------------------------------------------------------------------------
function getSequentialRquote($category)
	{

	// by PD, not yet implemented

	// make use of cookie to store last displayed rquote

	// if cookies not enabled then fetch randomly
//$query = "SELECT * from	#__rquotes WHERE published='1' and catid = $category";
 
 
	$db =& JFactory::getDBO(); 	


$query = "SELECT * from	#__rquotes WHERE published='1' and catid = $category";
 
	$db->setQuery( $query );

	$rows = $db->loadObjectList();

 
	$numRows = count($rows) - 1;

	if (isset($_COOKIE['rquote'])){

		$i = intval($_COOKIE['rquote']);

		if ($i < $numRows)

			$i++;

		else 

			$i = 0;

 
		setcookie('rquote',$i,time()+3600);

		$row = array( $rows[$i] );

	} else {

		// pick a random value

		$i = rand(0, $numRows);

		setcookie('rquote',$i,time()+3600);

		$row = array( $rows[$i] );

	}

 
	return $row;

}

}
//-------------------------------------------------------------------------------------------------------------
function getTextFile(&$params,$filename)
{
jimport('joomla.filesystem.file');

		$path= JPATH_BASE."/modules/mod_rquotes/mod_rquotes/$filename";
		$cleanpath=JPATH::clean($path);
		$contents=JFile::read($cleanpath);
		$lines=explode("\n", $contents);
		$count=count($lines);
		$rows=explode("\n", $contents);
		$num=rand(0,$count-1);
		
	require(JModuleHelper::getLayoutPath('mod_rquotes','textfile'));

	return $rows;
 }
 
//----------------------------------------------------------------------------------------------------------------------- 
function getTextFile2(&$params,$filename)
{
	jimport('joomla.filesystem.file');

	$today=date("d");
	$num=($today-1);
	$path= JPATH_BASE."/modules/mod_rquotes/mod_rquotes/$filename";
	$cleanpath=JPATH::clean($path);
	$contents=JFile::read($cleanpath);
	$lines=explode("\n", $contents);
	$count=count($lines);
	$rows=explode("\n", $contents);

	require(JModuleHelper::getLayoutPath('mod_rquotes','textfile'));
	}

//------------------------------------------------------------------------------------------------	
function getDailyRquote($category,$x)
	{
	
	$db =& JFactory::getDBO();
	$query="SELECT count(*) from #__rquotes WHERE published='1' AND catid='$category'";
	$db->setQuery($query,0);
	$no_of_quotes=$db->loadResult();
	$query="SELECT * FROM #__rquotes_meta";
	$db->setQuery($query,0);
	$row=$db->loadRow();
	
	$number_reached = $row[1];
	$date_modified= $row[2];
	
	// get the current day of the month (from 1 to 31)

	$day_today = date("$x");

	
		if ($date_modified != $day_today){
		// we have reached the end of the quotes
		if ($number_reached >($no_of_quotes - 1)){
			$number_reached = 1;
			$db =& JFactory::getDBO();
			$query3 = "UPDATE `#__rquotes_meta` SET `date_modified`= '$day_today', number_reached = '$number_reached'";
			$db->setQuery($query3);
			$row=$db->query();
		} else {
		// we haven't reached the end of the quotes	- therefore we increment $number_reached
		
		$number_reached = $number_reached + 1;
		
		
		$query3 = "UPDATE `#__rquotes_meta` SET `date_modified`= '$day_today', number_reached = '$number_reached'";
	$db->setQuery($query3);
	$row=$db->query();
		}
	}
	// we get the quote with 'catid = $number_reached' from the database
	$getQuoteQuery = "SELECT * FROM #__rquotes WHERE published='1' AND catid = '$category' AND daily_number = '$number_reached'";
	$db->setQuery($getQuoteQuery,0);
	$row=$db->loadObjectList();
	
	return $row;
}
?>
