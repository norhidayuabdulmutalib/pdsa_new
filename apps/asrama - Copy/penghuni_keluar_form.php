<?
include_once '../common.php';
//include_once '../include/formatedate.php';
$proses = $_POST['proses'];
if(empty($proses)){
?>
<link rel="stylesheet" href="../css/template-css.css" type="text/css" />
    <script language="javascript" type="text/javascript">
	<!--
    function do_save(){
		if(confirm("Adakah anda pasti untuk pendaftaran keluar pelajar ini?")){
			document.ilim.proses.value = 'keluar';
			document.ilim.action = "penghuni_keluar_form.php";
			document.ilim.submit();
		}
    }
	function do_close(){
		parent.modalWindow.hide();
	}
	-->
    </script>
<?
//$conn->debug=true;
$id = $_GET['id'];
$sql = "SELECT * FROM _sis_tblpelajar A, _sis_a_tblasrama C, ref_kursus B WHERE A.kursus_id=B.kid 
AND A.pelajar_id=C.pelajar_id AND C.daftar_id=".tosql($id,"Text");
$rs = $conn->execute($sql);
$pelajar_id = $rs->fields['pelajar_id'];
$bil=0;
$tajuk = "DARUL QURAN<BR>JABATAN KEMAJUAN ISLAM MALAYSIA";
$tajuk1 = "PENDAFTARAN KELUAR ASRAMA";
?>
<body style="background: #F3F3F3">
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">
    <tr>
    	<td colspan="2" align="center"><h3><?=$tajuk1;?></h3></td>
    </tr>
	<tr><td colspan="2">
    	<table width="95%" cellpadding="3" cellspacing="2" border="0" align="center">
            <tr>
                <td width="30%">NAMA PENUH : <br /></td>
              	<td colspan="2" width="60%"><?=strtoupper($rs->fields['p_nama']);?></td>
              	<td width="10%" rowspan="5" valign="top" align="center">
              	<span id="ImgViewBoarder"><span id="ImgView">
                <img id="elImage" src="../student/student_pic/<?=$rs->fields['img_pelajar'];?>" width="100" height="120"></span></span><br />
               </td>
            </tr>
            <tr>
                <td>NO. KP / <i>[No. Matrik]</i> : </td>
                <td colspan="2"><?=strtoupper($rs->fields['p_nokp']);?> / <i>[<?=strtoupper($rs->fields['no_matrik']);?>]</i></td>
            </tr>
            <tr>
                <td>SESI PENGAJIAN : </td>
                <td colspan="3"><?=strtoupper($rs->fields['sesi_kemasukan']);?>&nbsp;&nbsp;</td>
           </tr>
           <tr>
              <td>PROGRAM / <i>[Syukbah]</i>: </td>
              <td colspan="3"><? print strtoupper(dlookup("ref_kursus","kursus","kid='".$rs->fields['kursus_id']."'"));?> 
              / <i>[<? print strtoupper(dlookup("ref_syukbah","ref_sukbah","ref_sukbah_id='".$rs->fields['syukbah_id']."'"));?>]</i></td>
           </tr>
            <tr>
                <td>Alasan Keluar : </td>
                <td colspan="3">
                	<select name="a_keluar">
                    	<option value="Cuti Semester">Cuti Semester</option>
                    	<option value="Tamat Pengajian">Tamat Pengajian</option>
                    	<option value="Tangguh Semester">Tangguh Semester</option>
                    	<option value="Tindakan Tatatertib">Tindakan Tatatertib</option>
                    	<option value="Tawaran Lain">Tawaran Lain</option>
                    	<option value="Lain-Lain">Lain-Lain</option>
                    </select>
                </td>
           </tr>
            <tr>
                <td>Senarai Kemudahan : </td>
                <td colspan="3">
					<?php 
                    $sSQL="SELECT a.*, b.inv_nama FROM _sis_a_tblinventori_det a,_sis_a_tblinventori b WHERE b.inventori_id = a.inv_id AND a.is_deleted= 0 
                    AND a.daftar_id=".tosql($id,"Text");
                    $rs = $conn->Execute($sSQL);
                    $cnt = $rs->recordcount();
                    ?>
            <tr>
              <td colspan="4"><table border="1" width="100%" cellspacing="0" cellpadding="3" bordercolorlight="#000000" bordercolordark="#FFFFFF">
                  <tr bgcolor="#D1E0F9">
                    <td width="10%" align="center"><b>Bil</b></td>
                    <td width="40%" align="center"><strong>Jenis Kemudahan</strong></td>
                    <td width="20%" align="center"><strong>Bilangan</strong></td>
                    <td width="20%" align="center"><strong>Tarikh Gunapakai</strong></td>
                </tr>
                  <?
				if(!$rs->EOF) {
					$cnt = 1;
					$bil = 1;
					while(!$rs->EOF ) {
						?>
						  <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>" >
							<td align="center"><? echo $bil;?>&nbsp;</td>
							<td valign="top"><? echo $rs->fields['inv_nama'];?>&nbsp;</td>
							<td align="center"><? echo $rs->fields['bil'];?>&nbsp;</td>
							<td align="center"><? echo DisplayDate($rs->fields['create_dt']);?>&nbsp;</td>
						  </tr>
						  <?
						$cnt = $cnt + 1;
						$bil = $bil + 1;
						$rs->movenext();
					}
					$rs->Close();
				}
            ?>
              </table></td>
            </tr>
          <tr>
                <td colspan="4" align="center">
                <br>
                <input type="button" value="Daftar Keluar Asrama" onClick="do_save()" title="Sila klik untuk pendaftaran keluar asrama">
                <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup paparan maklumat">
                <input type="hidden" name="pelajar_id" value="<?=$pelajar_id;?>" />
                <input type="hidden" name="id" value="<?=$id;?>" />
                <input type="hidden" name="bilik_id" value="<?=$rs->fields['bilik_id'];?>" />
                <input type="hidden" name="proses" id="proses" value="<?=$proses;?>">               
                </td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
</body>
<? } else { ?>
    <?
	$conn->debug=true;
	$proses = $_POST['proses'];
	$pelajar_id = $_POST['pelajar_id'];
	$id = $_POST['id'];	
	$bilik_id = $_POST['bilik_id'];	
	$sebab = $_POST['a_keluar'];	
	echo "Daftar Keluar";
	$sql = "UPDATE _sis_a_tblasrama SET is_daftar=0, is_keluar=1, tkh_keluar=".tosql(date("Y-m-d"),"Text").", 
	sebab=".tosql($sebab,"Text").", update_dt=now(), update_by='".$_SESSION["s_UserID"]."' 
	WHERE daftar_id=".tosql($id,"Text");
	//echo $sql;
	//$sql = "UPDATE _sis_tblstaff SET fld_image=".tosql($newname,"Text")." WHERE staff_id=".tosql($id,"Text");
	$conn->Execute($sql);
	echo "Set Status Bilik Kepada KOSONG";
	$sql = "UPDATE _sis_a_tblbilik SET status_bilik=0 WHERE bilik_id=".tosql($bilik_id,"Number");
	$conn->Execute($sql);
    //exit;
	// KEMASKINI MAKLUMAT INV UNTUK KOSONGKAN
	$sql_s = "SELECT * FROM _sis_a_tblinventori_det WHERE daftar_id=".tosql($id,"Text");
	$rs_inv = $conn->Execute($sql_s);
	if(!$rs_inv->EOF){
		while(!$rs_inv->EOF){
			$inv_id = $rs_inv->fields['inv_id'];
			$bil = $rs_inv->fields['bil']-0;
			$pinjam = dlookup("_sis_a_tblinventori","inv_pinjam","inventori_id = ".tosql($inv_id,"Number"));
			$sql = "UPDATE _sis_a_tblinventori SET 
			inv_pinjam=".tosql($pinjam-$bil,"Number").", 
			update_dt=".tosql(now(),"Text").", update_by=".tosql($_SESSION["s_UserID"],"Text")."
			WHERE inventori_id=".tosql($inv_id,"Number");
			$conn->Execute($sql);
			//echo "<br>".$sql;
			
			$rs_inv->movenext();
		}
		$sql = "UPDATE _sis_a_tblinventori_det SET is_deleted = 1,
		delete_dt=".tosql(now(),"Text").", delete_by=".tosql($_SESSION["s_UserID"],"Text")."
		WHERE daftar_id=".tosql($id,"Text");
		$conn->Execute($sql);
		//echo "<br>".$sql;
	}	
	//exit;
	?>
    <form id="frm" name="frm" method="post">
    	<table width="100%"><tr><td>
         <input type="hidden" name="proses" id="proses" value="selesai">
        </td></tr></table>
    </form>
    <script language="javascript" type="text/javascript">
		<!--
		//parent.location.reload();
		parent.modalWindow.hide();
		//-->
    </script>
<? } ?>
