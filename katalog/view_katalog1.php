<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$msg='';
?>
<script LANGUAGE="JavaScript">
function do_pages(URL){
	//alert(URL);
	document.ilim.action = URL;
	document.ilim.submit();
}

function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<?php
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
//$conn->debug=true;
//print $_SERVER['HTTP_ACCEPT'];
$idk=$id; //$_GET['idk'];
$sSQL="SELECT A.*, B.startdate, B.enddate, B.timestart, B.timeend, B.class, B.status, B.jumkos, B.bilik_kuliah, B.set_penilaian, B.lelaki, 
B.perempuan, B.vip, B.penyelaras, B.penyelaras_notel, B.category_code, B.id as idk    
FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE A.id=B.courseid AND B.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
if($rs->fields['startdate']<=date("Y-m-d")){ $disp = 'T'; } else { $disp='B'; $link='&idk='.$rs->fields['idk'];}
if($rs->fields['status']=='9'){ $disp = 'T'; }
else if($rs->fields['status']=='2'){ $disp = 'T'; }
else if($rs->fields['status']=='1'){ $disp = 'T'; }
$href_link1 = "index.php?pages=katalog/mohon&idk=".$idk;
?>
<form name="ilim" method="post">
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
    <tr>
        <td align="right"><b> Pusat Latihan @ Tempat Kursus : </b></td> 
      <td align="left" colspan="2" ><b style="color:#00F"><?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['kampus_id'])); ?></b></td>
    </tr>
    <tr>
        <td width="28%" align="right"><b> Kategori Kursus : </b></td> 
   	  <td width="72%" colspan="2" align="left" ><?php print dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code'])); ?>
      	<div style="float:right">
        <?php if($disp=='B'){ ?>
        <input type="button" value="Mohon Kursus" style="cursor:pointer" 
          onclick="do_pages('<?=$href_link1;?>')" />
  		<?php } ?>
        <input type="button" value="Tutup" style="cursor:pointer" onclick="do_pages('index.php')" />
  		</div>
      	</td>
    </tr>
    <?php 
        /*$sqlkks = "SELECT * FROM _tbl_kursus_catsub WHERE is_deleted=0 ";
        if(!empty($rs->fields['category_code'])){ $sqlkks .= " AND f_category_code=".tosql($rs->fields['category_code'],"Number"); }
        $sqlkks .= " ORDER BY SubCategoryNm";
        $rskks = &$conn->Execute($sqlkks);*/
    ?>
    <tr>
        <td align="right"><b> Pusat / Unit : </b></td> 
      <td align="left" colspan="2" ><?php print dlookup("_tbl_kursus_catsub","SubCategoryDesc","id=".tosql($rs->fields['subcategory_code'])); ?></td>
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
   <tr>
        <td align="right"><b>Tarikh Kursus : </b></td> 
        <td align="left">
            Mula : <?php echo DisplayDate($rs->fields['startdate']);?>&nbsp;&nbsp;&nbsp;Tamat : <?php echo DisplayDate($rs->fields['enddate']);?></td>
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
	<tr><td colspan="3"><hr /></td></tr>
    <tr>
        <td align="right"><b>Nama Penyelaras : </b></td>
        <td align="left" colspan="2"><?php print $rs->fields['penyelaras'];?></td>
    </tr>
    <tr>
        <td align="right"><b>No. Tel. Penyelaras : </b></td>
        <td align="left" colspan="2"><?php print $rs->fields['penyelaras_notel'];?></td>
    </tr>
    <!--<tr>
        <td align="right"><b>Kemudahan Penginapan Asrama : </b></td>
        <td align="left" colspan="2"><?php if($rs->fields['asrama_perlu']=='TIDAK'){ print 'Tidak perlu'; }
                else if($rs->fields['asrama_perlu']=='ASRAMA'){ print 'Asrama'; } ?>
        </td>
    </tr>-->
    
	<!--<?php if(!empty($idk)){ ?>
    <tr><td colspan="3"><hr /></td></tr>
    <tr><td colspan="3"><?php $kid = $rs->fields['id'];?>
        <?php //include 'kursus_document.php'; ?>
    </td></tr>
    <?php } ?>
    <tr><td colspan="3"><hr /></td></tr>
    <tr><td colspan="3"><?php $id = $idk;?>
		<?php //include 'kursus/jadual_pensyarah.php'; ?>
    </td></tr>-->

</table>
<hr />
<div align="center">
<?php if($disp=='B'){ ?>
<input type="button" value="Mohon Kursus" style="cursor:pointer" 
  onclick="do_pages('<?=$href_link1;?>')" />
<?php } ?>  
<input type="button" value="Tutup" style="cursor:pointer" onclick="do_pages('index.php')" />
</div>
</form>