<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$id_masa=isset($_REQUEST["id_masa"])?$_REQUEST["id_masa"]:"";
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var nama = document.ilim.tajuk.value;
	if(nama==''){
		alert("Sila masukkan maklumat tajuk kursus terlebih dahulu.");
		document.ilim.tajuk.focus();
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
$sql = "SELECT startdate, enddate FROM _tbl_kursus_jadual WHERE id=".tosql($id);
$rs_kursus = $conn->execute($sql);

$sSQL="SELECT * FROM _tbl_kursus_jadual_masa WHERE id_jadmasa = ".tosql($id_masa,"Number");
$rs = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SET PENILAIAN KURSUS - MAKLUMAT BAHAGIAN</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
            <?php
			$sql_det = "SELECT A.*, B.ingenid, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Text");
			$rs_det = $conn->execute($sql_det);
			?>
            <tr>
                <td width="30%"><b>Maklumat Penceramah : </b></td>
                <td width="70%" colspan="2">
                <select name="id_pensyarah">
                <?php while(!$rs_det->EOF){ ?>
                	<option value="<?=$rs_det->fields['ingenid'];?>" <?php if($rs_det->fields['ingenid']=$rs->fields['id_pensyarah']){ print 'selected'; }?>
                    ><? print $rs_det->fields['insname'] . " - " . $rs_det->fields['insorganization'];?></option>
                <?php $rs_det->movenext(); } ?>
                </select>
                </td>
            </tr>
            <tr>
                <td><b>Tarikh : </b></td>
                <td colspan="2">
                <?php $ddiff = get_datediff($rs_kursus->fields['startdate'],$rs_kursus->fields['enddate']); //print $ddiff?>
                	<select name="tarikh">
					<?php for($i=0;$i<$ddiff;$i++){ 
						$dt = get_jadual_kursus($rs_kursus->fields['startdate'],$rs_kursus->fields['enddate'],$i); ?>
	                   	<option value="<?php print $dt;?>" <? if($rs->fields['tarikh']==$dt){ print 'selected'; }?>><?php print $dt;?></option>
                	<?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><b>Masa Kursus : </b></td>
                <td colspan="2"> Mula : 
                	<select name="masa_mula">
						<option value="05:00:00" <?php if($rs->fields['masa_mula']=='05:00:00'){ print 'selected'; }?>> 05:00 pagi </option>					
						<option value="05:15:00" <?php if($rs->fields['masa_mula']=='05:15:00'){ print 'selected'; }?>> 05:15 pagi </option>					
						<option value="05:30:00" <?php if($rs->fields['masa_mula']=='05:30:00'){ print 'selected'; }?>> 05:30 pagi </option>					
						<option value="05:45:00" <?php if($rs->fields['masa_mula']=='05:45:00'){ print 'selected'; }?>> 05:45 pagi </option>					
						<option value="06:00:00" <?php if($rs->fields['masa_mula']=='06:00:00'){ print 'selected'; }?>> 06:00 pagi </option>					
						<option value="06:15:00" <?php if($rs->fields['masa_mula']=='06:15:00'){ print 'selected'; }?>> 06:15 pagi </option>					
						<option value="06:30:00" <?php if($rs->fields['masa_mula']=='06:30:00'){ print 'selected'; }?>> 06:30 pagi </option>					
						<option value="06:45:00" <?php if($rs->fields['masa_mula']=='06:45:00'){ print 'selected'; }?>> 06:45 pagi </option>					
						<option value="07:00:00" <?php if($rs->fields['masa_mula']=='07:00:00'){ print 'selected'; }?>> 07:00 pagi </option>					
						<option value="07:15:00" <?php if($rs->fields['masa_mula']=='07:15:00'){ print 'selected'; }?>> 07:15 pagi </option>					
						<option value="07:30:00" <?php if($rs->fields['masa_mula']=='07:30:00'){ print 'selected'; }?>> 07:30 pagi </option>					
						<option value="07:45:00" <?php if($rs->fields['masa_mula']=='07:45:00'){ print 'selected'; }?>> 07:45 pagi </option>					
						<option value="08:00:00" <?php if($rs->fields['masa_mula']=='08:00:00'){ print 'selected'; }?>> 08:00 pagi </option>					
						<option value="08:15:00" <?php if($rs->fields['masa_mula']=='08:15:00'){ print 'selected'; }?>> 08:15 pagi </option>					
						<option value="08:30:00" <?php if($rs->fields['masa_mula']=='08:30:00'){ print 'selected'; }?>> 08:30 pagi </option>					
						<option value="08:45:00" <?php if($rs->fields['masa_mula']=='08:45:00'){ print 'selected'; }?>> 08:45 pagi </option>					
						<option value="08:00:00" <?php if($rs->fields['masa_mula']=='09:00:00'){ print 'selected'; }?>> 09:00 pagi </option>					
						<option value="09:15:00" <?php if($rs->fields['masa_mula']=='09:15:00'){ print 'selected'; }?>> 09:15 pagi </option>					
						<option value="09:30:00" <?php if($rs->fields['masa_mula']=='09:30:00'){ print 'selected'; }?>> 09:30 pagi </option>					
						<option value="09:45:00" <?php if($rs->fields['masa_mula']=='09:45:00'){ print 'selected'; }?>> 09:45 pagi </option>					
						<option value="10:00:00" <?php if($rs->fields['masa_mula']=='10:00:00'){ print 'selected'; }?>> 10:00 pagi </option>					
						<option value="10:15:00" <?php if($rs->fields['masa_mula']=='10:15:00'){ print 'selected'; }?>> 10:15 pagi </option>					
						<option value="10:30:00" <?php if($rs->fields['masa_mula']=='10:30:00'){ print 'selected'; }?>> 10:30 pagi </option>					
						<option value="10:45:00" <?php if($rs->fields['masa_mula']=='10:45:00'){ print 'selected'; }?>> 10:45 pagi </option>					
						<option value="11:00:00" <?php if($rs->fields['masa_mula']=='11:00:00'){ print 'selected'; }?>> 11:00 pagi </option>					
						<option value="11:15:00" <?php if($rs->fields['masa_mula']=='11:15:00'){ print 'selected'; }?>> 11:15 pagi </option>					
						<option value="11:30:00" <?php if($rs->fields['masa_mula']=='11:30:00'){ print 'selected'; }?>> 11:30 pagi </option>					
						<option value="11:45:00" <?php if($rs->fields['masa_mula']=='11:45:00'){ print 'selected'; }?>> 11:45 pagi </option>					
						<option value="12:00:00" <?php if($rs->fields['masa_mula']=='12:00:00'){ print 'selected'; }?>> 12:00 tghari </option>					
						<option value="12:15:00" <?php if($rs->fields['masa_mula']=='12:15:00'){ print 'selected'; }?>> 12:15 tghari </option>					
						<option value="12:30:00" <?php if($rs->fields['masa_mula']=='12:30:00'){ print 'selected'; }?>> 12:30 tghari </option>					
						<option value="12:45:00" <?php if($rs->fields['masa_mula']=='12:45:00'){ print 'selected'; }?>> 12:45 tghari </option>					
						<option value="13:00:00" <?php if($rs->fields['masa_mula']=='13:00:00'){ print 'selected'; }?>> 01:00 tghari </option>					
						<option value="13:15:00" <?php if($rs->fields['masa_mula']=='13:15:00'){ print 'selected'; }?>> 01:15 petang </option>					
						<option value="13:30:00" <?php if($rs->fields['masa_mula']=='13:30:00'){ print 'selected'; }?>> 01:30 petang </option>					
						<option value="13:45:00" <?php if($rs->fields['masa_mula']=='13:45:00'){ print 'selected'; }?>> 01:45 petang </option>					
						<option value="14:00:00" <?php if($rs->fields['masa_mula']=='14:00:00'){ print 'selected'; }?>> 02:00 petang </option>					
						<option value="14:15:00" <?php if($rs->fields['masa_mula']=='14:15:00'){ print 'selected'; }?>> 02:15 petang </option>					
						<option value="14:30:00" <?php if($rs->fields['masa_mula']=='14:30:00'){ print 'selected'; }?>> 02:30 petang </option>					
						<option value="14:45:00" <?php if($rs->fields['masa_mula']=='14:45:00'){ print 'selected'; }?>> 02:45 petang </option>					
						<option value="15:00:00" <?php if($rs->fields['masa_mula']=='15:00:00'){ print 'selected'; }?>> 03:00 petang </option>					
						<option value="15:15:00" <?php if($rs->fields['masa_mula']=='15:15:00'){ print 'selected'; }?>> 03:15 petang </option>					
						<option value="15:30:00" <?php if($rs->fields['masa_mula']=='15:30:00'){ print 'selected'; }?>> 03:30 petang </option>					
						<option value="15:45:00" <?php if($rs->fields['masa_mula']=='15:45:00'){ print 'selected'; }?>> 03:45 petang </option>					
						<option value="16:00:00" <?php if($rs->fields['masa_mula']=='16:00:00'){ print 'selected'; }?>> 04:00 petang </option>					
						<option value="16:15:00" <?php if($rs->fields['masa_mula']=='16:15:00'){ print 'selected'; }?>> 04:15 petang </option>					
						<option value="16:30:00" <?php if($rs->fields['masa_mula']=='16:30:00'){ print 'selected'; }?>> 04:30 petang </option>					
						<option value="16:45:00" <?php if($rs->fields['masa_mula']=='16:45:00'){ print 'selected'; }?>> 04:45 petang </option>					
						<option value="17:00:00" <?php if($rs->fields['masa_mula']=='17:00:00'){ print 'selected'; }?>> 05:00 petang </option>
						<option value="17:15:00" <?php if($rs->fields['masa_mula']=='17:15:00'){ print 'selected'; }?>> 05:15 petang </option>					
						<option value="17:30:00" <?php if($rs->fields['masa_mula']=='17:30:00'){ print 'selected'; }?>> 05:30 petang </option>					
						<option value="17:45:00" <?php if($rs->fields['masa_mula']=='17:45:00'){ print 'selected'; }?>> 05:45 petang </option>					
						<option value="18:00:00" <?php if($rs->fields['masa_mula']=='18:00:00'){ print 'selected'; }?>> 06:00 petang </option>					
						<option value="18:15:00" <?php if($rs->fields['masa_mula']=='18:15:00'){ print 'selected'; }?>> 06:15 petang </option>					
						<option value="18:30:00" <?php if($rs->fields['masa_mula']=='18:30:00'){ print 'selected'; }?>> 06:30 petang </option>					
						<option value="18:45:00" <?php if($rs->fields['masa_mula']=='18:45:00'){ print 'selected'; }?>> 06:45 petang </option>					
                    </select>
                    &nbsp;&nbsp;Tamat :
                	<select name="masa_tamat">
						<option value="05:00:00" <?php if($rs->fields['masa_tamat']=='05:00:00'){ print 'selected'; }?>> 05:00 pagi </option>					
						<option value="05:15:00" <?php if($rs->fields['masa_tamat']=='05:15:00'){ print 'selected'; }?>> 05:15 pagi </option>					
						<option value="05:30:00" <?php if($rs->fields['masa_tamat']=='05:30:00'){ print 'selected'; }?>> 05:30 pagi </option>					
						<option value="05:45:00" <?php if($rs->fields['masa_tamat']=='05:45:00'){ print 'selected'; }?>> 05:45 pagi </option>					
						<option value="06:00:00" <?php if($rs->fields['masa_tamat']=='06:00:00'){ print 'selected'; }?>> 06:00 pagi </option>					
						<option value="06:15:00" <?php if($rs->fields['masa_tamat']=='06:15:00'){ print 'selected'; }?>> 06:15 pagi </option>					
						<option value="06:30:00" <?php if($rs->fields['masa_tamat']=='06:30:00'){ print 'selected'; }?>> 06:30 pagi </option>					
						<option value="06:45:00" <?php if($rs->fields['masa_tamat']=='06:45:00'){ print 'selected'; }?>> 06:45 pagi </option>					
						<option value="07:00:00" <?php if($rs->fields['masa_tamat']=='07:00:00'){ print 'selected'; }?>> 07:00 pagi </option>					
						<option value="07:15:00" <?php if($rs->fields['masa_tamat']=='07:15:00'){ print 'selected'; }?>> 07:15 pagi </option>					
						<option value="07:30:00" <?php if($rs->fields['masa_tamat']=='07:30:00'){ print 'selected'; }?>> 07:30 pagi </option>					
						<option value="07:45:00" <?php if($rs->fields['masa_tamat']=='07:45:00'){ print 'selected'; }?>> 07:45 pagi </option>					
						<option value="08:00:00" <?php if($rs->fields['masa_tamat']=='08:00:00'){ print 'selected'; }?>> 08:00 pagi </option>					
						<option value="08:15:00" <?php if($rs->fields['masa_tamat']=='08:15:00'){ print 'selected'; }?>> 08:15 pagi </option>					
						<option value="08:30:00" <?php if($rs->fields['masa_tamat']=='08:30:00'){ print 'selected'; }?>> 08:30 pagi </option>					
						<option value="08:45:00" <?php if($rs->fields['masa_tamat']=='08:45:00'){ print 'selected'; }?>> 08:45 pagi </option>					
						<option value="08:00:00" <?php if($rs->fields['masa_tamat']=='09:00:00'){ print 'selected'; }?>> 09:00 pagi </option>					
						<option value="09:15:00" <?php if($rs->fields['masa_tamat']=='09:15:00'){ print 'selected'; }?>> 09:15 pagi </option>					
						<option value="09:30:00" <?php if($rs->fields['masa_tamat']=='09:30:00'){ print 'selected'; }?>> 09:30 pagi </option>					
						<option value="09:45:00" <?php if($rs->fields['masa_tamat']=='09:45:00'){ print 'selected'; }?>> 09:45 pagi </option>					
						<option value="10:00:00" <?php if($rs->fields['masa_tamat']=='10:00:00'){ print 'selected'; }?>> 10:00 pagi </option>					
						<option value="10:15:00" <?php if($rs->fields['masa_tamat']=='10:15:00'){ print 'selected'; }?>> 10:15 pagi </option>					
						<option value="10:30:00" <?php if($rs->fields['masa_tamat']=='10:30:00'){ print 'selected'; }?>> 10:30 pagi </option>					
						<option value="10:45:00" <?php if($rs->fields['masa_tamat']=='10:45:00'){ print 'selected'; }?>> 10:45 pagi </option>					
						<option value="11:00:00" <?php if($rs->fields['masa_tamat']=='11:00:00'){ print 'selected'; }?>> 11:00 pagi </option>					
						<option value="11:15:00" <?php if($rs->fields['masa_tamat']=='11:15:00'){ print 'selected'; }?>> 11:15 pagi </option>					
						<option value="11:30:00" <?php if($rs->fields['masa_tamat']=='11:30:00'){ print 'selected'; }?>> 11:30 pagi </option>					
						<option value="11:45:00" <?php if($rs->fields['masa_tamat']=='11:45:00'){ print 'selected'; }?>> 11:45 pagi </option>					
						<option value="12:00:00" <?php if($rs->fields['masa_tamat']=='12:00:00'){ print 'selected'; }?>> 12:00 tghari </option>					
						<option value="12:15:00" <?php if($rs->fields['masa_tamat']=='12:15:00'){ print 'selected'; }?>> 12:15 tghari </option>					
						<option value="12:30:00" <?php if($rs->fields['masa_tamat']=='12:30:00'){ print 'selected'; }?>> 12:30 tghari </option>					
						<option value="12:45:00" <?php if($rs->fields['masa_tamat']=='12:45:00'){ print 'selected'; }?>> 12:45 tghari </option>					
						<option value="13:00:00" <?php if($rs->fields['masa_tamat']=='13:00:00'){ print 'selected'; }?>> 01:00 tghari </option>					
						<option value="13:15:00" <?php if($rs->fields['masa_tamat']=='13:15:00'){ print 'selected'; }?>> 01:15 petang </option>					
						<option value="13:30:00" <?php if($rs->fields['masa_tamat']=='13:30:00'){ print 'selected'; }?>> 01:30 petang </option>					
						<option value="13:45:00" <?php if($rs->fields['masa_tamat']=='13:45:00'){ print 'selected'; }?>> 01:45 petang </option>					
						<option value="14:00:00" <?php if($rs->fields['masa_tamat']=='14:00:00'){ print 'selected'; }?>> 02:00 petang </option>					
						<option value="14:15:00" <?php if($rs->fields['masa_tamat']=='14:15:00'){ print 'selected'; }?>> 02:15 petang </option>					
						<option value="14:30:00" <?php if($rs->fields['masa_tamat']=='14:30:00'){ print 'selected'; }?>> 02:30 petang </option>					
						<option value="14:45:00" <?php if($rs->fields['masa_tamat']=='14:45:00'){ print 'selected'; }?>> 02:45 petang </option>					
						<option value="15:00:00" <?php if($rs->fields['masa_tamat']=='15:00:00'){ print 'selected'; }?>> 03:00 petang </option>					
						<option value="15:15:00" <?php if($rs->fields['masa_tamat']=='15:15:00'){ print 'selected'; }?>> 03:15 petang </option>					
						<option value="15:30:00" <?php if($rs->fields['masa_tamat']=='15:30:00'){ print 'selected'; }?>> 03:30 petang </option>					
						<option value="15:45:00" <?php if($rs->fields['masa_tamat']=='15:45:00'){ print 'selected'; }?>> 03:45 petang </option>					
						<option value="16:00:00" <?php if($rs->fields['masa_tamat']=='16:00:00'){ print 'selected'; }?>> 04:00 petang </option>					
						<option value="16:15:00" <?php if($rs->fields['masa_tamat']=='16:15:00'){ print 'selected'; }?>> 04:15 petang </option>					
						<option value="16:30:00" <?php if($rs->fields['masa_tamat']=='16:30:00'){ print 'selected'; }?>> 04:30 petang </option>					
						<option value="16:45:00" <?php if($rs->fields['masa_tamat']=='16:45:00'){ print 'selected'; }?>> 04:45 petang </option>					
						<option value="17:00:00" <?php if($rs->fields['masa_tamat']=='17:00:00'){ print 'selected'; }?>> 05:00 petang </option>
						<option value="17:15:00" <?php if($rs->fields['masa_tamat']=='17:15:00'){ print 'selected'; }?>> 05:15 petang </option>					
						<option value="17:30:00" <?php if($rs->fields['masa_tamat']=='17:30:00'){ print 'selected'; }?>> 05:30 petang </option>					
						<option value="17:45:00" <?php if($rs->fields['masa_tamat']=='17:45:00'){ print 'selected'; }?>> 05:45 petang </option>					
						<option value="18:00:00" <?php if($rs->fields['masa_tamat']=='18:00:00'){ print 'selected'; }?>> 06:00 petang </option>					
						<option value="18:15:00" <?php if($rs->fields['masa_tamat']=='18:15:00'){ print 'selected'; }?>> 06:15 petang </option>					
						<option value="18:30:00" <?php if($rs->fields['masa_tamat']=='18:30:00'){ print 'selected'; }?>> 06:30 petang </option>					
						<option value="18:45:00" <?php if($rs->fields['masa_tamat']=='18:45:00'){ print 'selected'; }?>> 06:45 petang </option>					
                    </select>
                    
                </td>
            </tr>
            <tr>
                <td><b>Tajuk : </b></td>
                <td colspan="2"><textarea rows="2" cols="90" name="tajuk"><?php print $rs->fields['tajuk'];?></textarea></td>
			</td>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=SAVE')" >
                    <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan kategori jawatan" onClick="form_back()" >
                    <input type="text" name="event_id" value="<?=$id?>" />
                    <input type="text" name="id_jadmasa" value="<?=$id_jadmasa?>" />
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.nilai_keterangan.focus();
</script>
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id_jadmasa =isset($_REQUEST["id_jadmasa"])?$_REQUEST["id_jadmasa"]:"";
	$event_id =isset($_REQUEST["event_id"])?$_REQUEST["event_id"]:"";
	$id_pensyarah =isset($_REQUEST["id_pensyarah"])?$_REQUEST["id_pensyarah"]:"";
	$tarikh =isset($_REQUEST["tarikh"])?$_REQUEST["tarikh"]:"";
	$masa_mula=isset($_REQUEST["masa_mula"])?$_REQUEST["masa_mula"]:"";
	$masa_tamat=isset($_REQUEST["masa_tamat"])?$_REQUEST["masa_tamat"]:"";
	$tajuk=isset($_REQUEST["tajuk"])?$_REQUEST["tajuk"]:"";

	if(empty($id_bhg)){
		$sql = "INSERT INTO _tbl_kursus_jadual_masa (event_id, id_pensyarah, tarikh, masa_mula, masa_tamat, tajuk) 
		VALUES(".tosql($event_id,"Text").", ".tosql($id_pensyarah,"Text").", ".tosql(DBDate($tarikh),"Text").", 
		".tosql($masa_mula,"Text").", ".tosql($masa_tamat,"Text").", ".tosql($tajuk,"Text").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _tbl_kursus_jadual_masa  SET 
			id_pensyarah=".tosql($id_pensyarah,"Text").",
			tarikh=".tosql(DBDate($tarikh),"Text").",
			masa_mula=".tosql($masa_mula,"Text").",
			masa_tamat=".tosql($masa_tamat,"Text").",
			tajuk=".tosql($tajuk,"Text")."
			WHERE id_jadmasa=".tosql($id_jadmasa,"Text");
		$rs = &$conn->Execute($sql);
	}
	
	print $sql; exit;
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>