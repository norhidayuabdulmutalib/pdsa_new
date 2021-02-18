<?
//include_once '../include/dateformat.php'; 
//$conn->debug=true;
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$blok_search=isset($_REQUEST["blok_search"])?$_REQUEST["blok_search"]:"";

if(!empty($pro) && $pro=='PILIH'){
	if(empty($id)){ $id = $kid; }
	$bilikid=isset($_REQUEST["bilikid"])?$_REQUEST["bilikid"]:"";
	$jk=isset($_REQUEST["jk"])?$_REQUEST["jk"]:"";
	//$sql = "UPDATE _tbl_kursus_jadual SET bilik_kuliah=".tosql($bilikid)." WHERE id=".tosql($id);
	//$conn->execute($sql);
	$rsd = "SELECT * FROM _tbl_kursus_jadual WHERE id=".tosql($kid);
	$rsdt = $conn->execute($rsd);
	$stdt = $rsdt->fields['startdate'];
	$endt = $rsdt->fields['enddate'];
	//print $jk;
	for($ii=0;$ii<$jk;$ii++){
		$tid = "T-".date("Ymd")."-".uniqid();
		$sqli = "INSERT INTO _sis_a_tblasrama_tempah(tempahan_id, event_id, bilik_id, asrama_type, startdt, enddt)
		VALUES(".tosql($tid).", ".tosql($kid).", ".tosql($bilikid,"Number").", 'P',".tosql($stdt).", ".tosql($endt).")";
		$conn->execute($sqli);
		//print "<br>".$sqli;
	}
	
	$sql = "UPDATE _tbl_kursus_jadual SET bilik_kuliah=".tosql($bilikid)." WHERE id=".tosql($id);
	//$conn->execute($sql);
	
	/*print '<script>parent.location.reload();</script>';*/
	//exit;
}

$sSQL="SELECT * FROM _tbl_kursus_jadual WHERE id = ".tosql($kid,"Text");
$rs = &$conn->Execute($sSQL);

$href_search = "modal_form.php?win=".base64_encode('kursus/tempahan_bilik_asrama.php;'.$kid);
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
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
        <td height="30" colspan="3" valign="middle">
        	<div style="float:left"><font size="2" face="Arial, Helvetica, sans-serif">
	        <strong>MAKLUMAT BILIK ASRAMA</strong></font></div>
        	<div style="float:right"><input type="button" value="Tutup" onclick="javascript:parent.location.reload();" style="cursor:pointer" /></div>
      	</td>
    </tr>
	<tr>
		<td width="20%" align="right"><b>Maklumat Blok : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
	  	<select name="blok_search" onchange="do_page('<?=$href_search;?>&kid=<?=$kid;?>')">
      		<option value="">-- semua bilik --</option>
           <?  	//$conn->debug=true;
		   		$sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_kb_id=2 AND f_bb_status = 0 AND is_deleted=0 ORDER BY f_bb_desc";
				$rs_l = &$conn->Execute($sql_l); 
				while(!$rs_l->EOF){
					print '<option value="'.$rs_l->fields['f_bb_id'].'"'; 
					if($rs_l->fields['f_bb_id']==$blok_search){ print 'selected'; }
					print '>'. $rs_l->fields['f_bb_desc'] .'</option>';
					$rs_l->movenext();
				}
			?>
         </select></td>
         <td rowspan="3" width="20%">
         	<table width="100%" cellpadding="2" cellpadding="0" border="0">
            	<tr><td width="10%" bgcolor="#FF9999">&nbsp;</td><td width="90%">Bilik telah ditempah</td></tr>
            	<tr><td width="10%" bgcolor="#FF9900">&nbsp;</td><td width="90%">Bilik berpenghuni</td></tr>
            </table>
         </td>
	</tr>
	<tr>
		<td align="right"><b>Kursus : </b></td> 
		<td align="left">&nbsp;&nbsp;<?php print $rs->fields['acourse_name'];?></td>
        <!--<input type="button" value="Kosongkan Bilik" style="cursor:pointer" 
        onclick="do_page1('<?=$href_search;?>&pro=PILIH&bilikid=&kid=<?=$id;?>')" title="Sila klik untuk mengosongkan maklumat bilik kuliah" />-->
	</tr>
	<tr>
		<td align="right"><b>Tarikh Kursus : </b></td> 
		<td align="left">&nbsp;&nbsp;Mula : <?php print DisplayDate($rs->fields['startdate']);?> 
        &nbsp;&nbsp;&nbsp;Tamat : <?php print DisplayDate($rs->fields['enddate']);?></td>
	</tr>
</table>
<?php
$days = get_datediff($rs->fields['startdate'],$rs->fields['enddate']);
//print "DAT:".$days;

