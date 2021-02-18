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
// ************************** misc other variables - do not change **********************
// ************************************ below here! *************************************
// ************************* unless you know what you're doing **************************

//$dir=substr(__FILE__, 0, strrpos(__FILE__, "/")+1);
$dir='';
// load config
include_once($dir."config.inc.php");
include_once($dir."FCKeditor/fckeditor.php") ;

$dat=$dir."data.dat";						
$templatefile=$dir."templates.inc.php";		
$log=$dir."log.dat.php";							
$pathtowysiwyg=$pathtoscript."wysiwyg/";
setlocale(LC_TIME, $datelang);

$me= $_SERVER['PHP_SELF'];
$empty=false;
$now=time();
$version="1.6.4";

if (!isset($_GET['hash']) || $_GET['hash']=="") {
	srand($now);
	for ($i=0; $i<16 ; $i++) $secret.=chr(rand(60, 127));
	$secret=md5($secret);
	$hash=md5($_SERVER['HTTP_USER_AGENT'].$now.$secret);
}else $hash= $_GET['hash'];
$getvars="?hash=$hash";

if (isset($_REQUEST['do'])) 		$do=$_REQUEST['do'];
if (isset($_REQUEST['id'])) 		$id=$_REQUEST['id'];
if (isset($_REQUEST['action'])) 	$action=$_REQUEST['action'];
if (isset($_REQUEST['title'])) 	$title=$_REQUEST['title'];
if (isset($_REQUEST['name'])) 		$name=$_REQUEST['name'];
if (isset($_REQUEST['pwd'])) 		$pwd=$_REQUEST['pwd'];
if (isset($_REQUEST['email'])) 	$email=$_REQUEST['email'];
if (isset($_REQUEST['www'])) 		$www=$_REQUEST['www'];
if (isset($_REQUEST['story'])) 		$story=$_REQUEST['story'];
if (isset($_REQUEST['teaser'])) 		$teaser=$_REQUEST['teaser'];
if (isset($_REQUEST['time'])) 	$time=$_REQUEST['time'];
if (isset($_REQUEST['date'])) 	$date=$_REQUEST['date'];


// ************************** functions ***********************
// ************************************************************


function getkey($index, $stuff){
	foreach ($stuff->data as $key => $item){
		if ($item['id']==$index){
			$ret=$key;
			break;	
		}
	}
	return $ret;
}

function validemail($addr){
	return eregi("^[a-z0-9]+([_.-][a-z0-9]+)*@([a-z0-9]+([.-][a-z0-9]+)*)+\\.[a-z]{2,4}$", $addr);
}

function jsRedirect($url){
	echo "<script language=\"Javascript\" type=\"text/javascript\">\n<!--\n  location.href='$url'  \n//-->\n</script>";
}

function clearoldadmins() {
	global $log, $now, $adminexpire;
	include($log);
	if (count($admins)>0){
		$i=0;
		$fp=fopen($log, "w");
		fputs($fp, "<?\n");
		foreach ($admins as $line){
			if ($now-$line['time']<$adminexpire)
				fputs($fp, "\$admins[$i]['time']=".$line[time]."; \$admins[$i]['hash']='".$line['hash']."';\n");			
			$i++;
		}
		fputs($fp, "?>");
		fclose($fp);
	}
}

function saveposts($stuff){
	global $dat;
	$fp=fopen($dat, "w");
	foreach ($stuff as $item){
		$line=$item['id']."|".$item['time']."|".$item['mode']."|".$item['title']."|".$item['story']."|".$item['teaser']."\n";
		fputs($fp, $line);
	}
	fclose($fp);
}

function isloggedin() {
	global $log, $now, $adminexpire;
	include($log);
	$logged=false;
	if (count($admins)>0){
		foreach ($admins as $line){
			if ($line['hash']==md5($_GET['hash'])) $logged=true;
		}
	}
	return $logged;
}

function showmenu() {
	global $txtsign, $txtview, $txtadmin, $me, $getvars;
	echo "<div class='smtxt' style='margin-bottom:8px;'><a href='file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/$me$getvars&do=add'>$txtsign</a> :: <a href='file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/$me$getvars&do=view'>$txtview</a></div>"; 
}

