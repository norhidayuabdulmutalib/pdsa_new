<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$idnama = $_GET['idnama'];
$msg='';
?>
<script LANGUAGE="JavaScript">
function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
$idk=$_GET['idk'];
$sSQL="SELECT A.*, B.startdate, B.enddate, B.timestart, B.timeend, B.class, B.status, B.jumkos, B.bilik_kuliah, B.set_penilaian, B.lelaki, 
B.perempuan, B.vip, B.penyelaras, B.penyelaras_notel, B.category_code   
FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE A.id=B.courseid AND B.id = ".tosql($idk,"Text");
$rs = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
    <tr>
        <td width="28%" align="right"><b><font color="#FF0000">*</font> Kategori Kursus : </b></td> 
      	<td width="72%" colspan="2" align="left" ><?php print dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code'])); ?>
      	<div style="float:right"><input type="button" value="Tutup" style="cursor:pointer" onclick="javascript:parent.emailwindow.hide();" /></div>
      	</td>
    </tr>
    <?php 
        $sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 ";
        if(!empty($rs->fields['category_code'])){ $sqlkks .= " AND f_category_code=".tosql($rs->fields['category_code'],"Number"); }
        $sqlkks .= " ORDER BY SubCategoryNm";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Pusat / Unit : </b></td> 
        <td align="left" colspan="2" ><?php print dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'])); ?></td>
    </tr>
    <?php 
        $sqlkks = "SELECT * FROM _tbl_kursus WHERE is_deleted=0 AND courseid=".tosql($rs->fields['courseid']);
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Subjek : </b></td> 
        <td align="left" colspan="2" ><?php print $rskks->fields['courseid'] . " - " . $rskks->fields['coursename'];?></td>
	</tr>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Objektif Kursus : </b></td> 
        <td align="left" colspan="2" ><?php print nl2br($rs->fields['objektif']);?></td>
	</tr>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Kandungan Kursus : </b></td> 
        <td align="left" colspan="2" ><?php print nl2br($rs->fields['kandungan']);?></td>
	</tr>
    <tr>
        <td align="right"><b><font color="#FF0000">*</font> Kumpulan Sasar : </b></td> 
        <td align="left" colspan="2" ><?php print nl2br($rs->fields['ksasar']);?></td>
	</tr>

    <tr>
        <td align="right"><b>Tarikh Kursus : </b></td> 
        <td align="left">
            Mula : <? echo DisplayDate($rs->fields['startdate']);?>&nbsp;&nbsp;&nbsp;Tamat : <? echo DisplayDate($rs->fields['enddate']);?></td>
    </tr>
    <tr>
        <td align="right"><b>Masa Mula : </b></td> 
        <td align="left"><?php print $rs->fields['timestart'];?>  </td>
    </tr>
    <tr>
        <td align="right"><b>Masa Tamat : </b></td> 
        <td align="left"><?php print $rs->fields['timeend'];?></td>
    </tr>
    <tr>
        <td align="right"><b>Tempat : </b></td> 
        <td align="left" colspan="2" >
        	<?php print dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs->fields['bilik_kuliah']));?>
        </td>
    </tr>
    <tr>
        <td align="right"><b>Nama Penyelaras : </b></td>
        <td align="left" colspan="2"><?php print $rs->fields['penyelaras'];?></td>
    </tr>
    <tr>
        <td align="right"><b>No. Tel. Penyelaras : </b></td>
        <td align="left" colspan="2"><?php print $rs->fields['penyelaras_notel'];?></td>
    </tr>
    <tr>
        <td align="right"><b>Bilangan Peserta : </b></td>
        <td align="left" colspan="2">
        	Lelaki : <?php print $rs->fields['lelaki'];?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            Perempuan : <?php print $rs->fields['perempuan'];?>
        </td>
    </tr>
    <tr>
        <td align="right"><b>Kemudahan Penginapan Asrama : </b></td>
        <td align="left" colspan="2"><? if($rs->fields['asrama_perlu']=='TIDAK'){ print 'Tidak perlu'; }
                else if($rs->fields['asrama_perlu']=='ASRAMA'){ print 'Asrama'; } ?>
        </td>
    </tr>
    
	<?php if(!empty($idk)){ ?>
    <tr><td colspan="3"><hr /></td></tr>
    <tr><td colspan="3"><? $kid = $rs->fields['id'];?>
        <?php include 'kursus_document.php'; ?>
    </td></tr>
    <?php } ?>
    <tr><td colspan="3"><hr /></td></tr>
    <tr><td colspan="3"><? $id = $idk;?>
		<?php include 'kursus/jadual_pensyarah.php'; ?>
    </td></tr>

    <tr><td colspan="3"><hr /></td></tr>
<!--
	<tr><td colspan="3">
        <table width="90%" cellpadding="4" cellspacing="0" border="1" align="center">

            <tr bgcolor="#CCCCCC"><td colspan="5"><b>Senarai penceramah & fasilatitor bagi kursus : <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b></td></tr>
            <tr bgcolor="#CCCCCC">
                <td width="5%" align="center"><b>Bil</b></td>
                <td width="40%" align="center"><b>Nama Penceramah / Fasilitator</b></td>
                <td width="35%" align="center"><b>Agensi/Jabatan/Unit</b></td>
                <td width="10%" align="center"><b>Bidang Tugas</b></td>
                <td width="10%" align="center">&nbsp;</td>
            </tr>
			<?php while(!$rs_det->EOF){ $bil++; 
                $idh=$rs_det->fields['kur_eve_id'];
 				$href_surat_penceramah = "modal_form.php?win=".base64_encode('kursus/surat_penceramah.php;'.$rs_det->fields['kur_eve_id']);
           ?>
            <tr>
                <td align="right"><?php print $bil;?>.&nbsp;</td>
                <td align="left"><?php print $rs_det->fields['insname'];?>&nbsp;</td>
                <td align="left"><?php print $rs_det->fields['insorganization'];?>&nbsp;</td>
                <td align="left"><?php if($rs_det->fields['instruct_type']=='PE'){ print 'Penceramah'; } else if($rs_det->fields['instruct_type']=='FA'){ print 'Fasilitator'; }?>&nbsp;</td>
                <td align="center">
               <?php if($btn_display==1){ ?>
                	<img src="../img/delete_btn1.jpg" border="0" width="20" height="20" style="cursor:pointer" onclick="do_hapus('jadual_kursus_ceramah','<?=$idh;?>')" />
                    &nbsp;
                    <img src="../img/printer_icon1.jpg" width="23" height="23" style="cursor:pointer" 
                    title="Sila klik untuk mencetak Cetak surat jemputan kepada Penceramah @ Pensyarah" 
                    onclick="openModal('<?=$href_surat_penceramah;?>','Cetak surat jemputan kepada Penceramah @ Pensyarah',1,1)" />
                <?php } ?>
                &nbsp;</td>
            </tr>
            <?php $rs_det->movenext(); } ?>
            <tr>
                <td colspan="5" align="right">
                	<?php if($btn_display==1){ ?>
                    <input type="button" value="Tambah Maklumat Penceramah" style="cursor:pointer" 
                    onclick="open_modal1('<?php print $href_link_add;?>&ty=PE','Penambahan Maklumat Penceramah',80,80)" />
                    <input type="button" value="Tambah Maklumat Fasilitator" style="cursor:pointer" 
                    onclick="open_modal1('<?php print $href_link_add;?>&ty=FA','Penambahan Maklumat Fasilitator',80,80)" />
                    <?php } ?>
                </td>
            </tr>
        </table>
    </td></tr>
-->    
</table>
</form>