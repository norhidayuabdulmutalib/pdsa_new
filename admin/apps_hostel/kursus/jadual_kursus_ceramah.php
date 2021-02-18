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
</head>
<body>
<?php
$currdate = date("Y-m-d");
$sSQL="SELECT A.*, B.categorytype, C.SubCategoryNm 
FROM _tbl_kursus_jadual A, _tbl_kursus_cat B, _tbl_kursus_catsub C WHERE A.category_code=B.id AND A.sub_category_code=C.id AND A.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;

$href_link_add = "modal_form.php?win=".base64_encode('kursus/jadual_penceramah_list.php;'.$id);
$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Text");
$rs_det = $conn->execute($sql_det);
$bil=0;
//print $sql_det;
?>
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="1">
    <tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="25%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="74%" align="left"><?php print $rs->fields['acourse_name'];?></td>                
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

            <tr bgcolor="#CCCCCC"><td colspan="5"><b>Senarai penceramah & fasilatitor bagi kursus : <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b></td></tr>
            <tr bgcolor="#CCCCCC">
                <td width="5%" align="center"><b>Bil</b></td>
                <td width="40%" align="center"><b>Nama Penceramah / Fasilitator</b></td>
                <td width="40%" align="center"><b>Agensi/Jabatan/Unit</b></td>
                <td width="10%" align="center"><b>Bidang Tugas</b></td>
                <td width="5%" align="center">&nbsp;</td>
            </tr>
			<?php while(!$rs_det->EOF){ $bil++; 
                $idh=$rs_det->fields['kur_eve_id'];
            ?>
            <tr>
                <td align="right"><?php print $bil;?>.&nbsp;</td>
                <td align="left"><?php print $rs_det->fields['insname'];?>&nbsp;</td>
                <td align="left"><?php print $rs_det->fields['insorganization'];?>&nbsp;</td>
                <td align="left"><?php if($rs_det->fields['instruct_type']=='PE'){ print 'Penceramah'; } else if($rs_det->fields['instruct_type']=='FA'){ print 'Fasilitator'; }?>&nbsp;</td>
                <td align="center">
               <?php if($btn_display==1){ ?>
                	<img src="../img/delete_btn1.jpg" border="0" style="cursor:pointer" onclick="do_hapus('jadual_kursus_ceramah','<?=$idh;?>')" />
                <?php } ?>
                &nbsp;</td>
            </tr>
            <?php $rs_det->movenext(); } ?>
            <tr>
                <td colspan="5" align="right">
                	<?php if($btn_display==1){ ?>
                    <input type="button" value="Tambah Maklumat Penceramah" style="cursor:pointer" 
                    onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Penambahan Maklumat Penceramah',70,70)" />
                    <input type="button" value="Tambah Maklumat Fasilitator" style="cursor:pointer" 
                    onclick="open_modal1('<?php print $href_link_add;?>&ty=FA','Penambahan Maklumat Fasilitator',70,70)" />
                    <?php } ?>
                </td>
            </tr>
        </table>
    </td></tr>
</table>
</body>
</html>
