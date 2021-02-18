<?
//$conn->debug=true;
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

if(!empty($proses) && $proses=='DEL'){
	$sql=isset($_REQUEST["sql"])?$_REQUEST["sql"]:"";
	$sqldel = "DELETE FROM auditlog ".$sql;
	//print $sqldel;
	$conn->Execute($sqldel);
	print '<script language=javascript>alert("Maklumat telah dihapuskan");</script>';
}

$sSQL="SELECT * FROM auditlog ";
$sSQL1 = " WHERE logid<>0 ";
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL1.=" AND trans_date>=".tosql(DBDate($tkh_mula)." 00:00:00"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL1.=" AND trans_date BETWEEN ".tosql(DBDate($tkh_mula)." 00:00:00")." AND ".tosql(DBDate($tkh_tamat)." 00:00:00"); } 
if(!empty($search)){ $sSQL1.=" AND ( log_user LIKE '%".$search."%' OR id_user LIKE '%".$search."%' )"; } 
$sSQL .= $sSQL1 . " ORDER BY trans_date DESC";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode('user;maintenance/logmasuk_list.php;admin;logmasuk');
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
	function do_hapus(URL){
		var rec = document.ilim.jum_rec.value;
		if(confirm("Sebanyak "+rec+" rekod tersenarai dalam carian anda.\nAdakah anda pasti untuk menghapuskan kesemua "+rec+" rekod ini daripada senarai?")){
			document.ilim.action = URL;
			document.ilim.target = '_self';
			document.ilim.submit();
		}
	}
</script>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="30%" align="right"><b>Tarikh Transaksi : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	Mula : 
			<input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
			<input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
		</td>
	</tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
            &nbsp;&nbsp;
			<input type="button" name="Hapus" value="  Hapus  " onClick="do_hapus('<?=$href_search;?>&pro=DEL')">
            <input type="hidden" name="sql" value="<?=$sSQL1;?>" size="100" />
            <input type="hidden" name="jum_rec" value="<?=$RecordCount;?>" />
		</td>
	</tr>
	<? include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT LOG MASUK PENGGUNA</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="1" cellpadding="5" cellspacing="0" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="45%" align="center"><b>Maklumat Proses</b></td>
                    <td width="20%" align="center"><b>Pengguna</b></td>
                    <td width="15%" align="center"><b>Masa</b></td>
                    <td width="10%" align="center"><b>IP</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['remarks']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['log_user']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['trans_date']);?>&nbsp;</td>
            				<td valign="top" align="left"><? echo stripslashes($rs->fields['ip']);?>&nbsp;</td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="5" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <? } ?>                   
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
