<!-- <link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script> -->
<!-- <script type="text/javascript" src="../modalwindow/modal.js"></script> -->
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
<!-- <div class="section-body">
    <div class="row">
        <div class="col-12"> -->
            <div class="card">
                <div class="card-header" >
                    <h4>Senarai maklumat modul dan maklumat tambahan bagi kursus : </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" align="center"><b>Bil</b></th>
                                    <th width="55%" align="center"><b>Maklumat</b></th>
                                    <th width="20%" align="center"><b>Jenis</b></th>
                                    <th width="10%" align="center"><b>Status</b></th>
                                    <th width="10%" align="center"><b>Tindakan</b></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while(!$rs_det->EOF){ $bil++; 
                                    if($rs_det->fields['jenis']='Nota'){ $jenis='Nota Kursus'; } else { $jenis='Modul'; }
                                    
                                ?>
                                <tr>
                                    <td align="right" valign="top"><?php print $bil;?>.&nbsp;</td>
                                    <td align="left" valign="top"><?php print $rs_det->fields['maklumat'];?>&nbsp;
                                    <?php if(!empty($rs_det->fields['file_name'])){ ?><br>-->
                                    <a href="#" onClick="open_win('all_pic/open_files.php?id=<?=$rs_det->fields['id_kur_det'];?>')" title="Sila klik untuk muat-turun dokumen"><?php print $rs_det->fields['file_name'];?></a>
                                    <br />http://itis.islam.gov.my/apps/all_pic/open_files.php?id=<?=$rs_det->fields['id_kur_det'];?>
                                    <?php } else { ?><br />(Tiada dokumen)<?php } ?>
                                    </td>
                                    <td align="center"><?php print $jenis;?>&nbsp;</td>
                                    <td align="center"><?php if($rs_det->fields['status']=='1'){ print 'Aktif'; } else { print '<font color="red">Tidak Aktif</font>'; }?>&nbsp;</td>
                                    <td align="center">
                                        <button class="btn btn-warning" border="0" style="cursor:pointer;padding:8px;" title="Sila klik untuk pengemaskinian data" 
                                            onclick="open_modal1('<?=$href_link_add;?>&id_kur_det=<?=$rs_det->fields['id_kur_det'];?>','Kemaskini Maklumat Dokumen',1,1)" ><i class="fas fa-edit"></i></button>
                                        &nbsp;
                                        <button class="btn btn-danger" border="0" style="cursor:pointer;padding:8px;" title="Sila klik untuk penghapusan data" 
                                            onclick="open_modal1('<?=$href_link_add;?>&id_kur_det=<?=$rs_det->fields['id_kur_det'];?>&pro=DELETE','Hapus Maklumat Dokumen',200,200)"><i class="fas fa-trash"></i></button> 
                                    </td>
                                </tr>
                                <?php $rs_det->movenext(); } ?>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <div style="float:right">
                            <?php //if($btn_display==1){ ?>
                            <button type="button" class="btn btn-success" value="Tambah Maklumat Kursus" style="cursor:pointer" 
                            onclick="open_modal1('<?php print $href_link_add;?>','Penambahan Maklumat Jadual Kursus',70,70)" ><i class="fas fa-plus"></i><b> Tambah</b></button>
                            <?php //} ?>
                            <?php if($bil>=1){ ?>
                            <a href="qrcode/test.php?kid=<?=$kid;?>" target="_blank"><input type="button" value="Proses QR Code" style="cursor:pointer" /></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div>
    </div>
</div> -->
