<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$msg='';
if($proses=='SAVE'){ 
	$tkk_id 	= $_POST['tkk_id'];
	$event_id 	= $_POST['event_id'];
	$subjek 	= $_POST['subjek'];
	$jtb1 		= $_POST['jtb1'];
	$jtb2 		= $_POST['jtb2'];
	$grade1 	= $_POST['grade1'];
	$grade2 	= $_POST['grade2'];
	
	if(empty($tkk_id)){
		$sql = "INSERT INTO _tbl_kursus_kriteria(event_id, subjek, jtb1, jtb2, 
		grade1, grade2) 
		VALUES(".tosql($event_id,"Text").", ".tosql($subjek,"Text").", ".tosql($jtb1,"Text").", ".tosql($jtb2,"Text").", 
		".tosql($grade1,"Text").", ".tosql($grade2,"Text").")";
		$rs = &$conn->Execute($sql);
		audit_trail($sql);
	} else {
		$sql = "UPDATE _tbl_kursus_kriteria SET 
			subjek=".tosql($subjek,"Text").",
			jtb1=".tosql($jtb1,"Text").",
			jtb2=".tosql($jtb2,"Text").",
			grade1=".tosql($grade1,"Text").",
			grade2=".tosql($grade2,"Text")." 
			WHERE tkk_id=".tosql($tkk_id,"Text");
		$rs = &$conn->Execute($sql);
		audit_trail($sql);
	}
	
	//print $sql;
	
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();
		</script>";
}
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}

</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
$sSQL="SELECT A.courseid, A.coursename, A.kampus_id, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;
?>
<form name="ilim" method="post">
<table width="100%" cellpadding="5" cellspacing="1" border="1" align="center">
    <tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
			<tr>
                <td width="25%" align="right"><b>Pusat Latihan @ Tempat Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td align="left"><font color="#0033FF" style="font-weight:bold">
                    <?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['kampus_id'])); ?></font>
                </td>	        
            </tr>
	        <tr>
                <td width="25%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="74%" align="left"><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rs->fields['startdate']);?> - <?php print DisplayDate($rs->fields['enddate']);?></td>                
            </tr>
		</table>
    </td></tr>
	<tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
            <tr>
                <td width="100%" align="left" colspan="3" bgcolor="#CCCCCC"><b>KRITERIA PEMILIHAN PESERTA KURSUS</b></td>
            </tr>
            <?php
            $sql_k = "SELECT * FROM _tbl_kursus_kriteria WHERE event_id=".tosql($id,"Text");
            $rs_det = &$conn->execute($sql_k);
            //print $sql_k;
            ?>
            
            <?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
                $rskk = &$conn->Execute($sqlkk);
            ?>
            <?php 
                $sqlkks = "SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
                if(!empty($rs->fields['category_code'])){ $sqlkks .= " AND category_code=".tosql($rs->fields['category_code'],"Number"); }
                if(!empty($rs->fields['SubCategoryCd'])){ $sqlkks .= " AND SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Number"); }
                $sqlkks .= " ORDER BY coursename";
                $rskks = &$conn->Execute($sqlkks);
            ?>
            <tr>
                <td align="right"><b>Prasyarat Kursus : </b></td> 
                <td align="left" colspan="2" >
                    <select name="subjek" onchange="query_data('include/get_kursus.php')">
                        <option value="">-- Sila pilih subjek --</option>
                        <?php while(!$rskks->EOF){ ?>
                        <option value="<?php print $rskks->fields['id'];?>" <?php if($rs_det->fields['subjek']==$rskks->fields['id']){ print 'selected'; }?>
                        ><?php print $rskks->fields['courseid'] . " - " . $rskks->fields['coursename'];?></option>
                        <?php $rskks->movenext(); } ?>
                    </select>
                </td>
            <tr>
                <td align="right"><b>Jumlah Tahun Berkhidmat : </b></td> 
                <td align="left">
                <select name="jtb1">
                    <option value="">-- Sila pilih --</option>
                    <option value="="<?php if($rs_det->fields['jtb1']=="="){ print 'selected'; }?>> = </option>
                    <option value=">="<?php if($rs_det->fields['jtb1']==">="){ print 'selected'; }?>> >= </option>
                    <option value="<="<?php if($rs_det->fields['jtb1']=="<="){ print 'selected'; }?>> <= </option>
                </select>
                &nbsp;&nbsp;&nbsp;
                <select name="jtb2">
                    <option value="">-- Sila pilih --</option>
                    <?php for($t=1;$t<=30;$t++){ ?>
                    <option value="<?php print $t;?>" <?php if($rs_det->fields['jtb2']==$t){ print 'selected'; }?>> <?php print $t;?> </option>
                    <?php } ?>        
                </select>        
                </td>
            </tr>
            <?php
            $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
            $rspg = &$conn->execute($sqlp);
            ?>
            <tr>
                <td align="right"><b>Gred Jawatan : </b></td>
                <td colspan="2">
                <select name="grade1">
                    <option value="">-- Sila pilih --</option>
                    <option value="="<?php if($rs_det->fields['grade1']=="="){ print 'selected'; }?>> = </option>
                    <option value=">="<?php if($rs_det->fields['grade1']==">="){ print 'selected'; }?>> >= </option>
                    <option value="<="<?php if($rs_det->fields['grade1']=="<="){ print 'selected'; }?>> <= </option>
                </select>
                &nbsp;&nbsp;&nbsp;
                <select name="grade2">
                    <?php while(!$rspg->EOF){ ?>
                    <option value="<?php print $rspg->fields['f_gred_code'];?>" <?php if($rspg->fields['f_gred_code']==$rs_det->fields['grade2']){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                    <? $rspg->movenext(); } ?>
               </select>   
                </td>
            </tr>
		</tr>
     </table>
     </td></tr>  
    <tr>
        <td colspan="3" align="center">
        <?php if($btn_display==1){ ?>
            <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
        <?php } ?>
            <!--<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >-->
            <input type="hidden" name="event_id" value="<?=$id?>" />
            <input type="hidden" name="tkk_id" value="<?=$rs_det->fields['tkk_id']?>" />
            <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
        </td>
    </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.kategori.focus();
</script>
