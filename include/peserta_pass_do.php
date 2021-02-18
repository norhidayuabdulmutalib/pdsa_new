<?
//include 'loading.php';
$s_userid = $_SESSION["s_userid"];
$pass 	= md5($_POST['retype_pass']);
$m_update_dt = date("Y-m-d H:i:s");

// proses penghapusan data
// proses kemaskini data
$sql = "UPDATE _tbl_user SET 
f_password=".tosql($pass,"Text").",  f_updatedt=". tosql($m_update_dt,"Text") . "  
WHERE id_user=".tosql($s_userid,"Text");
//$conn->debug=true;
$result = $conn->Execute($sql);
if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
//exit;
//$url = base64_encode('mohon;permohonan/pelajar_bio_penjaga.php;biodata;ibubapa;');
$url = base64_encode('user;default.php;default;;;');
//echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
?>
<form name="ilim" method="post" action="index.php?data=<?=$url;?>">
<table width="60%" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr>
    	<td width="100%" align="center"><br /><br />
        	<b>Syabas.<br />Anda telah mengubah kata laluan anda dengan yang baru.</b> <br /><br />
            <table width="100%" cellpadding="5" cellspacing="1" border="0">
            <tr><td width="50%" align="right"><b>ID anda : </b></td><td width="50%" align="left"><?=$_SESSION["s_logid"];?></td></tr>
            <tr><td width="50%" align="right"><b>Katalaluan : </b></td><td width="50%" align="left"><?=$_POST['retype_pass'];?></td></tr>
            </table>
        </td>
    </tr>
	<!--<tr>
    	<td align="center">
        	<input type="submit" value="Kembali" style="cursor:pointer" /> 
        </td>
    </tr>-->
</table>
</form>