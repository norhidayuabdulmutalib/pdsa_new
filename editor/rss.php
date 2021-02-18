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



// send xml header
header('Content-Type: text/xml; charset=ISO-8859-1');
echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
error_reporting(0);


$dir=substr(__FILE__, 0, strrpos(__FILE__, "/")+1);

// load config
include_once($dir."config.inc.php");


?>

<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://my.netscape.com/rdf/simple/0.9/">
<channel>
<title><?=htmlspecialchars($rssTitle)?></title>
<link><?=$rssChannelUrl?></link>
<description><?=htmlspecialchars($rssDescription)?></description>
</channel>

<?
// Constructing RSS feed

// news data
$dat=$dir."data.dat";						
$foo=file($dat);
$stuff= new mdasort;
$stuff->sortkeys = array(array('time', $rssOrder));

if (count($foo)==0){
	$empty=true;
}else{
	$i=0;
	foreach ($foo as $line){
		$line=explode("|", rtrim($line));
		if ($line[2]=="static" || ($line[2]=="dynamic" && $line[1]<$now)){
			$stuff->data[$i] = array("id" => $line[0], "time" => $line[1], "mode" => $line[2], "title" => $line[3], "story" => $line[4], "teaser" => $line[5]);
			$i++;
		}		
	}
	if ($i>0){
		$stuff->msort();
		$numposts=count($stuff->data);
	}else{
		$empty=true;
		$numposts=0;
	}
}

$i=0;
$news = array_slice ($stuff->data, 0, $rssNumNews);

foreach ($news as $row){
	$title =  htmlspecialchars(html_entity_decode(strip_tags(stripslashes($row['title']))));
	$description = htmlspecialchars(html_entity_decode(strip_tags(stripslashes($row['teaser']))));
	$link = $rssNewspageUrl.((strpos($rssNewspageUrl, "?")!==false) ? "&amp;" : "?")."mnid=".$row['id'];
	$i++;

	echo '
	<item rdf:about="'.$link.'">
	<title>'.$title.'</title>
	<link>'.$link.'</link>
	<description>'.$description.'</description>
	</item>
	';

}
?>

</rdf:RDF>


