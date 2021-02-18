<link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="../modalwindow/modal.js"></script>
<script language="javascript" type="text/javascript">	
function open_modal1(URL,title,width,height){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
} //End "opennewsletter" function
function open_win(URL){
	window.open(URL);
}
</script>
<?php
$href_link_add = "modal_form.php?win=".base64_encode('kursus/kursus_form_add.php;'.$kid);
$sql_det = "SELECT * FROM _tbl_kursus_det WHERE kursus_id=".tosql($kid,"Number");
$rs_det = $conn->execute($sql_det);
$bil=0;

?>
               <table width="98%" cellpadding="4" cellspacing="0" border="1" align="center">
                	<tr bgcolor="#CCCCCC"><td colspan="5"><b>Senarai maklumat modul dan maklumat tambahan bagi kursus : </b></td></tr>

                    <tr bgcolor="#CCCCCC">
                        <td width="5%" align="center"><b>Bil</b></td>
                        <td width="55%" align="center"><b>Maklumat</b></td>
                        <td width="20%" align="center"><b>Jenis</b></td>
                        <td width="10%" align="center"><b>Status</b></td>
                        <td width="10%" align="center">&nbsp;</td>
                    </tr>
                    <?php while(!$rs_det->EOF){ $bil++; 
						if($rs_det->fields['jenis']='Nota'){ $jenis='Nota Kursus'; } else { $jenis='Modul'; }
						
					?>
                    <tr>
                    	<td align="right" valign="top"><?php print $bil;?>.&nbsp;</td>
                        <td align="left" valign="top"><?php print $rs_det->fields['maklumat'];?>&nbsp;
                        <?php if(!empty($rs_det->fields['file_name'])){ ?><br>-->
                        <a href="#" onClick="open_win('all_pic/open_files.php?id=<?=$rs_det->fields['id_kur_det'];?>')" title="Sila klik untuk muat-turun dokumen"><?php print $rs_det->fields['file_name'];?></a>
						<br />http://itis.islam.gov.my/apps/all_pic/open_files.php?id=<?=$rs_det->fields['id_kur_det'];?>
    					<? } else { ?><br />(Tiada dokumen)<?php } ?>
                        </td>
                        <td align="center"><?php print $jenis;?>&nbsp;</td>
                        <td align="center"><?php if($rs_det->fields['status']=='1'){ print 'Aktif'; } else { print '<font color="red">Tidak Aktif</font>'; }?>&nbsp;</td>
                        <td align="center">
                        	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal1('<?=$href_link_add;?>&id_kur_det=<?=$rs_det->fields['id_kur_det'];?>','Kemaskini Maklumat Dokumen',1,1)" />
                            &nbsp;
                        	<img src="../img/delete_btn1.jpg" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" 
                                onclick="open_modal1('<?=$href_link_add;?>&id_kur_det=<?=$rs_det->fields['id_kur_det'];?>&pro=DELETE','Hapus Maklumat Dokumen',200,200)" /></td>
                    </tr>
                    <?php $rs_det->movenext(); } ?>
					<tr>
                    	<td colspan="5" align="right">
                        	<?php //if($btn_display==1){ ?>
                        	<input type="button" value="Tambah Maklumat Kursus" style="cursor:pointer" 
                            onclick="open_modal1('<?php print $href_link_add;?>','Penambahan Maklumat Jadual Kursus',70,70)" />
                            <?php //} ?>
                        	<?php if($bil>=1){ ?>
                        	<a href="qrcode/test.php?kid=<?=$kid;?>" target="_blank"><input type="button" value="Proses QR Code" style="cursor:pointer" /></a>
                            <?php } ?>
                            
                        </td>
                    </tr>
                </table>
