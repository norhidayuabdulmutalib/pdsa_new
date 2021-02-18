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

//$proses = $_GET['pro'];

$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

$msg='';

if(empty($proses)){ 

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

if(!empty($id)){

	$sSQL="SELECT * FROM _tbl_instructor_akademik WHERE ingenid_akademik = ".tosql($id,"Number");

	$rs = &$conn->Execute($sSQL);

}

?>

<form name="ilim" method="post">

<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">

    <tr>

    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT AKADEMIK PENCERAMAH</td>

    </tr>

	<tr><td colspan="2">

    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">

        	<?php if(!empty($msg)){ ?>

            <tr>

                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>

            <?php } ?>

            <tr>

                <td width="30%"><b>Kelulusan : </b></td>

              <td width="70%" colspan="2"><select name="inaka_sijil">
                        <?php 
                                $r_gred = dlookupList('_ref_akademik', 'f_akademik_id,f_akademik_nama', '', 'f_akademik_id');
                                while ($row_gred = mysql_fetch_array($r_gred, MYSQL_BOTH)) { ?>
                                <option value="<?=$row_gred['f_akademik_id'] ?>" <?php if($rs->fields['inaka_sijil'] == $row_gred['f_akademik_id']) echo "selected"; ?> >
								<?=$row_gred['f_akademik_nama']?></option>
                        <?php }?>        
                   </select>   
</td>
            </tr>
			<tr>
 				<td width="30%"><b>Bidang Kursus : </b></td>
 				<td width="70%" colspan="2"><input type="text" size="60" name="inaka_kursus" value="<?php print $rs->fields['inaka_kursus'];?>" /></td>
            </tr>
            <tr>
              <td><b>Institusi : </b></td>
              <td colspan="2"><input type="text" size="60" name="inaka_institusi" value="<?php print $rs->fields['inaka_institusi'];?>" /></td>
            </tr>
            <tr>
              <td><b>Tahun : </b></td>
              <td colspan="2"><input type="text" size="5" name="inaka_tahun" value="<?php print $rs->fields['inaka_tahun'];?>" /></td>
            </tr>


            <tr><td colspan="3"><hr /></td></tr>

            <tr>

                <td colspan="3" align="center">

                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >

                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai gred jawatan" onClick="form_back()" >

                    <input type="hidden" name="id" value="<?=$id?>" />

                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                </td>
            </tr>
        </table>

      </td>

   </tr>

</table>

</form>

<script LANGUAGE="JavaScript">

	document.ilim.f_gred_code.focus();

</script>

<?php } else {

	//print 'simpan';

	include '../loading_pro.php';

	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

	$inaka_sijil=isset($_REQUEST["inaka_sijil"])?$_REQUEST["inaka_sijil"]:"";

	$inaka_kursus=isset($_REQUEST["inaka_kursus"])?$_REQUEST["inaka_kursus"]:"";

	$inaka_institusi=isset($_REQUEST["inaka_institusi"])?$_REQUEST["inaka_institusi"]:"";

	$inaka_tahun=isset($_REQUEST["inaka_tahun"])?$_REQUEST["inaka_tahun"]:"";



	/*$id 			= $_POST['id'];

	$category_code 	= strtoupper($_POST['category_code']);

	$categorytype 	= $_POST['categorytype'];

	$status 		= $_POST['status'];*/

	

	if(empty($id)){

		$sql = "INSERT INTO _tbl_instructor_akademik(ingenid,inaka_sijil, inaka_kursus, inaka_institusi, inaka_tahun) 

		VALUES(".tosql($_SESSION['ingenid']).", ".tosql(strtoupper($inaka_sijil),"Text").", ".tosql(strtoupper($inaka_kursus),"Text").", ".tosql(strtoupper($inaka_institusi),"Text").", ".tosql($inaka_tahun,"Number").")";

		$rs = &$conn->Execute($sql);

	} else {

		$sql = "UPDATE _tbl_instructor_akademik SET 

			inaka_sijil=".tosql(strtoupper($inaka_sijil),"Text").",

			inaka_kursus=".tosql(strtoupper($inaka_kursus),"Text").",

			inaka_institusi=".tosql($inaka_institusi,"Text").",

			inaka_tahun=".tosql($inaka_tahun,"Number")."

			WHERE ingenid_akademik=".tosql($id,"Text");

		$rs = &$conn->Execute($sql);

	}

	

	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";

}

?>