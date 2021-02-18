<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$msg='';
?>
<script LANGUAGE="JavaScript">
function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
$idk=$id; //$_GET['idk'];
$sSQL="SELECT A.* FROM _tbl_kursus A WHERE A.id = ".tosql($idk,"Text");
$rs = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
    <tr>
        <td width="28%" align="right"><b> Kategori Kursus : </b></td> 
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
        <td align="right"><b> Pusat / Unit : </b></td> 
      <td align="left" colspan="2" ><?php print dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['subcategory_code'])); ?></td>
    </tr>
    <?php 
        $sqlkks = "SELECT * FROM _tbl_kursus WHERE is_deleted=0 AND courseid=".tosql($rs->fields['courseid']);
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b> Subjek : </b></td> 
      <td align="left" colspan="2" ><?php print $rskks->fields['courseid'] . " - " . $rskks->fields['coursename'];?></td>
	</tr>
    <tr>
        <td align="right"><b>Objektif Kursus : </b></td> 
      <td align="left" colspan="2" ><?php print nl2br($rs->fields['objektif']);?></td>
	</tr>
    <tr>
        <td align="right"><b> Kandungan Kursus : </b></td> 
      <td align="left" colspan="2" ><?php print nl2br($rs->fields['kandungan']);?></td>
	</tr>
    <tr>
        <td align="right"><b>Kumpulan Sasar : </b></td> 
      <td align="left" colspan="2" ><?php print nl2br($rs->fields['ksasar']);?></td>
	</tr>
	<tr><td colspan="3"><hr /></td></tr>
   <!-- <tr>
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
    </tr>-->
    <tr>
        <td align="right"><b>Nama Penyelaras : </b></td>
        <td align="left" colspan="2"><?php print $rs->fields['penyelaras'];?></td>
    </tr>
    <tr>
        <td align="right"><b>No. Tel. Penyelaras : </b></td>
        <td align="left" colspan="2"><?php print $rs->fields['penyelaras_notel'];?></td>
    </tr>
    <!--<tr>
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
    </tr>-->
    
	<!--<?php if(!empty($idk)){ ?>
    <tr><td colspan="3"><hr /></td></tr>
    <tr><td colspan="3"><? $kid = $rs->fields['id'];?>
        <?php //include 'kursus_document.php'; ?>
    </td></tr>
    <?php } ?>
    <tr><td colspan="3"><hr /></td></tr>
    <tr><td colspan="3"><? $id = $idk;?>
		<?php //include 'kursus/jadual_pensyarah.php'; ?>
    </td></tr>-->

    <tr><td colspan="3"><hr /></td></tr>
	
    <?php $curr_dt = date("Y-m-d");
	$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE courseid=".tosql($id);
	$rsdetail = &$conn->execute($sqlk);
	?>
	<tr><td colspan="3">
        <table width="90%" cellpadding="4" cellspacing="0" border="1" align="center">

            <tr bgcolor="#CCCCCC"><td colspan="5"><b>Jadual Kursus : <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b></td></tr>
            <tr bgcolor="#CCCCCC">
                <td width="5%" align="center"><b>Bil</b></td>
                <td width="15%" align="center"><b>Tarikh</b></td>
                <td width="55%" align="center"><b>Penyelaras Kursus</b></td>
                <td width="15%" align="center"><b>Permohonan</b></td>
            </tr>
			<?php while(!$rsdetail->EOF){ $bil++; 
                $idh=$rsdetail->fields['kur_eve_id'];
 				//$href_surat_penceramah = "modal_form.php?win=".base64_encode('kursus/surat_penceramah.php;'.$rs_det->fields['kur_eve_id']);
           ?>
            <tr>
                <td align="right"><?php print $bil;?>.&nbsp;</td>
                <td align="center" valign="top">
					<?php print DisplayDate($rsdetail->fields['startdate'])."<br>-<br>".DisplayDate($rsdetail->fields['enddate']);?>&nbsp;</td>
                <td align="left" valign="top"><?php print $rsdetail->fields['penyelaras'];?><br />
                Telefon : <?php print $rsdetail->fields['penyelaras_notel'];?><br />
                Emel : <?php print $rsdetail->fields['penyelaras_notel'];?>
                &nbsp;</td>
                <td align="center" valign="middle">
                <?php if($rsdetail->fields['enddate']>$curr_dt){ print 'Permohonan Dibuka'; } else { print '<font color="#FF0000">Ditutup</font>'; } ?>
                &nbsp;</td>
            </tr>
            <?php $rsdetail->movenext(); } ?>
        </table>
    </td></tr>
    
</table>
</form>