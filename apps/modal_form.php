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
function openModal(URL){
	var height=screen.height-150;
	var width=screen.width-100;

	var returnValue = window.showModalDialog(URL, 'I-TIS','help:no;status:yes;scroll:yes;resize:yes;toolbar=yes;dialogHeight:'+height+'px;dialogWidth:'+width+'px');
	//window.open(URL,'name','height=255,width=250,toolbar=yes,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
	
	//var dialogFeatures = 'center:yes; dialogWidth:600px; location:no;dialogHeight:400px; edge:raised; help:no; resizable:no; scroll:no; status:no; statusbar:no; toolbar:no; menubar:no; addressbar:no; titlebar:no;';
	//newwindow2 = window.showModalDialog('Combo?start1=' + calEvent.start + '&end1=' + calEvent.end + '&ownerType=' + < %= ApplicationConstants.OWNER_TYPE_CALENDAR % > , 'app', dialogFeatures);
	
} 
</script>
<script language='javascript1.2' src='../script/RemoteScriptServer.js'></Script>
<script language="javascript" type="text/javascript">
function query_data(strFileName){
	var code = document.ilim.kategori.value; 
	var URL = strFileName + '?code=' + code;
	//alert(URL);
	//document.ilim.action = URL;
	//document.ilim.target = '_blank';
	//document.ilim.submit();
	callToServer(URL);
}

function query_subjek(strFileName){
	var code = document.ilim.kategori.value; 
	var pusat = document.ilim.subkategori.value; 
	var URL = strFileName + '?code=' + code +'&pusat=' + pusat;
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

function close_paparan(){
	parent.emailwindow.hide();
}
</script>
</head>
<?php
$win = base64_decode($_GET['win']);
$get_win = explode(";", $win);
$pages = $get_win[0]; // piece1
$id = $get_win[1]; // piece1
//if(!empty($_SESSION["s_logid"]) && $_SESSION["s_logid"]=='1'){
	//print "PG: ".$pages . " / " . $id;
//	print '<font color="#666666"><i><b>ID: ' . $id . '</b></i></font>';
//}
$sql = "SELECT A.*, Z.kampus_id, Z.f_level FROM _tbl_user Z, _tbl_menu_user A, _tbl_menu B 
WHERE Z.id_user=A.id_kakitangan AND A.menu_id=B.menu_id AND menu_link LIKE '%".$page."%' 
	AND A.id_kakitangan=".tosql($_SESSION["s_userid"]);
$rsmenus = &$conn->execute($sql);

$_SESSION['SESS_KAMPUS']=$rsmenus->fields['kampus_id'];
$_SESSION["s_level"]=$rsmenus->fields['f_level'];
$_SESSION['SESS_ADD']=$rsmenus->fields['is_add'];
$_SESSION['SESS_UPD']=$rsmenus->fields['is_upd'];
$_SESSION['SESS_DEL']=$rsmenus->fields['is_del'];

if($_SESSION["s_level"]=='99'){ 
	$sql_filter=''; 
	$sql_kampus='';
} else { 
	$sql_filter = '';
	$sql_kampus=" AND kampus_id=".$rsmenus->fields['kampus_id']; 
}

?>
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
