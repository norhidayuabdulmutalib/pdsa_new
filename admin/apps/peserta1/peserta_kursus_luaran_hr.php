                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3">MAKLUMAT KURSUS LUARAN YANG TELAH DIAMBIL</td>
	                          <td colspan="3" align="right"><?php $new_page = "modal_form.php?win=".base64_encode('peserta/peserta_kursus_luaran_form.php;'.$rs->fields['id_peserta']);?>
					        	<input type="button" value="Tambah Maklumat Kursus Luaran" style="cursor:pointer" 
                                onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Kursus Luaran',700,400)"  /> &nbsp;&nbsp;</td>
						</tr>
                </table>
                <table width="100%" cellpadding="4" cellspacing="0" border="1">
                    	<tr class="title" >
                        	<td width="5%">Bil</td>
                            <td width="30%">Nama Kursus</td>
                            <td width="35%">Tempat Kursus<br><i>Anjuran</i></td>
                            <td width="10%">Tarikh Mula</td>
                            <td width="10%">Tarikh Tamat</td>
                            <td width="10%">&nbsp;</td>
                        </tr>
                        <?php 	
						$id_peserta = $rs->fields['id_peserta'];
						$sSQL2="SELECT * FROM _tbl_peserta_kursusluar WHERE id_peserta=".tosql($id_peserta,"Text");
						$sSQL2 .= " ORDER BY startdate DESC";
						$rs2 = &$conn->Execute($sSQL2);
						$cnt = $rs2->recordcount();
						//print $sSQL2;
						if(!$rs2->EOF) {
						$cnt = 1;
						$bil = 1;
						while(!$rs2->EOF) {
							$href_link = "modal_form.php?win=".base64_encode('peserta/peserta_kursus_luaran_form.php;'.$rs2->fields['id_peserta']);
							$del_href_link = "modal_form.php?win=".base64_encode('peserta/_peserta_kursus_luaran.php;'.$rs2->fields['id_peserta']);
						?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=$rs2->fields['nama_kursus'];?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['tempat_kursus']?><br /><i>Anjuran: <?=$rs2->fields['anjuran']?></i>&nbsp;</td>
            				<td valign="top" align="center"><?= DisplayDate($rs2->fields['startdate']);?>&nbsp;</td>
                            <td valign="top" align="center"><?= DisplayDate($rs2->fields['enddate']);?>&nbsp;</td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>&idp=<?=$rs2->fields['klp_id'];?>','Kemaskini Maklumat Kursus Luaran',700,400)" />
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" 
                                onclick="open_modal('<?=$del_href_link;?>&idp=<?=$rs2->fields['klp_id'];?>','Padam Maklumat Kursus Luaran',700,300)" />
                            </td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <?php } ?> 
                    </table>
