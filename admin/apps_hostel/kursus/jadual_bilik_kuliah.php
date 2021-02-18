<?
//$conn->debug=true;
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$kursus=isset($_REQUEST["kursus"])?$_REQUEST["kursus"]:"";

if(!empty($pro) && $pro=='PILIH'){
	if(empty($id)){ $id = $kid; }
	$bilikid=isset($_REQUEST["bilikid"])?$_REQUEST["bilikid"]:"";
	$sql = "UPDATE _tbl_kursus_jadual SET bilik_kuliah=".tosql($bilikid)." WHERE id=".tosql($id);
	//print $sql; print $kid;
	$conn->execute($sql);
	
	print '<script>//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;
	</script>';
	exit;
}

if(!empty($kursus) && $kursus == 'LUAR'){
	$sSQL=" SELECT startdate, enddate, bilik_kuliah, acourse_name AS coursename FROM _tbl_kursus_jadual WHERE id = ".tosql($kid,"Text");
} else {
	$sSQL="SELECT A.*, B.startdate, B.enddate, B.bilik_kuliah
	FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE A.id=B.courseid AND B.id = ".tosql($kid,"Text");
}
$rs = &$conn->Execute($sSQL);

$href_search = "modal_form.php?win=".base64_encode('kursus/jadual_bilik_kuliah.php;'.$kid);
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page1(URL){
		if(confirm("Adakah anda pasti untuk membuat pilihan ini?")){
			document.ilim.action = URL;
			document.ilim.target = '_self';
			document.ilim.submit();
		}
	}
</script>
<? //include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>MAKLUMAT BILIK KULIAH</strong></font>
        </td>
    </tr>
	<tr>
		<td width="20%" align="right"><b>Kursus : </b></td> 
		<td width="70%" align="left">&nbsp;&nbsp;<?php print $rs->fields['coursename'];?></td>
        <td width="10%" rowspan="2"><input type="button" value="Kosongkan Bilik" style="cursor:pointer" 
        onclick="do_page1('<?=$href_search;?>&pro=PILIH&bilikid=&kid=<?=$id;?>')" title="Sila klik untuk mengosongkan maklumat bilik kuliah" />
        <input type="button" value="Tutup" onclick="javascript:parent.emailwindow.hide();" style="cursor:pointer" />
        </td>
	</tr>
	<tr>
		<td align="right"><b>Tarikh Kursus : </b></td> 
		<td align="left">&nbsp;&nbsp;Mula : <?php print DisplayDate($rs->fields['startdate']);?> 
        &nbsp;&nbsp;&nbsp;Tamat : <?php print DisplayDate($rs->fields['enddate']);?></td>
	</tr>
	<!--<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="70%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
            <input type="hidden" name="kid" value="<?=$kid;?>" />
		</td>
	</tr>-->
</table>
<?php
$days = get_datediff($rs->fields['startdate'],$rs->fields['enddate']);
//print "DAT:".$days;

$sSQL="SELECT * FROM _tbl_bilikkuliah  WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND f_bilik_nama LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY f_bilik_nama";
$rs_bilik = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!$rs_bilik->EOF) {
	$cnt = 1;
	$bil = 0;
	while(!$rs_bilik->EOF) {
    	$bil++; $kosong=0;
		for($i=-1;$i<=$days;$i++){ 
			$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i));
			$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE bilik_kuliah=".tosql($rs_bilik->fields['f_bilikid'])." AND ".tosql($ddate)." BETWEEN startdate AND enddate";
			$rs_masa = $conn->execute($sqlk);
			if(!$rs_masa->EOF){ $kosong=1; }
		}
?>
<br />
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" align="left" bgcolor="#999999" height="25" valign="middle">
        <div style="float:left;vertical-align:middle">&nbsp;&nbsp;<b><?php print strtoupper(stripslashes($rs_bilik->fields['f_bilik_nama']));?></b></div>
        <div style="float:right"><?php if(empty($kosong)){ ?><input type="button" value="Pilih Bilik Kuliah" style="cursor:pointer" 
        onclick="do_page1('<?=$href_search;?>&pro=PILIH&bilikid=<?=$rs_bilik->fields['f_bilikid'];?>&kid=<?=$id;?>')" 
        title="Sila klik untuk membuat pemilihan bilik kuliah" /><?php } ?>&nbsp;&nbsp;</div>
        </td>
    </tr>
    <tr><td width="100%">
    	<table width="100%" cellpadding="2" cellspacing="0" border="1">
        	<tr>
            <?php for($i=-1;$i<=$days;$i++){ ?>	
            	<td align="center"><?=get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i);?></td>
            <?php } ?>
            </tr>
        	<tr>
            <?php for($i=-1;$i<=$days;$i++){ 
				$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i));
				$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE bilik_kuliah=".tosql($rs_bilik->fields['f_bilikid'])." AND ".tosql($ddate)." BETWEEN startdate AND enddate";
				$rs_masa = $conn->execute($sqlk);
				$kur = ''; $bils=0;
				while(!$rs_masa->EOF){
					if($bils==0){ $kur .= $rs_masa->fields ['courseid1']; }
					else { $kur .= " , ".$rs_masa->fields ['courseid1']; }
					$bils++;
					$rs_masa->movenext();
				}
				if(!empty($kur)){ $bgk="#FF9900"; } else { $bgk='#FFFFFF'; }
				print '<td height=21px align=center bgcolor='.$bgk.'>'.$kur.'</td>';			
			}
			?>	
            </tr>
        </table>
    </td></tr>
</table>
<?php
		$rs_bilik->movenext();
	} 
} ?>                   
</form>
