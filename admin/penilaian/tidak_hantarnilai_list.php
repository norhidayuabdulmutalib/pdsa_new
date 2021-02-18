<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="../modalwindow/modal.js"></script>
<script language="javascript" type="text/javascript">	
function open_modal1(URL,title,width,height){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
} //End "opennewsletter" function
</script>
<script language='javascript1.2' src='../script/RemoteScriptServer.js'></Script>
<script language="javascript" type="text/javascript">
function do_terima1(ty,ids){
	var URL = 'kursus/jadual_kursus_peserta_hadir.php?ty=' + ty + '&ids=' + ids;
	/*alert(URL);
	document.hadir.action = URL;
	document.hadir.target = '_blank';
	document.hadir.submit();*/
	callToServer(URL);
	location.reload(true);

}
function do_terima(ty,ids){
	var URL = 'kursus/jadual_kursus_peserta_hadir.php?ty=' + ty + '&ids=' + ids;
	//if(confirm("Adakah anda pasti untuk menghapuskan data yang dipilih daripada senarai?")){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Kemaskini Maklumat', 'width=200px,height=100px,center=1,resize=1,scrolling=0')
	//}
}
</script>
</head>
<body>
<?php
//$conn->debug=true;
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;

//$sqlsel = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE InternalStudentAccepted=1 AND EventId=".tosql($id) . " 
//AND InternalStudentId NOT IN (SELECT id_peserta FROM _tbl_set_penilaian_peserta WHERE event_id=".tosql($id).")";

//$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Number");
$sql_det = "SELECT A.*, B.f_peserta_nama, B.BranchCd, B.f_peserta_noic, B.f_title_grade 
FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
WHERE A.peserta_icno=B.f_peserta_noic AND A.EventId=".tosql($id) . " AND A.InternalStudentAccepted=1 AND A.is_deleted=0 AND B.is_deleted=0  
AND A.InternalStudentId IN (SELECT id_peserta FROM _tbl_set_penilaian_peserta WHERE is_nilai=0 AND event_id=".tosql($id).")";
$sql_det .= " ORDER BY B.f_peserta_nama";
$rs_det = $conn->execute($sql_det);
//print $sql_det;
$bil=0;

$curr_date = date("Y-m-d");
$end_date = $rs->fields['enddate'];
?>
<form name="hadir" method="post" action="">
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="1">
    <tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="15%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="50%" align="left"><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></td>    
                <td width="34%" align="right" rowspan="4">&nbsp;
                
                </td>            
            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rs->fields['startdate']);?> - <?php print DisplayDate($rs->fields['enddate']);?></td>                
            </tr>
		</table>
    </td>
	<tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="1" align="center">
            <tr bgcolor="#CCCCCC">
            	<td colspan="4" valign="top">
                <div style="float:left">
                <b>Senarai peserta yang tidak membuat penilaian bagi kursus :<br /><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b></div>
            	</td>
            </tr>
            <tr bgcolor="#CCCCCC">
                <td width="5%" align="center"><b>Bil</b></td>
                <td width="40%" align="center"><b>Nama Peserta</b></td>
                <td width="5%" align="center"><b>Gred</b></td>
                <td width="30%" align="center"><b>Agensi/Jabatan/Unit</b></td>
          </tr>
            <?php while(!$rs_det->EOF){ $bil++; ?>
            <tr>
                <td align="right"><?php print $bil;?>.&nbsp;</td>
                <td align="left"><?php print $rs_det->fields['f_peserta_nama'];?><br /><i>No. KP: <?php print $rs_det->fields['f_peserta_noic'];?>
                (<?php print $rs_det->fields['InternalStudentId'];?>)</i>&nbsp;</td>
                <td align="center"><?php print dlookup("_ref_titlegred","f_gred_code","f_gred_id=".tosql($rs_det->fields['f_title_grade']));?>&nbsp;</td>
                <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs_det->fields['BranchCd']));?>&nbsp;</td>
          </tr>
            <?php $rs_det->movenext(); } ?>
        </table>
    </td></tr>
</table>
</form>
</body>
</html>
