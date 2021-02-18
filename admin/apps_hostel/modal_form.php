<?php include '../common.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="../modalwindow/modal.js"></script>
<script language="javascript" type="text/javascript">	
function open_modal(URL,title,width,height){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
} //End "opennewsletter" function
</script>
<script language='javascript1.2' src='../script/RemoteScriptServer.js'></Script>
<script language="javascript" type="text/javascript">
function query_data(strFileName){
	//ClearListBox('lstDaerah');
	
	var code = document.ilim.kategori.value; 
	var URL = strFileName + '?code=' + code;
	//alert(URL);
	//document.ilim.action = URL;
	//document.ilim.target = '_blank';
	//document.ilim.submit();
	callToServer(URL);
}

/***************************************
 *** To get value from remote server ***
 *** and place them to listbox       ***
 ***************************************/
function handleResponse(ID,Data,lst){
	strID = new String(ID);
	strData = new String(Data);
	if(strID == ''){
		document.ilim.elements[lst].length = 0;
		document.ilim.elements[lst].options[0]= new Option('Pilih','');
	}else{
		splitID = strID.split(",");
		splitData = strData.split(",");
		document.ilim.elements[lst].options[0]= new Option('Pilih','');
		for(i=1;i<=splitID.length;i++){
			document.ilim.elements[lst].options[i]= new Option(splitData[i-1],splitID[i-1]);
		}
		document.ilim.elements[lst].length = splitID.length + 1;
	}
}
</script>
</head>
<?php
$win = base64_decode($_GET['win']);
$get_win = explode(";", $win);
$pages = $get_win[0]; // piece1
$id = $get_win[1]; // piece1
if($_SESSION["s_logid"]==1){
	print "PG: ".$pages . " / " . $id;
}?>
<body>
<table width="98%" align="center" cellpadding="4" cellspacing="0" border="0">
	<tr>
    	<td>
			<?php include $pages;?>
        </td>
    </tr>
</table>
</body>
</html>
