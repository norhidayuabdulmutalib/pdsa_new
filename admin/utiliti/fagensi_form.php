<?
include "../top/top.php";
?>
<script language="JavaScript" src="../calender/calendar1.js"></script>
<script language="javascript">
function do_submit(URL){
	document.frm.action = URL;
	document.frm.target = '_self';
	document.frm.submit();
}

function do_hapus(URL){
	if(confirm("Adakah anda pasti?")){
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}
</script>
<?
$id = $_GET['id'];
$PageNo = $_GET['PageNo'];
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM agensi WHERE id_agensi=$id";
	$result = &$conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Agensi";
} else {
	$title = "Tambah Maklumat Agensi";
}
?>
<body>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<table width="90%" border="0" cellspacing="1" cellpadding="5" align="center">
	<tr>
    	<td colspan="2" height="40">
        	<table width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="2%" height="40" align="left" class="left_h">&nbsp;</td>
                    <td width="96%" class="middle_h" align="center"><h3><?=$title;?></h3></td>
                    <td width="2%" align="right" class="right_h">&nbsp;</td>
                </tr>
                <tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%">
                    	<table width="100%">
                          <tr>
                            <td width="20%">Nama Agensi :</td>
                            <td width="80%">                          <input name="nama_agensi" type="text" size="50" maxlength="80" 
                              value="<?php echo $row['nama_agensi']?>" /></td>
                          </tr>
                          <tr>
                            <td>No Pendaftaran:</td>
                            <td><input name="no_pendaftaran" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['no_pendaftaran']?>" /></td>
                          </tr>
                          <tr>
                            <td>Alamat :</td>
                            <td><input name="alamat" type="text" size="80" maxlength="80" 
                            value="<?php echo $row['alamat1']?>" /></td>
                          </tr>
						  <tr>
                            <td>Bandar :</td>
                            <td>
                              <input name="bandar" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['bandar']?>" />
                            </td>
                          </tr>
                          <tr>
                            <td>Poskod :</td>
                            <td><input name="poskod" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['poskod']?>" /></td>
                          </tr>
                          <tr>
                            <td>Negeri :</td>
                            <td>
                              <input name="negeri" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['negeri']?>" />
                            </td>
                          </tr>
                        
                        
                          <tr>
                            <td>No Tel :</td>
                            <td><input name="no_tel" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['no_tel']?>" /></td>
                          </tr>
                          <tr>
                            <td>Status :</td>
                            <td><input name="status" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['status']?>" /></td>
                          </tr>
                          <tr>
                            <td>Level : </td>
                            <td><input name="level" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['level']?>" /></td>
                          </tr>
                          <tr>
                            <td>Pegawai Agensi : </td>
                            <td><input name="pegawai_agensi" type="text" size="30" maxlength="30" 
                            value="<?php echo $row['level']?>" /></td>
                          </tr>
                          <tr>
                            <td>No Handphone :</td>
                            <td><input name="no_handphone" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['no_handphone']?>" /></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td><input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_submit('agensi_do.php')" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button2" value="Hapus" 
                              onclick="do_hapus('agensi_do.php?act=DELETE')" />
                            <?php } ?>
                              <input type="button" name="button3" id="button3" value="Kembali" 
                              onclick="do_submit('agensi.php?PageNo=<?php echo $PageNo?>')" />
                              <input type="hidden" name="id_agensi" value="<?php echo $row['id_agensi']?>" />
                              <input type="hidden" name="actions" id="actions" value="<?php echo $actions?>" />
                              <input type="hidden" name="PageNo" value="<?php echo $PageNo?>" />
                            </td>
                          </tr>
                                                </table>
                    </td>
                    <td width="2%" align="right" >&nbsp;</td>
                </tr>
            </table>
    	</td>
    </tr>
</table>
</form>
</td></tr></table>
<?php include "../top/footer.php"; ?>