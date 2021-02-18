<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$msg='';
if($proses=='SAVE'){ 
	$id 			= $_POST['id'];
	$jumkos_sebenar 		= $_POST['jumkos_sebenar'];
	$jumkceramah_sebenar 	= $_POST['jumkceramah_sebenar'];
	$jumkos_sebenar = str_replace(",","",$jumkos_sebenar);
	$jumkceramah_sebenar = str_replace(",","",$jumkceramah_sebenar);
	

	$sql = "UPDATE _tbl_kursus_jadual SET 
		jumkos_sebenar=".tosql($jumkos_sebenar,"Text").",
		jumkceramah_sebenar=".tosql($jumkceramah_sebenar,"Text").",
		update_dt=".tosql(date("Y-m-d H:i:s"),"Text").",
		update_by=".tosql($_SESSION["s_logid"],"Text")."
		WHERE id=".tosql($id,"Text");
	$rs = &$conn->Execute($sql);
	audit_trail($sql,"");
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();
		</script>";
}
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.jumkos_sebenar.value==''){
		alert("Sila masukkan kos sebenar kursus terlebih dahulu.");
		document.ilim.jumkos_sebenar.focus();
		return true;
	} else if(document.ilim.jumkceramah_sebenar.value==''){
		alert("Sila masukkan kos sebenar penceramah terlebih dahulu.");
		document.ilim.jumkceramah_sebenar.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
function form_back(URL){
	parent.emailwindow.hide();
}
function form_hapus(URL){
	if(confirm("Adakah anda pasti untuk menghapuskan rekod ini?")){
		document.ilim.action=URL;
		document.ilim.submit();
	}
}

</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT A.*, B.startdate, B.enddate, B.timestart, B.timeend, B.class, B.status, B.jumkos, B.jumkceramah, B.bilik_kuliah, B.set_penilaian, B.lelaki, 
	B.perempuan, B.vip, B.penyelaras, B.penyelaras_notel, B.category_code, B.jumkos_sebenar, B.jumkceramah_sebenar   
	FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE A.id=B.courseid AND B.id = ".tosql($id,"Text");
	$rs = &$conn->Execute($sSQL);
	//print $sSQL;
} else {
	$btn_display=1;
}
?>
<form name="ilim" method="post">
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
    <?php if(!empty($msg)){ ?>
    <tr>
        <td align="center" colspan="3"><b><i><font color="#FF0000"><?php //print $msg;?></font></i></b></td>
    </tr>
    <?php } ?>
    <tr>
        <td width="43%" align="right"><b><font color="#FF0000">*</font> Kategori Kursus : </b></td> 
      <td width="57%" colspan="2" align="left"><?php print dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code'])); ?></td>
    </tr>
    <?php 
        $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 ";
        if(!empty($rs->fields['category_code'])){ $sqlkks .= " AND f_category_code=".tosql($rs->fields['category_code'],"Number"); }
        $sqlkks .= " ORDER BY SubCategoryNm";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Pusat / Unit : </b></td> 
        <td align="left" colspan="2"><?php print dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'])); ?></td>
    </tr>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Subjek : </b></td> 
        <td align="left" colspan="2"><?php print $rs->fields['courseid']." - " .$rs->fields['coursename']; ?></td>
	</tr>
    <tr>
        <td align="right"><b>Tarikh Kursus : </b></td> 
        <td align="left">
            Mula : <?php echo DisplayDate($rs->fields['startdate']);?>
            &nbsp;&nbsp;&nbsp;Tamat : 
            <?php echo DisplayDate($rs->fields['enddate']);?>
        </td>
    </tr>
    <tr>
        <td align="right"><b>Masa Mula : </b></td> 
        <td align="left">
            <?php
			$mula = explode(":",$rs->fields['timestart']);
			$varStHour = $mula[0];
			$varStMinute = $mula[1];
			print $varStHour.":".$varStMinute;
			?>
         </td>
    </tr>
    <tr>
        <td align="right"><b>Masa Tamat : </b></td> 
        <td align="left">
            <?php
			$tamat = explode(":",$rs->fields['timeend']);
			$varEndHour = $tamat[0];
			$varEndMinute = $tamat[1];
			print $varEndHour.":".$varEndMinute;
			?>
        </td>
    </tr>

    <tr>
        <td align="right"><b>Nama Penyelaras : </b></td>
        <td align="left" colspan="2"><?php print $rs->fields['penyelaras'];?></td>
    </tr>
    <tr>
        <td align="right"><b>No. Tel. Penyelaras : </b></td>
        <td align="left" colspan="2"><?php print $rs->fields['penyelaras_notel'];?></td>
    </tr>

    <tr><td colspan="3"><hr /></td></tr>
    <tr>
        <td align="right"><b>Kos Kursus @ Kos Makan/Minum (RM) : </b></td>
      	<td align="left" colspan="2"><?php print number_format($rs->fields['jumkos'],2);?></td>
    </tr>
    <tr>
        <td align="right"><b>Kos Penceramah - <i>Anggaran</i> (RM) : </b></td>
      	<td align="left" colspan="2"><?php print number_format($rs->fields['jumkceramah'],2);?></td>
    </tr>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Kos Sebenar Kursus @ Kos Makan/Minum (RM) : </b></td>
      	<td align="left" colspan="2"><input type="text" size="20" name="jumkos_sebenar"  value="<?php print $rs->fields['jumkos_sebenar'];?>" /></td>
    </tr>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Kos Sebenar Penceramah (RM) : </b></td>
      	<td align="left" colspan="2"><input type="text" size="20" name="jumkceramah_sebenar"  value="<?php print $rs->fields['jumkceramah_sebenar'];?>"/></td>
    </tr>

    <tr><td colspan="3"><hr /></td></tr>

    <tr>
        <td colspan="3" align="center">
        	<?php //if($btn_display==1){ ?>
    	        <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
            <?php //} ?>
            <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
        </td>
    </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.jumkos_sebenar.focus();
</script>