function emailencoder ($str){
	for ($i=0; $i< strlen($str); $i++){
		$n=rand(0,10);
		if ($n>5) $foo.="&#".ord($str[$i]).";";
		else $foo.="&#x".sprintf("%X", ord($str[$i])).";";
	}
	return $foo;	
}

function getTemplate($tpl, $html){
	$match="/<\!\-\-$tpl\-\->(.*?)<\!\-\-$tpl\-\->/s";
	preg_match($match, $html, $tmp);
	return $tmp[1];		
}

if (!function_exists('str_ireplace'))
{
    function str_ireplace ($search, $replace, $subject, $count = null)
    {
        if (is_string($search) && is_array($replace)) {
            trigger_error('Array to string conversion', E_USER_NOTICE);
            $replace = (string) $replace;
        }
        if (!is_array($search)) {
            $search = array ($search);
        }
        if (!is_array($replace))
        {
            $replace_string = $replace;

            $replace = array ();
            for ($i = 0, $c = count($search); $i < $c; $i++)
            {
                $replace[$i] = $replace_string;
            }
        }
        $length_replace = count($replace);
        $length_search = count($search);
        if ($length_replace < $length_search)
        {
            for ($i = $length_replace; $i < $length_search; $i++)
            {
                $replace[$i] = '';
            }
        }
        $was_array = false;
        if (!is_array($subject)) {
            $was_array = true;
            $subject = array ($subject);
        }
        $count = 0;
        foreach ($subject as $subject_key => $subject_value)
        {
            foreach ($search as $search_key => $search_value)
            {
                $segments = explode(strtolower($search_value), strtolower($subject_value));
                $count += count($segments) - 1;
                $pos = 0;
                foreach ($segments as $segment_key => $segment_value)
                {
                    $segments[$segment_key] = substr($subject_value, $pos, strlen($segment_value));
                    $pos += strlen($segment_value) + strlen($search_value);
                }
                $subject_value = implode($replace[$search_key], $segments);
            }
            $result[$subject_key] = $subject_value;
        }
        if ($was_array === true) {
            return $result[0];
        }
        return $result;
    }
}

function paging(
	$pages,
	$pagevar="page",
	$ppv=10, 
	$first	="<a href='file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/%7Burl%7D'>&laquo;&laquo;&laquo;</a>&nbsp;",
	$firsts ="&laquo;&laquo;&laquo&nbsp;",
	$prev	="<a href='file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/%7Burl%7D'>&laquo;&laquo;</a>&nbsp;&nbsp;",
	$prevs	="&laquo;&laquo;&nbsp;&nbsp;",
	$num	="<a href='file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/%7Burl%7D'>{page}</a>",
	$nums	="{page}",
	$sep	="&nbsp;|&nbsp;",
	$more	="[<a href='file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/%7Burl%7D'>...</a>]",
	$next	="&nbsp;&nbsp;<a href='file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/%7Burl%7D'>&raquo;&raquo;</a>",
	$nexts	="&nbsp;&nbsp;&raquo;&raquo;",
	$last	="&nbsp;<a href='file:///C|/DOCUME%7E1/admin2/LOCALS%7E1/Temp/%7Burl%7D'>&raquo;&raquo;&raquo;</a>",
	$lasts	="&nbsp;&raquo;&raquo;&raquo;"){
	
	// get URI parameters			
	$getvars=$_SERVER['PHP_SELF']."?";
	foreach ($_GET as $key => $val){
		if ($key!=$pagevar){
			if (isset($val) && $val!=""){
				$getvars.="$key=$val&";
			}else{
				$getvars.="$key&";
			}
		}
	}
	
	$page=(is_numeric($_GET[$pagevar])) ? $_GET[$pagevar] : 1;
	$page=($page>$pages) ? $pages : $page;
	$prevpage=($page>1) ? $page-1 : 1;
	$nextpage=($page < $pages) ? $page+1 : $pages;
	$paging="";
	
	if ($pages>1){
		// first
		$paging.=($page>1) ? str_replace("{url}", "$getvars$pagevar=1", $first) : $firsts;
		// prev
		$paging.=($page>1) ? str_replace("{url}", "$getvars$pagevar=$prevpage", $prev) : $prevs;
		
		// pages		
		$ppvrange=ceil($page/$ppv);
		$start=($ppvrange-1)*$ppv;
		$end=($ppvrange-1)*$ppv+$ppv;
		$end=($end>$pages) ? $pages : $end;
		$paging.=($start>1) ? str_replace("{url}", "$getvars$pagevar=".($start-1), $more).$sep : "";
		for ($i=1; $i<=$pages; $i++){
			if ($i>$start && $i<= $end){
				$paging.=($page==$i) ? str_replace("{page}", $i, $nums).(($i<$end) ? $sep : "") : str_replace(array("{url}", "{page}"), array("$getvars$pagevar=$i", $i), $num).(($i<$end) ? $sep : "");
			}
		}
		$paging.=($end<$pages) ? $sep.str_replace("{url}", "$getvars$pagevar=".($end+1), $more) : "" ;
		
		// next
		$paging.=($page<$pages) ? str_replace("{url}", "$getvars$pagevar=$nextpage", $next) : $nexts;
		// last
		$paging.=($page<$pages) ? str_replace("{url}", "$getvars$pagevar=$pages", $last) : $lasts;
	}
				
	return $paging;
}

