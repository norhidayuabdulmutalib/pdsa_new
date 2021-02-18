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
//$conn->debug=true;;
$sSQL="SELECT A.*, B.categorytype, C.SubCategoryNm 
FROM _tbl_kursus_jadual A, _tbl_kursus_cat B, _tbl_kursus_catsub C WHERE A.category_code=B.id AND A.sub_category_code=C.id AND A.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;

$href_link_add = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_list.php;'.$id);
$href_link_pro = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_pro.php;'.$id);
//$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Number");
$sql_det = "SELECT * FROM _sis_a_tblasrama_tempah WHERE event_id=".tosql($id)." ORDER BY bilik_id";
$rs_det = $conn->execute($sql_det);
//print $sql_det;
$bil=0;
//$conn->debug=true;
$jum_all=$rs->fields['lelaki']+$rs->fields['perempuan'];
$jum_tem=dlookup("_sis_a_tblasrama_tempah","count(*)","event_id=".tosql($id));
if($jum_tem>=$jum_all){ $pilih=1; } else { $pilih=0; }
$href_bilik = "modal_form.php?win=".base64_encode('kursus/tempahan_bilik_asrama.php;'.$rs->fields['id']);
?>
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="1">
    <tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="15%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="54%" align="left"><?php print $rs->fields['acourse_name'];?></td>
                <td width="30%" align="center" rowspan="4" valign="top">
                <?php if($pilih==0){ ?>
                <input type="button" value="Proses Tempahan Bilik" 
                onclick="open_modal1('<?=$href_bilik;?>&kid=<?=$rs->fields['id'];?>','TEMPAHAN BILIK - Pilih Bilik Asrama',1,1)"  />
                <?php } ?>
                <br />Maklumat Tempahan<br />
                Peserta Lelaki: <u><?=$rs->fields['lelaki'];?> Orang</u> <b>/</b> Tempah:
				<?php print dlookup("_sis_a_tblasrama_tempah A, _ref_blok_bangunan B, _sis_a_tblbilik C ","count(*)",
				"A.bilik_id=C.bilik_id AND C.blok_id=B.f_bb_id AND B.f_bb_type='L' AND A.event_id=".tosql($id));?>
                <br />
                Peserta Perempuan: <u><?=$rs->fields['perempuan'];?> Orang</u> <b>/</b> Tempah:
				<?php print dlookup("_sis_a_tblasrama_tempah A, _ref_blok_bangunan B, _sis_a_tblbilik C ","count(*)",
				"A.bilik_id=C.bilik_id AND C.blok_id=B.f_bb_id AND B.f_bb_type='P' AND A.event_id=".tosql($id));?>
                <? $conn->debug=false;?>
                </td>    
            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Sub Kategori</b></td>
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
            <tr bgcolor="#CCCCCC"><td colspan="6"><b>Senarai tempahan bilik bagi kursus : <?php print $rs->fields['acourse_name'];?></b></td></tr>
            <tr bgcolor="#CCCCCC">
                <td width="5%" align="center"><b>Bil</b></td>
               <!-- <td width="60%" align="center"><b>Nama Peserta</b></td>-->
                <td width="20%" align="center"><b>Maklumat Bilik</b></td>
                <td width="10%" align="center"><b>&nbsp;</b></td>
            </tr>
            <?php while(!$rs_det->EOF){ $bil++; 
				$href_link = "modal_form.php?win=".base64_encode('kursus/tempahan_bilik_asrama_del.php;');
				$href_nama = "modal_form.php?win=".base64_encode('kursus/tempahan_bilik_asrama_upd.php;');
				$idh=$rs_det->fields['InternalStudentId'];
				$sqlb="SELECT A.no_bilik, B.f_bb_desc FROM _sis_a_tblbilik A, _ref_blok_bangunan B WHERE A.blok_id=B.f_bb_id AND A.bilik_id=".tosql($rs_det->fields['bilik_id']);
				$rsbi=$conn->execute($sqlb);
				$no_bilik = $rsbi->fields['no_bilik'];
				$asrama_bilik = $rsbi->fields['f_bb_desc'];
			?>
            <tr>
                <td align="right"><?php print $bil;?>.&nbsp;</td>
                <!--<td align="left"><div style="float:left"><?php print $rs_det->fields['f_peserta_nama'];?><br /><i>No. KP: <?php print $rs_det->fields['f_peserta_noic'];?></i></div>
                <div style="float:right"><img src="../img/item.gif" border="0" style="cursor:pointer" title="Sila klik untuk tambah maklumat tempahan." 
                onclick="open_modal('<?=$href_nama;?>&tid=<?=$rs_det->fields['tempahan_id'];?>','Kemaskini maklumat tempahan',1,1)" /></div>
                &nbsp;</td>-->
                <td align="center"><?php print $no_bilik ." - " . $asrama_bilik;?>&nbsp;</td>
                <td align="center">
                    <img src="../img/off.gif" width="22" height="22" style="cursor:pointer" title="Sila klik untuk menghapuskan data" 
                    onclick="open_modal('<?=$href_link;?>&tid=<?=$rs_det->fields['tempahan_id'];?>','Hapus maklumat tempahan bilik peserta',10,10)" />
				</td>
            </tr>
            <?php $rs_det->movenext(); } ?>
        </table>
    </td></tr>
</table>
</body>
</html>
