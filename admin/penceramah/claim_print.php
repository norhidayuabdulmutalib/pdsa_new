<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$ruri = $_SERVER['REQUEST_URI'];
$URLs = $uri[1];
$proses = $_POST['proses'];
$ty = $_GET['ty'];
//print_r($uri);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css" media="all">@import"file:///C|/xampp/htdocs/ilim/css/print_style.css";</style>
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
<script language="javascript" type="text/javascript">
function handleprint(){
	window.print();
}
function form_back(){
	parent.emailwindow.hide();
}
</script>
</head>
<body>
<?
//$conn->debug=true;
function dlookupList($Table, $fName, $sWhere, $sOrder){
	$sSQL = "SELECT " . $fName . " FROM " . $Table . " " . $sWhere . " ORDER BY ". $sOrder;
	$result = mysql_query($sSQL);
	if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit();}
	$intRecCount = mysql_num_rows($result);
	if($intRecCount > 0){  
		return $result;
	} else {
		return "";
	}
}
$PageNo = $_POST['PageNo'];
$sSQL="SELECT * FROM _tbl_claim  WHERE cl_id= ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
$ingid = $rs->fields['cl_ins_id'];
?>
<form name="ilim" id="frm" method="post">
<table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
    <tr>
    	<td colspan="2" height="30" align="center"><b>BORANG PERMOHONAN UNTUK MENJALANKAN TUGAS<BR />
        SEBAGAI PENSYARAH/PENCERAMAH SAMBILAN ATAU<BR />
        PENSYARAH/PENCERAMAH SAMBILAN PAKAR<BR />BAGI 
        BULAN <label style="border-bottom:thin;border-bottom-style:dotted"><?php print month($rs->fields['cl_month']);?></label> 
        TAHUN <label style="border-bottom:thin;border-bottom-style:dotted"><?php print $rs->fields['cl_year'];?></label> </b></td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
           <tr>
                <td colspan="3" height="80" valign="top">Kepada</td>
           </tr>
           <tr>
                <td colspan="3" height="30">Kementerian/Jabatan/Agensi Penganjur</td>
           </tr>
            <tr>
                <td colspan="3">
                	<table width="99%" cellpadding="3" cellspacing="0" border="1" align="center">
                        <tr>
                          <td width="14%">Kod Jabatan</td>
                          <td width="48%"><?php print $rs->fields['cl_depcd'];?></td>
                          <td width="16%">Kod Pejabat Perakaunan</td>
                          <td width="22%"><?php print $rs->fields['cl_accoffcd'];?></td>
                  </tr>
                  <tr>
                        <td>PTJ</td>
                        <td><?php print $rs->fields['cl_ptjdesc'];?></td>
                        <td>Kod PTJ</td>
                        <td><?php print $rs->fields['cl_ptjcd'];?></td>
                  </tr>
                   <tr>
                     <td>Pusat Pembayaran</td>
                     <td><?php print $rs->fields['cl_payctrdesc'];?></td>
                     <td>Kod Pusat Pembayaran</td>
                     <td><?php print $rs->fields['cl_payctrcd'];?></td>
                   </tr>
                   <tr>
                     <td>Cawangan</td>
                     <td><?php print $rs->fields['cl_brchdesc'];?></td>
                     <td>Kod Cawangan</td>
                     <td><?php print $rs->fields['cl_brchcd'];?></td>
                   </tr>
                   <tr>
                     <td>Jenis Dok. Asal</td>
                     <td><?php print $rs->fields['cl_doctype'];?></td>
                     <td>No. Rujukan Dok. Asal</td>
                     <td><?php print $rs->fields['cl_docno'];?></td>
                   </tr>
              </table>              
              </td>
            </tr>
            <tr>

                <td colspan="3" height="30"><br /><br />BAHAGIAN 1<br />A. BUTIR-BUTIR PERIBADI</td>
            </tr>
			<?php
				$sqlinst = "SELECT * FROM _tbl_instructor WHERE ingenid=".tosql($ingid);
				$rs_inst = $conn->execute($sqlinst);
			?>

            <tr>

                <td width="30%">1. Nama Penuh : </td>

                <td width="80%" colspan="3" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs_inst->fields['insname'];?></td>
            </tr>

            <tr>
              <td>2. No. K/P : </td>
              <td colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs_inst->fields['insid'];?></td>
            </tr>
            <tr>
              <td>3. Gred / Jawatan Yang Disandang :</td>
            <td colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs_inst->fields['titlegredcd'];?></td>
            </tr>
            

            <tr>
              <td>4. Taraf Jawatan : </td>
              <td colspan="2" style="border-bottom:thin;border-bottom-style:dotted;">
			  		<?php if($rs->fields['cl_tarafpost'] == '01'){ print 'TETAP'; } 
                    	else if($rs->fields['cl_tarafpost'] == '02'){ print 'SAMBILAN'; }
                    	else if($rs->fields['cl_tarafpost'] == '03'){ print 'KONTRAK'; }?>
              </td>
            </tr>
            <tr>
                <td width="30%">5. a) Gaji pokok : </td>
                <td width="80%" colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs->fields['cl_gaji'];?></td>
            </tr>
            <tr>
                <td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;b) Elaun Memangku (Jika ada) : </td>
              <td width="80%" colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs->fields['cl_elaun'];?></td>
            </tr>
            <tr>
                <td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;c. No. Gaji / Pekerja: </td>
                <td width="80%" colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs->fields['cl_gajino'];?></td>
            </tr>
            <tr>
                <td>6. Nama Bank : </td>
                <td colspan="3" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs->fields['cl_bank'];?></td>
            </tr>
            <tr>
                <td>7. Cawangan Bank : </td>
                <td colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs->fields['cl_bankbrch'];?></td>
            </tr>
            <tr>
                <td>8. No. Akaun Bank : </td>
                <td colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs->fields['cl_akaun'];?></td>
            </tr>
            <tr>
              <td>9. Nama Kementerian / Jabatan / Agensi : </td>
              <td colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print $rs->fields['cl_orgdesc'];?></td>
            </tr>
            <tr>
              <td valign="top">10. Alamat Kementerian / Jabatan / Agensi : </td>
              <td colspan="2" style="border-bottom:thin;border-bottom-style:dotted;"><?php print nl2br($rs->fields['cl_orgadd']);?></td>
            </tr>
		</table>
      </td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">

            <tr>
                <td colspan="3" height="30">B. BUTIR-BUTIR PERMOHONAN</td>
            </tr>
            <tr>
                <td colspan="3">
                <table width="100%" cellpadding="3" cellspacing="0" border="1">
                    	<tr >
	                       	<td width="4%">Bil</td>
                            <td width="40%" align="center">Nama Jabatan Yang Menganjurkan Kursus/Ceramah</td>
                            <td width="20%" align="center">Tarikh Kursus / Ceramah</td>
                            <td width="10%" align="center">Tempoh (Dalam jam)</td>
                            <td width="10%" align="center">Jumlah Tuntutan (RM)</td>
                        </tr>
                        <?php 
						if(!empty($id)) {	
								$_SESSION['cl_id'] = $id;
								$payperhour = dlookup("_tbl_instructor", "payperhours", " ingenid = ".tosql($ingid));
								$sSQL2="SELECT * FROM _tbl_claim_event WHERE cl_id = ".tosql($id,"number");
								$sSQL2 .= " ORDER BY cl_eve_startdate";
								$rs2 = &$conn->Execute($sSQL2);
								$cnt = $rs2->recordcount();
						 if(!$rs2->EOF) {
							$cnt = 1;
							$bil = 1;
							$sum = 0;
							while(!$rs2->EOF) {
								$pay = $rs2->fields['cl_eve_tempoh']*$payperhour;
								$sum += $pay;
						?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=dlookup("_tbl_kursus", "coursename", " id = ".tosql($rs2->fields['cl_eve_course_id']))?>&nbsp;</td>
            				<td valign="top" align="center"><?php echo DisplayDate($rs2->fields['cl_eve_startdate'])." - ".DisplayDate($rs2->fields['cl_eve_enddate']);?>&nbsp;</td>
            				<td valign="top" align="center"><?=$rs2->fields['cl_eve_tempoh']?>&nbsp;</td>
                            <td valign="top" align="right"><?php echo number_format($pay,2); ?>&nbsp;</td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                    }  ?>
					   <tr>
	                       	 <td colspan="4" align="right">Jumlah Besar &nbsp;(RM)&nbsp;</td>
                             <td align="right"><?php print number_format($sum,2);?>&nbsp;</td>
                        </tr>
				<?
                } else {
                ?>
                <tr><td colspan="10" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } } ?> 
                  </table>
                </td>
            </tr>
            <tr>
              <td colspan="3">
              	<table width=" 100%" cellpadding="4" cellspacing="0" border="0">
                	<tr>
                    	<td width="2%" valign="top">2.</td>
                        <td width="5%" align="center" valign="top">(a)</td>
                        <td width="93%">Jumlah besar tuntutan bulanan di para 1 di atas adalah selaras dengan kelayakan saya seperti di perenggan 4.1.2 (iv) atau
                         (v) dalam Pekeliling Perbendaharaan Bil 5/95.</td>
                     </tr>
                     <tr><td height="40px" colspan="3" align="center"><b>ATAU</b></td></tr>
                     <tr>
                     	<td>&nbsp;
                     	<td align="center" valign="top">(b)</td>
                        <td>Jumlah besar tuntutan bulanan di para 1 di atas adalah melebihi kelayakan saya seperti di tetapkan di perenggan 4.1.2 (iv) atau (v) 
                        dalam Pekeliling Perbendaharaan Bil 5/95 dan saya telah memulangkan balik lebihan bayaran saguhati yang diterima sebanyak 
                        RM ........................ kepada Kementerian / Jabatan / Agensi ......................................................................
                        seperti surat yang disertakan daripada kementerian / Jabatan / Agensi .................................................................
                        Bil .......................................... Bertarikh ........................................</td>
                     
                     </tr>
                </table>
              </td>
            </tr>
        </table>
      </td>
   </tr>
   <tr><td colspan="2" height="40px">&nbsp;</td></tr>
   	<tr><td colspan="2">
    	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
            <tr>
                <td colspan="3" height="30">C. PERAKUAN</td>
            </tr>
            <tr><td colspan="3">Saya mengaku butir-butir yang dinyatakan di atas adalah benar.</td></tr>
            <tr><td height="60px">&nbsp;</td></tr>
            <tr>
            	<td valign="top" width="40%">Tarikh : ..................................</td>
                <td width="20%">&nbsp;</td>
                <td valign="top" width="40%">.................................................................<br />
                Tandatangan Pemohon<br /><br />
                Nama : ......................................................</td>
            </tr>
		</table>
    </td></tr>