?>
<script language="JavaScript" type="text/javascript">
function addEvent(obj, evType, fn, useCapture){
  if (obj.addEventListener){
    obj.addEventListener(evType, fn, useCapture);
    return true;
  } else if (obj.attachEvent){
    var r = obj.attachEvent("on"+evType, fn);
    return r;
  } else {
    alert("Handler could not be attached");
  }
}

function getElement(id){
	var obj;
	if (document.getElementById){
		obj = document.getElementById(id);	
	}else if (document.all){
		obj = document.all.id;	
	}
	return obj;
}

function toggleStory(chb, id){
	var obj = getElement(id);
	if (chb.checked){
		obj.style.visibility = "visible";
		obj.style.height = "450px";
	}else{
		obj.style.visibility = "hidden";
		obj.style.height = "0";
	}
}
</script>


<?

// ************************** MAIN ****************************
// ************************************************************

// init
$foo=file($dat);
$stuff= new mdasort;
$stuff->sortkeys = array(array('time','DESC'));

if (count($foo)==0){
	$empty=true;
	$nextindex=1;
}else{
	$i=0;
	foreach ($foo as $line){
		$line=explode("|", rtrim($line));	
		if ($line[2]=="static" || ($line[2]=="dynamic" && $line[1]<$now) || isloggedin() ){
			$stuff->data[$i] = array("id" => $line[0], "time" => $line[1], "mode" => $line[2], "title" => $line[3], "story" => $line[4], "teaser" => $line[5]);
			$i++;
		}
	}
	if ($i>0){
		$stuff->sortkeys = array(array('id','DESC'));
		$stuff->msort();
		$foo=current($stuff->data);
		$nextindex=$foo['id']+1;
		$stuff->sortkeys = array(array('time','DESC'));
		$stuff->msort();
		$numposts=count($stuff->data);
	}else{
		$numposts=0;		
		$empty=true;
	}
}

// RSS stuff
if ($rssEnable){
	$info = pathinfo($_SERVER['PHP_SELF']);
	$info['dirname'] = ($info['dirname'] == "/") ? $info['dirname'] : $info['dirname']."/";
	$url = $info['dirname'].$pathtoscript."rss.php?mndo=rss";
	echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"$rssTitle\" href=\"$url\" />";
}

echo "\n\n<!-- start mynews $version -->\n\n";
echo "<table cellpadding='0' cellspacing='0' border='0' width='100%'><tr><td align='center'>";
clearoldadmins();


