<script language="javascript" type="text/javascript">	
function upd_sijil(id,chk){
	var URL = 'kursus/kursus_cetakan_sijilupd.php?id='+id+'&chk='+chk;
	callToServer(URL);
	/*document.ilim.action=URL;
	document.ilim.target='_blank';
	document.ilim.submit();*/
	//document.GetElementById['print'].display=true;
}

function open_cetak(URL,title,width,height){
	var id_template = document.ilim.tsijil.value;
	if(id_template==''){ 
		alert('Sila pilih template sijil untuk cetakan');
	} else {
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL+ '&tsid='+id_template, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
	}
} //End "opennewsletter" function
function cetak_openModal(URL){
	var id_template = document.ilim.tsijil.value;
	if(id_template==''){ 
		alert('Sila pilih template sijil untuk cetakan');
	} else {
		var height=screen.height-150;
		var width=screen.width-100;
		
		var returnValue=window.showModalDialog(URL+'&tsid='+id_template,'I-TIS','help:no;status:yes;scroll:yes;resize:yes;toolbar=yes;dialogHeight:'+height+'px;dialogWidth:'+width+'px');
		//window.open(URL,'name','height=255,width=250,toolbar=yes,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
	}
} 


function do_papar(URL){
	var id_template = document.ilim.tsijil.value;
	if(id_template==''){ 
		alert('Sila pilih template sijil untuk cetakan');
	} else {
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL + '&tsid='+id_template, 'Template Cetakan Sijil', 'width=1px,height=1px,center=1,resize=1,scrolling=0')
	}
} //End "opennewsletter" function

</script>
<?php
//$conn->debug=true;
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.id AS CID, C.SubCategoryNm, D.startdate, D.enddate, A.kampus_id 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;

$href_link_add = "modal_form.php?win=".base64_encode('kursus/jadual_peserta_list.php;'.$id);
//$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Number");
$sql_det = "SELECT A.*, B.f_peserta_nama, B.BranchCd FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
WHERE A.InternalStudentAccepted= 1 AND A.is_selected=1 AND A.peserta_icno=B.f_peserta_noic AND A.EventId=".tosql($id);
$sql_det .= " GROUP BY A.peserta_icno ORDER BY B.f_peserta_nama";
$rs_det = $conn->execute($sql_det);
$jum_peserta = $rs_det->recordcount();
//print $sql_det;
$bils=0;
$kampus_id = $rs->fields['kampus_id'];
?>

