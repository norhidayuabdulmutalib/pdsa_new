<?
//include_once '../include/dateformat.php'; 
//$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
$kid=$id;
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$blok_search=isset($_REQUEST["blok_search"])?$_REQUEST["blok_search"]:"";

//print "Pro:".$pro;
if(!empty($pro) && $pro=='PILIH'){
	//$conn->debug=true;
	print "JK:".$jk;
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
		$sqli = "INSERT INTO _sis_a_tblasrama_tempah(tempahan_id, event_id, bilik_id, asrama_type, startdt, enddt, j_tempah)
		VALUES(".tosql($tid).", ".tosql($kid).", ".tosql($bilikid,"Number").", 'P',".tosql($stdt).", ".tosql($endt).", 'KD')";
		$conn->execute($sqli);
		//print "<br>".$sqli;
	}
	
	//$sql = "UPDATE _tbl_kursus_jadual SET bilik_kuliah=".tosql($bilikid)." WHERE id=".tosql($id);
	//$conn->execute($sql);
	
	/*print '<script>//parent.location.reload();	
	refresh = parent.location; 
	parent.location = refresh;</script>';*/
	//exit;
}
if(!empty($pro) && $pro=='DTEMPAH'){
	$bilikid=isset($_REQUEST["bilikid"])?$_REQUEST["bilikid"]:"";
	$sql = "DELETE FROM _sis_a_tblasrama_tempah WHERE bilik_id=".tosql($bilikid,"Number");
	$conn->execute($sql);
}
$conn->debug=false;


$sSQL="SELECT A.*, B.coursename FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND A.id = ".tosql($kid,"Text");
$rs = &$conn->Execute($sSQL);
$courseids = $rs->fields['courseid'];
$href_search = "modal_form.php?win=".base64_encode('kursus/tempahan_bilik_asrama1.php;'.$id);
$href_selected = 'kursus/kursus_tempah_upd.php';
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
	function do_selected(URL){
		//alert(URL);
		//document.ilim.action = URL;
		//document.ilim.target = '_blank';
		//document.ilim.submit();
		hold();
		callToServer(URL);
	}
	
	function hold() {   
		document.body.style.cursor='wait';
		document.body.disabled =true
		setTimeout("release();",10000);
	}
	
	function release() {
		document.body.disabled =false;
		document.body.style.cursor='default';
		//document.f1.text1.focus();
	}
</script>
<? //include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="2" cellspacing="0" border="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="3" valign="middle">
        	<div style="float:left"><font size="2" face="Arial, Helvetica, sans-serif">
	        <strong>MAKLUMAT BILIK ASRAMA</strong></font></div>
        	<div style="float:right">
            	<input type="button" value="Proses" onclick="do_page('<?=$href_search;?>&kid=<?=$kid;?>')" style="cursor:pointer" />
            	<input type="button" value="Tutup" onclick="javascript:refresh=parent.location;parent.location=refresh;" style="cursor:pointer" />
            </div>
      	</td>
    </tr>
	<tr>
		<td width="20%" align="right"><b>Maklumat Blok : </b></td> 
		<td width="60%" align="left">
	  	<select name="blok_search" onchange="do_page('<?=$href_search;?>&kid=<?=$kid;?>')">
      		<option value="">-- semua bilik --</option>
           <?  	//$conn->debug=true;
		   		$sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_kb_id=1 AND f_bb_status = 0 AND is_deleted=0 ORDER BY f_bb_desc";
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
         	<table width="100%" cellpadding="2" cellspacing="0" border="0">
            	<tr><td width="10%" bgcolor="#FF9999">&nbsp;</td><td width="90%">Bilik telah ditempah</td></tr>
            	<tr><td width="10%" bgcolor="#FF9900">&nbsp;</td><td width="90%">Bilik berpenghuni</td></tr>
                <tr><td><img src="../img/delete_last.gif" width="20" height="20" /></td><td>Hapus Tempahan</td></tr>
            </table>
         </td>
	</tr>
	<tr>
		<td align="right"><b>Kursus : </b></td> 
		<td align="left"><?php print $rs->fields['coursename'];?></td>
	</tr>
	<tr>
		<td align="right"><b>Tarikh Kursus : </b></td> 
		<td align="left">Mula : <?php print DisplayDate($rs->fields['startdate']);?> 
        &nbsp;&nbsp;&nbsp;Tamat : <?php print DisplayDate($rs->fields['enddate']);?></td>
	</tr>
    <?php
	$sql_det = "SELECT count(*) AS cnt, B.f_peserta_jantina 
	FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B WHERE A.peserta_icno=B.f_peserta_noic AND InternalStudentAccepted=1 AND A.EventId=".tosql($id);
	$sql_det .= " GROUP BY B.f_peserta_jantina ORDER BY B.f_peserta_jantina";
	$rs_det = $conn->execute($sql_det); //print $sql_det;
	//$count = $rs_det->recordcount();
	if(!$rs_det->EOF){ $p=0; $l=0;
		while(!$rs_det->EOF){
			if($rs_det->fields['f_peserta_jantina']=='L'){ $l=$rs_det->fields['cnt']; }
			else if($rs_det->fields['f_peserta_jantina']=='P'){ $p=$rs_det->fields['cnt']; }
			$rs_det->movenext();
		}
	}
	?>
	<tr>
		<td align="right"><b>Bilangan Peserta : </b></td> 
		<td align="left"><?php print '<b>Peserta Lelaki :</b> '.$l.' Orang peserta &nbsp;&nbsp;&nbsp;&nbsp;<b>Peserta Wanita :</b> '.$p.' Orang peserta';?></td>
	</tr>