// admin stuff
if ($do=="admin") {
	
	if ($action=="login"){
		if ($name==$adminname && $pwd==$adminpwd){
			include($log);
			
			$fp=fopen($log, "w");
			fputs($fp, "<?\n");
			$i=0;
			if (count($admins)>0){
				foreach ($admins as $line){
					fputs($fp, "\$admins[$i]['time']=".$line[time]."; \$admins[$i]['hash']='".$line['hash']."';\n");			
					$i++;
				}
			}
			fputs($fp, "\$admins[$i]['time']=".$now."; \$admins[$i]['hash']='".md5($hash)."';\n?>");			
			fclose($fp);
			
			jsRedirect($me.$getvars);
		}
	}
	
	if ($action=="delete" && isloggedin()){
		$todel=getkey($id, $stuff);
		unset($stuff->data[$todel]);
		$stuff->msort();
		saveposts($stuff->data);
		$do="view";
	}else{
		?>
		<form action="<?=$me.$getvars?>" method="post" name="form2" class="smtxt">
		Admin Login<br><br>
		<table border="0" cellpadding="0" cellspacing="2" class="smtxt">
		<tr><td>Login&nbsp;&nbsp;</td><td>
		<input name="name" type="text" id="name" size="20">
		</td></tr><tr><td>Password&nbsp;&nbsp;</td>
		<td><input name="pwd" type="password" id="pwd" size="20"></td>
		</tr><tr><td>&nbsp;</td><td>
		<input type="submit" name="Submit" value="Login">
		<input name="do" type="hidden" id="do" value="admin">
		<input name="action" type="hidden" id="action" value="login">
		</td></tr></table> 
		</form>
		<?
	}
}

