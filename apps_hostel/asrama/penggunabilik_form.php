<script LANGUAGE="JavaScript">
function do_back(URL){
	parent.emailwindow.hide();
}
</script>
<?
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$kemaskini=0;

//$conn->debug=true;
$PageNo = $_GET['PageNo'];
$sSQL="SELECT * FROM _sis_a_tblbilik  WHERE bilik_id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
$bil_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$id." AND is_daftar = 1");
?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT BILIK ASRAMA/PENGINAPAN</b>
        <div style="float:right">
        	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai maklumat bilik" 
            onClick="do_back('index.php?data=<? print base64_encode('user;asrama/bilik_list.php;asrama;bilik;');?>&blok_id=<?=$blok_id?>&page=<?=$PageNo?>')">&nbsp;&nbsp;
        </div>
        </td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="3" class="title">A.&nbsp;&nbsp;&nbsp;MAKLUMAT BILIK</td>
           </tr>
            <tr>
                <td width="20%">No Bilik : </td>
                <td width="80%" colspan="2"><? print $rs->fields['no_bilik'];?></td>
            </tr>
            <tr>
              <td>Blok : </td>
              <td colspan="2"><?php print dlookup("_ref_blok_bangunan","f_bb_desc","f_bb_id=".tosql($rs->fields['blok_id']));//f_kb_id=2 AND ?></td>
            </tr>
            <tr>
                <td>Aras : </td>
              	<td colspan="2"><?php print dlookup("_ref_aras_bangunan","f_ab_desc","f_ab_id=".tosql($rs->fields['tingkat_id']));?></td>
            </tr>
            <tr>
                <td>Jenis Bilik</td>
              	<td colspan="2"><?php 
					if($rs->fields['jenis_bilik'] == '1'){ print 'BILIK SEORANG / VIP'; }
					else if($rs->fields['jenis_bilik'] == '2'){ print 'SEBILIK 2 ORANG'; }
					else if($rs->fields['jenis_bilik'] == '3'){ print 'SEBILIK 3 ORANG'; }
				?>
                </td>
            </tr>
            <tr>
                <td>Keadaan Bilik : </td>
              	<td colspan="2"><?php 
					if($rs->fields['keadaan_bilik'] == '0'){ print 'SEDIA DIDUDUKI'; }
					else if($rs->fields['keadaan_bilik'] == '1'){ print 'SEDANG DISELENGGARA'; }
				?>
                </td>
            </tr>


			<tr><td>&nbsp;</td></td></tr>
            <tr>
                <td colspan="3" class="title">B.&nbsp;&nbsp;&nbsp;MAKLUMAT PENGHUNI</td>
            </tr>
            <tr>
                <td colspan="3">
               <? //$conn->debug=true;
			    $sSQL="SELECT A.*, B.no_bilik FROM _sis_a_tblasrama A, _sis_a_tblbilik B WHERE A.bilik_id=B.bilik_id AND A.bilik_id=".tosql($id,"Text");
                $rs2 = $conn->Execute($sSQL);
				$cnt = $rs2->recordcount();
				$conn->debug=false;
				?>
                <table border="1" width=100% cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                  <tr bgcolor="#D1E0F9"> 
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="40%" align="center"><b>Nama Peserta / Penceramah<br /><i>[ Agensi ]</i></b></td>
                    <td width="40%" align="center"><b>Kursus<br /><i>[ Tarikh Kursus ]</i></b></td>
                    <td width="15%"><b>Status</b></td>
                  </tr>
          <?
        	if(!$rs2->EOF) {
            $cnt = 1;
			
            $bil = 1;
            while(!$rs2->EOF ) {
				$href_link = "modal_form.php?win=".base64_encode('asrama/dkeluar_form.php;'.$rs2->fields['daftar_id']);
				$href_pindah = "modal_form.php?win=".base64_encode('asrama/dpindah_form.php;'.$rs2->fields['daftar_id']);
				$kursus_type = $rs2->fields['kursus_type'];
				if($kursus_type=='I'){
					if($rs2->fields['asrama_type']=='P'){
						$sub_tab='peserta';
						$sSQL="SELECT A.f_peserta_nama AS daftar_nama, E.f_tempat_nama AS agensi
						FROM _tbl_peserta A, _sis_a_tblasrama C, _ref_tempatbertugas E
						WHERE A.f_peserta_noic=C.peserta_id AND A.is_deleted=0 AND C.is_daftar=1 AND A.BranchCd=E.f_tbcode
						AND A.f_peserta_noic=".tosql($rs2->fields['peserta_id'],"Text");
						$rs_peserta = $conn->execute($sSQL);
	
						$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat FROM _tbl_kursus A, _tbl_kursus_jadual B, _tbl_kursus_jadual_peserta C 
						WHERE A.id=B.courseid AND B.id=C.EventId AND C.peserta_icno=".tosql($rs2->fields['peserta_id'],"Text");
						$rs_kursus = $conn->execute($sql_k);
					} else {
						$sSQL="SELECT A.insname AS daftar_nama, A.insorganization AS agensi
						FROM _tbl_instructor A
						WHERE A.is_deleted=0 AND A.insid=".tosql($rs2->fields['peserta_id'],"Text");
						$rs_peserta = $conn->execute($sSQL);
	
						$sql_k = "SELECT coursename AS kursus, B.startdate AS mula, B.enddate AS tamat FROM _tbl_kursus A, _tbl_kursus_jadual B, _tbl_kursus_jadual_det C 
						WHERE A.id=B.courseid AND B.id=C.event_id AND C.instruct_id=".tosql($rs2->fields['peserta_id'],"Text");
						$rs_kursus = $conn->execute($sql_k);
					}
					$nama_peserta = $rs_peserta->fields['daftar_nama'];
					$kursus = $rs_kursus->fields['kursus'];
					$agensi = $rs_peserta->fields['agensi'];
				} else if($kursus_type=='L'){
					$nama_peserta = $rs2->fields['nama_peserta'];
					$agensi= 'Peserta Kursus Luar';
					$sql_k = "SELECT acourse_name AS kursus, startdate AS mula, enddate AS tamat FROM _tbl_kursus_jadual  
					WHERE id=".tosql($rs2->fields['event_id'],"Text");
					$rs_kursus = $conn->execute($sql_k);
				}
            ?>
          <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right" valign="top"><? echo $bil;?>.&nbsp;</td>
            <td align="left" valign="top"><? echo stripslashes($nama_peserta);?><br /><i>[ <? echo stripslashes($agensi);?> ]</i>&nbsp;</td>
            <td align="center"><? echo $kursus;?><br /><i>[ <? echo DisplayDate($rs_kursus->fields['mula']);?> - <? echo DisplayDate($rs_kursus->fields['tamat']);?> ]</i>&nbsp;</td>
            <td><?php
            	if($rs2->fields['is_daftar']==1 && $rs2->fields['is_keluar']==0){ print '<font color=#FF0000>Penghuni Asrama</font>'; }
            	else if($rs2->fields['is_daftar']==0 && $rs2->fields['is_keluar']==1){ print 'Telah Daftar Keluar<br>'.DisplayDate($rs2->fields['tkh_keluar']); }
				?>
            </td>
         </tr>
          <?
                $cnt = $cnt + 1;
                $bil = $bil + 1;
                $rs2->movenext();
            	}
            	$rs2->Close();
        	}
            ?>
        </table>         </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>