$sSQL="SELECT * FROM _sis_a_tblbilik WHERE is_deleted=0 AND status_bilik=0 AND keadaan_bilik=1 ";
if(!empty($blok_search)){ $sSQL.=" AND blok_id=".tosql($blok_search); } 
if(!empty($search)){ $sSQL.=" AND no_bilik LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY no_bilik";
$rs_bilik = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!$rs_bilik->EOF) {
	$cnt = 1;
	$bil = 0;
	while(!$rs_bilik->EOF) {
    	$bil++; $kosong=0; $jk=0;
		$bilikid=$rs_bilik->fields['bilik_id'];
		$jum_katil=$rs_bilik->fields['jenis_bilik'];
		for($i=-1;$i<=$days;$i++){ 
			$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i-1));
			$sqlk = "SELECT * FROM _sis_a_tblasrama A, _tbl_kursus_jadual B 
			WHERE A.event_id=B.id AND A.bilik_id=".tosql($bilikid)." AND A.is_daftar=1 AND ".tosql($ddate)." BETWEEN B.startdate AND B.enddate";
			$rs_masa = $conn->execute($sqlk);
			if(!$rs_masa->EOF){ $kosong=1; $kur = dlookup("_tbl_kursus","coursename","id=".tosql($rs_masa->fields['courseid'])); }
			if(empty($kosong)){
				$sqltem = "SELECT * FROM _sis_a_tblasrama_tempah A,  _tbl_kursus_jadual B 
				WHERE A.event_id=B.id AND A.bilik_id=".tosql($bilikid)." AND ".tosql($ddate)." BETWEEN B.startdate AND B.enddate";
				$rs_masa = $conn->execute($sqltem);
				$jum_k=$rs_masa->recordcount();
				if(!$rs_masa->EOF){ $kosong=1; $kur = $rs_masa->fields['acourse_name'];}
				if($jum_k<$jum_katil){ $kosong=0; $jk=$jum_katil-$jum_k; }
			}
			
		}
?>
<br />
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" align="left" bgcolor="#999999" height="25" valign="middle">
        <div style="float:left;vertical-align:middle">&nbsp;&nbsp;<b><?php print strtoupper(stripslashes($rs_bilik->fields['no_bilik']));?></b> -
        <b><i><?=$kur;?></i></b>
		(<?php print "Bilik ".$jum_katil." katil";?>&nbsp;&nbsp;-
		<?php if(empty($jum_k)){ print "<font color=#FF0000>Bilik Kosong"; }
			else if($jum_k=='1'){ print "Terdapat 1 kekosongan"; }
			else if($jum_k=='2'){ print "Bilik penuh"; }
		?>)
        </div>
        <div style="float:right"><?php if(empty($kosong)){ ?><input type="button" value="Tempahan Bilik" style="cursor:pointer" 
        onclick="do_page1('<?=$href_search;?>&pro=PILIH&bilikid=<?=$bilikid;?>&kid=<?=$kid;?>&jk=<?=$jk;?>')" 
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
				//$sqlk = "SELECT * FROM _sis_a_tblasrama WHERE bilik_id=".tosql($rs_bilik->fields['bilik_id'])." AND is_daftar=1";
				$sqlk = "SELECT A.*, B.courseid FROM _sis_a_tblasrama A, _tbl_kursus_jadual B 
				WHERE A.event_id=B.id AND A.bilik_id=".tosql($bilikid)." AND A.is_daftar=1 AND ".tosql($ddate)." BETWEEN B.startdate AND B.enddate";
				$rs_masa = $conn->execute($sqlk);
				$kur = ''; $bils=0; $kursus=0;
				if(!$rs_masa->EOF){
					$kursus=1;
					$kur = dlookup("_tbl_kursus","courseid","id=".tosql($rs_masa->fields['courseid']));
				}

				if(empty($kursus)){
					$sqltem = "SELECT B.acourse_name FROM _sis_a_tblasrama_tempah A,  _tbl_kursus_jadual B 
					WHERE A.event_id=B.id AND A.bilik_id=".tosql($bilikid)." AND ".tosql($ddate)." BETWEEN B.startdate AND B.enddate";
					$rs_masa = $conn->execute($sqltem);
					if(!$rs_masa->EOF){ 
						$kursus=2;
						$kur = "KL";
					}
				}
				if($kursus==1){
					if(!empty($kur)){ $bgk="#FF9900"; } else { $bgk='#FFFFFF'; }
				} else if($kursus==2){
					if(!empty($kur)){ $bgk="#FF9999"; } else { $bgk='#FFFFFF'; }
				} else {
					$bgk='#FFFFFF';
				}
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
