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
		audit_trail($sql,"");
	} else {
		$sql = "UPDATE _tbl_kursus_kriteria SET 
			subjek=".tosql($subjek,"Text").",
			jtb1=".tosql($jtb1,"Text").",
			jtb2=".tosql($jtb2,"Text").",
			grade1=".tosql($grade1,"Text").",
			grade2=".tosql($grade2,"Text")." 
			WHERE tkk_id=".tosql($tkk_id,"Text");
		$rs = &$conn->Execute($sql);
		audit_trail($sql,"");
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
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan @ Tempat Kursus : </b></label>
        <div class="col-sm-12 col-md-7">
            <font color="#0033FF" style="font-weight:bold">
            <?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['kampus_id'])); ?></font>
        </div>	        
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kursus : </b></label>
        <div class="col-sm-12 col-md-7">
            <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?>
        </div>                
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori : </b></label>
        <div class="col-sm-12 col-md-7">
            <?php print $rs->fields['categorytype'];?>
        </div>                
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat : </b></label>
        <div class="col-sm-12 col-md-7">
            <?php print $rs->fields['SubCategoryNm'];?>
        </div>                
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh Kursus : </b></label>
        <div class="col-sm-12 col-md-7">
            <?php echo date('d-m-Y', strtotime($rs->fields['startdate'])) ?> - <?php echo date('d-m-Y', strtotime($rs->fields['enddate'])) ?>
            <!-- <?php //print DisplayDate($rs->fields['startdate']);?> - <?php //print DisplayDate($rs->fields['enddate']);?>                -->
        </div>
    </div>


    <div class="card  col-md-12">
        <div class="card-header" >
            <h4>KRITERIA PEMILIHAN PESERTA KURSUS</h4>
        </div>
        <div class="card-body">

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
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Prasyarat Kursus :</b></label>
                <div class="col-sm-12 col-md-7">
                    <select name="subjek" class="form-control" onchange="query_data('include/get_kursus.php')">
                        <option value="">-- Sila pilih subjek --</option>
                        <?php while(!$rskks->EOF){ ?>
                        <option value="<?php print $rskks->fields['id'];?>" <?php if($rs_det->fields['subjek']==$rskks->fields['id']){ print 'selected'; }?>
                        ><?php print $rskks->fields['courseid'] . " - " . $rskks->fields['coursename'];?></option>
                        <?php $rskks->movenext(); } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Jumlah Tahun Berkhidmat :</b></label>
                <div class="col-sm-12 col-md-3">
                    <select class="form-control" name="jtb1">
                        <option value="">-- Sila pilih --</option>
                        <option value="="<?php if($rs_det->fields['jtb1']=="="){ print 'selected'; }?>> = </option>
                        <option value=">="<?php if($rs_det->fields['jtb1']==">="){ print 'selected'; }?>> >= </option>
                        <option value="<="<?php if($rs_det->fields['jtb1']=="<="){ print 'selected'; }?>> <= </option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-3">
                    <select class="form-control" name="jtb2">
                        <option value="">-- Sila pilih --</option>
                        <?php for($t=1;$t<=30;$t++){ ?>
                        <option value="<?php print $t;?>" <?php if($rs_det->fields['jtb2']==$t){ print 'selected'; }?>> <?php print $t;?> </option>
                        <?php } ?>        
                    </select>        
                </div>
            </div>

            <?php
            $sqlp = "SELECT * FROM _ref_titlegred WHERE is_deleted=0 AND f_status=0 ORDER BY f_gred_code";
            $rspg = &$conn->execute($sqlp);
            ?>
            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Gred Jawatan : </b></label>
                <div class="col-sm-12 col-md-3">
                    <select class="form-control" name="grade1">
                        <option value="">-- Sila pilih --</option>
                        <option value="="<?php if($rs_det->fields['grade1']=="="){ print 'selected'; }?>> = </option>
                        <option value=">="<?php if($rs_det->fields['grade1']==">="){ print 'selected'; }?>> >= </option>
                        <option value="<="<?php if($rs_det->fields['grade1']=="<="){ print 'selected'; }?>> <= </option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-3">
                    <select class="form-control" name="grade2">
                        <?php while(!$rspg->EOF){ ?>
                        <option value="<?php print $rspg->fields['f_gred_code'];?>" <?php if($rspg->fields['f_gred_code']==$rs_det->fields['grade2']){ print 'selected'; }?>><?php print $rspg->fields['f_gred_code'] ." - ". $rspg->fields['f_gred_name'];?></option>
                        <?php $rspg->movenext(); } ?>
                    </select>   
                </div>
            </div>
		</div>
        <div align="center">
            <?php if($btn_display==1){ ?>
            <button class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" ><i class="far fa-save"></i><b> Simpan</b></button>
            <?php } ?>
            <!--<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >-->
            <input type="hidden" name="event_id" value="<?=$id?>" />
            <input type="hidden" name="tkk_id" value="<?=$rs_det->fields['tkk_id']?>" />
            <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
            </br>
        </div>
    </div>

</table>    
</form>

<script LANGUAGE="JavaScript">
	document.ilim.kategori.focus();
</script>
