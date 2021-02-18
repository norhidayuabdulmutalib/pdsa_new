<?php
$j=isset($_REQUEST["j"])?$_REQUEST["j"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$bidang=isset($_REQUEST["bidang"])?$_REQUEST["bidang"]:"";
$subjek=isset($_REQUEST["subjek"])?$_REQUEST["subjek"]:"";
//print "BIDANG:".$_POST['bidang'];
//$subjek=isset($_REQUEST["subjek"])?$_REQUEST["subjek"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$inskategori=isset($_REQUEST["inskategori"])?$_REQUEST["inskategori"]:"";
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
print "K:".$kampusid;
if(!empty($pro) && $pro=='PILIH'){
	include_once '../../common.php';
	//$conn->debug=true;
	$ingid=isset($_REQUEST["ingenid"])?$_REQUEST["ingenid"]:"";
	$maxno = dlookup("_tbl_claim","MAX(cl_id)","1")+1;
	$sqli = "INSERT INTO _tbl_claim (cl_id, kampus_id, cl_ins_id, cl_month, cl_year, 
	create_dt, create_by, is_deleted, is_process)
	VALUES(".tosql($maxno).", ".tosql($kid).", ".tosql($ingid).", ".tosql(date("m")).", ".tosql(date("Y")).", 
	".tosql(date("Y-m-d H:i:s")).", ".tosql($ipdaye_by).",0 , 0)";
	print $sqli; exit;
	$conn->execute($sqli);
	$href_link = "../index.php?data=".base64_encode($userid.';penceramah/claim_form.php;penceramah;tuntutan;'.$maxno);
	?>
	<script language="javascript">
		parent.location.href="<?=$href_link;?>";
	</script>
	<?
	exit;
}

$sSQL="SELECT A.* FROM _tbl_instructor A";
if(!empty($subjek)){ $sSQL .= ", _tbl_kursus_jadual_det B, _tbl_kursus_jadual C"; }
if(!empty($bidang)){ $sSQL .= ", _tbl_instructor_kepakaran D"; }
$sSQL .= " WHERE A.is_deleted=0 AND A.instypecd ='01' ";
if(!empty($subjek)){ $sSQL .= " AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=".tosql($subjek); }
if(!empty($bidang)){ $sSQL .= " AND A.ingenid=D.ingenid AND D.inpakar_bidang=".tosql($bidang); }
if(!empty($inskategori)){ $sSQL .= " AND A.inskategori=".tosql($inskategori); }
//if(!empty($j)){ $sSQL.=" AND fld_jawatan='P' "; } 
if(!empty($search)){ $sSQL.=" AND (A.insname LIKE '%".$search."%' OR A.insid LIKE '%".$search."%') "; }
$sSQL .= " ORDER BY A.insname";
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
//print $sSQL;

$href_search = "modal_form.php?win=".base64_encode('penceramah/_penceramah_list.php');
?>
<script language="javascript" type="text/javascript">
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">
    <tr>
        <td width="30%" align="right"><b>Bidang : </b></td>
        <td width="70%">
            <select name="bidang" onchange="do_open('<?=$href_search;?>')" style="cursor:pointer" 
            	title="Sila buat pilihan untuk penyenaraian nama penceramah">
            <option value="">-- Sila pilih bidang --</option>
            <?php 
            //$r_gred = dlookupList('_ref_kepakaran', 'f_pakar_code,f_pakar_nama', '', 'f_pakar_nama');
            $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
            while (!$r_gred->EOF){ ?>
            <option value="<?=$r_gred->fields['f_pakar_code'] ?>" <?php if($bidang == $r_gred->fields['f_pakar_code']) echo "selected"; ?> >
            <?=$r_gred->fields['f_pakar_nama']?></option>
            <?php $r_gred->movenext(); }?>        
           </select></td>
    </tr>
    <tr>
        <td align="right"><b>Kategori Penceramah : </b></td>
        <td colspan="2">
        <select name="inskategori"  onchange="do_open('<?=$href_search;?>')" style="cursor:pointer" 
        	title="Sila buat pilihan untuk penyenaraian nama penceramah">
        	<option value="">-- Semua kategori --</option>
		<?php	
            $r_kat = &$conn->execute("SELECT * FROM _ref_kategori_penceramah ORDER BY f_kp_sort");
            while (!$r_kat->EOF){ ?>
            <option value="<?=$r_kat->fields['f_kp_id'] ?>" <?php if($inskategori == $r_kat->fields['f_kp_id']) echo "selected"; ?> >
            <?=$r_kat->fields['f_kp_kenyataan']?></option>
            <?php $r_kat->movenext(); }?>        
           </select></td>
        </td>
    </tr>
	<tr>
		<td align="right"><b>Maklumat Carian : </b></td> 
		<td align="left">
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_open('<?=$href_search;?>')" style="cursor:pointer" title="Sila klik untuk penyenaraian nama penceramah">
		</td>
	</tr>
<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="4" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PENCERAMAH</strong></font>
        </td>
    </tr>
    <tr>
        <td colspan="4" align="center">
            <table width="100%" border="1" cellpadding="3" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="30%" align="center"><b>Nama Penceramah</b></td>
                    <td width="15%" align="center"><b>Kategori</b></td>
                    <td width="10%" align="center"><b>No. HP</b></td>
                    <td width="35%" align="center"><b>Jabatan/Unit/Pusat</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
			             	<td valign="top" align="left"><a href="penceramah/_penceramah_list.php?pro=PILIH&ingenid=<?=$rs->fields['ingenid'];?>&kid=<?=$_SESSION['SESS_KAMPUS'];?>">
								<?php echo stripslashes($rs->fields['insname']);?></a>&nbsp;</td>
                            <td valign="top" align="center"><?php echo dlookup("_ref_kategori_penceramah","f_kp_kenyataan","f_kp_id=".$rs->fields['inskategori']);?>&nbsp;</td>
                            <td valign="top" align="center"><?php echo $rs->fields['insmobiletel'];?>&nbsp;</td>
                            <td valign="top" align="left"><?php echo $rs->fields['insorganization'];?>&nbsp;</td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
					$rs->Close();
                } else {
                ?>
                <tr><td colspan="5" width="100%" bgcolor="#FFFFFF"><b>No Record Found.</b></td></tr>
                <?php } ?>
                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="4">	
<?
$sFileName=$href_search;
?>
<?php include_once 'include/list_footer.php'; ?> </td></tr>
<tr><td>        
</td></td>
</table> 
</form>
