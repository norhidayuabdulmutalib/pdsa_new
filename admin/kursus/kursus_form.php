<?php
//include_once '../common_func.php'; 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$msg='';
if(!empty($proses) && empty($_POST['id'])){
	$courseid 	= strtoupper($_POST['courseid']);
	$sql = "SELECT * FROM _tbl_kursus WHERE courseid=".tosql($courseid,"Text"); 
	$rs = &$conn->Execute($sql);
	if($rs->recordcount()==0){
		
	} else {
		$proses=''; $msg = 'Rekod telah ada dalam pangkalan data anda.';
	}
}

?>

<?php if(!empty($proses)){
	//print 'simpan';
	//$conn->debug=true;
	//include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$courseid=isset($_REQUEST["courseid"])?$_REQUEST["courseid"]:"";
	$bidang_id=isset($_REQUEST["bidang_id"])?$_REQUEST["bidang_id"]:"";
	$coursename=isset($_REQUEST["coursename"])?$_REQUEST["coursename"]:"";
	$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
	$subkategori=isset($_REQUEST["subkategori"])?$_REQUEST["subkategori"]:"";
	$coursefees=isset($_REQUEST["coursefees"])?$_REQUEST["coursefees"]:"";
	$coursedesc=isset($_REQUEST["coursedesc"])?$_REQUEST["coursedesc"]:"";
	$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
	$objektif=isset($_REQUEST["objektif"])?$_REQUEST["objektif"]:"";
	$kandungan=isset($_REQUEST["kandungan"])?$_REQUEST["kandungan"]:"";
	$ksasar=isset($_REQUEST["ksasar"])?$_REQUEST["ksasar"]:"";
	$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
	
	$coursefees = str_replace(",","",$coursefees);
	
	if(empty($id)){
		$sql = "INSERT INTO _tbl_kursus(courseid, bidang_id, coursename, status, category_code, 
		subcategory_code , coursefees, coursedesc, 
		objektif, kandungan, ksasar, kampus_id) 
		VALUES(".tosql($courseid).",".tosql($bidang_id).", ".tosql($coursename,"Text").", ".tosql($status,"Number").", ".tosql($kategori,"Text").", 
		".tosql($subkategori,"Text").", ".tosql($coursefees,"Text").", ".tosql($coursedesc,"Text").", 
		".tosql($objektif,"Text").", ".tosql($kandungan,"Text").", ".tosql($ksasar,"Text").", ".tosql($kampus_id,"Text").")";
		$rs = &$conn->Execute($sql);
		audit_trail($sql,"");
		$id = dlookup("_tbl_kursus","MAX(id)","1");
	} else {
		$sql = "UPDATE _tbl_kursus SET courseid=".tosql($courseid,"Text").", 				
			bidang_id=".tosql($bidang_id,"Text").", 				coursename=".tosql($coursename,"Text").",
			category_code=".tosql($kategori,"Text").",			subcategory_code =".tosql($subkategori,"Text").",
			coursefees=".tosql($coursefees,"Text").", 			coursedesc=".tosql($coursedesc,"Text").",
			objektif=".tosql($objektif,"Text").", 				kandungan=".tosql($kandungan,"Text").",
			ksasar=".tosql($ksasar,"Text").", 					status=".tosql($status,"Number").", 
			kampus_id=".tosql($kampus_id,"Text")." 
			WHERE id=".tosql($id,"Text");
		$rs = &$conn->Execute($sql);
		audit_trail($sql,"");
	}
	
	//print $sql; exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();
		</script>";
}
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var kod = document.ilim.courseid.value;
	var desc = document.ilim.coursename.value;
	if(kod==''){
		alert("Sila masukkan kod kursus terlebih dahulu.");
		document.ilim.courseid.focus();
		return true;
	} else if(desc==''){
		alert("Sila masukkan diskripsi kursus terlebih dahulu.");
		document.ilim.coursename.focus();
		return true;
	} else {
		/*if(kod.length!=5){
			alert("Sila pastikan kod anda mempunyai 5 aksara.");
			document.ilim.courseid.focus();
			return true;
		} else {*/
			document.ilim.action = URL;
			document.ilim.submit();
		//}
	}
}
function form_back(URL){
	//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
	parent.emailwindow.hide();
}

