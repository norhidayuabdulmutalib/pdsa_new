<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.no_bilik.value==''){
		alert("Sila masukkan no bilik terlebih dahulu.");
		document.ilim.no_bilik.focus();
		return true;
	} else if(document.ilim.tingkat_id.value==''){
		alert("Sila masukkan Tingkat");
		document.ilim.tingkat_id.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function form_delete(URL){
	if(confirm('Adakah anda pasti untuk menghapuskan data ini?')) {
		document.ilim.del.value = '1';
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function do_back(URL){
	//var kemas = document.ilim.kemaskini.value;
	//if(kemas==0){
	//	parent.emailwindow.hide();
	//} else { 
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
	//}
}
</script>
<?

$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
$kemaskini=0;

if(!empty($proses)){
	//include '../loading_pro.php';
	//$conn->debug=true;
	$id = $_POST['id'];
	$no_bilik = $_POST['no_bilik'];
	$tingkat_id = $_POST['tingkat_id'];
	$blok_id = $_POST['blok_id'];
	$jenis = $_POST['jenis'];
	$bilp = $_POST['bilp'];
	$status = 0;
	$del = $_POST['del'];
	$keadaan = $_POST['keadaan'];
	$PageQUERY = $_POST['PageQUERY'];
	$PageNo = $_POST['PageNo'];
	if($del == "0"){
		if(empty($id)){
			echo "insert";
			$sql = "INSERT INTO _sis_a_tblbilik(no_bilik, tingkat_id, blok_id, jenis_bilik, keadaan_bilik)
			VALUES(".tosql($no_bilik,"Text").", ".tosql($tingkat_id,"Text").", ".tosql($blok_id,"Text").", 
			".tosql($jenis,"Text").", ".tosql($keadaan,"Text").")";
			$conn->Execute($sql);
			audit_trail($sql,"");
			$id = dlookup("_sis_a_tblbilik","MAX(bilik_id)","1");
		} else {
			echo "Update";
			if($bilp==0){
			$sql = "UPDATE _sis_a_tblbilik SET no_bilik=".tosql($no_bilik,"Text").
			", tingkat_id=".tosql($tingkat_id,"Text").", blok_id=".tosql($blok_id,"Text").
			", jenis_bilik=".tosql($jenis,"Text").", keadaan_bilik=".tosql($keadaan,"Text").
			" WHERE bilik_id=".tosql($id,"Text");
			} else {
			$sql = "UPDATE _sis_a_tblbilik SET no_bilik=".tosql($no_bilik,"Text").
			", tingkat_id=".tosql($tingkat_id,"Text").", blok_id=".tosql($blok_id,"Text").
			" WHERE bilik_id=".tosql($id,"Text");
			}
			$conn->Execute($sql);
			audit_trail($sql,"");
		}
		$kemaskini=1;
	} else {
		echo "Delete";
		$sql = "UPDATE _sis_a_tblbilik SET is_deleted = 1 WHERE bilik_id=".tosql($id,"Text");
		$conn->Execute($sql);
		audit_trail($sql,"");
		print "<script language=\"javascript\">
			alert('Rekod telah dihapuskan');
			//parent.location.reload();	
			refresh = parent.location; 
			parent.location = refresh;
			</script>";
	}
	//echo $sql;
	//$sql = "UPDATE _sis_tblstaff SET fld_image=".tosql($newname,"Text")." WHERE staff_id=".tosql($id,"Text");
}



//$conn->debug=true;
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$sSQL="SELECT * FROM _sis_a_tblbilik  WHERE bilik_id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
$bil_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id = ".$id." AND is_daftar = 1");
?>
<form name="ilim" method="post">
<table width="99%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT BILIK ASRAMA/PENGINAPAN</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="3" class="title">A.&nbsp;&nbsp;&nbsp;MAKLUMAT BILIK</td>
           </tr>
            <tr>
                <td width="30%">No Bilik : </td>
                <td width="80" colspan="2"><input name="no_bilik" type="text" id="no_bilik" value="<?php print $rs->fields['no_bilik'];?>" size="20" /></td>
            </tr>
            <tr>
              	<td>Blok : </td>
              	<td colspan="2"><select name="blok_id">
			   <?php  	//$conn->debug=true;
                    $sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_bb_status = 0 AND is_deleted=0 ";
					if($_SESSION["s_level"]<>'99'){ $sql_l .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
					$sql_l .= " ORDER BY f_bb_desc";
                    $rs_l = &$conn->Execute($sql_l); 
                    while(!$rs_l->EOF){
                        print '<option value="'.$rs_l->fields['f_bb_id'].'"'; 
                        if($rs_l->fields['f_bb_id']==$rs->fields['blok_id']){ print 'selected'; }
                        print '>'. $rs_l->fields['f_bb_desc'] .'</option>';
                        $rs_l->movenext();
                    }
                ?>
	         	</select>
             	</td>
            </tr>
            <tr>
                <td width="30%">Aras : </td>
                <td width="80" colspan="2"><select name="tingkat_id">
            <?php  $sql_l = "SELECT * FROM _ref_aras_bangunan WHERE f_ab_status = 0 ORDER BY f_ab_desc";
						$rs_l = &$conn->Execute($sql_l); 
						while(!$rs_l->EOF){
							print '<option value="'.$rs_l->fields['f_ab_id'].'"';
							if($rs_l->fields['f_ab_id']==$rs->fields['tingkat_id']){ print 'selected'; }
							print '>'. $rs_l->fields['f_ab_desc'].'</option>';
							$rs_l->movenext();
						}
					?>
            	</select>
                </td>
            </tr>
            <tr>
              	<td>Jenis Bilik</td>
              	<td colspan="2"><select name="jenis">
                 <option value="1" <?php if($rs->fields['jenis_bilik'] == '1') echo 'selected';?> >BILIK SEORANG</option>
                 <option value="2" <?php if($rs->fields['jenis_bilik'] == '2') echo 'selected';?> >SEBILIK 2 ORANG</option>
                 <option value="3" <?php if($rs->fields['jenis_bilik'] == '3') echo 'selected';?> >SEBILIK 3 ORANG</option>
              	</select>
                </td>
            </tr>
           <?php if( $bil_penghuni == 0) {?>
            <tr>
                <td width="30%">Keadaan Bilik : </td>
                <td width="80" colspan="2"><select name="keadaan">
               			<option value="1" <?php if($rs->fields['keadaan_bilik'] == '1') echo 'selected';?> >SEDIA DIDUDUKI</option>
                    	<option value="0" <?php if($rs->fields['keadaan_bilik'] == '0') echo 'selected';?> >SEDANG DISELENGGARA</option>
                    </select>    
                </td>
            </tr>
			<?php }?>

            <tr>
                <td></td>
                <td><br>
                    <?php //if( $bil_penghuni == 0){ ?>
					<input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
                    onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')">
					<?php //} ?>
                    <?php if( $bil_penghuni == 0 && !empty($id)) {?>
                    <input type="button" value="Hapus"  name="hapus" id="hapus" class="button_disp" title="Sila klik untuk menghapus maklumat" 
                    onClick="form_delete('modal_form.php?<?php print $URLs;?>&pro=DELETE')">
                    <?php } ?>
                	<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai maklumat bilik" 
                    onClick="do_back('');">
                    <!--onClick="do_back('index.php?data=<?php print base64_encode($userid.';apps/asrama/bilik_list.php;asrama;bilik;');?>&blok_id=<?=$blok_id?>&page=<?=$PageNo?>')">-->
                    <input type="hidden" name="del" value="0" />
					<input type="hidden" name="bilp" value="<?=$bil_penghuni;?>" />
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                
                    <input type="hidden" name="kemaskini" value="<?=$kemaskini?>" />                
                 </td>
            </tr>

			<tr><td>&nbsp;</td></tr>
            <tr>
                <td colspan="3" class="title">B.&nbsp;&nbsp;&nbsp;MAKLUMAT PENGHUNI</td>
            </tr>
            <tr>
                <td colspan="3">
               <?
			   //$conn->debug=true;
				/*$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, C.bilik_id, C.daftar_id, D.no_bilik 
				FROM _tbl_peserta A, _sis_a_tblasrama C, _sis_a_tblbilik D, _ref_tempatbertugas E
				WHERE A.f_peserta_noic=C.peserta_id AND A.is_deleted=0 AND C.is_daftar=1 AND C.bilik_id=D.bilik_id AND A.BranchCd=E.f_tbcode ";
				$sSQL .= " AND C.bilik_id=".tosql($id,"Text");*/

			    $sSQL="SELECT A.*, B.no_bilik FROM _sis_a_tblasrama A, _sis_a_tblbilik B WHERE A.is_daftar=1 AND A.bilik_id=B.bilik_id AND A.bilik_id=".tosql($id,"Text");
                $rs2 = $conn->Execute($sSQL);
				$jum_peserta = $rs2->recordcount();
				?>
                <table border="1" width=100% cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                  <tr bgcolor="#D1E0F9"> 
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="40%" align="center"><b>Nama Peserta / Penceramah<br /><i>[ Agensi ]</i></b></td>
                    <td width="40%" align="center"><b>Kursus<br /><i>[ Tarikh Kursus ]</i></b></td>
                    <td width="40%" align="center"><b>Tindakan</b></td>
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
          <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right"><?php echo $bil;?>.&nbsp;</td>
            <td align="left" valign="top"><?php echo stripslashes($nama_peserta);?>
            <br /><i>[ <?php echo stripslashes($agensi);?> ]</i>&nbsp;</td>
            <td align="center"><?php echo $kursus;?><br />
             <i>[ <?php echo DisplayDate($rs_kursus->fields['mula']);?> - <?php echo DisplayDate($rs_kursus->fields['tamat']);?> ]</i>&nbsp;</td>
            <td align="center">
            	<img src="../images/btn_web-users_bg.gif" style="cursor:pointer" border="0" 
                onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Keluar Penghuni Asrama',700,350)" 
                title="Sila klik untuk daftar keluar peserta / penceramah">
                &nbsp;&nbsp;
                <img src="../images/btn_configure-odbc_bg.gif" border="0" style="cursor:pointer"
                onclick="open_modal('<?=$href_pindah;?>&tab=<?=$sub_tab;?>','Daftar Pindah Penghuni Asrama',700,350)" 
                title="Sila klik untuk proses pindah bilik">
            </td>
         </tr>
          <?
                $cnt = $cnt + 1;
                $bil = $bil + 1;
                $rs2->movenext();
            	}
            	$rs2->Close();
        	} else {
				$sql_upd = "UPDATE _sis_a_tblbilik SET status_bilik=0 WHERE bilik_id=".tosql($id,"Number");
				$conn->Execute($sql_upd);
				//print $sql_upd;
			}
            ?>
        </table>         </td>
            </tr>
        <?php if($cnt>0){ ?>
        	<tr><td style="padding-left:20px;text-align:inherit" valign="middle">
        	<img src="../images/btn_web-users_bg.gif" /> Proses daftar keluar penghuni asrama.
            <br />
            <img src="../images/btn_configure-odbc_bg.gif" border="0" /> Proses perpindahan penghuni asrama.
            </td></tr>
        <?php } ?>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.no_bilik.focus();
</script>
