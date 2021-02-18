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
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.id AS CID, C.SubCategoryNm, D.startdate, D.enddate 
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
?>
<form name="ilim" method="post" action="">
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="1">
    <tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="20%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="74%" align="left" colspan="2"><?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></td>
                <td width="5%" rowspan="4" align="center" valign="top">
                	<input type="button" name="tutup" value="Cetak Sijil" style="cursor:pointer" 
                    onclick="cetak_openModal('kursus/kursus_cetakan_sijil.php?id=<?=$id;?>&idpeserta=')" /><br><br>
                	<input type="button" name="tutup" value="Tutup" style="cursor:pointer" onclick="close_paparan()" />
                </td>
            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left" colspan="2"><?php print $rs->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left" colspan="2"><?php print dlookup("_tbl_kursus_catsub","SubCategoryDesc","id=".tosql($rs->fields['CID']));
				//pusat_list($rs->fields['CID']); //$rs->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left" width="35%"><?php print DisplayDate($rs->fields['startdate']);?> - <?php print DisplayDate($rs->fields['enddate']);?></td>                
                <td align="left" width="39%"><b>Template : </b>
                	<?php $sqlsijil = "SELECT * FROM _ref_template_sijil WHERE ref_ts_status=0 AND ref_ts_delete=0"; //$conn->debug=true;
					$rstsijil = &$conn->Execute($sqlsijil); $bil=0;
					?>
					<select name="tsijil">
                    	<option value="">Sila pilih</option>
                        <?php while(!$rstsijil->EOF){ $bil++; ?>
                        <?php if(empty($rstsijil->fields['ref_tajuk_sijil'])){ ?>
                            <option value="<?php print $rstsijil->fields['ref_ts_id'];?>">Template : <?php print $bil;?></option>
                        <?php } else { ?>
                            <option value="<?php print $rstsijil->fields['ref_ts_id'];?>"><?php print $rstsijil->fields['ref_tajuk_sijil'];?></option>
                        <?php } ?>
                        <?php $rstsijil->movenext(); }?>
                    </select>
                    <input type="button" value="Papar" style="cursor:pointer" onclick="do_papar('kursus/ref_template_sijil_form1.php?id=<?=$id;?>&forms=cetak')" />
                </td>                
           </tr>
			<tr>
                <td align="right"><b>Jumlah Peserta</b></td>
                <td align="center"><b> : </b></td>
                <td align="left" width="35%" colspan="2"><?php print $jum_peserta;?> Orang Peserta               
                <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>Peserta Hadir : </b>
				<?php print dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND EventId=".tosql($id));?> Orang Peserta-->
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>Cetakan Sijil : </b>
				<?php print dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND is_sijil=1 AND EventId=".tosql($id));?> Orang Peserta
                </td>
            </tr>
        </table>
    </td>
	<tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="1" align="center">

            <tr bgcolor="#CCCCCC"><td colspan="5"><b>Senarai peserta bagi kursus : <?php print $rs->fields['courseid'] . " - " .$rs->fields['coursename'];?></b></td></tr>
            <tr bgcolor="#CCCCCC">
                <td width="5%" align="center"><b>Bil</b></td>
                <td width="40%" align="center"><b>Nama Peserta</b></td>
                <td width="40%" align="center"><b>Agensi/Jabatan/Unit</b></td>
                <td width="10%" align="center"><b>Pilih untuk cetakan</b><br />
                	<input type="checkbox" onclick="upd_sijil('<?=$id;?>','ALL')" style="cursor:pointer" 
                    title="Sila klik untuk menandakan semua peserta untuk proses cetakan" />
                </td>
                <td width="5%" align="center"><b>Cetak Sijil</b></td>
            </tr>
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
                    onclick="cetak_openModal('kursus/kursus_cetakan_sijil.php?id=<?=$id;?>&idpeserta=<?=$rs_det->fields['InternalStudentId'];?>')" />
                &nbsp;</td>
            </tr>
            <?php $rs_det->movenext(); } ?>
        </table>
    </td></tr>
</table>
</form>
