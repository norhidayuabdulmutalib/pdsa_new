<?
$dir='';
// load config
include_once($dir."config.inc.php");
include_once($dir."FCKeditor/fckeditor.php") ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form>
	<table width="100%">
			<!-- Teaser -->
			<tr>
			<td valign="top">Teaser&nbsp;
			</td><td>
			<div class="rte">
			<? if ($wysiwyg===true){ 
				$oFCKeditor = new FCKeditor('teaser') ;
				$oFCKeditor->BasePath = $pathtoscript.'FCKeditor/';
				$oFCKeditor->Value = $teaser;
				$oFCKeditor->Width = "100%";
				$oFCKeditor->Height = 300;
				$oFCKeditor->Create() ;
			 } else { ?>
				<textarea name="teaser" cols="50" rows="5" id="story" style="width:500px"><?=$teaser?></textarea>
			<? }?>
			</div>
			</td></tr>
	</table>
</form>
</body>
</html>
