<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];
$URLs = $uri[1];
$proses = $_GET['proses'];
$ty = $_GET['ty'];
//print_r($uri);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="javascript" type="text/javascript">
function do_proses(URL){
	document.ilim.action=URL;
	document.ilim.submit();
}
function form_back(){
	parent.emailwindow.hide();
}
</script>
</head>
<body>
<?php
if(!empty($proses) && $proses=='PRO'){
	//$conn->debug=true;
	//$conn->execute("UPDATE ref_surat SET surat_1=".tosql($_POST['surat'])." WHERE kod_surat='SRT_PEN'");
	$conn->execute("UPDATE _tbl_kursus_jadual SET ref_surat_penceramah=".tosql($_POST['surat'])." WHERE id = ".tosql($id,"Text"));

	$rss = $conn->execute("SELECT * FROM ref_surat WHERE kod_surat='SRT_PEN'");
	if(!$rss->EOF){ 
		//$surat = stripslashes($rss->fields['surat_1']); 
		$surat_ruj  = stripslashes($rss->fields['surat_ruj_fail']); 
	} 

	$rss = $conn->execute("SELECT ref_surat_penceramah FROM _tbl_kursus_jadual WHERE id = ".tosql($id,"Text"));
	if(!$rss->EOF){ 
		$surat = stripslashes($rss->fields['ref_surat_penceramah']); 
		//$surat_ruj  = stripslashes($rss->fields['ref_surat_penceramah']); 
	} 


	$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, C.SubCategoryDesc, D.startdate, D.enddate, D.bilik_kuliah, D.penyelaras, D.timestart, D.timeend
	FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
	WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
	$rs_kursus = &$conn->Execute($sSQL);
	$namakursus = $rs_kursus->fields['coursename'];
	$SubCategoryDesc = $rs_kursus->fields['SubCategoryDesc'];
	$tarikh_kursus = DisplayDate($rs_kursus->fields['startdate']).' - '.DisplayDate($rs_kursus->fields['enddate']);
	$tarikh_mula = DisplayDate($rs_kursus->fields['startdate']);
	$tarikh_mula = DisplayDate($rs_kursus->fields['startdate']);
	$masa_mula = substr($rs_kursus->fields['timestart'],0,5);
	$masa_tamat = substr($rs_kursus->fields['timeend'],0,5);
	$masa = $masa_mula." - ". $masa_tamat;
	//$urusetia = $rs_kursus->fields['penyelaras'];
	//if(!empty($rs_kursus->fields['penyelaras_notel'])){ $urusetia .= " ( Tel: ".$rs_kursus->fields['penyelaras_notel']." )"; }
	//$conn->debug=true;
	$sqltempat = "SELECT A.f_bilik_nama, B.f_bb_desc  
	FROM _tbl_bilikkuliah A, _ref_blok_bangunan B 
	WHERE A.f_bb_id=B.f_bb_id AND A.f_bilikid=".tosql($rs_kursus->fields['bilik_kuliah']);
	$rs_tempat = &$conn->Execute($sqltempat);
	$nama_tempat = $rs_tempat->fields['f_bilik_nama'];
	$nama_blok = $rs_tempat->fields['f_bb_desc'];
	//$conn->debug=false;
	
	
	$surat = str_replace("!tkh_kini!",date("d-m-Y"),$surat);
	$surat = str_replace("!rujukan!",$surat_ruj,$surat);

	//$surat = str_replace("!nama_penceramah!",$surat_ruj,$surat);
	$surat = str_replace("!nama_pusat!",$SubCategoryDesc,$surat);

	$surat = str_replace("!tajuk_ceramah!",strtoupper($namakursus),$surat);
	$surat = str_replace("KURSUS KURSUS","KURSUS ",$surat);
	$surat = str_replace("!tarikh_kursus!",$tarikh_kursus,$surat);
	$surat = str_replace("!nama_tempat!",$nama_tempat,$surat);
	$surat = str_replace("!nama_blok!",$nama_blok,$surat);
	$surat = str_replace("!tarikh_mula!",$tarikh_mula,$surat);
	$surat = str_replace("!masa!",$masa,$surat);
	//$surat = str_replace("!tkh_daftar!",$tarikh_mula,$surat);
	//$surat = str_replace("!urusetia!",$urusetia,$surat);
	
	// PROSES SURAT BAGI KURSUS
	/*$surat_all = $surat;
	$surat_all = str_replace("!nama!","KEPADA YANG BEKENAAN",$surat_all);
	$surat_all = str_replace("!alamat!","",$surat_all);
	$sqlkursus = "UPDATE _tbl_kursus_jadual SET fld_surat=".tosql(addslashes($surat_all))." WHERE id=".tosql($id);
	$conn->execute($sqlkursus);*/
	
	// PROSES SURAT KEPADA PESERTA
	$sSQL = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Text");
	//print $sSQL; exit; 
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
	//$conn->debug=false;
	$bil=0;
	while(!$rs->EOF){ $bil++; 
		$surat_ind = $surat;
		$nama 	= $rs->fields['insname'];
		$alamat = $rs->fields['insorganization'];
		
		$surat_ind = str_replace("!nama_penceramah!",$nama,$surat_ind);
		$surat_ind = str_replace("!alamat_penceramah!",$alamat,$surat_ind);
	
		$sqlu = "UPDATE _tbl_kursus_jadual_det SET 
		surat_jemputan=".tosql(addslashes($surat_ind))."
		WHERE event_id =".tosql($id)." AND instruct_id=".tosql($rs->fields['instruct_id']);
		//print "<br>".$bil." : ".$sqlu."<br>";
		//$conn->debug=true;
		$conn->execute($sqlu);
		$rs->movenext();
	}
	?>
	<form name="ilim" method="post">
	<table width="96%" border="1" cellpadding="3" cellspacing="0" align="center">
		<tr><td height="200px" align="center">
			Proses jana surat panggilan kursus telah dijalankan.
			<br /><br />
			<input type="button" value="OK" style="cursor:pointer" onclick="form_back()" />
		</td></tr>
	</table>
	</form>
<?php } else {
//$conn->debug=true; 
$dir='';
$pathtoscript='../editor/';
include_once($dir."../editor/config.inc.php");
include_once($dir."../editor/FCKeditor/fckeditor.php") ;
$href_link_pro = "modal_form.php?win=".base64_encode('kursus/jadual_penceramah_pro.php;'.$id);
$save=$_GET['act'];
if(!empty($save) && $save=='SAVE'){
	//$conn->execute("UPDATE ref_surat SET surat_1=".tosql($_POST['surat'])." WHERE kod_surat='SRT_PEN'");
	$conn->execute("UPDATE _tbl_kursus_jadual SET ref_surat_penceramah=".tosql($_POST['surat'])." WHERE id = ".tosql($id,"Text"));
}

$selrss = "SELECT * FROM _tbl_kursus_jadual WHERE id = ".tosql($id,"Text");
$rss = &$conn->execute($selrss);
if(!$rss->EOF){
	$surat = stripslashes($rss->fields['ref_surat_penceramah']);
	if(empty($surat)){
		$rs = $conn->execute("SELECT * FROM ref_surat WHERE kod_surat='SRT_PEN'");
		if(!$rs->EOF){ $bil++; 
			$surat = stripslashes($rs->fields['surat_1']);
			//$rs->movenext();
			$sql = "UPDATE _tbl_kursus_jadual SET ref_surat_penceramah=".tosql($rs->fields['surat_1'])." WHERE id = ".tosql($id,"Text");
			$conn->execute($sql);
		} 
	}
}

?>
	<form name="ilim" method="post">
	<table width="98%" border="1" cellpadding="3" cellspacing="0" align="center">
		<tr><td height="20px" align="right">
			<input type="button" value="Proses Surat" style="cursor:pointer" onclick="do_proses('<?=$href_link_pro;?>&proses=PRO')" />&nbsp;&nbsp;
			<input type="button" value="Simpan" style="cursor:pointer" onclick="do_proses('<?=$href_link_pro;?>&proses=&act=SAVE')" />&nbsp;&nbsp;
            <input type="button" value="Tutup" style="cursor:pointer" onclick="form_back()" />
		</td></tr>
        <tr>
            <td align="left" valign="top"> <div class="rte"> 
              <?php  if ($wysiwyg===true){ 
                    $oFCKeditor = new FCKeditor('surat') ;
                    $oFCKeditor->BasePath = $pathtoscript.'../editor/FCKeditor/';
                    $oFCKeditor->Value = $surat;
                    $oFCKeditor->Width = "100%";
                    $oFCKeditor->Height = 430;
                    $oFCKeditor->Create() ;
                 } else {
                  ?>
                      <textarea name="surat" cols="60" rows="5"><?php print $surat; ?></textarea>
                 <?php }?>
                    </div>
                </td>    
        </tr>
	</table>
	</form>
<?php } ?>
</body>
</html>