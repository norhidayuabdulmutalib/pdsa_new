<?
//$conn->debug=true;
$blok = $_GET['blok'];        
$sql_l = "SELECT A.f_ab_id, A.f_ab_desc FROM _ref_aras_bangunan A, _sis_a_tblbilik B 
WHERE A.f_ab_id=B.tingkat_id AND A.is_deleted=0 GROUP BY A.f_ab_id"; // =".tosql($id);
$rs_l = &$conn->Execute($sql_l); 
//print $rs->fields['daftar_nama'];
?>
<body bgcolor="#3366CC" text="#FFFFFF" link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF" leftmargin="0" topmargin="0">
<script type="text/javascript" src="../script/wz_tooltip.js"></script>
<script type="text/javascript" src="../script/tip_balloon.js"></script>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="1" cellspacing="0" border="0">
	<tr>
    	<td width="33%">
	    <div style="border:thin;border:#0000FF;border-style:solid;width:50px;float:left;text-align:center;background-color:#009900">
        <font color="#FFFFFF">A001</font></div> &nbsp;Bilik Kosong<br />
    	</td>
    	<td width="33%">
	    <div style="border:thin;border:#0000FF;border-style:solid;width:50px;float:left;text-align:center;background-color:#FFFFFF">
        <font color="#000000">A001</font></div> &nbsp;Bilik diselenggara - (Rosak)<br />
    	</td>
    </tr>
	<tr>
    	<td width="33%">
	    <div style="border:thin;border:#0000FF;border-style:solid;width:50px;float:left;text-align:center;background-color:#FF0000">
        <font color="#FFFFFF">A001</font></div> &nbsp;Bilik berpenghuni - Penuh<br />
    	</td>
    	<td width="33%">
	    <div style="border:thin;border:#0000FF;border-style:solid;width:50px;float:left;text-align:center;background-color:#000066">
        <font color="#FFFFFF">A001</font></div> &nbsp;Bilik berpenghuni - (masih ada kekosongan)<br />
    	</td>
    	<td width="33%">
	    <div style="border:thin;border:#0000FF;border-style:solid;width:50px;float:left;text-align:center;background-color:#9933CC">
        <font color="#FFFFFF">A001</font></div> &nbsp;Bilik telah ditempah<br />
    	</td>
    </tr>
	<tr>
    	<td height="30" bgcolor="#999999" width="100%" colspan="3">&nbsp;<b>MAKLUMAT BILIK ASRAMA - 
		<?php print strtoupper(dlookup("_ref_blok_bangunan","f_bb_desc","f_bb_id=".tosql($blok)));?></b>
        <div style="float:right"><input type="button" value="Tutup" onClick="javascript:parent.emailwindow.hide();" style="cursor:pointer" 
        title="Tutup paparan ini." /></div>
        </td>
    </tr>
