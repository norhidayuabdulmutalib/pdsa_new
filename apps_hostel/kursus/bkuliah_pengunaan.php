<?
$sSQL="SELECT A.*, B.f_bb_desc, C.f_kb_desc, D.f_ab_desc FROM _tbl_bilikkuliah A, _ref_blok_bangunan B, _ref_kategori_blok C, _ref_aras_bangunan D 
WHERE A.f_bb_id=B.f_bb_id AND B.f_kb_id=C.f_kb_id AND A.f_ab_id=D.f_ab_id AND A.f_bilikid = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="3" valign="middle">
        	<div style="float:left"><font size="2" face="Arial, Helvetica, sans-serif">
	        <strong>MAKLUMAT BILIK KULIAH - PENGUNAAN BILIK </strong></font></div>
        	<div style="float:right"><input type="button" value="Tutup" onclick="javascript:parent.emailwindow.hide();" style="cursor:pointer" /></div>
      	</td>
    </tr>
	<tr>
		<td align="right" width="25%"><b>Nama Bilik Kuliah : </b></td> 
		<td align="left" width="75%">&nbsp;&nbsp;<?php print $rs->fields['f_bilik_nama'];?></td>
	</tr>
	<tr>
		<td align="right"><b>Blok Bangunan : </b></td> 
		<td align="left">&nbsp;&nbsp;<?php print $rs->fields['f_ab_desc']." - ".$rs->fields['f_bb_desc']." - ".$rs->fields['f_kb_desc'];?></td>
	</tr>
</table>
<?php
//$conn->debug=true;
$sSQL  = " SELECT acourse_name as namakursus, startdate, enddate, category_code, sub_category_code 
	FROM _tbl_kursus_jadual WHERE bilik_kuliah=".tosql($rs->fields['f_bilikid']); 
$sSQL .= " UNION ";
$sSQL .= " SELECT B.coursename as namakursus, A.startdate, A.enddate, A.category_code, A.sub_category_code 
	FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND A.bilik_kuliah=".tosql($rs->fields['f_bilikid']); 
$sSQL .= " ORDER BY startdate DESC";
$rs_bilik = &$conn->Execute($sSQL);
//$cnt = $rs->recordcount();
//print "CNT:".$cnt; 
$bil=0;
?>
<br />
<table width="99%" align="center" cellpadding="4" cellspacing="0" border="1">
	<tr bgcolor="#CCCCCC" height="21px">
    	<td width="5%" align="center"><b>Bil</b></td>
    	<td width="50%" align="center"><b>Nama Kursus</b></td>
    	<td width="25%" align="center"><b>Kursus Anjuran</b></td>
    	<td width="20%" align="center"><b>Tarikh Kursus</b></td>
    </tr>
<?php while(!$rs_bilik->EOF){ $bil++;
	$anjuran = dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs_bilik->fields['category_code']));
	$subcat = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs_bilik->fields['sub_category_code']));
?>
	<tr>
    	<td align="right"><?php print $bil;?>.</td>
    	<td><?php print $rs_bilik->fields['namakursus'];?></td>
    	<td align="center"><?php print $anjuran;?><br /><i><?php print $subcat;?></i></td>
    	<td align="center"><?php print DisplayDate($rs_bilik->fields['startdate']).' - '.DisplayDate($rs_bilik->fields['enddate']);?></td>
    </tr>
<?php $rs_bilik->movenext(); }     
	if(empty($bil)){ print "<tr><td colspan=4>Tiada maklumat</td></tr>"; }
?>
</table>
</form>
