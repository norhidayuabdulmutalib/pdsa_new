<script LANGUAGE="JavaScript">


</script>

<?

//$conn->debug=true;





$PageNo = $_POST['PageNo'];


	$sSQL="SELECT * FROM _tbl_claim  WHERE cl_id= ".tosql($id,"Text");
	

$rs = &$conn->Execute($sSQL);

$gred = dlookup("_tbl_instructor", "titlegredcd", " ingenid = ".$_SESSION['ingenid']);

?>



<table width="95%" align="center" cellpadding="1" cellspacing="0" border="0">

  <tr>

    	<td colspan="2" height="30">&nbsp;
   	    <div align="center"><b>BORANG PERMOHONAN UNTUK MENJALANKAN TUGAS </b></div>
        <div align="center"><b>SEBAGAI PENSYARAH / PENCERAMAH SAMBILAN ATAU </b></div>
        <div align="center"><b>PENSYARAH / PENCERAMAH SAMBILAN PAKAR</b></div>
        <div align="center"><b>BAGI BULAN <?=dlookup("ref_month", "desc_mal", " id_month = ".$rs->fields['cl_month'])?> TAHUN <?=$cl_year?></b></div>
        <div align="center">(Diisi dalam 2 Salinan)</div></td>

  </tr>
    
    <tr>

    	<td colspan="2" height="30">&nbsp;
   	    <div align="left">Kepada,</div>
    </td>

    </tr>
    
    <tr>

    	<td colspan="2" height="80">&nbsp;</td>
    </tr>

	<tr><td colspan="2">
        
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="0">

            <tr>

                <td height="40" colspan="3" valign="top" class="title"><b>Kementerian / Jabatan / Agensi Penganjur</b></td>
          </tr>
            <tr>

                <td colspan="3"><table width="80%" cellpadding="3" cellspacing="0" border="1" align="center">
<tr>
                               <td width="12%">Jabatan</td>
                               <td width="12%"><? print $rs->fields['cl_depcd'];?></td>
                               <td width="14%">PTJ</td>
                               <td width="12%"><? print $rs->fields['cl_ptjcd'];?></td>
                               <td width="16%">No. Rujukan Dok. Asal</td>
                               <td width="18%"><? print $rs->fields['cl_docno'];?></td>
                  <td width="16%">Jenis Dok. Asal</td>
</tr>
                           <tr>
                             <td colspan="2">Pejabat Perakaunan                             </td>
                             <td colspan="2"><? print $rs->fields['cl_accoffcd'];?>&nbsp;</td>
                               <td>No. Gaji</td>
                               <td><? print $rs->fields['cl_gajino'];?>&nbsp;</td>
                               <td><? print $rs->fields['cl_doctype'];?></td>
                  </tr>
                           <tr>
                             <td colspan="2">Pusat Pembayaran</td>
                             <td colspan="2"><? print $rs->fields['cl_payctrcd'];?></td>
                             <td>Bulan</td>
                             <td><?=dlookup("ref_month", "desc_mal", " id_month = ".$rs->fields['cl_month'])?>&nbsp;</td>
                             <td>&nbsp;</td>
                           </tr>
                           <tr>
                             <td colspan="2">Cawangan</td>
                             <td colspan="2"><? print $rs->fields['cl_brchcd'];?>&nbsp;</td>
                             <td>Tahun</td>
                             <td><?=$cl_year?>&nbsp;</td>
                             <td>&nbsp;</td>
                           </tr>
                           

              </table>              </td>
            </tr>
            <tr>

                <td colspan="3" class="title" height="30"><b>BAHAGIAN I <br /> 
                A.&nbsp;&nbsp;&nbsp;BUTIR-BUTIR PERIBADI</b></td>
            </tr>


            <tr>

                <td width="7%" height="40">&nbsp;&nbsp;&nbsp;1.</td>

                <td width="93%" colspan="3">Nama  :
  <?=dlookup("_tbl_instructor", "insname", " ingenid = ".$_SESSION['ingenid'])?></td>
          </tr>

            <tr>
              <td height="40">&nbsp;&nbsp;&nbsp;2.</td>
              <td colspan="2">No. Kad Pengenalan :
  <?=dlookup("_tbl_instructor", "insid", " ingenid = ".$_SESSION['ingenid'])?>                </td>
          </tr>
            <tr>
              <td height="40">&nbsp;&nbsp;&nbsp;3.</td>
            <td colspan="2">Jawatan Yang Disandang : <?=dlookup("_ref_titlegred", "f_gred_name", " f_gred_code = '".$gred."'")?></td> 
            </tr>
            

            <tr>
              <td height="40">&nbsp;&nbsp;&nbsp;4.</td>
              <td colspan="2">Gred :
                <?=$gred?></td>
            </tr>
            <tr>
              <td height="40">&nbsp;&nbsp;&nbsp;5.</td>
              <td colspan="2">Taraf Jawatan : 
                  					<?php if($rs->fields['cl_tarafpost'] == '01') echo "TETAP"; ?> 
                                   <?php if($rs->fields['cl_tarafpost'] == '02') echo "SAMBILAN"; ?> 
                                    <?php if($rs->fields['cl_tarafpost'] == '03') echo "KONTRAK"; ?>               				             </td>
            </tr>
            

            <tr>

                <td width="7%" height="40">&nbsp;&nbsp;&nbsp;6.</td>

                <td width="93%" colspan="2">a)&nbsp;&nbsp;&nbsp;Gaji pokok : <? print $rs->fields['cl_gaji'];?></td>
            </tr>

            <tr>

                <td width="7%" height="40">&nbsp;&nbsp;</td>

                <td width="93%" colspan="2">b)&nbsp;&nbsp;&nbsp;Elaun Memangku (Jika ada) : <? print $rs->fields['cl_elaun'];?></td>
            </tr>

            <tr>

                <td width="7%" height="40">&nbsp;&nbsp;&nbsp;</td>

                <td width="93%" colspan="2">c)&nbsp;&nbsp;&nbsp;No. Gaji / Pekerja : <? print $rs->fields['cl_gajino'];?></td>
            </tr>




            <tr>

                <td height="40">&nbsp;&nbsp;&nbsp;7.</td>

                <td colspan="3">Nama Bank dan Cawangan:
                <? print $rs->fields['cl_bank'];?>&nbsp;<? print $rs->fields['cl_bankbrch'];?></td>
            </tr>

            <tr>

                <td height="40">&nbsp;&nbsp;&nbsp;8.</td>

                <td colspan="2">No. Akaun Bank : <? print $rs->fields['cl_akaun'];?></td>
            </tr>
            <tr>
              <td height="40">&nbsp;&nbsp;&nbsp;9.</td>
              <td colspan="2">Nama Kementerian / Jabatan / Agensi :
