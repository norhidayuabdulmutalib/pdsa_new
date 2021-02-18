<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetakan Jadual</title>
<script language="javascript" type="text/javascript">	
function do_close(){
	parent.emailwindow.hide();
	//window.close();
}
function handleprint(){
	window.print();
}
</script>
<style type="text/css" media="all">@import"../../css/print_style.css";</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 10px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }

@media all{
 .page-break { display:none; }
}

@media print{
 .page-break { display:block; page-break-before:always; }
}
</style>
</head>
<body>
<?php
//$conn->debug=true;
$sSQL="SELECT * FROM _tbl_instructor  WHERE ingenid = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
?>
<div class="printButton" align="center">
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br /><br />
    </td></tr></table>
</div>
<table width="100%" align="center" cellpadding="1" cellspacing="0" border="1">
    <tr bgcolor="#00CCFF">
    	<td colspan="2" height="30">&nbsp;<b>MAKLUMAT PENCERAMAH</b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="4" class="title" height="30">A.&nbsp;&nbsp;&nbsp;MAKLUMAT AM</td>
            </tr>
            <tr>
                <td width="30%"><b>No. K/P : </b></td>
                <td width="50%" colspan="2"><? echo $rs->fields['insid'];?></td>
                <td width="20%" rowspan="6" align="center">
                	<? if(!empty($id)){ ?>
                    	<img src="all_pic/imgpenceramah.php?id=<? echo $rs->fields['ingenid'];?>" width="100" height="120" border="0">
					<? } ?>
               </td>
            </tr>
            <tr>
                <td width="20%"><b>Nama Penuh : </b></td>
                <td width="80%" colspan="3"><? print $rs->fields['insname'];?></td>
            </tr>
            <tr>
                <td width="20%"><b>Gred Jawatan : </b></td>
                <td width="50%" colspan="2"><?php print dlookup("_ref_titlegred","f_gred_name","f_gred_code=".tosql($rs->fields['titlegredcd']));?></td>
            </tr>
            <tr>
                <td width="20%"><b>Organisasi : </b></td>
              <td width="80%" colspan="3"><? print $rs->fields['insorganization'];?></td>
            </tr>
            <tr>
                <td width="20%"><b>Kategori Penceramah : </b></td>
                <td width="50%" colspan="2"><?php print dlookup("_ref_kategori_penceramah","f_kp_kenyataan","f_kp_id=".tosql($rs->fields['inskategori']));?></td>
            </tr>
            <tr>
                <td width="20%"><b>No. Telefon Pejabat : </b></td>
                <td width="50%" colspan="2"><? print $rs->fields['inshometel'];?></td>
            </tr>
            <tr>
                <td width="20%"><b>No. Telefon Bimbit : </b></td>
                <td width="50%" colspan="2"><? print $rs->fields['insmobiletel'];?></td>
            </tr>
            <tr>
                <td width="20%"><b>No. Faks : </b></td>
                <td width="50%" colspan="2"><? print $rs->fields['insfaxno'];?></td>
            </tr>
            <tr>
                <td width="20%"><b>Email : </b></td>
                <td width="50%" colspan="2"><? print $rs->fields['insemail'];?></td>
            </tr>
            <tr>
                <td valign="top"><b>Alamat : </b></td>
                <td colspan="2"><? print stripslashes(nl2br($rs->fields['insaddress']));?></td>
            </tr>
            <tr>
                <td width="20%"><b>Jantina : </b></td>
                <td width="50%" colspan="2"><? if($rs->fields['insgender']=='L'){ print 'Lelaki'; } else { print 'Perempuan'; }?></td>
            </tr>
            <tr>
                <td width="20%"><b>Tarikh lahir : </b></td>
                <td width="80%" colspan="3"><?=DisplayDate($rs->fields['insdob'])?></td>
          </tr>
          <tr>
                <td width="20%"><b>Warganegara : </b></td>
                <td width="50%" colspan="2"><?php print dlookup("_ref_negara","nama_negara","kod_negara=".tosql($rs->fields['insnationality']));?></td>
            </tr>
            <tr>
                <td colspan="4" class="title" height="30">B.&nbsp;&nbsp;&nbsp;MAKLUMAT KEWANGAN</td>
            </tr>
			<tr>
                <td><b>Kadar bayaran sejam : </b></td>
                <td colspan="2">RM <? print $rs->fields['payperhours'];?></td>
                <td rowspan="4" align="center"><? if(!empty($id)){ ?>
                    	<img src="all_pic/img_bukubank.php?id=<? echo $rs->fields['ingenid'];?>" width="100" height="100" border="0">
					<? } ?>
                 </td>
            </tr>
            <tr>
                <td><b>Nama Bank : </b></td>
                <td colspan="3"><? print $rs->fields['insbank'];?></td>
            </tr>
            <tr>
                <td><b>Cawangan Bank : </b></td>
                <td colspan="2"><? print $rs->fields['insbankbrch'];?></td>
            </tr>
            <tr>
                <td><b>No. Akaun Bank : </b></td>
                <td colspan="2"><? print $rs->fields['insakaun'];?></td>
            </tr>
            <tr>
                <td colspan="4" class="title" height="30">C.&nbsp;&nbsp;&nbsp;MAKLUMAT PEKERJAAN</td>
            </tr>
            <tr>
                <td colspan="4">
                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3">MAKLUMAT KELAYAKAN AKADEMIK</td>
						</tr>
                </table>
                <table width="100%" cellpadding="3" cellspacing="0" border="1">
                    	<tr class="title" >
	                       	<td width="5%">Bil</td>
                            <td width="25%">Kelulusan Akademik</td>
                            <td width="25%">Nama Kursus</td>
                            <td width="25%">Institusi Pengajian</td>
                            <td width="10%">Tahun</td>
                        </tr>
                        <?php 	
						$_SESSION['ingenid'] = $id;
						$sSQL2="SELECT * FROM _tbl_instructor_akademik WHERE ingenid = ".tosql($id,"Text");
						$sSQL2 .= "ORDER BY inaka_tahun DESC";
						$rs2 = &$conn->Execute($sSQL2);
						$cnt = $rs2->recordcount();
					
					    if(!$rs2->EOF) {
						$cnt = 1;
						$bil = 1;
						while(!$rs2->EOF) {
						?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=dlookup("_ref_akademik", "f_akademik_nama", " f_akademik_id = ".$rs2->fields['inaka_sijil'])?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_kursus']?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_institusi']?>&nbsp;</td>
                            <td valign="top" align="center"><?=$rs2->fields['inaka_tahun']?>&nbsp;</td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <? } ?> 
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                	<table width="100%" cellpadding="1" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3">MAKLUMAT BIDANG KEPAKARAN</td>
						</tr>
                     </table>
                     <table width="100%" cellpadding="3" cellspacing="0" border="1">
                    	<tr class="title" >
                        	<td width="5%">Bil</td>
                            <td width="40%">Bidang Kepakaran</td>
                            <td width="45%">Pengkhususan</td>
                        </tr>
                        <?php 	
						$_SESSION['ingenid'] = $id;
						$sSQL2="SELECT * FROM _tbl_instructor_kepakaran WHERE ingenid = ".tosql($id,"Text");
					//	$sSQL2 .= "ORDER BY inaka_tahun";
						$rs2 = &$conn->Execute($sSQL2);
						$cnt = $rs2->recordcount();
						if(!$rs2->EOF) {
						$cnt = 1;
						$bil = 1;
							while(!$rs2->EOF) {
							?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=dlookup("_ref_kepakaran", "f_pakar_nama", " f_pakar_code = ".$rs2->fields['inpakar_bidang'])?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inpakar_pengkhususan']?>&nbsp;</td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <? } ?> 
                   </table>
                </td>
            </tr>
		</table>
     </td>
  </tr>
</table>
<div class="printButton" align="center">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br /><br />
    </td></tr></table>
</div>
</body>
</html>
