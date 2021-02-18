<?php
//$conn->debug=true;
$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
$tkh_tamat=isset($_REQUEST["tkh_tamat"])?$_REQUEST["tkh_tamat"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$varSort=isset($_REQUEST["sb"])?$_REQUEST["sb"]:"startdate";
//$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$sSQL="SELECT A.* FROM _tbl_kursus_jadual A WHERE A.enddate>=".tosql(date("Y-m-d"));
$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd, B.subcategory_code  
FROM _tbl_kursus_jadual A, _tbl_kursus B, _tbl_kursus_catsub D 
WHERE A.courseid=B.id AND B.is_deleted=0"; 
$sSQL.= " AND B.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
$sSQL.=" AND A.enddate>=".tosql(date("Y-m-d"));
//$sSQL .= " AND A.status IN (0,9) ";
//if(!empty($search)){ $sSQL.=" AND B.coursename LIKE '%".$search."%' "; } 
//if(!empty($kategori)){ $sSQL.=" AND B.category_code=".tosql($kategori,"Text"); } 
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }
if(!empty($tkh_mula) && empty($tkh_tamat)){ $sSQL.=" AND A.startdate>=".tosql(DBDate($tkh_mula),"Text"); } 
if(!empty($tkh_mula) && !empty($tkh_tamat)){ $sSQL.=" AND A.startdate BETWEEN ".tosql(DBDate($tkh_mula),"Text")." AND ".tosql(DBDate($tkh_tamat),"Text"); } 
$strSort=((strlen($varSort)>0)?" ORDER BY $varSort ASC":"ORDER BY A.startdate ASC");
$sSQL .= $strSort; //"ORDER BY B.coursename";
$rs = $conn->query($sSQL);
//print $sSQL;
$cnt = $rs->recordcount();
//$conn->debug=false;

$href_search = "index.php?data=".base64_encode('user;kursus/penetapan_bilik.php;kursus;bilik');
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
<table width="100%" align="center" cellpadding="5" cellspacing="0" border="1">
	<? //include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	       <strong>SENARAI MAKLUMAT KURSUS (PENJADUALAN).</strong></font>
        <br />Sila klik pada ikon <img src="../images/btn_crontab-win_bg.gif" width="25" height="24" /> untuk penetapan bilik kuliah
        </td>
    </tr>
</table>
<table width="100%" border="1" cellpadding="3" cellspacing="0">
    <tr bgcolor="#CCCCCC">
        <td width="5%" align="center"><b>Bil</b></td>
        <td width="8%" align="center"><b>Kod Kursus</b></td>
        <td width="50%" align="center"><b>Diskripsi Kursus</b>&nbsp;</td>
        <td width="10%" align="center"><b>Pusat/Unit</b></td>
        <td width="10%" align="center"><b>Tarikh Kursus</b>&nbsp;</td>
        <td width="5%" align="center"><b>&nbsp;</b></td>
    </tr>
    <?
    if(!$rs->EOF) {
        $cnt = 1;
        $bil = $StartRec;
        while(!$rs->EOF) {
            $bil = $cnt + ($PageNo-1)*$PageSize;
            $href_bilik = "modal_form.php?win=".base64_encode('asrama/penetapan_bilik_kuliah.php;'.$rs->fields['id']);
            //$sqlkursus = "SELECT * FROM _tbl_kursus WHERE id=".tosql($rs->fields['courseid']);
            //$rskursus = $conn->execute($sqlkursus);
            $courseid = $rs->fields['courseid'];
            $coursename = $rs->fields['coursename'];
            $SubCategoryCd = $rs->fields['SubCategoryCd'];
            $subcategory_code = $rs->fields['subcategory_code'];
            //$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","SubCategoryCd=".tosql($SubCategoryCd,"Text"));
            $unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($subcategory_code,"Text"));
            $bilik = strtoupper(dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs->fields['bilik_kuliah'])));
            if(empty($coursename)){ $coursename = $rs->fields['acourse_name']; $courseid='KL'; }
			//print $courseid;
			if($courseid=='KL'){ $jk=0; } else { $jk=1; }
            ?>
            <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                <td valign="top" align="right"><?=$bil;?>.</td>
                <td valign="top" align="left"><? echo stripslashes($courseid);?>&nbsp;</td>
                <td valign="top" align="left"><? echo stripslashes($coursename);?>&nbsp;<br />
                <i><b><?php if(!empty($bilik)){ print "-> BILIK KULIAH : ".$bilik; } 
                else { print '<font color=#FF0000>-> BILIK KULIAH : ?? </font>'; }?></b></i></td>
                <td valign="top" align="center"><? echo stripslashes($unit);?>&nbsp;</td>
                <td valign="top" align="center"><? echo DisplayDate($rs->fields['startdate'])?><br />hingga<br /><? echo DisplayDate($rs->fields['enddate'])?></td>
                <td align="center">
                    <img src="../images/btn_crontab-win_bg.gif" width="30" height="28" style="cursor:pointer" title="Sila klik untuk pemilihan bilik kuliah" 
                    onclick="open_modal('<?=$href_bilik;?>&kid=<?=$rs->fields['id'];?>&jk=<?=$jk;?>','Pilih Bilik Kuliah',1,1)" />
                </td>
            </tr>
            <?
            $cnt = $cnt + 1;
            $bil = $bil + 1;
            $rs->movenext();
        } 
    } else {
    ?>
    <tr><td colspan="7" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
    <? } ?>                   
</table> 