<? print $rs->fields['cl_orgdesc'];?></td>
            </tr>
            <tr>
              <td height="40" valign="top">&nbsp;&nbsp;&nbsp;10.</td>
              <td colspan="2">Alamat Kementerian / Jabatan / Agensi :
<? print $rs->fields['cl_orgadd'];?></td>
            </tr>

            <tr>
              <td colspan="3" class="title" height="104">&nbsp;</td>
            </tr>
        </table>

      </td>

   </tr>

</table>



<table width="95%" cellpadding="3" cellspacing="0" border="0" align="center">
  <tr>
    <td width="7%" class="title"><b>B.&nbsp;</b></td>
    <td width="93%" height="30" class="title"><b>BUTIR - BUTIR PERMOHONAN</b></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;&nbsp;&nbsp;1.</td>
    <td><table width="95%" cellpadding="3" cellspacing="0" border="0">
      <tr class="title" >
        <td width="4%">Bil</td>
        <td width="31%">Nama Jabatan yg menganjurkan kursus / ceramah</td>
        <td width="17%" align="center">Tarikh kursus / ceramah</td>
        <td width="13%" align="center">Tempoh (Dalam jam)</td>
        <td width="15%" align="center">Jumlah Tuntutan</td>
        </tr>
      <?php 
						
						if(!empty($id)) {	

								$_SESSION['cl_id'] = $id;
								
								$payperhour = dlookup("_tbl_instructor", "payperhours", " ingenid = ".$_SESSION['ingenid']);

								$sSQL2="SELECT * FROM _tbl_claim_event WHERE cl_id = ".tosql($id,"number");

								$sSQL2 .= " ORDER BY cl_eve_startdate";

								$rs2 = &$conn->Execute($sSQL2);

								$cnt = $rs2->recordcount();

					

						 if(!$rs2->EOF) {

						$cnt = 1;

						$bil = 1;
						
						$sum = 0;

						while(!$rs2->EOF) {

							$href_link = "modal_form.php?win=".base64_encode('penceramah/_claim_event_form.php;'.$rs2->fields['cl_eve_id']);

							$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_claim_event_del.php;'.$rs2->fields['cl_eve_id']);
							
							$pay = $rs2->fields['cl_eve_tempoh']*$payperhour;
							
							$sum += $pay;

						?>
      <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
        <td valign="top" align="right"><?=$bil;?>
          .</td>
        <td valign="top" align="left"><?=dlookup("_tbl_kursus", "coursename", " id = ".$rs2->fields['cl_eve_course_id'])?>
          &nbsp;</td>
        <td valign="top" align="left"><? echo DisplayDate($rs2->fields['cl_eve_startdate'])." - ".DisplayDate($rs2->fields['cl_eve_enddate']);?>&nbsp;</td>
        <td valign="top" align="left"><?=$rs2->fields['cl_eve_tempoh']?>
          &nbsp;</td>
        <td valign="top" align="center"><? echo $pay; ?>&nbsp;</td>
        </tr>
      <?

                        $cnt = $cnt + 1;

                        $bil = $bil + 1;

                        $rs2->movenext();

                    }  ?>
      <tr class="title" >
        <td colspan="4" align="right">Jumlah Besar&nbsp;</td>
        <td width="15%" align="center"><?=$sum?>
          &nbsp;</td>
        </tr>
      <?

                } else {

                ?>
      <? } } ?>
    </table></td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;&nbsp;&nbsp;2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(a)</td>
    <td>Jumlah besar tuntutan bulanan di para 1 di atas adalah selaras dengan kelayakan saya seperti ditetapkan di <br />
    perenggan 4.1.2 (iv) atau (v) dalam Pekeliling Perbendaharaan Bil 5/95</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td height="50" align="center" valign="middle"><strong>Atau</strong></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b)</td>
    <td>Jumlah besar tuntutan bulanan di para 1 di atas adalah melebihi kelayakan saya seperti ditetapkan di <br />
      perenggan 4.1.2 (iv) atau (v) dalam Pekeliling Perbendaharaan Bil 5/95 dan saya telah memulangkan balik <br />
      lebihan bayaran saguhati yang diterima tersebut sebanyak RM ................................... kepada Kementerian / <br />
      Jabatan / Agensi ................................................................................................... <br />
      seperti surat yang disertakan daripada Kementerian / Jabatan / Agensi .............................................. <br />
      ....................................................................................................................<br />
      Bil ..................................Bertarikh ....................................
      </td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="95%" cellpadding="3" cellspacing="0" border="0" align="center">
  <tr>
    <td width="7%" class="title"><b>C.&nbsp;</b></td>
    <td width="93%" height="30" class="title"><b>PERAKUAN</b></td>
  </tr>
  
  <tr>
    <td height="40" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>Saya mengaku butir-butir yang dinyatakan di atas adalah benar.</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td height="60" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="62%">Tarikh : ............................................................ </td>
          <td width="38%" align="left" valign="top">
            <p>&nbsp;</p>
            <p>..............................................................................................<br />
              Tandatangan Pemohon</p>
          <p>Nama : ...................................................................................         </p></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;&nbsp;&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="95%" cellpadding="3" cellspacing="0" border="0" align="center">
  <tr>
    <td height="47" colspan="2" class="title"><strong>BAHAGIAN II</strong></td>
  </tr>
  <tr>
    <td width="7%" class="title">A.&nbsp;</td>
    <td width="93%" height="30" class="title">Ulasan Ketua Jabatan</td>
  </tr>
  <tr>
    <td height="40" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td valign="top">&nbsp;</td>
    <td height="60" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="62%" valign="top"><p>&nbsp;</p>
          <p>Tarikh : ............................................................ </p></td>
        <td width="38%" align="center" valign="top"><p>&nbsp;</p>
              <p>..............................................................................................<br />
                ( Tandatangan Ketua Jabatan )</p>
          <p>Nama : ................................................................................... </p>
          <p>Jawatan : ................................................................................</p>
          <p>Cop jabatan  :...........................................................................</p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="50" valign="top">&nbsp;&nbsp;&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="title">B.&nbsp;</td>
    <td height="30" class="title">Pengesahan Ketua Jabatan</td>
  </tr>
  <tr>
    <td height="40" valign="top">&nbsp;</td>
    <td><p>Disahkan bahawa pegawai ini adalah seorang Pensyarah / Penceramah sambilan / Golongan Pakar *</p>
    </td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td height="60" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="62%" valign="top"><p>&nbsp;</p>
              <p>Tarikh : ............................................................ </p></td>
          <td width="38%" align="center" valign="top"><p>&nbsp;</p>
              <p>..............................................................................................<br />
                ( Tandatangan Ketua Jabatan )</p>
            <p>Nama : ................................................................................... </p>
            <p>Jawatan : ................................................................................</p>
            <p>Cop jabatan  :...........................................................................</p></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td height="50" valign="bottom">* Potong yang mana tidak berkenaan</td>
  </tr>
  <tr>
    <td height="44" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="95%" cellpadding="3" cellspacing="0" border="0" align="center">
  <tr>
    <td height="47" colspan="2" class="title"><strong>BAHAGIAN III</strong></td>
  </tr>
  <tr>
    <td width="7%" class="title">1.&nbsp;</td>
    <td width="93%" height="30" class="title">Keputusan Permohonan</td>
  </tr>
  <tr>
    <td height="40" valign="top">&nbsp;</td>
    <td>Diluluskan / Tidak Diluluskan *</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td height="60" align="left" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="62%" valign="top"><p>&nbsp;</p>
              <p>Tarikh : ............................................................ </p></td>
        <td width="38%" align="center" valign="top"><p>&nbsp;</p>
              <p>..............................................................................................<br />
                ( Tandatangan Ketua Jabatan )</p>
          <p>Nama : ................................................................................... </p>
          <p>Jawatan : ................................................................................</p>
          <p>Cop jabatan  :...........................................................................</p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td height="40">* Potong yang mana tidak berkenaan</td>
  </tr>
  <tr>
    <td height="44" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td height="40" colspan="4" align="right" valign="top" class="title">Lampiran 1</td>
  </tr>
  <tr>
    <td colspan="4" align="center"><p>&nbsp;</p>
    <p>Maklumat-maklumat yang perlu diisikan bagi kakitangan kerajaan yang menuntut elaun perkhidmatan latihan<br /> 
    kakitangan / pensyarah dan elaun peperiksaan / <br />ahli panel peperiksaan<br /> Jabatan</p>
    <hr size="3" noshade="noshade" />    
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td height="30" colspan="4" class="title">Maklumat-maklumat berikut perlu diisikan bagi pegawai-pegawai kerajaan di mana gajinya diproses oleh JANM Wilayah Persekutuan<br /> atau diproses oleh Jabatan mengakaun sendiri.</td>
  </tr>
  <tr>
    <td height="40">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="6%" height="40">&nbsp;&nbsp;&nbsp;1.</td>
    <td width="17%">Nama </td>
    <td width="77%" colspan="3">:
      <?=dlookup("_tbl_instructor", "insname", " ingenid = ".$_SESSION['ingenid'])?></td>
  </tr>
  <tr>
    <td height="40">&nbsp;&nbsp;&nbsp;2.</td>
    <td>No. Kad Pengenalan</td>
    <td colspan="2"> :
      <?=dlookup("_tbl_instructor", "insid", " ingenid = ".$_SESSION['ingenid'])?>    </td>
  </tr>
  <tr>
    <td height="40">&nbsp;&nbsp;&nbsp;3.</td>
    <td>Kod Jabatan</td>
    <td colspan="2">: <? print $rs->fields['cl_depcd'];?></td>
  </tr>
  <tr>
    <td height="40">&nbsp;&nbsp;&nbsp;4.</td>
    <td>Kod dan Nama PTJ</td>
    <td colspan="2">: <? print $rs->fields['cl_ptjcd'];?> / <? print $rs->fields['cl_ptjdesc'];?></td>
  </tr>
  <tr>
    <td height="40">&nbsp;&nbsp;&nbsp;5.</td>
    <td>Kod Pejabat Perakaunan</td>
    <td colspan="2">: <? print $rs->fields['cl_accoffcd'];?></td>
  </tr>
  <tr>
    <td width="6%" height="40">&nbsp;&nbsp;&nbsp;6.</td>
    <td width="17%">No. Gaji  : </td>
    <td width="77%" colspan="2">: <? print $rs->fields['cl_gajino'];?></td>
  </tr>
  <tr>
    <td width="6%" height="40">&nbsp;&nbsp;7.</td>
    <td width="17%">Nama dan Kod Pusat Pembayar</td>
    <td width="77%" colspan="2">: <? print $rs->fields['cl_payctrdesc'];?> / <? print $rs->fields['cl_payctrcd'];?></td>
  </tr>
  <tr>
    <td width="6%" height="40">&nbsp;&nbsp;8.&nbsp;</td>
    <td width="17%">Cawangan dan Kod Cawangan</td>
    <td width="77%" colspan="2">: <? print $rs->fields['cl_brchdesc'];?> / <? print $rs->fields['cl_brchcd'];?></td>
  </tr>
  <tr>
    <td height="40">&nbsp;&nbsp;9.</td>
    <td>Alamat Bank</td>
    <td colspan="3">: <? print $rs->fields['cl_bank'];?>&nbsp;<br />&nbsp;</td>
  </tr>
  <tr>
    <td height="40">&nbsp;10.</td>
    <td>No. Akaun</td>
    <td colspan="2">: <? print $rs->fields['cl_akaun'];?></td>
  </tr>
  <tr>
    <td height="40" colspan="4"><hr size="3" noshade="noshade" /></td>
  </tr>
  <tr>
    <td height="40" colspan="4"><p>Nota : Kecuali PTJ, semua maklumat tersebut boleh diperolehi daripada slip gaji bulanan yang dikeluarkan oleh majikan tuan / puan.<br />Bagi Kod PTJ, sila dapatkan dari Bahagian Kewangan / Akaun Jabatan tuan / puan.
    </p>    </td>
  </tr>
  <tr>
    <td height="40" colspan="4">Nota : Pembayaran tuntutan tidak akan diterima oleh pejabat jika butiran-butiran tersebut tidka dibekalkan sepenuhnya.</td>
  </tr>
</table>
