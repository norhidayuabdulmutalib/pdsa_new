<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;

$proses = $_GET['pro'];
$msg='';
if($proses=='SAVE'){ 
	$kampus_id 	 	= $_POST['kampus_id'];
	$id 			  = $_POST['id'];
	$kategori 		= $_POST['kategori'];
	$subkategori 	= $_POST['subkategori'];
	$courseid 		= $_POST['subjek'];
	$tkh_mula 		= DBDate($_POST['tkh_mula']);
	$tkh_tamat 		= DBDate($_POST['tkh_tamat']);
	$ddStHour 		= $_POST['ddStHour'];
	$ddStMinute 	= $_POST['ddStMinute'];
	$ddEndHour 		= $_POST['ddEndHour'];
	$ddEndMinute 	= $_POST['ddEndMinute'];
	$tempat 			= $_POST['tempat'];
	$masa_daftar		= $_POST['txt_daftar'];
	$masa_taklimat	= $_POST['txt_taklimat'];
	$status 		= $_POST['status'];
	$jumkos 		= $_POST['jumkos'];
	$jumkceramah 	= $_POST['jumkceramah'];
	$bilik_kuliah 	= $_POST['bilik_kuliah'];
	$lelaki 		= $_POST['lelaki'];
	$perempuan 		= $_POST['perempuan'];
	$vip	 		= $_POST['vip'];
	$penyelaras		= $_POST['penyelaras'];
	$penyelaras_email	= $_POST['penyelaras_email'];
	$penyelaras_notel	= $_POST['penyelaras_notel'];
	$asrama_perlu	= $_POST['asrama_perlu'];
	$catatan		= $_POST['catatan'];
	$no_rujukan_surat		= $_POST['no_rujukan_surat'];
	
	$timestart = $ddStHour.":".$ddStMinute.":00";
	$timeend = $ddEndHour.":".$ddEndMinute.":00";

	$jumkos = str_replace(",","",$jumkos);
	$jumkceramah = str_replace(",","",$jumkceramah);
	
	if(!empty($tkh_tamat)){ $enddt_nilai = get_jadual_kursus($tkh_tamat,'',7); }
	
	if(empty($id)){
		
		$id='E'.date("Ymd")."-". uniqid();
		$href = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;'.$id);
		$courseid1 = dlookup("_tbl_kursus","courseid","id=".tosql($courseid));
		$sql = "INSERT INTO _tbl_kursus_jadual(kampus_id, id, courseid, courseid1, category_code, sub_category_code, 
		startdate, enddate, enddate_nilai, timestart, 
		timeend, class, status, jumkos, 
		jumkceramah, bilik_kuliah, penyelaras_email, 
		lelaki, perempuan, vip, penyelaras, penyelaras_notel, create_by, asrama_perlu,
		masa_daftar, masa_taklimat, no_rujukan_surat) 
		VALUES(".tosql($kampus_id,"Text").", ".tosql($id,"Text").", ".tosql($courseid,"Text").", 
		".tosql($courseid1,"Text").", ".tosql($kategori,"Text").", ".tosql($subkategori,"Text").",
		".tosql($tkh_mula,"Text").", ".tosql($tkh_tamat,"Text").", ".tosql(DBDate($enddt_nilai),"Text").", ".tosql($timestart,"Text").", 
		".tosql($timeend,"Text").", ".tosql($tempat,"Text").", ".tosql($status,"Number").", ".tosql($jumkos,"Text").", 
		".tosql($jumkceramah,"Text").", ".tosql($bilik_kuliah,"Number").", ".tosql($penyelaras_email,"Text").",
		".tosql($lelaki,"Text").", ".tosql($perempuan,"Text").", ".tosql($vip,"Text").", ".tosql($penyelaras,"Text").", 
		".tosql($penyelaras_notel,"Text").", ".tosql($_SESSION["s_logid"]).",".tosql($asrama_perlu).",
		".tosql($masa_daftar).",".tosql($masa_taklimat).", ".tosql($no_rujukan_surat).")";
		//$conn->debug=true;
		$rs = &$conn->Execute($sql);
		audit_trail($sql,"");
		print "<script language=\"javascript\">
			//alert('Rekod telah disimpan');
			//parent.location.reload();
			</script>";
?>
	<table width="100%" cellpadding="5" cellspacing="0" border="0">
    	<tr height="100px">
        	<td align="center">Maklumat jadual kursus telah disimpan.<br />
            	<a href="<?=$href;?>&load_pages="><input type="button" value="OK" style="cursor:pointer"/></a>
            </td>
        </tr>
    </table>
<?php exit;
	} else {
		// Akan diaktifkan jika terdapat perubahan kepada tarikh kursus	
		//$conn->debug=true;
		$tkh_mula_hidden 	= DBDate($_POST['tkh_mula_hidden']);
		$tkh_tamat_hidden 	= DBDate($_POST['tkh_tamat_hidden']);

		$courseid1 = dlookup("_tbl_kursus","courseid","id=".tosql($courseid));
		//$conn->debug=true;
		$sql = "UPDATE _tbl_kursus_jadual SET kampus_id=".tosql($kampus_id).", 
			courseid=".tosql($courseid,"Text").", 		courseid1=".tosql($courseid1,"Text").",
			category_code=".tosql($kategori,"Text").",	sub_category_code=".tosql($subkategori,"Text").",
			startdate=".tosql($tkh_mula,"Text").",		enddate=".tosql($tkh_tamat,"Text").",
			enddate_nilai=".tosql(DBDate($enddt_nilai),"Text").", timestart=".tosql($timestart,"Text").",
			timeend=".tosql($timeend,"Text").",			class=".tosql($tempat,"Text").",
			status=".tosql($status,"Number").",			jumkos=".tosql($jumkos,"Text").",
			jumkceramah=".tosql($jumkceramah,"Text").",	bilik_kuliah=".tosql($bilik_kuliah,"Text").", 
			lelaki=".tosql($lelaki,"Text").", 			perempuan=".tosql($perempuan,"Text").",
			vip=".tosql($vip,"Text").",					penyelaras=".tosql($penyelaras,"Text").",
			penyelaras_notel=".tosql($penyelaras_notel,"Text").", penyelaras_email=".tosql($penyelaras_email,"Text").", 
			asrama_perlu=".tosql($asrama_perlu,"Text").", status=".$status.", 
			masa_daftar=".tosql($masa_daftar,"Text").", masa_taklimat=".tosql($masa_taklimat).",
			no_rujukan_surat=".tosql($no_rujukan_surat,"Text").",  
			update_dt=".tosql(date("Y-m-d H:i:s"),"Text").",	update_by=".tosql($_SESSION["s_logid"],"Text")."
			WHERE id=".tosql($id,"Text");
		
		//print $sql; exit;
		
		$rs = $conn->Execute($sql);

		audit_trail($sql,"");
		
		$tukar_tarikh=0;
		if($tkh_mula_hidden <> $tkh_mula) { $tukar_tarikh=1; }
		else if($tkh_tamat_hidden <> $tkh_tamat){ $tukar_tarikh=1; }
		else { $tukar_tarikh=0; }
		$conn->debug=false;
		if($status=='2'){ $tukar_tarikh=0; }
		
		if($tukar_tarikh==1){
			$conn->execute("UPDATE _tbl_kursus_jadual_tukar SET status=1 WHERE id_jadual_kursus=".tosql($id));
			$sqltarikh="INSERT INTO _tbl_kursus_jadual_tukar(id_jadual_kursus, tkh_mula, tkh_akhir, status,
			new_tkh_mula, new_tkh_akhir, create_by, create_dt, kat_perubahan)
			VALUES(".tosql($id).", ".tosql($tkh_mula_hidden).", ".tosql($tkh_tamat_hidden).", 0,
			".tosql($tkh_mula).", ".tosql($tkh_tamat).", ".tosql($_SESSION["s_logid"]).", ".tosql(date("Y-m-d H:i:s")).", 0)";
			$rs = &$conn->Execute($sqltarikh);
			audit_trail($sqltarikh,"KURSUS MASA");
			
			include 'email/email_penanguhan_kursus.php';
		}
		
		if($status=='2'){
			/*$sqli = "UPDATE _tbl_kursus_jadual_tukar SET status=1 WHERE id_jadual_kursus=".tosql($id);
			$conn->execute($sqli);
			audit_trail($sqli,"KURSUS MASA");
			
		} else if($status=='2'){*/
			$conn->execute("UPDATE _tbl_kursus_jadual_tukar SET status=1 WHERE id_jadual_kursus=".tosql($id));
			$sqltarikh="INSERT INTO _tbl_kursus_jadual_tukar(id_jadual_kursus, tkh_mula, tkh_akhir, status,
			create_by, create_dt, kat_perubahan)
			VALUES(".tosql($id).", ".tosql($tkh_mula_hidden).", ".tosql($tkh_tamat_hidden).", 0,
			".tosql($_SESSION["s_logid"]).", ".tosql(date("Y-m-d H:i:s")).", 1)";
			$rs = $conn->Execute($sqltarikh);
			audit_trail($sqltarikh,"KURSUS MASA");
			
			
			$conn->execute("UPDATE _tbl_kursus_jadual SET bilik_kuliah=NULL WHERE id=".tosql($id,"Text"));
			
			include 'email/email_pembatalan_kursus.php';
		}
		
		print "<script language=\"javascript\">
			alert('Rekod telah disimpan');
			//parent.location.reload();
			</script>";
	}
	//print $sql;
} else if($proses=='HAPUS'){
	//$conn->debug=true;
	//$sqld = "DELETE FROM _tbl_kursus_jadual_peserta WHERE EventId=".tosql($id);
	//$conn->Execute($sqld);
	//$sqld = "DELETE FROM _tbl_kursus_jadual WHERE id=".tosql($id);
	//$conn->Execute($sqld);
	$tkh=date("Y-m-d H:i:s");
	$by=$_SESSION["s_logid"];
	$sqld = "UPDATE _tbl_kursus_jadual_peserta SET is_deleted=1, delete_dt='{$tkh}', delete_by='{$by}' WHERE EventId=".tosql($id);
	$conn->Execute($sqld);
	$sqld = "UPDATE _tbl_kursus_jadual SET is_deleted=1, delete_dt='{$tkh}', delete_by='{$by}' WHERE id=".tosql($id);
	$conn->Execute($sqld);

	//exit;
	print "<script language=\"javascript\">
	alert('Rekod telah dihapuskan');
	//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
	//parent.emailwindow.hide();
	</script>";
}
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.kategori.value==''){
		alert("Sila pilih kategori terlebih dahulu.");
		document.ilim.kategori.focus();
		return true;
	} else if(document.ilim.subkategori.value==''){
		alert("Sila pilih pusat kursus terlebih dahulu.");
		document.ilim.subkategori.focus();
		return true;
	} else if(document.ilim.subjek.value==''){
		alert("Sila pilih subjek kursus terlebih dahulu.");
		document.ilim.subjek.focus();
		return true;
	} else if(document.ilim.no_rujukan_surat.value==''){
		alert("Sila masukkan no. rujukan surat terlebih dahulu.");
		document.ilim.no_rujukan_surat.focus();
		return true;
	} else if(document.ilim.jumkos.value==''){
		alert("Sila masukkan kos kursus terlebih dahulu.");
		document.ilim.jumkos.focus();
		return true;

	} else if(document.ilim.tkh_mula.value==''){
		alert("Sila masukkan tarikh mula kursus terlebih dahulu.");
		document.ilim.tkh_mula.focus();
		return true;
	} else if(document.ilim.tkh_tamat.value==''){
		alert("Sila masukkan tarikh tamat kursus terlebih dahulu.");
		document.ilim.tkh_tamat.focus();
		return true;
	} else if(document.ilim.ddStHour.value==''){
		alert("Sila pilih masa mula kursus terlebih dahulu.");
		document.ilim.ddStHour.focus();
		return true;
	} else if(document.ilim.ddEndHour.value==''){
		alert("Sila pilih masa tamat kursus terlebih dahulu.");
		document.ilim.ddEndHour.focus();
		return true;
	} else if(document.ilim.txt_daftar.value==''){
		alert("Sila masukkan masa pendaftaran terlebih dahulu.");
		document.ilim.txt_daftar.focus();
		return true;
	} else if(document.ilim.txt_taklimat.value==''){
		alert("Sila masukkan masa taklimat kursus terlebih dahulu.");
		document.ilim.txt_taklimat.focus();
		return true;
	} else if(document.ilim.penyelaras.value==''){
		alert("Sila masukkan nama penyelaras kursus terlebih dahulu.");
		document.ilim.penyelaras.focus();
		return true;
	} else if(document.ilim.penyelaras_email.value==''){
		alert("Sila masukkan emel penyelaras kursus terlebih dahulu.");
		document.ilim.penyelaras_email.focus();
		return true;
	} else if(document.ilim.penyelaras_notel.value==''){
		alert("Sila masukkan no. telefon penyelaras terlebih dahulu.");
		document.ilim.penyelaras_notel.focus();
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
//$conn->debug=true;
if(!empty($id)){
	$sSQL="SELECT A.*, B.startdate, B.enddate, B.timestart, B.timeend, B.class, B.status, B.jumkos, 
	B.jumkceramah, B.bilik_kuliah, B.set_penilaian, B.lelaki, B.perempuan, B.vip, B.penyelaras, 
	B.penyelaras_notel, B.category_code, B.jumkos_sebenar, B.jumkceramah_sebenar, B.penyelaras_email, B.asrama_perlu, 
	B.masa_daftar, B.masa_taklimat, B.no_rujukan_surat     
	FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE A.id=B.courseid AND B.id = ".tosql($id,"Text");
	$rs = &$conn->Execute($sSQL);
	//print $sSQL;
	$kampus_id = $rs->fields['kampus_id'];
} else {
	$btn_display=1;
	$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
}
?>

<form name="ilim" method="post">
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
    <?php if(!empty($msg)){ ?>
    <tr>
        <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php //print $msg;?></font></i></b></td>
    </tr>
    <?php } ?>
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Pusat Latihan @ Tempat Kursus : </b></label>
        <div class="col-sm-12 col-md-7">
            <font color="#0033FF" style="font-weight:bold">
            <?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($kampus_id)); ?></font>
            <input type="hidden" name="kampus_id" value="<?=$kampus_id;?>" />
        </div>
    </div>
    <!--<tr>
        <td align="right"><b><font color="#FF0000">*</font> Bidang : </b></td> 
        <td align="left" colspan="2" ><font color="#0033FF" style="font-weight:bold">
        	<?php //print dlookup("_ref_kepakaran","f_pakar_nama","f_pakar_code=".tosql($rs->fields['bidang_id'])); ?></font>
		</td>
    </tr>-->

    <?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
        $rskk = &$conn->Execute($sqlkk);
    ?>
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Kategori Kursus : </b></label>
        <div class="col-sm-12 col-md-7">
            <select class="form-control" name="kategori" onchange="query_data('include/get_kursus_catsub.php')">
                <option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['id'];?>" <?php if($rs->fields['category_code']==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
        </div>
    </div>
    
    <?php 
        $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_status=0 ";
        if(!empty($rs->fields['category_code'])){ $sqlkks .= " AND f_category_code=".tosql($rs->fields['category_code'],"Number"); }
        if(!empty($kampus_id)){ $sqlkks .= " AND kampus_id=".tosql($kampus_id,"Number"); }
		if($_SESSION["s_level"]<>'99'){ $sqlkks .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
        $sqlkks .= " ORDER BY SubCategoryNm";
        $rskks = $conn->query($sqlkks);
    ?>
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Pusat / Unit : </b></label>
        <div class="col-sm-12 col-md-7">
            <select class="form-control" name="subkategori"  onchange="query_subjek('include/get_subjek.php')">
                <option value="">-- Sila pilih pusat / unit --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($rs->fields['subcategory_code']==$rskks->fields['id']){ 
				print 'selected'; }?>><?php print $rskks->fields['SubCategoryNm'] ." - ".$rskks->fields['SubCategoryDesc'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </div>
    </div>

    <?php 
        $sqlkks = "SELECT A.id, A.courseid, A.coursename FROM _tbl_kursus A, _tbl_kursus_catsub B WHERE A.is_deleted=0 "; //subcategory_code
		$sqlkks .= " AND A.subcategory_code=B.id AND B.f_status=0 ";
		$sqlkks .= " AND A.kampus_id='{$kampus_id}'";
        if(!empty($rs->fields['category_code'])){ $sqlkks .= " AND A.category_code=".tosql($rs->fields['category_code'],"Number"); }
        if(!empty($rs->fields['SubCategoryCd'])){ $sqlkks .= " AND A.subcategory_code=".tosql($rs->fields['subcategory_code'],"Text"); }
        $sqlkks .= " ORDER BY A.courseid, A.coursename";
		//print $sqlkks."<br>".$rs->fields['SubCategoryCd'];
		//$conn->debug=true;
        $rskks = $conn->query($sqlkks);
    ?>
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Subjek : </b></label>
        <div class="col-sm-12 col-md-7">
            <select class="form-control" name="subjek" onchange="query_data('include/get_kursus.php')">
                <option value="">-- Sila pilih sub-kategori --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($rs->fields['courseid']==$rskks->fields['courseid']){ print 'selected'; }?>
                ><?php print $rskks->fields['courseid'] . " - " . $rskks->fields['coursename'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </div>
	</div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>No. Rujukan Surat : </b></label>
        <div class="col-sm-12 col-md-7">
            <input class="form-control" type="text" size="30" name="no_rujukan_surat"  value="<?php print $rs->fields['no_rujukan_surat'];?>" maxlength="30"/>
            &nbsp;&nbsp;<i>Cth: JAKIM(19.00)/12/700-1/1-2( )</i>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Kos Kursus @ Kos Makan/Minum (RM) : </b></label>
        <div class="col-sm-12 col-md-7">
      	    <input class="form-control" type="text" size="20" name="jumkos"  value="<?php print $rs->fields['jumkos'];?>"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <font color="#FF0000"><b>Kos Sebenar Kursus (RM) : </b><?php print number_format($rs->fields['jumkos_sebenar'],2);?></font>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kos Penceramah - <i>Anggaran</i> (RM) : </b></label>
        <div class="col-sm-12 col-md-7">
      	    <input class="form-control" type="text" size="20" name="jumkceramah"  value="<?php print $rs->fields['jumkceramah'];?>"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <font color="#FF0000"><b>Kos Sebenar Penceramah (RM) : </b><?php print number_format($rs->fields['jumkceramah_sebenar'],2);?></font>
        </div>
    </div>
    <!--<tr>
        <td align="right"><b>Kos Sebenar Kursus @ Kos Makan/Minum (RM) : </b></td>
      	<td align="left" colspan="2"><?php// print number_format($rs->fields['jumkos_sebenar'],2);?></td>
    </tr>
    <tr>
        <td align="right"><b>Kos Sebenar Penceramah (RM) : </b></td>
      	<td align="left" colspan="2"><?php //print number_format($rs->fields['jumkceramah_sebenar'],2);?></td>
    </tr>-->

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Tarikh Mula Kursus : </b></label>
        <div class="col-sm-8 col-md-3">
            <input class="form-control" type="date" width="40%" name="tkh_mula" value="<?php echo $tkh_mula;?>">
            <alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
        </div>

        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-2"><b><font color="#FF0000">*</font>Tarikh Tamat Kursus : </b></label>
		<div class="col-sm-8 col-md-3">
            <input class="form-control" type="date" width="40%" name="tkh_tamat" value="<?php echo $tkh_tamat;?>">
            <alt="" width="18" height="18" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/>
        </div>
    </div>    
        <input type="hidden" size="13" name="tkh_mula_hidden" value="<?php echo date(($rs->fields['startdate']));?>">
        <input type="hidden" size="13" name="tkh_tamat_hidden" value="<?php echo date(($rs->fields['enddate']));?>">
        
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-5 col-lg-3"><b>Masa Mula Kursus : </b></label>
        <div class="col-sm-12 col-md-1">
            <select class="form-control" name="ddStHour">
                <option value="00">Jam</option>
                    <?php
                    $mula = explode(":",$rs->fields['timestart']);
                    $varStHour = $mula[0];
                    $varStMinute = $mula[1];
                    $var_i=0;
                    $var_j=0;
                    for($var_i==0;$var_i<=23;$var_i++)
                    {
                        if($var_i<10){ $dvar_i = "0".$var_i; } else { $dvar_i = $var_i; }
                        if($varStHour==$dvar_i)									
                            echo "<option value=\"".$dvar_i."\" selected>".$dvar_i."</option>";
                        else
                            echo "<option value=\"".$dvar_i."\">".$dvar_i."</option>";
                    }
                    ?>
            </select>
        </div>
        <div class="col-sm-12 col-md-1">
            <select class="form-control" name="ddStMinute">
                <option value="00">Minit</option>
                <?php
                for($var_j==15;$var_j<=59;$var_j=$var_j+15)
                {
                    if($var_j<10){ $dvar_j = "0".$var_j; } else { $dvar_j = $var_j; }
                    if($varStMinute==$dvar_j)									
                        echo "<option value=\"".$dvar_j."\" selected>".$dvar_j."</option>";
                    else
                        echo "<option value=\"".$dvar_j."\">".$dvar_j."</option>";
                }
                ?>
            </select> 
        </div>
        <label class="col-form-label text-md-right col-12 col-md-5 col-lg-2"><b>Masa Tamat Kursus : </b></label>
        <div class="col-sm-12 col-md-1">
            <select class="form-control" name="ddEndHour">
                <option value="00">Jam</option>
                <?php
                $tamat = explode(":",$rs->fields['timeend']);
                $varEndHour = $tamat[0];
                $varEndMinute = $tamat[1];
                $var_k=0;
                $var_l=0;
                for($var_k==0;$var_k<=23;$var_k++)
                {
                    if($var_k<10){ $dvar_k = "0".$var_k; } else { $dvar_k = $var_k; }
                    if($varEndHour==$dvar_k)									
                        echo "<option value=\"".$dvar_k."\" selected>".$dvar_k."</option>";
                    else
                        echo "<option value=\"".$dvar_k."\">".$dvar_k."</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-sm-12 col-md-1">
            <select class="form-control"name="ddEndMinute">
                <option value="00">Minit</option>
                <?php
                for($var_l==0;$var_l<=59;$var_l=$var_l+15)
                {
                    if($var_l<10){ $dvar_l = "0".$var_l; } else { $dvar_l = $var_l; }
                    if($varEndMinute==$dvar_l)									
                        echo "<option value=\"".$dvar_l."\" selected>".$dvar_l."</option>";
                    else
                        echo "<option value=\"".$dvar_l."\">".$dvar_l."</option>";
                }
                ?>
            </select>
        </div>
    </div>
    
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Masa Pendaftaran : </b></label>
        <div class="col-sm-12 col-md-7">
        	<input class="form-control" type="text" size="25" name="txt_daftar" value="<?php print $rs->fields['masa_daftar'];?>" /> <i>Cth: 08:00 - :08:30 pagi</i>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Masa Taklimat : </b></label>
        <div class="col-sm-12 col-md-7">
        	<input class="form-control" type="text" size="25" name="txt_taklimat" value="<?php print $rs->fields['masa_taklimat'];?>" /> <i>Cth: 08:30 pagi</i>
        </div>
    </div>
   <!-- <tr>
        <td align="right"><b>Tempat : </b></td>
        <td align="left" colspan="2"><input type="text" size="70" name="tempat"  value="<?php //print $rs->fields['class'];?>"/></td>
    </tr>-->
    <!--<?php 
        $sqlkks = "SELECT * FROM _tbl_bilikkuliah WHERE is_deleted=0 ";
        $sqlkks .= " ORDER BY f_bb_id, f_ab_id, f_bilik_nama";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b>Bilik Kuliah : </b></td> 
        <td align="left" colspan="2" >
            <select name="bilik_kuliah" >
                <option value="">-- Sila pilih bilik kuliah --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['f_bilikid'];?>" <?php if($rs->fields['bilik_kuliah']==$rskks->fields['f_bilikid']){ print 'selected'; }?>><?php print $rskks->fields['f_bilik_nama'];?></option>
                <?php $rskks->movenext(); } ?>
            </select> 
            <input type="button" value=" ... " style="cursor:pointer" title="Sila klik untuk pilihan set penilaian" 
            onclick="open_modal('<?//=$href_link_set;?>&kid=<?//=$id;?>','Pilih set penilaian',90,90)" />
        </td>
    </tr>-->
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tempat : </b></label>
        <div class="col-sm-12 col-md-7">
        	<?php print dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs->fields['bilik_kuliah']));?>
        	<?php $href_bilik = "modal_form.php?win=".base64_encode('kursus/jadual_bilik_kuliah.php;'.$id); ?>
            &nbsp;&nbsp;
            <input type="button" class="btn btn-light p-2" value=" ... " style="cursor:pointer" title="Sila klik untuk pilihan bilik kuliah" 
            onclick="open_modal('<?=$href_bilik;?>&kid=<?=$id;?>','Pilih bilik kuliah',90,90)" />
            &nbsp;<i>(Sila klik untuk memilih atau membuat pertukaran bilik kuliah)</i>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>Nama Penyelaras : </b></label>
        <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" size="90" name="penyelaras" maxlength="120"  value="<?php print $rs->fields['penyelaras'];?>"/>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>E-mel Penyelaras : </b></label>
        <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" size="90" name="penyelaras_email" maxlength="120"  value="<?php print $rs->fields['penyelaras_email'];?>"/>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b><font color="#FF0000">*</font>No. Tel. Penyelaras : </b></label>
        <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" size="20" name="penyelaras_notel" maxlength="20"  value="<?php print $rs->fields['penyelaras_notel'];?>"/>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Bilangan Peserta : </b></label>
        <div class="col-sm-12 col-md-2">
        	Lelaki : 
                <input type="text" class="form-control" name="lelaki"  value="<?php print $rs->fields['lelaki'];?>"/>
        </div>
        <div class="col-sm-12 col-md-2">
            Perempuan :
                <input type="text" class="form-control" name="perempuan"  value="<?php print $rs->fields['perempuan'];?>"/>
        </div>
        <div class="col-sm-12 col-md-2">   
            Bilik VIP : 
                <input type="text" class="form-control" name="vip"  value="<?php print $rs->fields['vip'];?>"/>
        </div>
    </div>

    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kemudahan Penginapan Asrama : </b></label>
        <div class="col-sm-12 col-md-7">
            <select class="form-control" name="asrama_perlu">
                <option value="TIDAK" <?php if($rs->fields['asrama_perlu']=='TIDAK'){ print 'selected'; }?>>Tidak perlu</option>
                <option value="ASRAMA" <?php if($rs->fields['asrama_perlu']=='ASRAMA'){ print 'selected'; }?>>Asrama</option>
            </select>
        </div>
    </div>
    
    <div class="form-group row mb-4">
        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Status : </b></label>
        <div class="col-sm-12 col-md-7">
            <select class="form-control" name="status">
                <option value="0" <?php if($rs->fields['status']=='0'){ print 'selected'; }?>>Aktif</option>
                <option value="1" <?php if($rs->fields['status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                <option value="2" <?php if($rs->fields['status']=='2'){ print 'selected'; }?>>Kursus Dibatalkan</option>
                <option value="9" <?php if($rs->fields['status']=='9'){ print 'selected'; }?>>Kursus Ditutup</option>
            </select>
        </div>
    </div>
    
	<?php if(!empty($id)){ ?>
</table>
    <hr />

    <div colspan="3">
        <?php $kid = $rs->fields['id'];?>
        <?php include 'kursus_document.php'; ?>

        <?php } ?>

        <div colspan="3" align="center">
            <?php //if($btn_display==1){ ?>
                <button class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" ><i class="far fa-save"></i><b> Simpan</b></button>
                <?php if(!empty($id) && $_SESSION["s_level"]==99){ ?>
                <button class="btn btn-danger" value="Hapus" class="button_disp" title="Sila klik untuk menghapuskan maklumat" onClick="form_hapus('modal_form.php?<?php print $URLs;?>&pro=HAPUS')" ><i class="fas fa-trash"></i><b> Hapus</b></button>
                <?php } ?>
            <?php //} ?>
                <button class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai" onClick="form_back1()" ><b>Kembali</b></button>
                <input type="hidden" name="id" value="<?=$id?>" />
                <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
        </div>
    </div>

</form>
<script LANGUAGE="JavaScript">
	document.ilim.kategori.focus();
</script>