<section class="section">
    <div class="card">
        <div class="card-header" >
            <!-- <h4>Carian Maklumat Kursus</h4> -->
        </div>
        <div class="card-body">

            <div class="form-group row mb-4">   
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kursus : </b></label>
                <div class="col-sm-12 col-md-7">
                    <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?>
                </div>
            </div>

            <div class="form-group row mb-4">   
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Kategori : </b></label>
                <div class="col-sm-12 col-md-7">
                    <?php print $rs->fields['categorytype'];?>
                </div>                
            </div>

            <div class="form-group row mb-4">   
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat : </b></label>
                <div class="col-sm-12 col-md-7">
                    <?php print dlookup("_tbl_kursus_catsub","SubCategoryDesc","id=".tosql($rs->fields['CID']));
                    //pusat_list($rs->fields['CID']); //$rs->fields['SubCategoryNm'];?>
                </div>                
            </div>

            <div class="form-group row mb-4">   
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tarikh Kursus : </b></label>
                <div class="col-sm-12 col-md-7">
                    <?php echo date('d-m-Y', strtotime($rs->fields['startdate'])) ?> - <?php echo date('d-m-Y', strtotime($rs->fields['enddate'])) ?>
                        <!-- <?php// print DisplayDate($rs->fields['startdate']);?> - <?php //print DisplayDate($rs->fields['enddate']);?></td>     -->
                </div>
            </div>

            <div class="form-group row mb-4">   
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Template : </b></label>
                <div class="col-sm-12 col-md-7">
                    <?php $sqlsijil = "SELECT * FROM _ref_template_sijil WHERE ref_ts_status=0 AND ref_ts_delete=0"; //$conn->debug=true;
                    $sqlsijil .= " AND kampus_id='{$kampus_id}' ";
                    $rstsijil = &$conn->Execute($sqlsijil); $bil=0;
                    ?>
                    <select class="form-control" name="tsijil">
                        <option value="">Sila pilih</option>
                        <?php while(!$rstsijil->EOF){ $bil++; ?>
                        <?php if(empty($rstsijil->fields['ref_tajuk_sijil'])){ ?>
                            <option value="<?php print $rstsijil->fields['ref_ts_id'];?>">Template : <?php print $bil;?></option>
                        <?php } else { ?>
                            <option value="<?php print $rstsijil->fields['ref_ts_id'];?>"><?php print $rstsijil->fields['ref_tajuk_sijil'];?></option>
                        <?php } ?>
                        <?php $rstsijil->movenext(); }?>
                    </select>
                    <div class="col-sm-12 col-md-2">
                        <input type="button" class="btn btn-warning" value="Papar" style="cursor:pointer" onclick="do_papar('kursus/ref_template_sijil_form1.php?id=<?=$id;?>&forms=cetak')" />
                    </div>
                </div>               
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Jumlah Peserta :</b></label>
                <div class="col-sm-12 col-md-4">
                    <?php print $jum_peserta;?> Orang Peserta               
                    <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>Peserta Hadir : </b>
                    <?php //print dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND EventId=".tosql($id));?> Orang Peserta-->
                </div>
                <div class="col-sm-12 col-md-5">
                    <b>Cetakan Sijil : </b>
                    <?php print dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND is_sijil=1 AND EventId=".tosql($id));?> Orang Peserta
                </div>
            </div>
            
            <div class="form-group row mb-4" style="float:right">
                <div>
                    <input type="button" class="btn btn-info" name="tutup" value="Cetak Sijil" style="cursor:pointer" 
                    onclick="open_cetak('kursus/kursus_cetakan_sijil.php?id=<?=$id;?>&idpeserta=','Cetak Sijil',1,1)" />
                    <input type="button" class="btn btn-secondary"  name="tutup" value="Tutup" style="cursor:pointer" onclick="close_paparan()" />
                </div>
            </div>
        
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="8"><b>Senarai peserta bagi kursus : <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b></th>
                                </tr>
                                <tr>
                                    <th width="5%" align="center"><b>Bil</b></th>
                                    <th width="40%" align="center"><b>Nama Peserta</b></th>
                                    <th width="40%" align="center"><b>Agensi/Jabatan/Unit</b></th>
                                    <th width="10%" align="center"><b>Pilih untuk cetakan</b><br />
                                        <input type="checkbox" onclick="upd_sijil('<?=$id;?>','ALL')" style="cursor:pointer" 
                                        title="Sila klik untuk menandakan semua peserta untuk proses cetakan" />
                                    </th>
                                    <th width="5%" align="center"><b>Cetak Sijil</b></th>
                                </tr>
                            </thead>
                                <tbody>
                                    <?php while(!$rs_det->EOF){ $bils++; ?>
                                    <tr>
                                        <td align="right"><?php print $bils;?>.&nbsp;</td>
                                        <td align="left"><?php print $rs_det->fields['f_peserta_nama'];?>&nbsp;</td>
                                        <td align="left"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs_det->fields['BranchCd']));?>&nbsp;</td>
                                        <td align="center"><input type="checkbox" name="chk_cetak"<?php if($rs_det->fields['is_sijil']){ print 'checked="checked"'; }?> 
                                            onclick="upd_sijil('<?=$rs_det->fields['InternalStudentId'];?>','<?=$rs_det->fields['is_sijil'];?>')" style="cursor:pointer"/></td> 
                                        <td align="center">
                                            <?php if($rs_det->fields['is_sijil']==0){ $disp = 'display:none'; } else { $disp=''; }?>
                                            <img id="print" src="../images/printicon.gif" border="0" style="cursor:pointer;<?=$disp;?>" width="30" height="25" 
                                            onclick="open_cetak('kursus/kursus_cetakan_sijil.php?id=<?=$id;?>&idpeserta=<?=$rs_det->fields['InternalStudentId'];?>','',1,1)" />
                                        &nbsp;</td>
                                    </tr>
                                    <?php $rs_det->movenext(); } ?>
                                </tbody>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

