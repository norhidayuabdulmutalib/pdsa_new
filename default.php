<?php include 'common.php'; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title>Sistem Maklumat Latihan ILIM (I-TIS)</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link href="css/css_default.css" rel="stylesheet" type="text/css">
<link href="css/system.css" rel="stylesheet" type="text/css" media="screen">
<script language="javascript" type="text/javascript">	
	function do_log(){
		if(document.login.uname.value==''){
			alert("Sila masukkan No. Kad Pengenalan diri anda tanpa tanda '-'.");
			document.login.uname.focus();
		} else if(document.login.upass.value==''){
			alert("Sila masukkan No. Kad Pengenalan anda sekali lagi.");
			document.login.upass.focus();
		} else {
			document.login.prolog.value='process';
			document.login.action = 'default.php';
			document.login.submit();
		}
	}
</script>
</head>
<?php
$proses=isset($_POST["prolog"])?trim($_POST["prolog"]):"";
//print 
if(!empty($proses) && $proses=='process'){
	//include 'loading.php';
	//$conn->debug=true;
	$msg='';
	$varUser=isset($_POST["uname"])?trim($_POST["uname"]):"";
	$varPswd=isset($_POST["upass"])?trim($_POST["upass"]):"";
	
	//$sql = "SELECT * FROM _tbl_peserta WHERE f_peserta_noic=".tosql($varUser,"Text")." AND f_pass=".tosql(md5($varPswd),"Text");
	$sql = "SELECT * FROM _tbl_peserta WHERE f_peserta_noic=".tosql($varUser,"Text")." AND f_peserta_noic=".tosql($varPswd,"Text");
	//$sql = "SELECT * FROM _tbl_peserta WHERE f_peserta_noic=".tosql($varUser,"Text");
	//print $sql; exit;
	$rslogin = &$conn->Execute($sql);
	
	if(!$rslogin->EOF){
	
		$_SESSION["s_usertype"]='PESERTA';
		$_SESSION["s_user"]='PESERTA';
		$_SESSION["s_level"]='PESERTA';
		$_SESSION["s_userid"]=$rslogin->fields['id_peserta'];
		$_SESSION["s_logid"]=$rslogin->fields['f_peserta_noic'];
		$_SESSION["s_username"]=$rslogin->fields['f_peserta_nama'];
		
		/*session_register("s_level");
		session_register("s_userid");
		session_register("s_username");*/
		$pok=1;
		$msg = 'Anda berjaya log masuk ke dalam sistem.';
		audit_log($msg,'Peserta','','');
		print "<script>
			<!--
			alert('Anda berjaya log masuk ke dalam sistem.');
			window.open('apps/index.php?data=dXNlcjtkZWZhdWx0X3Blc2VydGEucGhwO2RlZmF1bHQ7ZGVmYXVsdA==','_self');
			//-->
			</script>";
		exit;
	} else {
		$pok=0;
		$msg = 'Kombinasi ID Pengguna dan No Kad pengenalan anda salah.<br>Sila cuba sekali lagi.';
		audit_log($msg,'Peserta',$varUser,'ERR');
		/*print '<script>
			alert("Kombinasi ID Pengguna dan Katalaluan anda salah. Sila cuba sekali lagi.");
			document.location.href="systems.php";
			</script>';
		*/
	}
}
?>
<?
$i_text = 'images/banner/text_itis.png';
$i_kiri = 'images/banner/biru_kiri.jpg';
$i_kanan = 'images/banner/biru_kanan.jpg';
?>
<body leftmargin="0" topmargin="0" background="img/background_master.jpg" marginheight="0" marginwidth="0" style="height:700px">
<table width="90%" align="center" border="0" cellpadding="0" cellspacing="0">
<tbody>
	<tr>
  	<td valign="top" align="left">
    	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
            <td background="../img/b_left.gif">&nbsp;</td>
            <td>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                  <tr>
                    <td height="112" width="25%">
                        <img src="<?php print $i_kiri;?>" alt="left"/>
                    </td>
                    <td height="112" width="50%" align="center">
                        <img src="images/banner/text_itis.png" alt="logo" style="float:none" />
                    </td>
                    <td height="112" width="25%" align="right">
                        <img src="<?php print $i_kanan;?>" />
                    </td>
                  </tr>
                </table>
            </td>
            <td background="../img/b_right.gif">&nbsp;</td>
        </tr>
	</tbody>
  </table></td>
</tr></tbody></table>
<table width="793" align="center" border="0" cellpadding="0" cellspacing="0">
<tbody><tr>
  <td valign="top" align="left"><table width="793" border="0" cellpadding="0" cellspacing="0">
      <tbody>
      <tr valign="top" align="left">
        <td width="397" background="img/header_007.jpg" height="20"></td>
        <td width="396" background="img/header_008.jpg" height="20"></td>
      </tr>
    </tbody>
    </table>
    <table class="font-std" width="793" border="0" cellpadding="0" cellspacing="0">
    <tbody><tr valign="top" align="left">
      <td width="29" background="img/background_borderup_left.jpg"><img src="img/borderup_001_left.jpg" width="29" height="133"></td>
      <td width="736" bgcolor="#ffffff">
            <table class="font-std" width="94%" align="center" border="0" cellpadding="4" cellspacing="1">
              <tbody>
              	<tr valign="top">
                	<td height="100" colspan="3" align="center" valign="middle"><label style="font-family:Arial, Helvetica, sans-serif;font-size:20px;font-weight:bold">
                    SISTEM MAKLUMAT LATIHAN  ILIM (I-TIS)</label></td>
                </tr>
                <tr valign="middle">
                  <td width="80%" height="188" align="center" bgcolor="#CCCCCC">
                  	<form name="login" method="post">
                  	<table width="100%" cellpadding="3" cellspacing="0" border="0" class="font-std">
                    	<?php if(!empty($msg)){ ?>
                        <tr><td width="100%" colspan="2" align="center"><font color="#FF0000"><?php print $msg;?></font><br><br></td></tr>
                        <?php } ?>
                    	<tr>
                        	<td width="50%" align="right" valign="top"><b>No. Kad Pengenalan : </b></td>
                            <td width="50%" align="left" valign="top"><input type="text" name="uname" size="15" maxlength="20" value=""></td>
                        </tr>
                    	<tr>
                        	<td width="50%" align="right" valign="top"><b>No. Kad Pengenalan : </b></td>
                            <td width="50%" align="left" valign="top"><input type="password" name="upass" size="15" maxlength="20"><br><i>Sila masukkan sekali lagi No. Kad pengenalan anda bagi tujuan pengesahan</i></td>
                        </tr>
                    	<tr>
                        	<td width="100%" align="center" colspan="2">
                            	<input type="button" value="Masuk" style="cursor:pointer" onClick="do_log()">
                            	<input type="hidden" name="prolog">
                            </td>
                        </tr>
                    </table>
                    </form>
                  </td>
                </tr>
            </tbody></table>
            <p class="font-std" align="center">&nbsp; </p>
			</td>
          <td width="28" align="right" background="img/background_borderup_right.jpg"><img src="img/borderup_001_right.jpg" width="29" height="133"></td>
        </tr>
      </tbody></table>
      <table width="793" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr>
          <td valign="top" width="793" align="center" background="img/footer_001.jpg" height="42"><p class="font-small">�2010 Institut Latihan Islam Malaysia (ILIM-Jakim). </p></td>
        </tr>
      </tbody></table></td>
  </tr>
</tbody></table>
<p class="font-small" align="center">
System processing time:
0.0028 seconds. <br>
</p>
</body></html>
<script language="javascript">
document.login.uname.focus();
</script>