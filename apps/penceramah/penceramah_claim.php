<?
$j=$_POST['j'];
$search=$_POST['search'];
$bidang=$_POST['bidang'];
$subjek=$_POST['subjek'];
//print "BIDANG:".$_POST['bidang'];
//$subjek=isset($_REQUEST["subjek"])?$_REQUEST["subjek"]:"";
$inskategori=isset($_REQUEST["inskategori"])?$_REQUEST["inskategori"]:"";

//$conn->debug=true;
$sSQL="SELECT A.*, D.cl_id, D.cl_month, D.cl_year, D.is_process FROM _tbl_instructor A, _tbl_claim D ";
if(!empty($subjek)){ $sSQL .= ", _tbl_kursus_jadual_det B, _tbl_kursus_jadual C"; }
if(!empty($bidang)){ $sSQL .= ", _tbl_instructor_kepakaran E"; }
$sSQL .= " WHERE A.is_deleted=0 AND A.instypecd ='01' AND A.ingenid=D.cl_ins_id AND D.is_process!=2 AND D.is_deleted=0 ";
if(!empty($subjek)){ $sSQL .= " AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=".tosql($subjek); }
if(!empty($bidang)){ $sSQL .= " AND A.ingenid=E.ingenid AND E.inpakar_bidang=".tosql($bidang); }
if(!empty($inskategori)){ $sSQL .= " AND A.inskategori=".tosql($inskategori); }
if(!empty($search)){ $sSQL.=" AND (A.insname LIKE '%".$search."%' OR A.insid LIKE '%".$search."%') "; }
$sSQL .= " ORDER BY A.insname, D.cl_year, D.cl_month";
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;
//print $sSQL;

$href_search = "index.php?data=".base64_encode('user;penceramah/penceramah_claim.php;penceramah;tuntutan');
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
        $sqlkks = "SELECT * FROM _tbl_kursus WHERE is_deleted=0 ";
        $sqlkks .= " ORDER BY courseid";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Subjek : </b></td> 
        <td align="left">
            <select name="subjek"  onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih subjek --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['id'];?>" <?php if($subjek==$rskks->fields['id']){ print 'selected'; }?>
                ><?php print $rskks->fields['courseid'] . " - " . $rskks->fields['coursename'];?></option>
                <?php $rskks->movenext(); } ?>
            </select
        ></td>
    <tr>
    <tr>
        <td width="30%" align="right"><b>Bidang : </b></td>
        <td width="70%">
            <select name="bidang"  onchange="do_page('<?=$href_search;?>')">
            <option value="">-- Sila pilih bidang --</option>
            <?php 
            //$r_gred = dlookupList('_ref_kepakaran', 'f_pakar_code,f_pakar_nama', '', 'f_pakar_nama');
            $r_gred = &$conn->execute("SELECT * FROM _ref_kepakaran ORDER BY f_pakar_nama");
            while (!$r_gred->EOF){ ?>
            <option value="<?=$r_gred->fields['f_pakar_code'] ?>" <?php if($bidang == $r_gred->fields['f_pakar_code']) echo "selected"; ?> >
            <?=$r_gred->fields['f_pakar_nama']?></option>
            <?php $r_gred->movenext(); }?>        
           </select></td>
    </tr>
    <tr>
        <td width="20%" align="right"><b>Kategori Penceramah : </b></td>
        <td width="50%" colspan="2">
        <select name="inskategori"  onchange="do_page('<?=$href_search;?>')">
        	<option value="">-- Semua kategori --</option>
		<?php	
            $r_kat = &$conn->execute("SELECT * FROM _ref_kategori_penceramah ORDER BY f_kp_sort");
            while (!$r_kat->EOF){ ?>
            <option value="<?=$r_kat->fields['f_kp_id'] ?>" <?php if($inskategori == $r_kat->fields['f_kp_id']) echo "selected"; ?> >
            <?=$r_kat->fields['f_kp_kenyataan']?></option>
            <?php $r_kat->movenext(); }?>        
           </select></td>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="70%" align="left">
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
<? include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="4" valign="middle">
        	<div style="float:left"><font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PENCERAMAH</strong></font></div>
            <div style="float:right">
				<? $new_page = "index.php?data=".base64_encode('user;penceramah/claim_form.php;penceramah;tuntutan;');?>
                <input type="button" value="Tambah Maklumat Tuntutan" style="cursor:pointer" onclick="do_page('<?=$new_page;?>')" />&nbsp;
			</div>
        </td>
    </tr>
    <tr>
        <td colspan="4" align="center">
            <table width="100%" border="1" cellpadding="4" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="40%" align="center"><b>Nama Penceramah<br>Jabatan/Unit/Pusat</b></td>
                    <td width="20%" align="center"><b>Kategori</b></td>
                    <td width="12%" align="center"><b>No. HP</b></td>
                    <td width="15%" align="center"><b>Bulan/Tahun</b><br /><i>Status</i></td>
                   <td width="8%" align="center">&nbsp;</td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
                    //while(!$rs->EOF) {
						//$bil = $cnt + ($PageNo-1)*$PageSize;
						//$href_link = "index.php?data=".base64_encode('user;penceramah/claim_list.php;penceramah;tuntutan;'.$rs->fields['ingenid']);
						$href_link = "index.php?data=".base64_encode('user;penceramah/claim_form.php;penceramah;tuntutan;'.$rs->fields['cl_id']);
						$href_surat = "modal_form.php?win=".base64_encode('penceramah/claim_print.php;'.$rs->fields['cl_id']);
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
			             	<td valign="top" align="left"><? echo stripslashes($rs->fields['insname']);?><br />
                            <? echo $rs->fields['insorganization'];?>&nbsp;</td>
                            <td valign="top" align="center"><? echo dlookup("_ref_kategori_penceramah","f_kp_kenyataan","f_kp_id=".$rs->fields['inskategori']);?>&nbsp;</td>
                            <td valign="top" align="center"><? echo $rs->fields['insmobiletel'];?>&nbsp;</td>
                            <td valign="top" align="center"><?php print month($rs->fields['cl_month']).", ".$rs->fields['cl_year']; ?>
                            <br /><i>
                            <?php
							if($rs->fields['is_process']==0){ print '<font color=#FF0000>Baru</font>'; }
							else if($rs->fields['is_process']==1){ print '<font color=#0000FF>Dalam Proses</font>'; }
							?></i>
                            &nbsp;</td>
                            <td align="center">
                            	<a href="<?=$href_link;?>"><img src="../img/icon-info1.gif" width="22" height="22" style="cursor:pointer" 
                                title="Sila klik untuk pengemaskinian data" border="0"/></a>
                                <img src="../images/printicon.gif" style="cursor:pointer" title="Cetak Tuntutan" 
                                onClick="open_modal('<?=$href_surat;?>','Cetakan borang tuntutan penceramah',1,1)" />
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
