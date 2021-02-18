<?php include_once '../../common.php'; ?>
<link href="../../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
<script LANGUAGE="JavaScript">

function do_back(URL){
	document.ilim.action =URL;
	document.ilim.submit();
}

</script>
<?
@session_start();
$s_userid = $_SESSION["s_userid"];
$s_username = $_SESSION["s_username"];
if(empty($_SESSION["s_userid"])){
	//include '../lout.php';
	exit();
} 
//$conn->debug=true;
$ic=isset($_REQUEST["ic"])?$_REQUEST["ic"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
//$conn->debug=true;
$sSQL="SELECT * FROM _tbl_peserta  WHERE is_deleted=0 AND f_peserta_noic = ".tosql($ic,"Text");
$rs = &$conn->Execute($sSQL);
if(!$rs->EOF){
	$id = $rs->fields['id_peserta'];
	$pass = $rs->fields['f_pass'];
	$f_peserta_noic = $rs->fields['f_peserta_noic'];
	$f_negara = $rs->fields['f_peserta_negara'];
	if(empty($f_negara)){ $f_negara='MY'; }
}
?>

<form name="ilim" id="frm" method="post">
<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT PESERTA KURSUS</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="1" cellspacing="0" border="0" align="center">
            <tr>
                <td width="25%"><strong>No. K/P : </strong></td>
                <td width="60%" colspan="2">
                <input type="hidden" name="id_peserta"  value="<?php print $rs->fields['id_peserta'];?>" />
                <?php print $f_peserta_noic;?></td>
                <td width="15%" rowspan="6" align="center">
                    	<img src="../all_pic/imgpeserta.php?id=<?php echo $rs->fields['id_peserta'];?>" width="100" height="120" border="0">
                        <br>
               </td>
            </tr>
            <tr>
                <td><strong>Nama Penuh Peserta : </strong></td>
                <td colspan="2"><?php print $rs->fields['f_peserta_nama'];?></td>
            </tr>
            <tr>
                <td><strong>Jantina : </strong></td>
                <td colspan="2">
					<?php if($rs->fields['f_peserta_jantina']=='L'){ print 'Lelaki'; }
					else if($rs->fields['f_peserta_jantina']=='P'){ print 'Perempuan'; } ?>
                </td>
            </tr>
            <tr>
                <td width="20%"><strong>Tarikh lahir : </strong></td>
                <td width="80%" colspan="3"><?=DisplayDate($rs->fields['f_peserta_lahir'])?></td>
          </tr>
          <tr>
                <td width="20%"><strong>Warganegara : </strong></td>
                <td colspan="2"><?php print dlookup("_ref_negara","nama_negara","kod_negara=".tosql($f_negara)); ?></td>
            </tr>
            <tr>
                <td width="20%"><strong>No. Telefon Rumah : </strong></td>
                <td width="50%" colspan="1"><?php print $rs->fields['f_peserta_tel_rumah'];?></td>
            </tr>
            <tr>
                <td width="20%"><strong>No. Telefon Bimbit : </strong></td>
                <td width="50%" colspan="1"><?php print $rs->fields['f_peserta_hp'];?></td>
            </tr>
            <tr>
                <td width="20%"><strong>Emel : </strong></td>
                <td width="50%" colspan="1"><?php print $rs->fields['f_peserta_email'];?></td>
            </tr>
            <tr><td colspan="4"><hr /></td></tr>
            <tr>
                <td><strong>Kumpulan Jawatan <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><?php print dlookup("_ref_kumpulan_kerja","f_kk_desc","f_kk_id=".tosql($rs->fields['f_peserta_grp'])); ?></td>
                <td align="center" rowspan="7" valign="top">
					<?php include 'view_kursus_calc.php'; ?>
				</td>
            </tr>
            <tr>
                <td><strong>Gred Jawatan : </strong></td>
                <td width="50%" colspan="2"><?php print dlookup("_ref_titlegred","f_gred_name","f_gred_id=".tosql($rs->fields['f_title_grade'])); ?></td>
            </tr>
            <tr>
                <td align="left"><b>Tarikh Lantikan : </b></td>
                <td align="left" colspan="2"><?=DisplayDate($rs->fields['f_peserta_appoint_dt'])?></td>
          </tr>
            <tr>
                <td align="left"><b>Tarikh Sah Jawatan : </b></td>
                <td align="left" colspan="2"><?=DisplayDate($rs->fields['f_peserta_sah_dt'])?></td>
          </tr>
            <tr>
                <td width="20%"><strong>No. Telefon Pejabat : </strong></td>
                <td width="50%" colspan="2"><?php print $rs->fields['f_peserta_tel_pejabat'];?></td>
            </tr>
            <tr>
                <td width="20%"><strong>No. Faks : </strong></td>
                <td width="50%" colspan="2"><?php print $rs->fields['f_peserta_faks'];?></td>
            </tr>
            <tr><td colspan="4"><hr /></td></tr>
            <tr>
                <td><strong>Jabatan/Agensi/Unit : </strong></td>
                <td colspan="2"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs->fields['BranchCd'])); ?></td>
            </tr>
            <tr>
                <td valign="top"><strong>Alamat : </strong></td>
                <td colspan="2"><?php print $rs->fields['f_peserta_alamat1'];?></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><?php print $rs->fields['f_peserta_alamat2'];?></td>
            </tr>
            <tr>
                <td valign="top">&nbsp;</td>
                <td colspan="2"><?php print $rs->fields['f_peserta_alamat3'];?></td>
            </tr>
            <tr>
                <td valign="top"><strong>Poskod : </strong>&nbsp;</td>
                <td colspan="2"><?php print $rs->fields['f_peserta_poskod'];?></td>
            </tr>
            <tr>
                <td valign="top"><strong>Negeri <font color="#FF0000">*</font> : </strong>&nbsp;</td>
                <td colspan="2"><?php print dlookup("ref_negeri","negeri","kod_negeri=".tosql($rs->fields['f_peserta_negeri'])); ?></td>
            </tr>
            <tr><td colspan="4"><hr /></td></tr>
            <?php
			$sqlpenyelia = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE peserta_icno=".tosql($f_peserta_noic)." ORDER BY InternalStudentId DESC";
			$rspenyelia = &$conn->execute($sqlpenyelia);
			//print $sqlpenyelia;
			?>
            <tr>
                <td><strong>Nama Penyelia <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><?php print $rspenyelia->fields['nama_ketuajabatan'];?></td>
            </tr>
            <tr>
                <td><strong>Jawatan <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><?php print $rspenyelia->fields['jawatan_ketuajabatan'];?></td>
            </tr>
            <tr>
                <td><strong>Emel <font color="#FF0000">*</font> : </strong></td>
                <td colspan="2"><?php print $rspenyelia->fields['email_ketuajabatan'];?></td>
            </tr>
			<?php //} ?>
            <?php //} ?>
        </table>
      </td>
   </tr>
    <tr>
        <td colspan="4"><br /><?php include 'view_peserta_akademik.php'; ?></td>
    </tr>
    <tr>
        <td colspan="4"><br /><?php include 'view_peserta_kursus_dalaman.php'; ?></td>
    </tr>
    <tr>
        <td colspan="4"><br /><?php include 'view_peserta_kursus_luaran.php'; ?></td>
    </tr>
</table>
</form>