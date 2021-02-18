<?php
//include_once '../include/dateformat.php'; 
//$conn->debug=true;
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$jk=isset($_REQUEST["jk"])?$_REQUEST["jk"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";

if(!empty($pro) && $pro=='PILIH'){
	if(empty($id)){ $id = $kid; }
	$bilikid=isset($_REQUEST["bilikid"])?$_REQUEST["bilikid"]:"";
	$sql = "UPDATE _tbl_kursus_jadual SET bilik_kuliah=".tosql($bilikid)." WHERE id=".tosql($id);
	//print $sql; print $kid;
	$conn->execute($sql);
	
	/*print '<script>parent.location.reload();</script>';*/
	print '<script>refresh = parent.location; parent.location = refresh;</script>';
	exit;
	
} else if(!empty($pro) && $pro=='DPILIH'){
	//$conn->debug=true;
	$kidd=isset($_REQUEST["kidd"])?$_REQUEST["kidd"]:"";
	//if(empty($id)){ $id = $kid; }
	$bilikid=isset($_REQUEST["bilikid"])?$_REQUEST["bilikid"]:"";
	$sql = "UPDATE _tbl_kursus_jadual SET bilik_kuliah=NULL WHERE id=".tosql($kidd);
	//print $sql; print $kid;
	$conn->execute($sql);
	$conn->debug=false;
	
	/*print '<script>parent.location.reload();</script>';*/
	print '<script>refresh = parent.location; parent.location = refresh;</script>';
	exit;
}

//$conn->debug=true;
if($jk==1){
	$sSQL="SELECT A.coursename AS namakursus, B.startdate, B.enddate, B.bilik_kuliah
	FROM _tbl_kursus A, _tbl_kursus_jadual B WHERE B.status IN (0,9) AND A.id=B.courseid AND B.id = ".tosql($kid,"Text");
	if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
	if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
	$rs = &$conn->Execute($sSQL);
} else {
	$sSQL="SELECT B.acourse_name AS namakursus, B.startdate, B.enddate, B.bilik_kuliah
	FROM _tbl_kursus_jadual B WHERE B.id = ".tosql($kid,"Text");
	if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
	if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
	$rs = &$conn->Execute($sSQL);
}

$href_search = "modal_form.php?win=".base64_encode('asrama/penetapan_bilik_kuliah.php;'.$kid);

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
<?php //include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="4" valign="middle">
        <div style="float:left">
        	<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>MAKLUMAT BILIK KULIAH</strong></font>
        </div>
        <div style="float:right"><input type="button" value="Tutup" onclick="javascript:parent.emailwindow.hide();"  class="button_disp" />&nbsp;</div>
        </td>
    </tr>
	<tr>
		<td width="15%" align="right"><b>Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;<?php print $rs->fields['namakursus'];?></td>
        <td width="25%" rowspan="2">
        	<table width="100%" cellpadding="4" cellspacing="0" border="0">
            	<tr><td width="10%" bgcolor="#FF9900">&nbsp;</td><td>Kursus anjuran ILIM</td></tr>
            	<tr><td width="10%" bgcolor="#FF0099">&nbsp;</td><td>Kursus Luar</td></tr>
            </table>
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
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
            <input type="hidden" name="kid" value="<?=$kid;?>" />
		</td>
	</tr>-->
</table>
<?php
$days = get_datediff($rs->fields['startdate'],$rs->fields['enddate']);
//print "DAT:".$days;
$bmula = substr($rs->fields['startdate'],5,2);
$ymula = substr($rs->fields['startdate'],0,4);
$bakhir = substr($rs->fields['enddate'],5,2);
$yakhir = substr($rs->fields['enddate'],0,4);

//print $bmula."/".$bakhir;

$sSQL="SELECT * FROM _tbl_bilikkuliah  WHERE is_deleted=0 ";
if(!empty($search)){ $sSQL.=" AND f_bilik_nama LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY f_bilik_nama";
$rs_bilik = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!$rs_bilik->EOF) {
	$cnt = 1;
	$bil = 0;
	while(!$rs_bilik->EOF) {
		$nama_kursus='';
    	$bil++; $kosong=0;
		/*for($i=-1;$i<=$days;$i++){ 
			//$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i-1));
			//$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE bilik_kuliah=".tosql($rs_bilik->fields['f_bilikid'])." 
			//AND ".tosql($ddate)." BETWEEN startdate AND enddate";
			$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i-1));
			$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE bilik_kuliah=".tosql($rs_bilik->fields['f_bilikid'])." 
			AND ".tosql($ddate)." BETWEEN startdate AND enddate";
			print $sqlk;
			$rs_masa = $conn->execute($sqlk);
			if(!$rs_masa->EOF){ 
				$kidd = $rs_masa->fields['id'];
				if(!empty($rs_masa->fields['courseid'])){
					$nama_kursus = "(Nama Kursus : ".dlookup("_tbl_kursus","coursename","id=".tosql($rs_masa->fields['courseid'])).")";
				} else {
					$nama_kursus = "(Nama Kursus : ".$rs_masa->fields['acourse_name'].")";
				}
				//$kosong=1; 
			}
		}*/
?>
<br />
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" align="left" bgcolor="#999999" height="25" valign="middle">
        <div style="float:left;vertical-align:middle">&nbsp;&nbsp;<b><?php print strtoupper(stripslashes($rs_bilik->fields['f_bilik_nama']));?></b>
        &nbsp;&nbsp;<i><u><?=$nama_kursus;?></u></i>
        </div>
        <div style="float:right">
		<?php if(empty($kosong)){ ?><input type="button" value="Pilih Bilik Kuliah" style="cursor:pointer" 
        onclick="do_page1('<?=$href_search;?>&pro=PILIH&bilikid=<?=$rs_bilik->fields['f_bilikid'];?>&kid=<?=$id;?>')" 
        title="Sila klik untuk membuat pemilihan bilik kuliah" />
		<?php } else { ?>
            <img src="../img/delete_last.gif" width="20" height="20" style="cursor:pointer" 
            onclick="do_page1('<?=$href_search;?>&pro=DPILIH&bilikid=<?=$rs_bilik->fields['f_bilikid'];?>&kidd=<?=$kidd;?>')" 
            title="Sila klik untuk membuat pembatalan tempahan bilik kuliah" />
        <?php } ?>&nbsp;&nbsp;
        </div>
        </td>
    </tr>
    <tr><td width="100%">
    	<table width="100%" cellpadding="2" cellspacing="0" border="1">
        	<tr>
            <?php $wcols = number_format(100/($days+2),0);
				for($i=-1;$i<=$days;$i++){ 
				if($i==-1){ $mula = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i)); }
				if($i==$days){ $akhir = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i)); }
				?>	
            	<td align="center" width="<?=$wcols;?>"><?=get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i);?></td>
            <?php } ?>
            </tr>
        	<?php
			$sql = "SELECT * FROM _tbl_kursus_jadual WHERE status IN (0,9) AND bilik_kuliah=".tosql($rs_bilik->fields['f_bilikid']);
			//$sql .= " AND startdate>=".tosql($mula)." AND enddate<=".tosql($akhir);
			//$sql .= " OR ".tosql($mula)." BETWEEN startdate AND enddate";
			//$sql .= " AND startdate BETWEEN ".tosql($mula)." AND ".tosql($akhir);
			//$sql .= " OR enddate BETWEEN ".tosql($mula)." AND ".tosql($akhir);
			if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
			if(!empty($kampus_id)){ $sSQL.=" AND kampus_id=".$kampus_id; }
			$sql .= " AND month(startdate)='$bmula' AND year(startdate)='$ymula' ";
			$sql .= " OR month(enddate)='$bakhir' AND year(enddate)='$yakhir' ";
			$rsb = &$conn->execute($sql);
			//print "<br>".$sql;
			while(!$rsb->EOF){
				$kur = ''; 
				$id = $rsb->fields['id'];
				$bilik_kuliah = $rsb->fields['bilik_kuliah'];
				if($rsb->fields['category_code']==1){
					$sqlk = "SELECT courseid, coursename FROM _tbl_kursus WHERE id=".tosql($rsb->fields['courseid']);
					$rskur = &$conn->execute($sqlk);
					$kur = $rskur->fields['courseid']."-".$rskur->fields['coursename']; 
					//dlookup("_tbl_kursus","courseid","id=".tosql($rsb->fields['courseid'])); 
					$bgks="#FF9900";
					//if(empty($kur)){ $kur = $rsb->fields['acourse_name']; }
					//$bgks="#FF9900";
				} else {
					//$cid = 'KL';
					if(!empty($rsb->fields['acourse_name'])){ 
						$kur = $rsb->fields['acourse_name'];
						if($rsb->fields['category_code']=='1'){ $bgks="#FF9900"; }
						else if($rsb->fields['category_code']=='2'){ $bgks="#FF0099"; }
					}
				}
				if($bilik_kuliah==$rs_bilik->fields['f_bilikid']){
			?>
            <tr>
            <?php for($i=-1;$i<=$days;$i++){ 
				$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i));
				$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE status IN (0,9) AND 
				bilik_kuliah=".tosql($rs_bilik->fields['f_bilikid'])." 
				AND id=".tosql($id)." AND ".tosql($ddate)." BETWEEN startdate AND enddate";
				if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
				if(!empty($kampus_id)){ $sSQL.=" AND kampus_id=".$kampus_id; }
				$rs_masa = $conn->execute($sqlk);
				//print "<br>".$sqlk;
				$bils=0;
				$masa='';
				if(!$rs_masa->EOF){
					//if($bils==0){ $kur .= $cid; } else { $kur .= " , ".$cid; }
					//$kur=$cid."/".$rs_masa->fields['category_code'];
					$bils++;
					//$rs_masa->movenext();
					if($ddate==$rs_masa->fields['startdate']){ $mmula = substr($rs_masa->fields['timestart'],0,5); } else { $mmula=''; }
					if($ddate==$rs_masa->fields['enddate']){ $makhir = substr($rs_masa->fields['timeend'],0,5); } else { $makhir=''; }
					if(!empty($mmula) && !empty($makhir)){ $masa = "<br>(".$mmula.' - '.$makhir.")"; }
					else if(!empty($mmula) && empty($makhir)){ $masa = "<br>(".$mmula.")"; }
					else if(empty($mmula) && !empty($makhir)){ $masa = "<br>(".$makhir.")"; }
					else { $masa=''; }
					if(!empty($kur)){ $bgk=$bgks; } else { $bgk='#FFFFFF'; }
					print '<td height=21px align=center bgcolor='.$bgk.'>'.$kur.$masa.'&nbsp;</td>';
				} else {
					print '<td height=21px align=center>&nbsp;</td>';
				}
			}?>
			</tr>
			<?php	
				}
				$rsb->movenext();
			}
			?>
        </table>
    </td></tr>
</table>
<?php
		$rs_bilik->movenext();
	} 
} ?>                   
</form>