</table>

<table width="100%" cellpadding="5" cellspacing="0" border="0">
	<tr>
    	<td colspan="4">BAHAGIAN II</td>
    </tr>
    <tr>
    	<td valign="top" width="5%">A.</td>
        <td width="35%">Ulasan Ketua Jabatan</td>
        <td width="20%">&nbsp;</td>
        <td width="40%" align="center">&nbsp;</td>
    </tr>
    <tr>
    	<td valign="top" ></td>
        <td>Tarikh : .....................................</td>
        <td>&nbsp;</td>
        <td align="left">.........................................................<br />Tandatangan Ketua Jabatan</td>
    </tr>
    <tr>
    	<td valign="top" ></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" style="line-height:30px">
        	Nama : ......................................................<br  />
        	Jawatan : ...................................................<br />
            Cop Jabatan : ...............................................
        </td>
    </tr>
    <tr>
    	<td valign="top" >B.</td>
        <td colspan="3">Pengesahan Ketua Jabatan<br /><br />
        Disahkan bahawa pegawai ini adalah seorang Pensyarah  / Penceramah Sambilan / GOlongan Pakar (*)<br /><br /></td>
    </tr>
    <tr>
    	<td valign="top" ></td>
        <td>Tarikh : .....................................</td>
        <td>&nbsp;</td>
        <td align="left">.........................................................<br />Tandatangan Ketua Jabatan</td>
    </tr>
    <tr>
    	<td valign="top" ></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" style="line-height:30px">
        	Nama : ......................................................<br  />
        	Jawatan : ...................................................<br />
            Cop Jabatan : ...............................................
        </td>
    </tr>
    <tr>
    	<td valign="top" >&nbsp;</td>
        <td colspan="3">(*) Potong yang mana tidak berkenaan</td>
    </tr>