</table>
<table width="100%" align="center" cellpadding="3" cellspacing="0" border="0">
<?php
while(!$rs_l->EOF){
	$tingkat = $rs_l->fields['f_ab_id'];
	$tingkat_desc = $rs_l->fields['f_ab_desc'];
	$sqla = "SELECT * FROM _sis_a_tblbilik WHERE is_deleted=0 AND blok_id=".tosql($blok)." AND tingkat_id=".tosql($tingkat)." ORDER BY no_bilik";
	$rsb = $conn->execute($sqla);
	$cnt = $rsb->recordcount();
?>
	<tr>
    	<td height="30" bgcolor="#ffffff" width="100%" valign="bottom">&nbsp;<b><?=$tingkat_desc;?></b> &nbsp;<i>( <?=$cnt;?> Bilik )</i></td>
    </tr>
	<tr>
    	<td height="30" bgcolor="#ffffff" width="100%">
        	<table width="100%" cellpadding="2" cellspacing="1" border="0">
            	<tr><td>
                <?php while(!$rsb->EOF){ 
				//$jumlah_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id=".$rsb->fields['bilik_id']." AND is_daftar = 1");
				$sql_pe = "SELECT * FROM _sis_a_tblasrama WHERE bilik_id=".$rsb->fields['bilik_id']." AND is_daftar = 1";
				$rs_bilik = $conn->execute($sql_pe);
				$jumlah_penghuni=0;
				$nama_pegawai = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>';
				while(!$rs_bilik->EOF){
					$kursus_type = $rs_bilik->fields['kursus_type'];
					$jumlah_penghuni++;
					if($rs_bilik->fields['asrama_type']=='P'){
						$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi
						FROM _tbl_peserta A, _ref_tempatbertugas E
						WHERE A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND A.f_peserta_noic=".tosql($rs_bilik->fields['peserta_id']);
					} else {
						$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi
						FROM _tbl_instructor A
						WHERE A.is_deleted=0 AND A.insid=".tosql($rs_bilik->fields['peserta_id']);
					}
					//print $sSQL;
					$rsp = $conn->execute($sSQL);
					
					if($kursus_type=='I'){
						$nama_kursus = dlookup("_tbl_kursus_jadual A, _tbl_kursus B","coursename","A.courseid=B.id AND A.id=".tosql($rs_bilik->fields['event_id']));
						$nama_pegawai .= $rsp->fields['daftar_nama']."<br>-<i>[".$rsp->fields['agensi']."]";
						$nama_pegawai .= "<br>".$nama_kursus;
						$nama_pegawai .= "</i><br><br>";
					} else if($kursus_type=='L'){
						$nama_kursus = dlookup("_tbl_kursus_jadual A","acourse_name","A.id=".tosql($rs_bilik->fields['event_id']));
						$nama_pegawai .= $rs_bilik->fields['nama_peserta']."<br><i>- Peserta kursus luar";
						$nama_pegawai .= "<br>- ".$nama_kursus;
						$nama_pegawai .= "</i><br><br>";
					}
					
					$rs_bilik->movenext();
				}
				
				if($rsb->fields['keadaan_bilik']=='1'){
					if($rsb->fields['status_bilik'] == 0){
						if($jumlah_penghuni==0){
							$f_penghuni='#009900'; $fonts = "#FFFFFF"; //$desc_penghuni = 'KOSONG'; 
						} else { 
							$f_penghuni='#000066'; $fonts = "#FFFFFF"; //$desc_penghuni = 'BELUM<br>PENUH'; 
						}
					}else{ 
						if($jumlah_penghuni==0){
							$f_penghuni='#009900'; $fonts = "#FFFFFF"; //$desc_penghuni = 'KOSONG'; 
						} else { 
							$f_penghuni='#FF0000'; $fonts = "#FFFFFF"; //$desc_penghuni = 'PENUH'; 
						}
					}
				} else {
						$f_penghuni='#FFFFFF'; $fonts = "#000000"; //$desc_penghuni = 'PENUH'; 
				}
				?>
                    <?php if($jumlah_penghuni>0){?>
                        <div style="border:thin;border:#0000FF;border-style:solid;width:50px;float:left;text-align:center;background-color:<?=$f_penghuni;?>;cursor:pointer"
                        onmouseover="Tip('<?=$nama_pegawai;?>', TITLE, 'Maklumat Penghuni Asrama', ABOVE, true, SHADOW, true, LEFT, true, FADEIN, 400, FADEOUT, 400)">
                        <font color="<?=$fonts;?>"><?=$rsb->fields['no_bilik'];?></font></div>
                    <?php } else { ?>
                    	<?php //$conn->debug=true;
						$sqlt = "SELECT B.* FROM _sis_a_tblasrama_tempah A, _tbl_kursus_jadual B WHERE A.event_id=B.id AND A.bilik_id=".tosql($rsb->fields['bilik_id']);
						$rstem = $conn->execute($sqlt); $conn->debug=false;
						if(!$rstem->EOF){
							$nama_kursus=$rstem->fields['acourse_name']."<br>[".DisplayDate($rstem->fields['startdate'])."-".DisplayDate($rstem->fields['enddate'])."]"; 
							$f_penghuni='#9933CC';
							
							if(empty($rstem->fields['acourse_name'])){ 
							//$conn->debug=true;
							$nama_kursus = dlookup("_tbl_kursus_jadual A, _tbl_kursus B","coursename","A.courseid=B.id AND A.id=".tosql($rstem->fields['id'])); 
							$nama_kursus .= "<br>[".DisplayDate($rstem->fields['startdate'])."-".DisplayDate($rstem->fields['enddate'])."]";
							//$conn->debug=false;
							}
						?>
                            <div style="border:thin;border:#0000FF;border-style:solid;width:50px;float:left;text-align:center;background-color:<?=$f_penghuni;?>;cursor:pointer"
                            onmouseover="Tip('<?=$nama_kursus;?>', TITLE, 'Maklumat Tempahan Asrama', ABOVE, true, SHADOW, true, LEFT, true, FADEIN, 600, FADEOUT, 400)">
                            <font color="<?=$fonts;?>"><?=$rsb->fields['no_bilik'];?></font></div>
						<?php } else { ?>
                            <div style="border:thin;border:#0000FF;border-style:solid;width:50px;float:left;text-align:center;background-color:<?=$f_penghuni;?>">
                            <font color="<?=$fonts;?>"><?=$rsb->fields['no_bilik'];?></font></div>
                        <?php } ?>
					<?php } ?>
                    
                <?php $rsb->movenext(); } ?>	
                </td></tr>
            </table>
        </td>
    </tr>
	<tr>
    	<td height="30" bgcolor="#ffffff" width="100%"><hr /></b></td>
    </tr>
    
<?php $rs_l->movenext(); } ?>    
</table>
</form>
</body>