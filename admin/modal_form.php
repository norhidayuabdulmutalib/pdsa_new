<?php @session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" >
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Sistem Maklumat Latihan ILIM</title>
		<!-- General CSS Files -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

		<!-- Template CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/components.css">
		<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
		<link href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,700,300,200" rel="stylesheet" type="text/css">
		<!-- <link rel="stylesheet" href="css/bootstrap-overrides.css" type="text/css" /> -->
		<!-- <link rel="stylesheet" href="modalwindow/modal.css" type="text/css" /> -->
		<!-- <link rel="stylesheet" href="../admin/modalwindow/dhtmlwindow.css" type="text/css" /> -->
		<link type="text/css" rel="stylesheet" href="cal/dhtmlgoodies_calendar.css" media="screen"></LINK>

		<!-- Datatable CSS -->
		<link rel="stylesheet" href="include/datatable/datatables.css">
		<link rel="stylesheet" href="include/datatable/datatables.min.css">


		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="script.js"></script>
		<SCRIPT type="text/javascript" src="cal/dhtmlgoodies_calendar2.js"></script>
		<script type="text/javascript" src="../admin/modalwindow/dhtmlwindow.js">
		/***********************************************
		* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
		* This notice must stay intact for legal use.
		* Visit http://www.dynamicdrive.com/ for full source code
		***********************************************/
		</script>

		<!-- General JS Scripts -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
		<script src="assets/js/stisla.js"></script>

		<!-- Template JS File -->
		<script src="assets/js/scripts.js"></script>
		<script src="assets/js/custom.js"></script>

		<!-- Datatable JS -->
		<script src="include/datatable/datatables.js"></script>
		<script src="include/datatable/datatables.min.js"></script>
		

		<!-- Page Specific JS File -->
		<!-- <script src="assets/js/page/index-0.js"></script> -->
		<script type="text/javascript" src="modalwindow/modal.js"></script>
		<?php //include 'common_modal.php'; 
		//ob_start();
		//ob_gzhandler();
		// ob_start("ob_gzhandler");
		// session_start();
		// date_default_timezone_set('Asia/Kuala_Lumpur');
		//error_reporting (E_ALL ^ E_NOTICE);
		// require_once('adodb.inc.php');
		// require_once 'include/dateformat.php';
		//require_once('include/color.php');
		//require_once('lang/lang.php');
		require_once('common.php');
		$time = microtime();
		$time = explode(" ", $time);
		$time = $time[1] + $time[0];
		$start = $time;
		$sistem = 'Portal I-TIS V2';
		$ip = $_SERVER['HTTP_HOST'];
		//print $ip;
		$DB_dbtype="mysqli"; $DB_hostname="jakimdb"; $DB_username="itis"; $DB_password="kioio&*(6uhwdihui&%hgui908"; $DB_dbname="itis";
		//print $DB_hostname."/".$DB_username."/".$DB_password."/".$DB_dbname;
		//$conn->debug=1;
		// var_dump($DB_dbtype);exit();
		// $conn = &ADONEWConnection($DB_dbtype);
		// $conn->Pconnect($DB_hostname, $DB_username, $DB_password, $DB_dbname);
		//$path_doc='var/www/html/eparlimen/doc/';
		$win = base64_decode($_GET['win']);
		$get_win = explode(";", $win);
		$pages = $get_win[0]; // piece1
		$id = $get_win[1]; // piece1
		//if(!empty($_SESSION["s_logid"]) && $_SESSION["s_logid"]=='1'){

		//$conn->debug=true;
		$skid=isset($_REQUEST["skid"])?$_REQUEST["skid"]:"";

		if($_SESSION["s_level"]=='99'){ 
			$sql_filter=''; 
			$sql_kampus='';
		} else { 
			$sql_filter = '';
			$sql_kampus=" AND kampus_id=".$_SESSION['SESS_KAMPUS']; 
		}

		//$conn->debug=false;
		?>
		<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ITIS</title>
		<link href="css/css_default.css" rel="stylesheet" type="text/css" media="screen">
		<link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
		<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
		<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
		/***********************************************
		* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
		* This notice must stay intact for legal use.
		* Visit http://www.dynamicdrive.com/ for full source code
		***********************************************/
		</script>
		<script type="text/javascript" src="../modalwindow/modal.js"></script> -->
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
		<!-- <script language='javascript1.2' src='../script/RemoteScriptServer.js'></Script> -->
		<script language="javascript" type="text/javascript">
		function query_data(strFileName){
			var code = document.ilim.kategori.value; 
			var kampus = document.ilim.kampus_id.value; 
			var URL = strFileName + '?code=' + code + '&kampus=' + kampus;
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
	
	<body>
		<Script Language='javascript' src='include/RemoteScriptServer.js'></Script>
		<table width="98%" align="center" cellpadding="4" cellspacing="0" border="0">
			<tr>
				<td>
				<?php //print $pages;?>
					<?php include $pages;?>
				</td>
			</tr>
		</table>
	</body>
</html>