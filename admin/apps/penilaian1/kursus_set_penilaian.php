<?
$conn->debug=true;
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

if(!empty($pro) && $pro=='PILIH'){
	$set_id=isset($_REQUEST["set_id"])?$_REQUEST["set_id"]:"";
	$sql = "UPDATE _tbl_kursus_jadual SET set_penilaian=".tosql($set_id)." WHERE id=".tosql($kid);
	//print $sql;
	$conn->execute($sql);
	
	print '<script>		
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
	</script>';
	exit;
}

$sSQL="SELECT * FROM _tbl_penilaian_set WHERE is_deleted=0 AND pset_status=0 ";
if(!empty($search)){ $sSQL.=" AND pset_tajuk LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY create_dt DESC";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "modal_form.php?win=".base64_encode('penilaian/kursus_set_penilaian.php;'.$kid);
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page1(URL){
		if(confirm("Adakah anda pasti untuk membuat pilihan ini?")){
			document.ilim.action = URL;
			document.ilim.target = '_self';
			document.ilim.submit();
		}
	}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
            <input type="text" name="kid" value="<?=$kid;?>" />
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT SET PENILAIAN</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="80%" align="center"><b>Tajuk Penilaian</b></td>
                    <td width="10%" align="center"><b>Tarikh Jana</b></td>
                    <td width="5%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?php echo stripslashes($rs->fields['pset_tajuk']);?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo stripslashes(DisplayDate($rs->fields['create_dt']));?>&nbsp;</td>
                            <td align="center">
                            	<img src="../img/dialog_ok.gif" width="25" height="25" style="cursor:pointer" title="Sila klik untuk pilih set penilaian" 
                                onclick="do_page1('<?=$href_search;?>&kid=<?=$kid;?>&set_id=<?=$rs->fields['pset_id'];?>&pro=PILIH')" />
                            </td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="5" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?
if($cnt<>0){
	$sFileName=$href_search;
	include_once 'include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 
</form>