</table>
<br /><br />
<table width="100%" cellpadding="5" cellspacing="0" border="0">
	<tr>
    	<td colspan="4">BAHAGIAN III</td>
    </tr>
    <tr>
    	<td valign="top" width="5%">1.</td>
        <td width="35%">Keputusan Permohonan</td>
        <td width="20%">&nbsp;</td>
        <td width="40%" align="center">&nbsp;</td>
    </tr>
    <tr>
    	<td valign="top" ></td>
        <td>Diluluskan / Tidak Diluluskan</td>
        <td>&nbsp;</td>
        <td align="left">&nbsp;</td>
    </tr>
    <tr>
    	<td valign="top" ></td>
        <td>Tarikh : .....................................</td>
        <td>&nbsp;</td>
        <td align="left">.........................................................<br />Tandatangan Ketua Jabatan</td>
    </tr>
    <tr>
    	<td valign="top" ></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left" style="line-height:30px">
        	Nama : ......................................................<br  />
        	Jawatan : ...................................................<br />
            Cop Jabatan : ...............................................
        </td>
    </tr>
    <tr>
    	<td valign="top" >&nbsp;</td>
        <td colspan="3">(*) Potong yang mana tidak berkenaan</td>
    </tr>
</table>
</form>
<div class="printButton" align="center">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="form_back()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br /><br />
    </td></tr></table>
</div>
</body>
</html>