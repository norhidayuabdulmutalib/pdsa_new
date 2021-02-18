				<table width="100%" cellpadding="3" cellspacing="0" border="0">
					<tr class="title" >
						<td colspan="3" align="right">
						<?php $new_page = "modal_form.php?win=".base64_encode('peserta/_akademik_form.php;'.$rs->fields['id_peserta']);?>

						<button class="btn btn-success" title="Sila klik untuk menyimpan maklumat peserta" 
							<?php if(empty($id)) {  
								print 'onclick="alert(\'Sila tekan SIMPAN dahulu sebelum menambah maklumat akademik!\')"'; 
								} else { 
								print 'onclick="open_modal(\''.$new_page.'\',\'Penambahan Maklumat Akademik\',700,400)"';  
							} ?>
						><i class="fas fa-plus"></i> Tambah Maklumat Akademik</button>
					</tr>
				</table>

				<br>

				<div class="table-responsive">
					<table class="table table-striped" id="table-1">
						<thead style="background-color:#f2f2f2;">
							<tr>
								<th width="5%"><strong>Bil</strong></th>
								<th width="25%"><strong>Kelulusan Akademik</strong></th>
								<th width="25%"><strong>Nama Kursus</strong></th>
								<th width="25%"><strong>Institusi Pengajian</strong></th>
								<th width="10%"><strong>Tahun</strong></th>
								<th width="10%">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
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
							<tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
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
							<?php
							$cnt = $cnt + 1;
							$bil = $bil + 1;
							$rs2->movenext();
						} 
						} else {
						?>
						<tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
						<?php } ?> 
						</tbody>
					</table>
				</div>
