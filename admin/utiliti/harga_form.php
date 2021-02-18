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
	$sql = "SELECT * FROM harga WHERE id_harga=$id";
	$result = &$conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Harga";
} else {
	$title = "Tambah Maklumat Harga";
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
                            <td width="16%">Destinasi :</td>
                            <td width="84%">
                              <input name="destinasi" type="text" size="50" maxlength="80" 
                              value="<?php echo $row['destinasi']?>" />    </td>
                          </tr>
                          <tr>
                            <td>Kelas :</td>
                            <td><input name="kelas" type="text" size="15" maxlength="15" 
                            value="<?php echo $row['kelas']?>" /></td>
                          </tr>
                          <tr>
                            <td>Sehala (RM) :</td>
                            <td><input name="sehala" type="text" size="50" maxlength="50" 
                            value="<?php echo $row['sehala']?>" /></td>
                          <!--</tr>
                        <?
                          $sqlb = "SELECT * FROM bahagian";
                          $res_b = &$conn->Execute($sqlb);
                          ?>
                          <tr>-->
						  </tr>
                          <tr>
                            <td>Dua Hala (RM)  :</td>
                            <td><input name="dua_hala" type="text" size="10" maxlength="10" value="<?php echo $row['dua_hala']?>" /></td>
                          </tr>
                          <tr>
                            <td>Cukai :</td>
                            <td>
                              <input name="cukai" type="text" size="10" maxlength="10" value="<?php echo $row['cukai']?>" />
</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td><input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_submit('harga_do.php')" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button2" value="Hapus" 
                              onclick="do_hapus('harga_do.php?act=DELETE')" />
                            <?php } ?>
                              <input type="button" name="button3" id="button3" value="Kembali" 
                              onclick="do_submit('harga.php?PageNo=<?php echo $PageNo?>')" />
                              <input type="hidden" name="id_harga" value="<?php echo $row['id_harga']?>" />
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