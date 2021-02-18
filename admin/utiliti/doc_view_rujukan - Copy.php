<script language="javascript">
function do_submit(URL){
	document.frm.action = URL;
	document.frm.target = '_self';
	document.frm.submit();
}

function do_hapus(URL){
	if(confirm("Adakah anda pasti?")){
		document.frm.actions.value = 'DELETE';
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}
	function do_cetak(id){
		document.frm.doc_id.value = id;
		document.frm.action = 'laporan/doc_rujukan_cetak.php';
		document.frm.target = '_blank';
		document.frm.submit();
	}
</script>
<?
//$id = $_GET['id'];
$PageNo = $_GET['PageNo'];
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM doc_rujukan WHERE doc_id='$id'";
	$result = &$conn->Execute($sql);
	if(!$result){ echo "Invalid query : " . mysql_errno(); }
	$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Dokumen Rujukan";
} else {
	$title = "Dokumen Rujukan";
}
?>
<table width="95%" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="1" cellpadding="5" align="center">
	<tr>
    	<td colspan="2" height="40">
        	<table width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%" align="center"><h3><?=$title;?></h3></td>
                    <td width="2%" align="right">&nbsp;</td>
                </tr>
                <tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%">
                    	<table width="100%">
                          <tr>
                            <td width="20%" valign="top" align="left">Nama Dokumen :</td>
                            <td width="80%" align="left"><?php echo $row['dokumen_tajuk']?></tr>
                          <tr>
                            <td valign="top" align="left">Maklumat :</td>
                            <td align="left"><?=$row['dokumen']?></td>
                          </tr>

                          <tr>
                            <td align="left" valign="top">Senarai Lampiran : </td>
                            <td align="left">
                            	<table width="100%" cellpadding="4" cellspacing="1" border="0" bgcolor="#000000">
                                	<tr bgcolor="#CCCCCC" align="center">
                                    	<td width="5%">Bil</td>
                                        <td width="40%">Tajuk</td>
                                        <td width="40%">Nama Dokumen</td>
                                        <td width="10%">Jenis</td>
                                    </tr>
                                <?
									$sql_doc = "SELECT * FROM tbl_attachment WHERE soalan_id='".$id."'";
									$rs_doc = &$conn->Execute($sql_doc);
									$bil = 0;
									while($row_doc = mysql_fetch_assoc($rs_doc)){
									$bil++;
								?>    
                                	<tr bgcolor="#FFFFFF">
                                    	<td width="5%" align="right"><?=$bil;?>.&nbsp;</td>
                                        <td width="40%"><?php print $row_doc['file_tajuk'];?></td>
                                        <td width="40%"><a href="doc/<?php print $row_doc['file_name'];?>" target="_blank"><?php print $row_doc['file_name'];?></a></td>
                                        <td width="10%" align="center"><?php print $row_doc['file_type'];?></td>
                                    </tr>
                                <?php }
								?>
                                </table>
                            </td>
                          </tr>

                          <tr>
                            <td align="center" colspan="2"><br /><br />
                              <img src="img/printer.png" border="0" title="Cetak Dokumen Rujukan" style="cursor:pointer" onclick="do_cetak('<?=$row['doc_id']?>')" />
                              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="button" name="button3" id="button3" value="Kembali" 
                              onclick="do_submit('index.php?data=<?=base64_encode('utiliti/doc_view_list.php;');?>&PageNo=<?php echo $PageNo?>')" />
                              <input type="hidden" name="doc_id" value="<?php echo $row['doc_id']?>" />
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
