<?
$conn->debug=true;
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$varSort=isset($_REQUEST["sb"])?$_REQUEST["sb"]:"startdate";

$sSQL = "SELECT A.* FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND A.enddate>=".tosql(date("Y-m-d"));
if(!empty($kategori)){ $sSQL.=" AND A.category_code=".tosql($kategori,"Text"); } 
if(!empty($search)){ $sSQL.=" AND B.coursename LIKE '%".$search."%' "; } 
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL.=" AND startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); } 
$sSQL .= " UNION ";
$sSQL .= "SELECT * FROM _tbl_kursus_jadual WHERE acourse_name<>'' AND enddate>=".tosql(date("Y-m-d"));
if(!empty($kategori)){ $sSQL.=" AND category_code=".tosql($kategori,"Text"); } 
if(!empty($search)){ $sSQL.=" AND acourse_name LIKE '%".$search."%' "; } 
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL.=" AND startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); } 

if($varSort=='coursename'){ 
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort ASC":"ORDER BY startdate DESC");
} else {
	$strSort=((strlen($varSort)>0)?" ORDER BY $varSort DESC":"ORDER BY startdate DESC");
}
$sSQL .= $strSort; //"ORDER BY B.coursename";

$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode('user;kursus/jadual_kursus.php;kursus;jkursus');
?>
<link type="text/css" rel="stylesheet" href="../cal/dhtmlgoodies_calendar2.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="../cal/dhtmlgoodies_calendar2.js"></script>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
</script>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
	<?php $sqlkk = "SELECT * FROM _tbl_kursus_cat WHERE is_deleted=0 ORDER BY category_code";
		$rskk = &$conn->Execute($sqlkk);
	?>
	<tr>
		<td width="20%" align="right"><b>Kategori Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	<select name="kategori" onchange="do_page('<?=$href_search;?>')">
            	<option value="">-- Sila pilih kategori --</option>
                <?php while(!$rskk->EOF){ ?>
                <option value="<?php print $rskk->fields['id'];?>" <?php if($kategori==$rskk->fields['id']){ print 'selected'; }?>><?php print $rskk->fields['categorytype'];?></option>
                <?php $rskk->movenext(); } ?>
            </select>
		</td>
        <td width="20%" rowspan="3">
        	<img src="../img/icon-info1.gif" width="25" height="25" border="0" /> Kemaskini maklumat kursus luaran
            <br /><img src="../images/btn_web-users_bg.gif" width="25" height="25" border="0" /> Kemaskini tempahan bilik asrama
            <br /><img src="../images/btn_crontab-win_bg.gif" width="25" height="25" border="0" /> Kemaskini tempahan bilik kuliah
        </td>
	</tr>
	<tr>
		<td align="right"><b>Tarikh Kursus : </b></td> 
		<td align="left">&nbsp;&nbsp;
        	Mula : 
			<input type="text" size="13" name="tkh_mula" value="<? echo $tkh_mula;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_mula,'dd/mm/yyyy',this)"/> 
            &nbsp;&nbsp;&nbsp;Tamat : 
			<input type="text" size="13" name="tkh_tamat" value="<? echo $tkh_tamat;?>">
            <img src="../cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                onclick="displayCalendar(document.forms[0].tkh_tamat,'dd/mm/yyyy',this)"/> [dd/mm/yyyy]
		</td>
	</tr>
	<tr>
		<td align="right"><b>Nama Kursus : </b></td> 
		<td align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<? include_once 'include/page_list.php'; ?>
</table>
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="2" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT KURSUS (PENJADUALAN)</strong></font>
        </td>
        <td colspan="1" valign="middle" align="right">
        	<? $new_page = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;');?>
        	<input type="button" value="Tambah Maklumat Jadual Kursus" style="cursor:pointer" 
            onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Jadual Kursus',1,1)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="8%" align="center"><b>Kod Kursus</b></td>
                    <td width="50%" align="center"><b>Diskripsi Kursus</b>&nbsp;</td>
                    <td width="10%" align="center"><b>Pusat/Unit</b></td>
                    <td width="10%" align="center"><b>Kategori Kursus</b></td>
                    <td width="10%" align="center"><a href="<?php echo $href_search."&sb=startdate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Mula</b></a>&nbsp;
					<?php echo (($varSort=="startdate")?"<img src=\"../images/down_arrow.gif\">":"");?></td>
                    <td width="10%" align="center"><a href="<?php echo $href_search."&sb=enddate&tkh_mula=$tkh_mula&tkh_tamat=$tkh_tamat&search=$search"; ?>"><b>Tarikh Tamat</b></a>&nbsp;
					<?php echo (($varSort=="enddate")?"<img src=\"../images/down_arrow.gif\">":"");?></td>
                    <td width="5%" align="center"><b>&nbsp;</b></td>
                </tr>
				<?
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
						$bil = $cnt + ($PageNo-1)*$PageSize;
						$courseid=''; $coursename=''; $SubCategoryCd='';
						$href_bilik = "modal_form.php?win=".base64_encode('asrama/penetapan_bilik_kuliah.php;'.$rs->fields['id']);
						$sqlk = "SELECT * FROM _tbl_kursus WHERE id=".tosql($rs->fields['courseid']);
						$rsk = $conn->execute($sqlk);
						if(!$rsk->EOF){
							$courseid = $rsk->fields['courseid'];
							$coursename = $rsk->fields['coursename'];
							$SubCategoryCd = $rsk->fields['SubCategoryCd'];
						} else {
							$courseid = '-';
							$coursename = $rs->fields['acourse_name'];
						}
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","SubCategoryCd=".tosql($SubCategoryCd,"Text"));
						$anjuran = dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code'],"Text"));
						$bilik = strtoupper(dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs->fields['bilik_kuliah'])));
                        ?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><? echo strtoupper(stripslashes($courseid));?>&nbsp;</td>
            				<td valign="top" align="left"><? echo strtoupper(stripslashes($coursename));?>&nbsp;
                            	<br /><i><b><?php if(!empty($bilik)){ print "-> BILIK KULIAH : ".$bilik; } 
								else { print '<font color=#FF0000>-> BILIK KULIAH : ?? </font>'; }?></b></i>
                                &nbsp;&nbsp;
                                <img src="../images/btn_crontab-win_bg.gif" width="25" height="24" style="cursor:pointer" title="Sila klik untuk pemilihan bilik kuliah" 
                                onclick="open_modal('<?=$href_bilik;?>&kid=<?=$rs->fields['id'];?>','Pilih Bilik Kuliah',1,1)" />
                            </td>
            				<td valign="top" align="center"><? echo stripslashes($unit);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo stripslashes($anjuran);?>&nbsp;</td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['startdate'])?></td>
            				<td valign="top" align="center"><? echo DisplayDate($rs->fields['enddate'])?></td>
                            <td align="center">
                            <?php if(empty($rs->fields['courseid'])){ $href_link = "modal_form.php?win=".base64_encode('kursus/jadual_kursus_form.php;'.$rs->fields['id']); ?>
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Jadual Kursus',1,1)" />
                            <?php } else { $href_bilik = "modal_form.php?win=".base64_encode('kursus/tempahan_bilik_asrama1.php;'.$rs->fields['id']); ?>
                            	<img src="../images/btn_web-users_bg.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_bilik;?>','Tempahan bilik asrama',1,1)" /> 
							<?php } ?>
                            </td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="8" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <? } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?
if($cnt<>0){
	$sFileName=$href_search;
	include_once 'include/list_footer.php'; 
}
?> 
</td></tr>
<tr><td>        
</td></td>
</table> 
</form>
