<?
//include 'loading.php';
$pass 	= md5($_POST['retype_pass']);
$m_update_dt = date("Y-m-d H:i:s");

// proses penghapusan data
// proses kemaskini data
$sql = "UPDATE _tbl_peserta SET 
f_pass=".tosql($pass,"Text").",  update_dt=". tosql($m_update_dt,"Text") . ", update_by=". tosql($_SESSION["s_logid"],"Text")." 
WHERE id_peserta=".tosql($_SESSION["s_userid"],"Text");
//$conn->debug=true;
$result = $conn->Execute($sql);
if(!$result){ echo "Invalid query : " . mysql_error(); exit; }
//exit;
//$url = base64_encode('mohon;permohonan/pelajar_bio_penjaga.php;biodata;ibubapa;');
$url = base64_encode('user;default.php;default;;;');
//echo "<meta http-equiv=\"refresh\" content=\"1; URL=index.php?data=".$url."\">";
?>
<form name="ilim" method="post" action="index.php?data=dXNlcjtkZWZhdWx0LnBocDtkZWZhdWx0">
<table width="60%" cellpadding="5" cellspacing="1" border="0">
	<tr>
    	<td width="100%" align="center" height="200px"><br />
        	<b>Syabas.<br />Anda telah mengubah kata laluan anda dengan yang baru. <br /><br />
            ID anda : <?=$_SESSION["s_userid"];?><br />
            Katalaluan : <?=$_POST['retype_pass'];?></b><br />
        </td>
    </tr>
	<tr>
    	<td align="center">
        	<input type="submit" value="Kembali" style="cursor:pointer" /> 
        </td>
    </tr>
</table>
</form>