if (isloggedin()){
	showmenu();

	if ($do=="add"){
		if ($action=="save"){
		
			$error=false;
			$saveit=false;
			if ($title=="") $error.="<br>&raquo; $txtbadtitle";
			//if ($story=="") $error.="<br>&raquo;  $txtbadstory";
			if ($teaser=="") $error.="<br>&raquo;  $txtbadteaser";
			if ($date=="") $error.="<br>&raquo;  $txtbaddate";
					
			if ($error===false){
				
				$date = explode(".", $date);
				$daytime = explode(".", $_REQUEST['daytime']);
				$daytime[0] = (is_numeric($daytime[0]) &&  $daytime[0] >= 0 && $daytime[0] < 24) ? $daytime[0] : 23;
				$daytime[1] = (is_numeric($daytime[1]) &&  $daytime[1] >= 0 && $daytime[1] < 60) ? $daytime[1] : 59;
				$time = mktime($daytime[0], $daytime[1], 0, $date[1], $date[0], $date[2]);
				$story = ($_REQUEST['hasstory'] == 1) ? $_REQUEST['story'] : "";
	
				if ($id=="new"){
					$index=$numposts;
					$id=$nextindex;					
					$saveit=true;
				}else if (is_numeric($id)){
					$index=getkey($id, $stuff);
					$saveit=true;
				}
				
				if ($saveit){			
					$stuff->data[$index]['id']=$id;
					$stuff->data[$index]['time']=$time;
					$stuff->data[$index]['mode']=$_REQUEST['mode'];
					$stuff->data[$index]['title']=str_replace(array("|"), array(" "), $title);
					if ($wysiwyg===true){
						$stuff->data[$index]['teaser']=stripslashes(str_replace(array("\r", "\n", "|"), array(" ", " ", " "), $teaser));
						$stuff->data[$index]['story']=stripslashes(str_replace(array("\r", "\n", "|"), array(" ", " ", " "), $story));
					}else{
						$stuff->data[$index]['teaser']=str_replace(array("\r", "\n", "|"), array(" ", "<br>", " "), $teaser);
						$stuff->data[$index]['story']=str_replace(array("\r", "\n", "|"), array(" ", "<br>", " "), $story);
					}
					saveposts($stuff->data);
					$stuff->msort();
					$empty=false;
				}
				
				$do="view";
				
			}else echo "<div class='smtxt' style='color:#cc0000;'><b>$txterrors</b>$error<br><br><i>$txtclickback</i></div>";
		
		}else{
			if ($action=="edit"){
				$post=$stuff->data[getkey($id, $stuff)];
				$title= htmlentities(stripslashes($post['title']), ENT_QUOTES);b
				if ($wysiwyg===true){
					$teaser = ($post['teaser']);
					$story = ($post['story']);
				}else{
					$teaser=stripslashes(str_replace("<br>", "\n", htmlentities($post['teaser'], ENT_QUOTES)));
					$story=stripslashes(str_replace("<br>", "\n", htmlentities($post['story'], ENT_QUOTES)));
				}
				$time=$post['time'];
				$mode = $post['mode'];
				$hasstory = (trim($story) != "") ? true : false;
			}else{
				$title="";
				$story="";
				$time="notset";
				$id="new";
				$mode = "dynamic";
				$hasstory = true;
			}
			
			?>
			<form name="form1" method="post" action="<?=$me.$getvars?>" onSubmit="return submitForm();">
			<table border="0" cellpadding="2" cellspacing="0" class="smtxt">
			<tr>
			<td width="65">Date&nbsp;</td>
			<td>
			<input name="date" type="text" id="date" value="<?=date("d.m.Y", ($time=="notset") ? time() : $time);?>" style="width:100px;" maxlength="10"> [dd.mm.yyyy] &nbsp;&nbsp;
			<input name="daytime" type="text" id="time" value="<?=date("H.i", ($time=="notset") ? time() : $time);?>" style="width:80px;" maxlength="5"> [hh.mm]
			</td>
			</tr>
			<tr>
			<td>Mode&nbsp;</td>
			<td>
			<div style="float:left; padding-top:3px;">
			<input name="mode" type="radio" value="dynamic" id="dynamic" style="vertical-align:-3px;" <?=($mode=="dynamic") ? "checked" : ""?>/><label for="dynamic">dynamic</label>&nbsp;&nbsp;&nbsp;
			<input name="mode" type="radio" value="static" id="static" style="vertical-align:-3px;" <?=($mode=="static") ? "checked" : ""?>/><label for="static">static</label>&nbsp;
			</div>
			<div style="float:right; text-align:right; font-size:10px;">
			<strong>dynamic</strong> = news aren't shown when date is in future<br />
			<strong>static</strong> = news are always shown
			</div>
			</td>
			</tr>
						<tr>
			<td>Title&nbsp;</td>	
			<td>
			<input name="title" type="text" id="title" value="<?=$title?>" style="width:500px;" >
			</td></tr>
			
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
	
			<!-- Story -->
			<tr>
				<td valign="top">&nbsp;
				</td>
				<td>
				<input name="hasstory" type="checkbox" id="hasstory" value="1" <?=($hasstory === true) ? "checked" : ""?> style="vertical-align:-3px;" onChange="toggleStory(this, 'rowStory');"/>
				<label for="hasstory">has story</label> 
				</td>
			</tr>
			
			
			<tr>
				<td colspan="2" valign="top" style="padding:0px;">
			
					<div id="rowStory">
					<table border="0" cellpadding="2" cellspacing="0" class="smtxt" width="100%">	
					<tr>
					<td width="65" valign="top">Story&nbsp;
					</td><td>
					<div class="rte">
					<? if ($wysiwyg===true){ 
					
						$oFCKeditor = new FCKeditor('story') ;
						$oFCKeditor->BasePath = $pathtoscript.'FCKeditor/';
						$oFCKeditor->Value = $story;
						$oFCKeditor->Width = "100%";;
						$oFCKeditor->Height = 450;
						$oFCKeditor->Create() ;
					
					 } else { ?>
						<textarea name="story" cols="50" rows="5" id="story" style="width:500px"><?=$story?></textarea>
					<? }?>
					</div>
					</td>
					</tr>
					</table>
					</div>
					
					<script language="JavaScript" type="text/javascript">
					addEvent(window, 'load', toggleStory(getElement('hasstory'), 'rowStory'));
					</script>

				
				</td>
			</tr>
			
					
			<tr><td>&nbsp;</td><td>
			<input type="submit" name="Submit" value="<?=($id=="new") ? "Add" : "Save"?>">
			<input name="do" type="hidden" id="do" value="add">
			<input name="action" type="hidden" id="action" value="save">
			<input name="id" type="hidden" id="id" value="<?=$id?>">
			</td></tr>
			</table>
			</form>
			<?
		}
	}
}


