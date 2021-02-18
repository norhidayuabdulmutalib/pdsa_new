                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3">MAKLUMAT KELAYAKAN AKADEMIK</td>
	                          <td colspan="3" align="right">
							  <? $new_page = "modal_form.php?win=".base64_encode('peserta/_akademik_form.php;'.$rs->fields['id_peserta']);?>
					        	<!--<input type="button" value="Tambah Maklumat Akademik" style="cursor:pointer"
            					<?php if(empty($id)) { ?> 
                                	onclick="alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat akademik!')" 
								<?php } else { ?> onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Akademik',700,400)" <? } ?> />--> &nbsp;&nbsp;</td>
						</tr>
                </table>
                <table width="100%" cellpadding="4" cellspacing="0" border="1">
                    	<tr class="title" >
                        	<td width="5%">Bil</td>
                            <td width="25%">Kelulusan Akademik</td>
                            <td width="25%">Nama Kursus</td>
                            <td width="25%">Institusi Pengajian</td>
                            <td width="10%">Tahun</td>
                            <td width="10%">&nbsp;</td>
                        </tr>
                        <?php 	
						$_SESSION['ingenid'] = $rs->fields['id_peserta'];
						$sSQL2="SELECT * FROM _tbl_peserta_akademik WHERE id_peserta = ".tosql($rs->fields['id_peserta'],"Text");
						$sSQL2 .= " ORDER BY inaka_tahun DESC";
						$rs2 = &$conn->Execute($sSQL2);
						$cnt = $rs2->recordcount();
						if(!$rs2->EOF) {
						$cnt = 1;
						$bil = 1;
						while(!$rs2->EOF) {
							$href_link = "modal_form.php?win=".base64_encode('peserta/_akademik_form.php;'.$rs2->fields['id_peserta']);
							$del_href_link = "modal_form.php?win=".base64_encode('peserta/_akademik_del.php;'.$rs2->fields['id_peserta']);
						?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=dlookup("_ref_akademik", "f_akademik_nama", " f_akademik_id = ".$rs2->fields['inaka_sijil'])?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_kursus']?>&nbsp;</td>
            				<td valign="top" align="left"><?=$rs2->fields['inaka_institusi']?>&nbsp;</td>
                            <td valign="top" align="center"><?=$rs2->fields['inaka_tahun']?>&nbsp;</td>
                            <td align="center">
                            	<img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>&idp=<?=$rs2->fields['ingenid_akademik'];?>','Kemaskini Maklumat Akademik',700,400)" />
                            	<img src="../img/ico-cancel.gif" width="30" height="30" style="cursor:pointer" title="Sila klik untuk penghapusan data" 
                                onclick="open_modal('<?=$del_href_link;?>&idp=<?=$rs2->fields['ingenid_akademik'];?>','Padam Maklumat Akademik',700,300)" />
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
                <? } ?> 
                    </table>
