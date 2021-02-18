<?php 
//include_once '../common.php';
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$nokp=isset($_REQUEST["nokp"])?$_REQUEST["nokp"]:"";
$proses = $_GET['pro'];
$msg='';
?>
<script LANGUAGE="JavaScript">
function do_pages(URL){
	//alert(URL);
	document.ilim.action = URL;
	document.ilim.submit();
}
function do_logs(URL){
	//alert(URL);
	parent.document.ilim.action = URL;
	parent.document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<form name="ilim" method="post">
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr><td colspan="3" height="30px" align="center" valign="middle" bgcolor="#66CC99">
    	<b>Sila masukkan No. kad Pengenalan anda / Kad Kuasa (Polis/Tentera)</b>
    </td></tr>
    <tr>
        <td width="28%" align="right"><b> No. Kad Pengenalan : </b></td> 
   	  	<td width="72%" colspan="2" align="left">
        	<input type="text" size="20" name="nokp" value="<?=$nokp;?>" />&nbsp;
      		<input type="button" value="Semak" style="cursor:pointer" 
            onclick="do_pages('modal_form.php?win=<?=base64_encode('katalog/semakan_permohonan.php;');?>')" />
            <input type="button" value="Tutup" style="cursor:pointer" onclick="form_back()" />
        </td>
    </tr>
</table>
<?php
//print $nokp;
if(!empty($nokp)){ 
	//$conn->debug=true;
	$sql_det = "SELECT B.f_peserta_noic, A.*, B.f_peserta_nama, B.BranchCd, B.f_title_grade, 
	D.courseid, D.coursename, C.startdate, C.enddate, A.is_selected, C.penyelaras, C.penyelaras_notel, C.penyelaras_email  
	FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _tbl_kursus_jadual C, _tbl_kursus D 
	WHERE A.peserta_icno=B.f_peserta_noic AND A.peserta_icno=".tosql($nokp);
	$sql_det .= " AND A.EventId=C.id AND C.courseid=D.id AND C.startdate>".tosql(date("Y-m-d"));
	$sql_det .= " ORDER BY C.enddate ASC";
	$rs = &$conn->Execute($sql_det); //AND A.is_selected=1 
	if(!$rs->EOF){
?>
        <br />
        <hr />
        <table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
            <tr><td colspan="3" align="center" valign="middle">
            	<b>Nama : <?php print strtoupper(stripslashes($rs->fields['f_peserta_nama']));?><br />
                No. Kad Pengenalan : <?php print strtoupper(stripslashes($rs->fields['f_peserta_noic']));?></b>
            </td></tr>
        </table>    
        <hr />
<?		while(!$rs->EOF){
			$kursus = "<br>".$rs->fields['courseid']." - ".$rs->fields['coursename'];
			$kursus .= "<br> Pada : ".DisplayDate($rs->fields['startdate'])." - ".DisplayDate($rs->fields['enddate']);
			$kursus .= "<br>";
			
			if($rs->fields['is_selected']=='1'){
?>
                <br />
                <table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
                    <tr><td colspan="3" height="30px" align="center" valign="middle">
                        <!--Permohonan anda untuk menghadiri kursus <b><?=$kursus;?></b> telah berjaya dan memerlukan pengesahan kehadiran tuan/puan.<br /><br />Sila log masuk ke dalam sistem untuk mengesahkan kehadiran anda.
                        <br /><br />
                        <input type="button" value="Log Masuk" style="cursor:pointer" onclick="do_logs('index.php?pages=login_peserta&id=<?=$nokp;?>')" />
                    	-->
                        Permohonan anda untuk menhgadiri kursus <b><?=$kursus;?></b> telah berjaya.  Sila semak email tuan/puan untuk mencetak surat tawaran dan borang pengesahan kehadiran.<br /><br />
                        Sila hubungi penyelaras <?php print $rs->fields['penyelaras'];?> di no. telefon <?php print $rs->fields['penyelaras_notel'];?> atau email <?php print $rs->fields['penyelaras_email'];?> jika terdapat sebarang masalah.
                    </td></tr>
                </table>
<?php 		} else { ?>
                <br />
                <hr /><br />
                <table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
                    <tr><td colspan="3" height="30px" align="center" valign="middle">
                        Permohonan anda untuk menghadiri kursus <b><?=$kursus;?></b> sedang diproses.  Sila tunggu surat tawaran daripada pihak ILIM sekiranya terpilih.
                        <br /><br /> 
                        <input type="button" value="Tutup" style="cursor:pointer" onclick="form_back()" />
                    </td></tr>
                </table>
<?php 
			}
			$rs->movenext();
		}
	} else { ?>
<br />
<hr /><br />
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr><td colspan="3" height="30px" align="center" valign="middle">
		Tiada maklumat dijumpai.<br /><br />
        <input type="button" value="Tutup" style="cursor:pointer" onclick="form_back()" />
	</td></tr>
</table>
<?php
}
}
?>
</form>
