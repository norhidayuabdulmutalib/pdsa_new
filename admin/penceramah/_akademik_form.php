<?php 
function dlookupList($Table, $fName, $sWhere, $sOrder){
	$sSQL = "SELECT " . $fName . " FROM " . $Table . " " . $sWhere . " ORDER BY ". $sOrder;
	$result = mysql_query($sSQL);
	if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit();}
	$intRecCount = mysql_num_rows($result);
	if($intRecCount > 0){  
		return $result;
	} else {
		return "";
	}
}

$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
//$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
//if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var sijil = document.ilim.inaka_sijil.value;
	var kursus = document.ilim.inaka_kursus.value;
	var ins = document.ilim.inaka_institusi.value;
	var tahun = document.ilim.inaka_tahun.value;
	if(sijil==''){
		alert("Sila masukkan kelulusan akademik terlebih dahulu.");
		document.ilim.inaka_sijil.focus();
		return true;
	} else if(kursus==''){
		alert("Sila masukkan nama kursus terlebih dahulu.");
		document.ilim.inaka_kursus.focus();
		return true;
     } else if(ins==''){
		alert("Sila masukkan nama institusi terlebih dahulu.");
		document.ilim.inaka_institusi.focus();
		return true;
	} else if(tahun==''){
		alert("Sila masukkan tahun terlebih dahulu.");
		document.ilim.inaka_tahun.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
//if(!empty($id)){
	$sSQL="SELECT * FROM _tbl_instructor_akademik WHERE ingenid_akademik = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
//}
?>
<form name="ilim" method="post" enctype="multipart/form-data" >
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT AKADEMIK PENCERAMAH</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="3" cellspacing="1" border="0" align="center">
        	<?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>
            <tr>
              <td width="30%"><b>Kelulusan : </b></td>
              <td width="70%" colspan="2">
              		<select name="inaka_sijil">
                        <?php 
						   $r_gred = &$conn->query("SELECT * FROM _ref_akademik ORDER BY f_akademik_id");
                           while (!$r_gred->EOF) { ?>
                           <option value="<?=$r_gred->fields['f_akademik_id'] ?>" <?php if($rs->fields['titlegredcd'] == $r_gred->fields['f_akademik_id']) echo "selected"; ?> ><?=$r_gred->fields['f_akademik_nama']?></option>
                        <?php $r_gred->movenext(); } ?>        
                   </select>   
				</td>
            </tr>
			<tr>
 				<td width="30%"><b>Bidang Kursus : </b></td>
 				<td width="70%" colspan="2">
                <input type="text" size="80" maxlength="120" name="inaka_kursus" value="<?php print $rs->fields['inaka_kursus'];?>" /></td>
            </tr>
            <tr>
              <td><b>Institusi : </b></td>
              <td colspan="2">
              	<input type="text" size="80" maxlength="120" name="inaka_institusi" value="<?php print $rs->fields['inaka_institusi'];?>" /></td>
            </tr>
            <tr>
              <td><b>Tahun : </b></td>
              <td colspan="2"><input type="text" size="5" name="inaka_tahun" value="<?php print $rs->fields['inaka_tahun'];?>" /></td>
            </tr>
			<tr>
              <td valign="top"><b>Muatnaik Sijil : </b></td>
            	<td colspan="2"><input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                <input type="hidden" name="action1" value="1">
                <input type="file" name="file1" size="50">
                <!--<br />
                <input type="radio" name="img_baru" value="Y" />Muatnaik Imej Baru &nbsp;&nbsp;&nbsp;
                <input type="radio" name="img_baru" value="N" checked="checked" />Kekalkan imej-->
                <br /><br />
                <?php if(!empty($rs->fields['fld_image'])){ ?>
                <img src="all_pic/img_akademik.php?id=<?php echo $rs->fields['ingenid_akademik'];?>" width="150" height="150" border="0"><br />
                <?php print $rs->fields['fld_image'];?>
                <?php } ?>
                <br />Sila pastikan hanya fail imej berikut sahaja yang dibenarkan untuk dimuatnaik ke dalam sistem (PNG, JPG, JPEG, GIF) atau fail PDF sahaja. 
                </td>
            </tr>

            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('penceramah/_akademik_form_do.php')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai gred jawatan" onClick="form_back()" >
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.inaka_sijil.focus();
</script>