// display posts
if ($do=="view" || !isset($do)){
	if (!$empty){
	
		$templates = implode("", file($templatefile));
		$tpl_teaser = getTemplate("TEASER", $templates);
		$tpl_story = getTemplate("STORY", $templates);
		
		// show full story of specific news
		if (is_numeric($_GET['mnid'])){
	
			$item = $stuff->data[getkey($_GET['mnid'], $stuff)];
			$item['title'] = stripslashes($item['title']);
			$item['teaser'] = stripslashes($item['teaser']);
			$item['story'] = stripslashes($item['story']);
			
			if ($wrap!==false) $item['story']=wordwrap($item['story'], $wrap, " ", 1);
			$match=array("{title}", "{time}", "{teaser}", "{story}", "{edit}", "{delete}", "{urltoallnews}");
			if (isloggedin()){
				$replace=array( $item['title'], 
								strftime($dateformat, $item['time']), 
								$item['teaser'], 
								$item['story'], 
								"<a href='$me$getvars&do=add&action=edit&id=".$item['id']."'>$txtedit</a>", 
								"<a href='$me$getvars&do=admin&action=delete&id=".$item['id']."&page=".$_GET['page']."'>$txtdelete</a>", 
								"$me$getvars&page=".$_GET['page']);
			}else $replace=array($item['title'], strftime($dateformat, $item['time']), $item['teaser'], $item['story'], "", "", "$me$getvars&page=".$_GET['page']);
			
			$tmp = str_replace($match, $replace, $tpl_story);
			ob_start();
			eval("?>".$tmp."<?");
			$tmpparsed = ob_get_contents();
			ob_end_clean();
			$html .= $tmpparsed;		
	
			echo stripslashes($html);
	
		
		// show all news
		}else{		
			$i=1;
			$from=(is_numeric($_GET['page'])) ? (($_GET['page']-1)*$ppp)+1 : 1;
			foreach($stuff->data as $item){
				if ($item['id']!=0 && $i>=$from && $i< ($from+$ppp) ){
				
					$item['title'] = stripslashes($item['title']);
					$item['teaser'] = stripslashes($item['teaser']);
					$item['story'] = stripslashes($item['story']);
					$hasstory = (trim($item['story']) != "") ? true : false;
					
					if ($wrap!==false) $item['story']=wordwrap($item['story'], $wrap, " ", 1);
					$match=array("{title}", "{time}", "{teaser}", "{story}", "{edit}", "{delete}", "{urltofullstory}");
					if (isloggedin()){
						$replace=array( $item['title'], 
										strftime($dateformat, $item['time']), 
										$item['teaser'], 
										$item['story'], 
										"<a href='$me$getvars&do=add&action=edit&id=".$item['id']."'>$txtedit</a>", 
										"<a href='$me$getvars&do=admin&action=delete&id=".$item['id']."&page=".$_GET['page']."'>$txtdelete</a>", 
										($hasstory === true) ? "$me$getvars&mnid=".$item['id']."&page=".$_GET['page'] : ""
										);
					}else{
						$replace = array($item['title'], 
										 strftime($dateformat, 
										 $item['time']), 
										 $item['teaser'], 
										 $item['story'], 
										 "", 
										 "", 
										 ($hasstory === true) ? "$me$getvars&mnid=".$item['id']."&page=".$_GET['page'] : ""
										 );
					}					
					$tmp = str_replace($match, $replace, $tpl_teaser);
					ob_start();
					eval("?>".$tmp."<?");
					$tmpparsed = ob_get_contents();
					ob_end_clean();
					$html .= $tmpparsed;		
				}		
				$i++;
			}
			echo stripslashes($html);
			$numpages=(fmod($numposts,$ppp)>0) ? floor($numposts/$ppp)+1 : ($numposts/$ppp);
			echo "<div class='smtxt'><br>";
			echo paging($numpages);
			echo "</div><br>";
		}
	}	
}


// closing table tags
// Please don't remove the 'powered by...' link
echo "</td></tr><tr class='smtxt'><td align='center' class='smsmall' height='20' valign='bottom'>";
if (!isloggedin()) echo "<a href='$me$getvars&do=admin'>$txtadmin</a> - ";
else echo "<a href='$me'>$txtlogout</a> - ";
echo "Powered by <a href='http://www.planetluc.com' target='_blank'>MyNews $version</a></td></tr></table>";
echo "\n\n<!-- end mynews $version -->\n\n";
?>
