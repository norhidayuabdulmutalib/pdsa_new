<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$msg='';
if($proses=='SAVE'){ 
	$id 			= $_POST['id'];
	$kampus_id 		= $_POST['kampus_id'];
	$kategori 		= $_POST['kategori'];
	$subkategori 	= $_POST['subkategori'];
	$courseid 		= $_POST['subjek'];
	$tkh_mula 		= DBDate($_POST['tkh_mula']);
	$tkh_tamat 		= DBDate($_POST['tkh_tamat']);
	$ddStHour 		= $_POST['ddStHour'];
	$ddStMinute 	= $_POST['ddStMinute'];
	$ddEndHour 		= $_POST['ddEndHour'];
	$ddEndMinute 	= $_POST['ddEndMinute'];
	$tempat 		= $_POST['tempat'];
	$status 		= $_POST['status'];
	$jumkos 		= $_POST['jumkos'];
	$bilik_kuliah 	= $_POST['bilik_kuliah'];
	$nama_subjek 	= $_POST['nama_subjek'];
	$lelaki 		= $_POST['lelaki'];
	$perempuan 		= $_POST['perempuan'];
	$vip	 		= $_POST['vip'];
	$penyelaras		= $_POST['penyelaras'];
	$penyelaras_notel = $_POST['penyelaras_notel'];
	$nama_agensi	= $_POST['nama_agensi'];
	$catatan		= $_POST['catatan'];
	$asrama_perlu	= $_POST['asrama_perlu'];
	
	$timestart = $ddStHour.":".$ddStMinute.":00";
	$timeend = $ddEndHour.":".$ddEndMinute.":00";
	
	if(empty($id)){
		$act="TAMBAH";
		$id="E".date("YmdHis");
		$sql = "INSERT INTO _tbl_kursus_jadual(id, kampus_id, courseid, category_code, sub_category_code, 
		startdate, enddate, timestart, 
		timeend, class, status, jumkos, bilik_kuliah, 
		acourse_name, lelaki, perempuan, vip, penyelaras, 
		penyelaras_notel, catatan, nama_agensi, create_by, asrama_perlu) 
		VALUES('{$id}',".tosql($kampus_id,"Text").", ".tosql($courseid,"Text").", ".tosql($kategori,"Text").", ".tosql($subkategori,"Text").", 
		".tosql($tkh_mula,"Text").", ".tosql($tkh_tamat,"Text").", ".tosql($timestart,"Text").", 
		".tosql($timeend,"Text").", ".tosql($tempat,"Text").", ".tosql($status,"Number").", ".tosql($jumkos,"Text").", ".tosql($bilik_kuliah,"Number").", 
		".tosql($nama_subjek).", ".tosql($lelaki,"Text").", ".tosql($perempuan,"Text").", ".tosql($vip,"Text").", ".tosql($penyelaras,"Text").", 
		".tosql($penyelaras_notel,"Text").", ".tosql($catatan,"Text").", ".tosql($nama_agensi,"Text").", ".tosql($_SESSION["s_logid"]).",".tosql($asrama_perlu).")";
		$rs = &$conn->Execute($sql);
		audit_trail($sql,"");
	} else {
		$act="UPDATE";
		$sql = "UPDATE _tbl_kursus_jadual SET 
			kampus_id=".tosql($kampus_id,"Text").",
			courseid=".tosql($courseid,"Text").",
			category_code=".tosql($kategori,"Text").",
			sub_category_code=".tosql($subkategori,"Text").",
			startdate=".tosql($tkh_mula,"Text").",
			enddate=".tosql($tkh_tamat,"Text").",
			timestart=".tosql($timestart,"Text").",
			timeend=".tosql($timeend,"Text").",
			class=".tosql($tempat,"Text").",
			status=".tosql($status,"Number").",
			jumkos=".tosql($jumkos,"Text").",
			acourse_name=".tosql($nama_subjek,"Text").", 
			lelaki=".tosql($lelaki,"Text").", 
			perempuan=".tosql($perempuan,"Text").",
			vip=".tosql($vip,"Text").",
			penyelaras=".tosql($penyelaras,"Text").",
			penyelaras_notel=".tosql($penyelaras_notel,"Text").",
			nama_agensi=".tosql($nama_agensi,"Text").",
			catatan=".tosql($catatan,"Text").",
			catatan=".tosql($catatan,"Text").",
			asrama_perlu=".tosql($asrama_perlu,"Text").",
			update_by=".tosql($_SESSION["s_logid"],"Text")."
			WHERE id=".tosql($id,"Text");
		$rs = &$conn->Execute($sql);
			//bilik_kuliah=".tosql($bilik_kuliah,"Text").", 
		audit_trail($sql,"");
	}
	
	if($act=='UPDATE'){
		print "<script language=\"javascript\">
			alert('Rekod telah disimpan');
			</script>";
	} else {
	$href_link = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;'.$id);

?>
<script LANGUAGE="JavaScript">
function do_pages(URL){
	document.ilim.action=URL;
	document.ilim.submit();
}
</script>
<form name="ilim" method="post">
	<table width="90%" height="200px" cellpadding="5" cellspacing="0" border="0" align="center">
    	<tr><td align="center">
        	Maklumat Kursus Telah Disimpan. Slia klik OK untuk proses seterusnya.
        	<input type="button" value="OK" onclick="do_pages('<?=$href_link;?>&load_pages=')" />
        </td></tr>
    </table>
</form>	
<?
	exit;
	}
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
	} else if(document.ilim.nama_agensi.value==''){
		alert("Sila masukkan maklumat nama Agensi @ Jabatan terlebih dahulu.");
		document.ilim.nama_agensi.focus();
		return true;
	} else if(document.ilim.subkategori.value==''){
		alert("Sila pilih maklumat sub kategori kursus terlebih dahulu.");
		document.ilim.subkategori.focus();
		return true;
	} else if(document.ilim.nama_subjek.value==''){
		alert("Sila masukkan maklumat subjek kursus terlebih dahulu.");
		document.ilim.nama_subjek.focus();
		return true;
	} else if(document.ilim.tkh_mula.value==''){
		alert("Sila masukkan maklumat tarikh mula kursus terlebih dahulu.");
		document.ilim.tkh_mula.focus();
		return true;
	} else if(document.ilim.tkh_tamat.value==''){
		alert("Sila masukkan maklumat tarikh tamat kursus terlebih dahulu.");
		document.ilim.tkh_tamat.focus();
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
//if(!empty($id)){
$sSQL="SELECT B.* FROM _tbl_kursus_jadual B WHERE B.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;
//} else {
if($rs->EOF){ $btn_display=1; }
//}
?>
<form name="ilim" method="post">
<table width="90%" cellpadding="2" cellspacing="1" border="0" align="center">
    <?php if(!empty($msg)){ ?>
    <tr>
        <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
    </tr>
    <? } ?>
	<?php $sqlb = "SELECT * FROM _ref_kampus WHERE kampus_status=0".$sql_kampus;
    $rs_kb = &$conn->Execute($sqlb);
    ?>
    <tr>
        <td width="30%" align="right"><b>Pusat Latihan : </b></td>
        <td width="70%" colspan="2" align="left">
            <select name="kampus_id" style="width:98%">
            <?php while(!$rs_kb->EOF){ ?>
                <option value="<?php print $rs_kb->fields['kampus_id'];?>" <?php if($rs_kb->fields['kampus_id']==$rs->fields['kampus_id']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['kampus_nama'];?></option>
            <?php $rs_kb->movenext(); } ?>
            </select>
            </td>
    </tr>
    <?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
        $rskk = &$conn->Execute($sqlkk);
    ?>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Kategori Kursus : </b></td> 
        <td align="left" colspan="2"><!--<input type="hidden" name="kategori" value="2" />Kursus Agensi Luar-->
        	<select name="kategori" onchange="do_page('<?=$href_search;?>')">
            	<option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['id'];?>" <?php if($rs->fields['category_code']==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
            </td>
    </tr>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Nama Agensi / Jabatan : </b></td> 
        <td align="left" colspan="2" ><input type="hidden" name="subjek" value="0" />
        	<input type="text" name="nama_agensi" size="90" value="<?php print $rs->fields['nama_agensi'];?>" />
        </td>
	</tr>
    <?php 
        $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_category_code=2";
        //if(!empty($rs->fields['category_code'])){ $sqlkks .= " AND f_category_code=".tosql($rs->fields['category_code'],"Number"); }
        $sqlkks .= " ORDER BY SubCategoryNm";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Sub-Kategori : </b></td> 
        <td align="left" colspan="2" >
            <select name="subkategori"  onchange="query_data('include/get_kursus.php')">
                <option value="">-- Sila pilih pusat / unit --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($rs->fields['sub_category_code']==$rskks->fields['id']){ print 'selected'; }?>><?php print $rskks->fields['SubCategoryNm'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <?php 
        $sqlkks = "SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
        if(!empty($rs->fields['category_code'])){ $sqlkks .= " AND category_code=".tosql($rs->fields['category_code'],"Number"); }
        if(!empty($rs->fields['SubCategoryCd'])){ $sqlkks .= " AND SubCategoryCd=".tosql($rs->fields['SubCategoryCd'],"Number"); }
        $sqlkks .= " ORDER BY coursename";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Subjek : </b></td> 
        <td align="left" colspan="2" ><input type="hidden" name="subjek" value="0" />
        	<input type="text" name="nama_subjek" size="90" value="<?php print $rs->fields['acourse_name'];?>" />
        </td>
	</tr>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Tarikh Kursus : </b></td> 
        <td align="left">
            Mula : 
            <input type="text" size="13" name="tkh_mula" value="<? echo DisplayDate($rs->fields['startdate']);?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
            <input type="text" size="13" name="tkh_tamat" value="<? echo DisplayDate($rs->fields['enddate']);?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
        </td>
    </tr>
    <tr>
        <td align="right"><b>Masa Mula : </b></td> 
        <td align="left">
            <select name="ddStHour">
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
            &nbsp;&nbsp;
            <select name="ddStMinute">
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
         </td>
    </tr>
    <tr>
        <td align="right"><b>Masa Tamat : </b></td> 
        <td align="left">
            <select name="ddEndHour">
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
            &nbsp;&nbsp;
            <select name="ddEndMinute">
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
        </td>
    </tr>
   <!-- <tr>
        <td align="right"><b>Tempat : </b></td>
        <td align="left" colspan="2"><input type="text" size="70" name="tempat"  value="<?php print $rs->fields['class'];?>"/></td>
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
            onclick="open_modal('<?=$href_link_set;?>&kid=<?=$id;?>','Pilih set penilaian',90,90)" />
        </td>
    </tr>-->
    <tr>
        <td align="right"><b>Kos Makan / Minum (RM) : </b></td>
        <td align="left" colspan="2"><input type="text" size="20" name="jumkos"  value="<?php print $rs->fields['jumkos'];?>"/></td>
    </tr>
    <tr>
        <td align="right"><b>Nama Penyelaras : </b></td>
        <td align="left" colspan="2"><input type="text" size="90" name="penyelaras" maxlength="120"  value="<?php print $rs->fields['penyelaras'];?>"/></td>
    </tr>
    <tr>
        <td align="right"><b>No. Tel. Penyelaras : </b></td>
        <td align="left" colspan="2"><input type="text" size="20" name="penyelaras_notel" maxlength="20"  value="<?php print $rs->fields['penyelaras_notel'];?>"/></td>
    </tr>
    <tr>
        <td align="right"><b>Catatan : </b></td>
        <td align="left" colspan="2"><textarea rows="3" cols="80" name="catatan"><?=$rs->fields['catatan'];?></textarea></td>
    </tr>
    <tr>
        <td align="right"><b>Bilangan Peserta : </b></td>
        <td align="left" colspan="2">
        	Lelaki : <input type="text" size="5" name="lelaki"  value="<?php print $rs->fields['lelaki'];?>"/>
            &nbsp;&nbsp;&nbsp;&nbsp;
            Perempuan : <input type="text" size="5" name="perempuan"  value="<?php print $rs->fields['perempuan'];?>"/>
            &nbsp;&nbsp;&nbsp;&nbsp;
            Bilik VIP : <input type="text" size="5" name="vip"  value="<?php print $rs->fields['vip'];?>"/>
            
        </td>
    </tr>    
    <tr>
        <td align="right"><b>Tempat : </b></td> 
        <td align="left" colspan="2" >
        	<?php print dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs->fields['bilik_kuliah']));?>
            <?php if(!empty($id)){ ?>
        	<?php $href_bilik = "modal_form.php?win=".base64_encode('kursus/jadual_bilik_kuliah.php;'.$id); ?>
            <input type="button" value=" ... " style="cursor:pointer" title="Sila klik untuk pilihan bilik kuliah" 
            onclick="open_modal('<?=$href_bilik;?>&kid=<?=$id;?>&kursus=LUAR','Pilih bilik kuliah',90,90)" />
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td align="right"><b>Kemudahan Penginapan Asrama : </b></td>
        <td align="left" colspan="2">
            <select name="asrama_perlu">
                <option value="TIDAK" <? if($rs->fields['asrama_perlu']=='TIDAK'){ print 'selected'; }?>>Tidak perlu</option>
                <option value="ASRAMA" <? if($rs->fields['asrama_perlu']=='ASRAMA'){ print 'selected'; }?>>Asrama</option>
            </select>
        </td>
    </tr>
    <tr>
        <td align="right"><b>Status : </b></td>
        <td align="left" colspan="2">
            <select name="status">
                <option value="0" <? if($rs->fields['status']=='0'){ print 'selected'; }?>>Aktif</option>
                <option value="1" <? if($rs->fields['status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
            </select>
        </td>
    </tr>
    <tr><td colspan="3"><hr /></td></tr>
    <tr>
        <td colspan="3" align="center">
        	<?php if($btn_display==1){ ?>
            <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
            <?php if(!empty($id)){ ?>
            <input type="button" value="Hapus" class="button_disp" title="Sila klik untuk menghapuskan maklumat" onClick="form_hapus('modal_form.php?<? print $URLs;?>&pro=HAPUS')" >
            <?php } ?>
            <?php } ?>
            <input type="button" value="Tutup" class="button_disp" title="Sila klik untuk menghapuskan maklumat" onClick="javascript:parent.emailwindow.hide();" >
            <!--<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >-->
            <input type="hidden" name="id" value="<?=$id?>" />
            <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
        </td>
    </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.subkategori.focus();
</script>
