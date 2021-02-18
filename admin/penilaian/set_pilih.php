<?
//$conn->debug=true;
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$id_bhg=isset($_REQUEST["id_bhg"])?$_REQUEST["id_bhg"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$proses=isset($_REQUEST["proses"])?$_REQUEST["proses"]:"";
if(empty($proses)){

/*$sSQL="SELECT A.*, B.f_penilaian FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 ";
if(!empty($kategori)){ $sSQL.=" AND A.f_penilaianid =".tosql($kategori,"Number"); } 
if(!empty($search)){ $sSQL.=" AND A.f_penilaian_desc LIKE '%".$search."%' "; } 
$sSQL .= " AND A.f_penilaian_detailid NOT IN (SELECT f_penilaian_detailid FROM _tbl_penilaian_det_detail WHERE pset_id=".tosql($id).") ";
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";*/

$sSQL="SELECT * FROM _ref_penilaian_maklumat WHERE is_deleted=0 ";
if(!empty($kategori)){ $sSQL.=" AND f_penilaianid =".tosql($kategori,"Text"); } 
if(!empty($search)){ $sSQL.=" AND f_penilaian_desc LIKE '%".$search."%' "; } 
$sSQL .= " AND f_penilaian_detailid NOT IN (SELECT f_penilaian_detailid FROM _tbl_penilaian_det_detail WHERE pset_id=".tosql($id).") ";
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
$sSQL .= " ORDER BY f_penilaianid, f_penilaian_desc";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "modal_form.php?win=".base64_encode('penilaian/set_pilih.php;')."&id=".$id."&id_bhg=".$id_bhg;
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}

    function do_save(URL){
		if(confirm("Adakah anda pasti meneruskan proses pemilihan ini.")){
			document.ilim.proses.value = 'PILIH';	
			document.ilim.action = URL;
			document.ilim.submit();
		}
    }
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
	<?php $sqlb = "SELECT * FROM _ref_penilaian_kategori WHERE is_deleted=0";
		if($_SESSION["s_level"]<>'99'){ $sqlb .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
    $rs_kb = &$conn->Execute($sqlb);
    ?>
    <tr>
        <td width="30%" align="right"><b>Kategori Penilaian : </b></td>
        <td width="60%">&nbsp;
            <select name="kategori">
            	<option value="">-- Sila pilih --</option>
            <?php while(!$rs_kb->EOF){ ?>
                <option value="<?php print $rs_kb->fields['f_penilaianid'];?>" <?php if($rs_kb->fields['f_penilaianid']==$kategori){ print 'selected="selected"';}?>><?php print $rs_kb->fields['f_penilaian'];?></option>
            <?php $rs_kb->movenext(); } ?>
                <option value="A" <?php if($rs->fields['f_penilaianid']=='A'){ print 'selected'; }?>>Keseluruhan Kursus</option>
                <option value="B" <?php if($rs->fields['f_penilaianid']=='B'){ print 'selected'; }?>>Cadangan Penambahbaikan</option>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
			<input type="hidden" size="10" name="id" value="<?php echo $id;?>">
			<input type="hidden" size="10" name="id_bhg" value="<?php echo $id_bhg;?>">
		</td>
	</tr>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT RUJUKAN PENILAIAN</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<input type="button" value="Pilih" style="cursor:pointer" onclick="do_save('<?=$href_search;?>&pro=SAVE')" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="5%" align="center"><b>&nbsp;</b></td>
                    <td width="60%" align="center"><b>Maklumat Penilaian</b></td>
                    <td width="30%" align="center"><b>Kategori Penilaian</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $bil = 0; $count=0;
                    while(!$rs->EOF) {
						$count++;
						//$kat_blok = dlookup("_ref_kategori_blok","f_kb_desc","f_kb_id=".tosql($rs->fields['f_kb_id'],"Number"));
						$kat_penilaian = dlookup("_ref_penilaian_kategori","f_penilaian","f_penilaianid=".tosql($rs->fields['f_penilaianid']));
						if($rs->fields['f_penilaianid']=='A'){ $kat_penilaian='Keseluruhan Kursus'; }
						else if($rs->fields['f_penilaianid']=='B'){ $kat_penilaian='Cadangan Penambahbaikan'; }
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$count;?>.</td>
                            <td valign="top" align="center"><input type="checkbox" name="del[<?=$bil?>]"></td>
            				<td valign="top" align="left"><input type="hidden" size="5" name="penilaian_id[<?=$bil;?>]" value="<?=$rs->fields['f_penilaian_detailid'];?>">
							<?php echo stripslashes($rs->fields['f_penilaian_desc']);?>&nbsp;</td>
            				<td valign="top" align="left"><?php echo stripslashes($kat_penilaian);?>&nbsp;</td>
                        </tr>
                        <?
						$bil++;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">
          <input type="hidden" name="bil" value="<?=$bil;?>">
          <input type="hidden" name="proses" value="">    
</td></tr>
<tr><td align="center" colspan="2">
	<input type="button" value="Tutup" style="cursor:pointer" onclick="close_paparan()" />        
</td></td>
</table> 
</form>
<?php } else { ?>
    <?
	$proses = $_POST['proses'];
	if(empty($proses)){ $proses=isset($_REQUEST["proses"])?$_REQUEST["proses"]:""; }
	print "Pro:".$proses."<br>";
	$id = $_POST['id'];
	$id_bhg = $_POST['id_bhg'];
	$bil = $_POST['bil'];
	//print "Bil:".$bil;
	if($proses=='PILIH'){
		for($i=0;$i<$bil;$i++){
			if($_POST['del'][$i]=='on'){
				//print "<br>DD".$_POST['penilaian_id'][$i];
				$pdet_id = $_POST['penilaian_id'][$i];
				$sql = "INSERT INTO _tbl_nilai_bahagian_detail(nilaib_id, f_penilaian_detailid, f_status) 
				VALUES(".tosql($id_bhg,"Text").", ".tosql($pdet_id,"Text").", 0)";
				//print $sql."<br>";	
				$conn->Execute($sql);
			}
		}
		audit_trail("Pilih maklumat penilaian");
	} 
	if($proses=='DEL'){
		$id=isset($_REQUEST["pset_id"])?$_REQUEST["pset_id"]:"";
		$iddel=isset($_REQUEST["iddel"])?$_REQUEST["iddel"]:"";
		$sql = "DELETE FROM _tbl_nilai_bahagian_detail WHERE pset_detailid=".tosql($iddel);
		$conn->Execute($sql);
		audit_trail("Hapus: ".$sql);
	}	
	//print $sql;
	$sql = "UPDATE _tbl_penilaian_set SET 
	update_dt=".tosql(date("Y-m-d H:i:s"),"Text").",
	update_by=".tosql($_SESSION["s_userid"],"Text")."
	WHERE pset_id=".tosql($id,"Text");
	$rs = &$conn->Execute($sql);
	audit_trail($sql,"");
	//print $sql; exit;
    ?>
    <form id="myform" name="myform" method="post">
    	<table width="100%"><tr><td>&nbsp;</td></tr></table>
    </form>
    <script language="javascript" type="text/javascript">
		<!--
		parent.location.reload();
		parent.emailwindow.hide();
		//-->
    </script>
<?php } ?>
