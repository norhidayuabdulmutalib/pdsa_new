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

	var sijil = document.ilim.cl_eve_event_id.value;

	var kursus = document.ilim.cl_eve_tempoh.value;
	
	if(sijil==''){

		alert("Sila masukkan bidang terlebih dahulu.");

		document.ilim.cl_eve_event_id.focus();

		return true;

	} else if(kursus==''){

		alert("Sila masukkan pengkhususan terlebih dahulu.");

		document.ilim.cl_eve_tempoh.focus();

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

	$sSQL="SELECT * FROM _tbl_claim_event WHERE cl_eve_id = ".tosql($id,"Number");

	$rs = &$conn->Execute($sSQL);

}

?>

<form name="ilim" method="post">

<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">

    <tr>

    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT KURSUS / CERAMAH</td>

    </tr>

	<tr><td colspan="2">

    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">

        	<?php if(!empty($msg)){ ?>

            <tr>

                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>

            <? } ?>

            <tr>

                <td width="30%"><b>Kursus / Ceramah : </b></td>

              <td width="70%" colspan="2"><select name="cl_eve_event_id">
                        <?php 
                                
										$sSQL = "SELECT eve.id eve_id, coursename, startdate, enddate
												FROM tblevent eve, _tbl_kursus_jadual_det kjd, _tbl_kursus kur
												WHERE kur.id = eve.courseid
												AND eve.id = kjd.event_id
												AND kjd.instruct_id = ".tosql($_SESSION['ingenid'],"Text")."
												AND (
												MONTH( startdate ) = ( 
												SELECT MONTH( DATE_sub( now( ) , INTERVAL 1 
												MONTH ) ) ) 
												OR MONTH( startdate ) = MONTH( now( ) ) 
												)";
								$r_eve = mysql_query($sSQL);
                                while ($row_eve = mysql_fetch_array($r_eve, MYSQL_BOTH)) { ?>
                                <option value="<?=$row_eve['eve_id'] ?>" <?php if($rs->fields['cl_eve_event_id'] == $row_eve['eve_id']) echo "selected"; ?> >
								<?=$row_eve['coursename']?> [ <?=DisplayDate($row_eve['startdate'])?> - <?=DisplayDate($row_eve['enddate'])?> ]</option>
                        <?php }?>        
                   </select></td>
            </tr>
			<tr>
 				<td width="30%"><b>Tempoh : </b></td>
 				<td width="70%" colspan="2"><input type="text" name="cl_eve_tempoh" id="cl_eve_tempoh" value="<?php print $rs->fields['cl_eve_tempoh'];?>" /> 
 				  Jam (Sila isi angka integer sahaja!)</td>
            </tr>
           <tr><td colspan="3"><hr /></td></tr>

            <tr>

                <td colspan="3" align="center">

                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >

                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke maklumat penceramah" onClick="form_back()" >

                    <input type="hidden" name="id" value="<?=$id?>" />

                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                </td>
            </tr>
        </table>

      </td>

   </tr>

</table>

</form>

<?php } else {

	//print 'simpan';

	include '../loading_pro.php';

	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

	$cl_eve_event_id=isset($_REQUEST["cl_eve_event_id"])?$_REQUEST["cl_eve_event_id"]:"";

	$cl_eve_tempoh=isset($_REQUEST["cl_eve_tempoh"])?$_REQUEST["cl_eve_tempoh"]:"";
	
	$sSQL = "SELECT courseid, startdate, enddate FROM tblevent WHERE id = '$cl_eve_event_id'";
	
	$r_eve = mysql_query($sSQL);
	
	$row_eve = mysql_fetch_array($r_eve, MYSQL_BOTH);
	
	$cl_eve_course_id = $row_eve['courseid'];

	$cl_eve_startdate = $row_eve['startdate'];

	$cl_eve_enddate = $row_eve['enddate'];

	

	if(empty($id)){

		$sql = "INSERT INTO _tbl_claim_event(cl_id,cl_eve_event_id,cl_eve_tempoh,cl_eve_course_id,cl_eve_startdate,cl_eve_enddate) 

		VALUES(".tosql($_SESSION['cl_id'],"Number").", ".tosql($cl_eve_event_id,"Text").", ".tosql($cl_eve_tempoh,"Number").", ".tosql($cl_eve_course_id,"Number").", 
		
		".tosql($cl_eve_startdate,"Text").", ".tosql($cl_eve_enddate,"Text").")";

		$rs = &$conn->Execute($sql);

	} else {

		$sql = "UPDATE _tbl_claim_event SET 

			cl_eve_event_id=".tosql($cl_eve_event_id,"Text").",

			cl_eve_tempoh=".tosql($cl_eve_tempoh,"Number").",
			
			cl_eve_course_id=".tosql($cl_eve_course_id,"Number").",
			
			cl_eve_startdate=".tosql($cl_eve_startdate,"Text").",
			
			cl_eve_enddate=".tosql($cl_eve_enddate,"Text")."

			WHERE cl_eve_id=".tosql($id,"Number");

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