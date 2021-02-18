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
$sSQL="SELECT * FROM _tbl_kursus_jadual WHERE id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
$nama_kursus = $rs->fields['acourse_name'];
$courseid = $rs->fields['courseid'];
if(empty($nama_kursus) && !empty($courseid)){ $nama_kursus = dlookup2("_tbl_kursus","coursename","courseid","id=".tosql($courseid)); }
?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT KURSUS &amp; PENGHUNI ASRAMA</b>
          <div style="float:right">
        	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai maklumat kursus" onClick="do_back('')">&nbsp;&nbsp;
        </div>
        </td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="3" class="title">A.&nbsp;&nbsp;&nbsp;MAKLUMAT KURSUS</td>
           </tr>
            <tr>
                <td width="20%"><b>Nama Kursus : </b></td>
                <td width="80%" colspan="2"><? print $nama_kursus;?></td>
            </tr>
            <tr>
              <td><b>Tarikh Kursus : </b></td>
              <td colspan="2"><?php print DisplayDate($rs->fields['startdate']). " hingga ".DisplayDate($rs->fields['enddate']);?></td>
            </tr>
            <tr>
                <td><b>Kursus : </b></td>
              	<td colspan="2"><?php print dlookup("_tbl_kursus_cat","categorytype","id=".tosql($rs->fields['category_code']));?></td>
            </tr>
	</table></td></tr>	

			<tr><td>&nbsp;</td></td></tr>
            <tr>
                <td colspan="3" class="title">B.&nbsp;&nbsp;&nbsp;MAKLUMAT PENGHUNI & BILIK</td>
            </tr>
            <tr>
                <td colspan="3">
               <? //$conn->debug=true;
			    $sSQL="SELECT A.*, B.no_bilik FROM _sis_a_tblasrama A, _sis_a_tblbilik B WHERE A.bilik_id=B.bilik_id AND A.event_id=".tosql($id,"Text");
                $rs2 = $conn->Execute($sSQL);
				$cnt = $rs2->recordcount();
				$conn->debug=false;
				?>
                <table border="1" width=100% cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                  <tr bgcolor="#D1E0F9"> 
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="50%" align="center"><b>Nama Peserta / Penceramah<br /><i>[ Agensi ]</i></b></td>
                    <td width="20%" align="center"><b>No. Tel</b></td>
                    <td width="10%" align="center"><b>No. Bilik</b></td>
                    <td width="15%"><b>Status</b></td>
                  </tr>
          <?
        	if(!$rs2->EOF) {
            $cnt = 1;
			
            $bil = 1;
            while(!$rs2->EOF ) {
				$kursus_type = $rs2->fields['kursus_type'];
				if($kursus_type=='I'){
					if($rs2->fields['asrama_type']=='P'){
						$sub_tab='peserta';
						$sSQL="SELECT A.f_peserta_nama AS daftar_nama, E.f_tempat_nama AS agensi, A.f_peserta_hp, A.f_peserta_tel_pejabat
						FROM _tbl_peserta A, _sis_a_tblasrama C, _ref_tempatbertugas E
						WHERE A.f_peserta_noic=C.peserta_id AND A.is_deleted=0 AND C.is_daftar=1 AND A.BranchCd=E.f_tbcode
						AND A.f_peserta_noic=".tosql($rs2->fields['peserta_id'],"Text");
						$rs_peserta = $conn->execute($sSQL);	
					} else {
						$sSQL="SELECT A.insname AS daftar_nama, A.insorganization AS agensi
						FROM _tbl_instructor A
						WHERE A.is_deleted=0 AND A.insid=".tosql($rs2->fields['peserta_id'],"Text");
						$rs_peserta = $conn->execute($sSQL);
					}
					$nama_peserta = $rs_peserta->fields['daftar_nama'];
					$no_tel = $rs_peserta->fields['f_peserta_tel_pejabat']."/".$rs_peserta->fields['f_peserta_hp'];
					$agensi = $rs_peserta->fields['agensi'];
				} else if($kursus_type=='L'){
					$nama_peserta = $rs2->fields['nama_peserta'];
					$no_tel = $rs2->fields['no_tel'];
					$agensi= 'Peserta Kursus Luar';
				}
            ?>
          <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right" valign="top"><? echo $bil;?>.&nbsp;</td>
            <td align="left" valign="top"><? echo stripslashes($nama_peserta);?><br /><i>[ <? echo stripslashes($agensi);?> ]</i>&nbsp;</td>
            <td align="center"><? echo $no_tel;?>&nbsp;</td>
            <td align="center"><? echo $rs2->fields['no_bilik'];?>&nbsp;</td>
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