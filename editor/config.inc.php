<?
/*
############################### MyNews ##############################
### |-----------------------------------------------------------| ###
### |      COPYRIGHT 2004 by Lukas Stalder, planetluc.com       | ###
### |      DO NOT REDISTRIBUTE OR RESELL THIS SCRIPT            | ###
### |      ANY WAYS WITHOUT MY EXPLICIT PERMISSION!             | ###
### |      For support use support@planetluc.com but            | ###
### |      please read README.txt for installation first!       | ###
### |      Or visit the board at www.planetluc.com              | ### 
### |-----------------------------------------------------------| ###
#####################################################################
*/



error_reporting(0);


// ************************** CONFIG **************************
// ************************************************************

$ppp = 5;									// posts to display per page
$adminname = "admin";
$adminpwd = "pass";
$adminexpire = 20*60;						// time in seconds until admin has to relogin
$wrap = false; 								// max. length of a word (to avoid bad entries like "hhhheeeeeeeeelllllllllllloooooooooo" that destroy your design)
											// ATTENTION: if wysiwyg is on set $wrap=false; otherwise unwanted spaces are insertetd into html tags!!
$dateformat = "%e. %b. %G - %H:%M";					// %e -> day, %b -> short month, %G -> 4digit year; for all possibilities have a look at http://www.php.net/manual/de/function.strftime.php
$datelang = "en_US";						// language for formatted date output, de_DE -> german formatting; see http://www.php.net/manual/de/function.setlocale.php

// WYSIWYG editor settings
$pathtoscript = "";			// path from the file where mynews.inc.php is included to the folder where mynews.inc.php is actually stored in
											// with trailing slash if set!
$wysiwyg = true;							// turn wysiwyg editor on/off
$filesPathFromDocRoot = "csfj/editor/files/";	// Path to the folder where all uploaded files from FCKeditor are saved. Relative to the document root. with trailing slash!
//$filesPathFromDocRoot = "en/demo/mynews/files/";	// Path to the folder where all uploaded files from FCKeditor are saved. Relative to the document root. with trailing slash!
 
// language setttings
$txtsign = "add news item";					// menu item text
$txtview = "view news items";				// menu item text
$txtadmin = "admin";
$txtlogout = "logout";								
$txtbadtitle = "missing title";
$txtbadstory = "missing story";
$txtbadteaser = "missing teaser";
$txtbaddate = "missing date";
$txtclickback = "Click BACK in your browser!";
$txterrors = "Following errors occurred:";
$txtedit = "edit";
$txtdelete = "delete";
$txtoptional = "optional";

// RSS 0.9 settings
$rssEnable = true;							// set to true if you want to offer rss feed of your news
$rssTitle = "My Site's News";				// Title of teh RSS feed
$rssDescription = "Get the lates news from my very interesting site!";		// Description of RSS feed
$rssChannelUrl = "http://www.mysite.com";	// Base URL of your Site (doesn't really matter)
$rssNewspageUrl = "http://www.mysite.com/news.php";		// URL of the site where you did the 'mynews.inc.php'-include
$rssNumNews = 5;							// Number of News to display in the rss feed
$rssOrder = "ASC";							// order of news in the feed: ASC/DESC




// ************************** STYLE DEFs **********************
// ************************************************************
if ($_REQUEST['mndo']!="rss" && $fromFCK !== true){
?>

<style type="text/css">
<!--
.smtxt, .smtxt a {
	font-size: 11px;
}
.smsmall, .smsmall a {
	font-size: 9px;
	letter-spacing: 0px;
}
-->
</style>

<?
}



// ************************************************************
// ****************** functions - don't touch *****************
// ************************************************************

$now = time();
class mdasort {
    var $data;	
    var $sortkeys;
    
    function _sortcmp($a, $b, $i=0) {
        $r = strnatcmp($a[$this->sortkeys[$i][0]],$b[$this->sortkeys[$i][0]]);
        if ($this->sortkeys[$i][1] == "DESC") $r = $r * -1;
        if($r==0) {
            $i++;
            if ($this->sortkeys[$i]) $r = $this->_sortcmp($a, $b, $i);
        }
        return $r;
    }
    
    function msort() {
        if(count($this->sortkeys)) {
            usort($this->data,array($this,"_sortcmp"));
        }
    }
}

?>