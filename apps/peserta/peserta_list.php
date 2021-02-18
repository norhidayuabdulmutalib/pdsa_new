<?
$j=$_POST['j'];
$search=$_POST['search'];
$pusat=$_POST['pusat'];
//$conn->debug=true;
$sSQL="SELECT A.*, B.f_tempat_nama FROM _tbl_peserta A, _ref_tempatbertugas B WHERE A.BranchCd=B.f_tbcode AND A.is_deleted=0 ";
if(!empty($pusat)){ $sSQL.=" AND A.BranchCd=".tosql($pusat,"Text"); } 
if(!empty($search)){ $sSQL.=" AND ( A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%') "; }
$sSQL .= " ORDER BY f_peserta_nama";
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
//$conn->debug=false;

$href_search = "index.php?data=".base64_encode('user;peserta/peserta_list.php;peserta;peserta');
?>
<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="modalwindow/dhtmlwindow.js">

/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="modalwindow/modal.js"></script>
<script type="text/javascript">
function opennewsletter(kid, staff){
	var URL = "staff/staff_menu.php";
	//var id = document.ilim.mohon_id.value;
	//var tid = document.ilim.tid.value;
	URL = URL + '?kid=' + kid;
	//alert(URL);
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Maklumat Capaian Menu - ' + staff, 'width=750px,height=500px,center=1,resize=0,scrolling=1')

	/*emailwindow.onclose=function(){ //Define custom code to run when window is closed
		var theform=this.contentDoc.forms[0] //Access first form inside iframe just for your reference
		var theemail=this.contentDoc.getElementById("emailfield") //Access form field with id="emailfield" inside iframe
		if (theemail.value.indexOf("@")==-1){ //crude check for invalid email
			alert("Please enter a valid email address")
			return false //cancel closing of modal window
		}
		else{ //else if this is a valid email
			//alert("refresh");
			//document.getElementById("youremail").innerHTML=theemail.value //Assign the email to a span on the page
			//jah('./cal/calendar_akhbar.php?nextMonth='+mth+'&curYear='+yr+'&p=NEXT','calender');
			//document.ilim.reload();
			return true; //allow closing of window
		}
	}*/
} //End "opennewsletter" function
</script>
<script language="javascript" type="text/javascript">
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
</script>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">
	<?php
	$sqlp = "SELECT * FROM _ref_tempatbertugas WHERE is_deleted=0 AND f_status=0 ORDER BY f_tempat_nama";
	$rspu = &$conn->execute($sqlp);
	?>
	<tr>
		<td width="30%" align="right"><b>Jabatan/Unit/Pusat: </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        <select name="pusat" onchange="do_page('<?=$href_search;?>')" style="cursor:pointer" title="Sila pilih maklumat untuk carian">
        	<option value="">-- Sila pilih --</option>
            <?php while(!$rspu->EOF){ ?>
            <option value="<?php print $rspu->fields['f_tbcode'];?>" <?php if($rspu->fields['f_tbcode']==$pusat){ print 'selected'; }?>><?php print $rspu->fields['f_tempat_nama'];?></option>
            <? $rspu->movenext(); } ?>
        </select>
		</td>
	</tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')" style="cursor:pointer" title="Sila klik untuk membuat carian">
		</td>
	</tr>
<? include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PESERTA KURSUS</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<? $new_page = "index.php?data=".base64_encode('user;peserta/peserta_form.php;peserta;peserta;');?>
        	<input type="button" value="Tambah Maklumat Peserta" style="cursor:pointer" onclick="do_page('<?=$new_page;?>')" title="Tambah Maklumat Peserta Kursus" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="4" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="30%" align="center"><b>Nama Peserta</b></td>
                    <td width="10%" align="center"><b>No. K/P</b></td>
                    <td width="5%" align="center"><b>Gred</b></td>
                    <td width="35%" align="center"><b>Jabatan/Unit/Pusat</b></td>
                    <td width="10%" align="center"><b>Jumlah Kursus Tahunan</b></td>
                   <td width="5%" align="center">&nbsp;</td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
                    //while(!$rs->EOF) {
						//$bil = $cnt + ($PageNo-1)*$PageSize;
						$href_link = "index.php?data=".base64_encode('user;peserta/peserta_form.php;peserta;peserta;'.$rs->fields['id_peserta']);
						$lepas = date("Y")-1; $semasa = date("Y"); 
						/*$sSQL2="SELECT B.startdate, B.enddate, A.* 
						FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
						WHERE A.EventId=B.id AND year(B.startdate)=".tosql($lepas)." AND A.InternalStudentAccepted=1 
						AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic']); //AND A.is_sijil=1 
						$sSQL2 .= " ORDER BY B.startdate DESC";
						$rs2 = &$conn->Execute($sSQL2);
						$jumlah1=0;
						while(!$rs2->EOF){
							$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
							$jumlah1+=$ddiff;
							$rs2->movenext();
						}*/
						//$jumlah1 = $rs2->recordcount();
						//print $sSQL2;

						/*$sSQL2="SELECT B.startdate, B.enddate, A.* 
						FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B 
						WHERE A.EventId=B.id AND year(B.startdate)=".tosql($semasa)." AND A.InternalStudentAccepted=1 
						AND A.peserta_icno=".tosql($rs->fields['f_peserta_noic']); //AND A.is_sijil=1 
						$sSQL2 .= " ORDER BY B.startdate DESC";
						$rs2 = &$conn->Execute($sSQL2);
						$jumlah2=0;
						while(!$rs2->EOF){
							$ddiff = get_datediff($rs2->fields['startdate'],$rs2->fields['enddate']);
							$jumlah2+=$ddiff;
							$rs2->movenext();
						}*/
						//$jumlah2 = $rs2->recordcount();
					?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
			             	<td valign="top" align="left"><? echo stripslashes($rs->fields['f_peserta_nama']);?></a>&nbsp;</td>
                            <td valign="top" align="center"><? echo $rs->fields['f_peserta_noic'];?>&nbsp;</td>
                            <td valign="top" align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs->fields['f_title_grade']));?>&nbsp;</td>
                            <td valign="top" align="left"><? echo $rs->fields['f_tempat_nama'];?>&nbsp;</td>
							<td align="left" valign="top">
                            	<?php include 'view_kursus_calc_main.php'; ?>
                                <!--<b><?php //print $lepas;?> :</b> <?//=$jumlah1;?> hari.<br />
                                <b><?php //print $semasa;?> :</b> <?//=$jumlah2;?> hari.<br />-->
                    		</td>
                            <td align="center">
                            	<a href="<?=$href_link;?>"><img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" 
                                title="Sila klik untuk pengemaskinian data" border="0"/></a>
                            </td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
					$rs->Close();
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>No Record Found.</b></td></tr>
                <? } ?>
                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?
$sFileName=$href_search;
?>
<? include_once 'include/list_footer.php'; ?> </td></tr>
<tr><td>        
</td></td>
</table> 
</form>