</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT * FROM _tbl_kursus WHERE id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="5" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="table-header" height="25"><h2>SELENGGARA MAKLUMAT KURSUS</h2></td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="4" cellspacing="0" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td width="100%" align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
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

            <tr>
                <td align="right"><b><font color="#FF0000">*</font> Bidang : </b></td>
                <td>
                    <select name="bidang_id" style="width:98%">
                    <option value="">-- Sila pilih bidang --</option>
                    <?php 
                    $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
                    while (!$r_gred->EOF){ ?>
                    <option value="<?=$r_gred->fields['f_pakar_code'] ?>" 
					<?php if($rs->fields['bidang_id']==$r_gred->fields['f_pakar_code']){ print "selected"; }?>><?=$r_gred->fields['f_pakar_nama']?></option>
                    <?php $r_gred->movenext(); }?>        
                   </select>
                </td>
            </tr>

            <tr>
                <td width="30%" align="right"><b><font color="#FF0000">*</font> Kod Kursus : </b></td>
                <td width="70%" align="left" colspan="2">
                	<input type="text" size="10" name="courseid" maxlength="10" value="<?php print $rs->fields['courseid'];?>"/> <i>Cth: C0001</i></td>
            </tr>
            <tr>
                <td align="right"><b><font color="#FF0000">*</font> Nama Kursus : </b></td>
                <td align="left" colspan="2" >
                	<input type="text" size="80" name="coursename" value="<?php print $rs->fields['coursename'];?>" style="width:98%" /></td>
            </tr>
			<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
                $rskk = &$conn->Execute($sqlkk);
            ?>
            <tr>
                <td align="right"><b><font color="#FF0000">*</font> Kategori Kursus : </b></td> 
                <td align="left" colspan="2" >
                    <select name="kategori" onchange="query_data('include/get_kursus_catsub.php')" style="width:98%">
                        <!--<option value="">-- Sila pilih kategori --</option>-->
                        <?php while(!$rskk->EOF){ ?>
                        <option value="<?php print $rskk->fields['id'];?>" <?php if($rs->fields['category_code']==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                        <?php $rskk->movenext(); } ?>
                    </select>
                </td>
            </tr>
			<?php 
				if(!empty($rs->fields['category_code'])){
					$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 AND f_category_code=".tosql($rs->fields['category_code'],"Number")." ORDER BY SubCategoryNm";
				} else {
					$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 ORDER BY SubCategoryNm";
				}
                $rskks = &$conn->Execute($sqlkks);
            ?>
            <tr>
                <td align="right"><b>Sub Kategori Kursus : </b></td> 
                <td align="left" colspan="2" >
                    <select name="subkategori" style="width:98%">
                        <option value="">-- Sila pilih sub-kategori --</option>
                        <?php while(!$rskks->EOF){ ?>
                        <option value="<?php print $rskks->fields['id'];?>" <?php if($rs->fields['subcategory_code']==$rskks->fields['id']){ print 'selected'; }?>><?php print pusat_list($rskks->fields['id']);?></option>
                        <?php $rskks->movenext(); } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td width="30%" align="right"><b>Yuran (RM) : </b></td>
                <td width="70%" align="left" colspan="2">
                	<input type="text" size="10" name="coursefees" value="<?php print number_format($rs->fields['coursefees'],2);?>"/>
                <i>Sila masukkan nilai sahaja. cth: 2000.00</i>
                </td>
            </tr>
            <tr>
                <td width="30%" align="right"><b>Objektif Kursus : </b></td>
                <td width="70%" align="left" colspan="2">
                	<textarea name="objektif" rows="3" cols="60" style="width:98%"><?php print $rs->fields['objektif'];?></textarea>
                </td>
            </tr>
            <tr>
                <td width="30%" align="right"><b>Kandungan Kursus : </b></td>
                <td width="70%" align="left" colspan="2">
                	<textarea name="kandungan" rows="3" cols="60" style="width:98%"><?php print $rs->fields['kandungan'];?></textarea>
                </td>
            </tr>
            <tr>
                <td width="30%" align="right"><b>Kumpulan Sasar : </b></td>
                <td width="70%" align="left" colspan="2">
                	<textarea name="ksasar" rows="3" cols="60" style="width:98%"><?php print $rs->fields['ksasar'];?></textarea>
                </td>
            </tr>
            <tr>
                <td width="30%" align="right"><b>Komen : </b></td>
                <td width="70%" align="left" colspan="2">
                	<textarea name="coursedesc" rows="3" cols="60" style="width:98%"><?php print $rs->fields['coursedesc'];?></textarea>
                </td>
            </tr>
            <tr>
                <td align="right"><b>Status : </b></td>
                <td align="left" colspan="2">
                	<select name="status">
                    	<option value="0" <?php if($rs->fields['status']=='0'){ print 'selected'; }?>>Aktif</option>
                    	<option value="1" <?php if($rs->fields['status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                    </select>
                </td>
            </tr>
            <!--<tr><td colspan="3"><hr /></td></tr>-->
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Tutup" class="button_disp" title="Sila klik untuk kembali ke senarai kursus" onClick="form_back()" >
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
                </td>
            </tr>
            <tr><td colspan="3"><hr /></td></tr>
            <?php if(!empty($id)){ $btn_display=1; ?>
			<tr><td colspan="3"><?php $kid = $rs->fields['id'];?>
                <?php include 'kursus_document.php'; ?>
			</td></tr>
            <?php } ?>
        </table>
      </td>
    </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.courseid.focus();
</script>
