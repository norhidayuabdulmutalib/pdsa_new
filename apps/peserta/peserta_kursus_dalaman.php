					<?php 
                    //$conn->debug=true;	
                    $_SESSION['ingenid'] = $rs->fields['id_peserta'];
                    $sSQLD="SELECT B.startdate, B.enddate, C.coursename, C.courseid, A.* 
                    FROM _tbl_kursus_jadual_peserta A, _tbl_kursus_jadual B, _tbl_kursus C 
                    WHERE A.EventId=B.id AND B.courseid=C.id AND A.is_deleted=0 
                    AND B.startdate<".tosql(date("Y=m-d"))." AND A.peserta_icno=".tosql($f_peserta_noic,"Text");
                    $sSQLD .= " ORDER BY B.startdate DESC";
                    $rsDataD = &$conn->Execute($sSQLD);
                    $cnt = $rsDataD->recordcount();
                    //print $sSQLD."<br>".$cnt; 
					?>
                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3">MAKLUMAT KURSUS DALAMAN YANG TELAH DIAMBIL</td>
	                          <td colspan="3" align="right"><!--<? $new_page = "modal_form.php?win=".base64_encode('peserta/_akademik_form.php;'.$rs->fields['id_peserta']);?>
					        	<input type="button" value="Tambah Maklumat Kursus Dalaman" style="cursor:pointer" 
                                onclick="open_modal('<?=$new_page;?>','Penambahan Maklumat Akademik',700,400)"  />--> &nbsp;&nbsp;</td>
						</tr>
                </table>
                <table width="100%" cellpadding="4" cellspacing="0" border="1">
                    	<tr class="title" >
                        	<td width="5%" align="center">Bil</td>
                            <td width="50%" align="center">Nama Kursus</td>
                            <td width="10%" align="center">Tempat Kursus</td>
                            <td width="10%" align="center">Tarikh Mula</td>
                            <td width="10%" align="center">Tarikh Tamat</td>
                            <td width="15%" align="center">Status Kehadiran</td>
                        </tr>
						<?php
						if(!$rsDataD->EOF) {
						$cnt = 1;
						$bil = 1;
						while(!$rsDataD->EOF) {
							//$href_link = "modal_form.php?win=".base64_encode('peserta/_akademik_form.php;'.$rsDataD->fields['id_peserta']);
							//$del_href_link = "modal_form.php?win=".base64_encode('peserta/_akademik_del.php;'.$rsDataD->fields['id_peserta']);
							$del_href_kursus = "modal_form.php?win=".base64_encode('peserta/_kursus_del.php;'.$rsDataD->fields['id_peserta']);
							$bilik_kuliah='ILIM';
						?>
                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				<td valign="top" align="left"><?=$rsDataD->fields['coursename'];?>&nbsp;</td>
            				<td valign="top" align="center"><?=$bilik_kuliah?>&nbsp;</td>
            				<td valign="top" align="center"><?= DisplayDate($rsDataD->fields['startdate']);?>&nbsp;</td>
                            <td valign="top" align="center"><?= DisplayDate($rsDataD->fields['enddate']);?>&nbsp;</td>
                            <td align="center">
							<?php
                            	if($rsDataD->fields['InternalStudentAccepted']=='0'){ print 'Tiada pengesahan'; }
                            	else if($rsDataD->fields['InternalStudentAccepted']=='1'){ print 'Hadir'; }
                            	else if($rsDataD->fields['InternalStudentAccepted']=='2'){ 
									print '<font color="#FF0000">Tidak Hadir</font>'; 
									print "<br><i>".$rs2->fields['InternalStudentReason']."</i>";
								}
							?>
                            <?php if($rsDataD->fields['InternalStudentAccepted']<>'1'){ ?>
                            <?php if($ty=='PE'){ $btn = '../../img/delete_btn1.jpg'; } else { $btn = '../img/delete_btn1.jpg'; }?>
				
                            <img src="<?=$btn;?>" width="25" height="25" style="cursor:pointer" title="Sila klik untuk hapus data" 
                                onclick="open_modal('<?=$del_href_kursus;?>&idp=<?=$rsDataD->fields['InternalStudentId'];?>','Hapus Data',700,400)" /> 
                            <?php } ?>
                            </td>
                        </tr>
                        <?
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rsDataD->movenext();
                    } 
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                <? } ?> 
                    </table>