</table>
<?php
$days = get_datediff($rs->fields['startdate'],$rs->fields['enddate']);
//print "DAT:".$days;

$sSQL="SELECT * FROM _sis_a_tblbilik WHERE is_deleted=0 AND keadaan_bilik=1 "; //AND status_bilik=0 
if(!empty($blok_search)){ $sSQL.=" AND blok_id=".tosql($blok_search); } 
if(!empty($search)){ $sSQL.=" AND no_bilik LIKE '%".$search."%' "; } 
$sSQL .= "ORDER BY no_bilik";
$rs_bilik = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

if(!$rs_bilik->EOF) {
	$cnt = 1;
	$bil = 0;
	while(!$rs_bilik->EOF) {
    	$bil++; $kosong=0; $jk=0; $jumlah_penghuni=0; $tempahan=0;
		$bilikid=$rs_bilik->fields['bilik_id'];
		$jum_katil=$rs_bilik->fields['jenis_bilik'];
		//if($rs_bilik->fields['no_bilik']=='C201' || $rs_bilik->fields['no_bilik']=='D203'){ $conn->debug=true; }
		//for($i=-1;$i<=$days;$i++){ 
			$ddate = DBDate(get_jadual_kursus($rs->fields['startdate'],$rs->fields['enddate'],$i+1));
			$sqlk = "SELECT *, B.courseid FROM _sis_a_tblasrama A, _tbl_kursus_jadual B 
			WHERE A.event_id=B.id AND A.bilik_id=".tosql($bilikid)." AND A.is_daftar=1"; // AND ".tosql($rs->fields['startdate'])." BETWEEN B.startdate AND B.enddate
			//AND ".tosql($rs->fields['enddate'])." BETWEEN B.startdate AND B.enddate"; //$ddate
			$rs_masa = $conn->execute($sqlk); 
			//if(!$rs_masa->EOF){ $jumlah_penghuni++; $kur = dlookup("_tbl_kursus","coursename","id=".tosql($rs_masa->fields['courseid'])); }
			$kur = dlookup("_tbl_kursus","coursename","id=".tosql($rs_masa->fields['courseid']));
			while(!$rs_masa->EOF){
				$jumlah_penghuni++; 
				$rs_masa->movenext();
			}
			if($jum_katil==$jumlah_penghuni){ $kosong=1; }
			//if(empty($kosong)){
				$sqltem = "SELECT A.*, B.courseid  FROM _sis_a_tblasrama_tempah A,  _tbl_kursus_jadual B 
				WHERE A.event_id=B.id AND A.bilik_id=".tosql($bilikid); //." AND A.startdt BETWEEN ".tosql($rs->fields['startdate'])." AND ".tosql($rs->fields['enddate']);  //$ddate
				$rs_masa1 = $conn->execute($sqltem);
				$cid = $rs_masa1->fields['courseid'];
				//$jum_k=$rs_masa->recordcount();
				if(empty($kur)){ $kur = $rs_masa1->fields['acourse_name']; }
				//if(!$rs_masa->EOF){ $kosong=1; }
				//if($jum_k<$jum_katil){ $kosong=0; $jk=$jum_katil-$jum_k; }
				while(!$rs_masa1->EOF){
					$jumlah_penghuni++; 
					if($cid<>$courseids){ $tempahan=0; } else { $tempahan=1; } 
					$rs_masa1->movenext();
				}
				if($jum_katil==$jumlah_penghuni){ $kosong=1; }
			//}
			
		if($rs_bilik->fields['no_bilik']=='C201' || $rs_bilik->fields['no_bilik']=='D203'){ $conn->debug=false; print $jum_k; }
		//}
		$jk = $jum_katil-$jumlah_penghuni;
?>
<br />
<table width="99%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" align="left" bgcolor="#999999" height="25" valign="middle" style="padding-top:5px">
        <div style="float:left;vertical-align:middle">&nbsp;&nbsp;<b><?php print strtoupper(stripslashes($rs_bilik->fields['no_bilik']));?></b> -
        <b><i><?=$kur;?></i></b>
		<b>(<?php print "Bilik ".$jum_katil." katil";?>&nbsp;&nbsp;-
		<?php if(empty($jumlah_penghuni)){ print "<font color=#FF0000>Bilik Kosong</font>"; }
			else if($jumlah_penghuni=='1'){ print "<font color=#0000FF>Terdapat 1 kekosongan</font>"; }
			else if($jumlah_penghuni=='2'){ print "Bilik penuh"; }
		?>)</b><?php //print $jum_katil."/".$jumlah_penghuni."/".$jk;?>
        <?php //print $cid."-".$courseids;?>
        </div>
        <div style="float:right">
        	<?php if($jumlah_penghuni==0){ ?>
            	<input type="checkbox" onclick="do_selected('<?=$href_selected;?>?pro=PILIH&bilikid=<?=$bilikid;?>&kid=<?=$kid;?>')" /> Katil A
                &nbsp;&nbsp;
            	<input type="checkbox" onclick="do_selected('<?=$href_selected;?>?pro=PILIH&bilikid=<?=$bilikid;?>&kid=<?=$kid;?>')" /> Katil B
        	<?php } else if($jumlah_penghuni==1){ ?>
            	<input type="checkbox" onclick="do_selected('<?=$href_selected;?>?pro=PILIH&bilikid=<?=$bilikid;?>&kid=<?=$kid;?>')" /> Katil B
            <?php } ?>
			<!--<?php if(empty($kosong)){ ?><input type="button" value="Tempahan Bilik" style="cursor:pointer" 
        		onclick="do_page1('<?=$href_search;?>&pro=PILIH&bilikid=<?=$bilikid;?>&kid=<?=$kid;?>&jk=<?=$jk;?>')" 
        		title="Sila klik untuk membuat pemilihan bilik kuliah" />
			<?php } ?>-->
            <?php if($tempahan==1){ ?>
            	<img src="../img/delete_last.gif" width="20" height="20" style="cursor:pointer" 
        		onclick="do_page1('<?=$href_search;?>&pro=DTEMPAH&bilikid=<?=$bilikid;?>&kid=<?=$kid;?>&jk=<?=$jk;?>')" 
        		title="Sila klik untuk membuat pembatalan tempahan bilik asrama" />
            <?php } ?>
            &nbsp;&nbsp;
         </div>
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
					$sqltem = "SELECT B.acourse_name, A.j_tempah, B.courseid1 FROM _sis_a_tblasrama_tempah A,  _tbl_kursus_jadual B 
					WHERE A.event_id=B.id AND A.bilik_id=".tosql($bilikid)." AND ".tosql($ddate)." BETWEEN B.startdate AND B.enddate";
					$rs_masa = $conn->execute($sqltem);
					if(!$rs_masa->EOF){ 
						$kursus=2;
						$j_tempah = $rs_masa->fields['j_tempah'];
						if($j_tempah=='KL'){ $kur='KL'; } else { $kur = $rs_masa->fields['courseid1']; }
						//$kur = "KL";
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
