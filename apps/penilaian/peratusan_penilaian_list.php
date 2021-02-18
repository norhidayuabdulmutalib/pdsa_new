<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
if(empty($id)){ $id=isset($_REQUEST["id"])?$_REQUEST["id"]:""; }
$proses=isset($_REQUEST["PRO"])?$_REQUEST["PRO"]:"";
if($proses=='PROSES'){
	//$conn->debug=true;
	$sql = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($id);
	$rs = &$conn->Execute($sql);
	if(!$rs->EOF){
		$jum = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.event_id=".tosql($id));
		$u19 = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_umur19=1 AND A.event_id=".tosql($id));
		$u20 = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_umur20=1 AND A.event_id=".tosql($id));
		$u30 = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_umur30=1 AND A.event_id=".tosql($id));
		$u40 = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_umur40=1 AND A.event_id=".tosql($id));
		$u50 = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_umur50=1 AND A.event_id=".tosql($id));

		$jantina_l = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_jantina_l=1 AND A.event_id=".tosql($id));
		$jantina_p = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_jantina_p=1 AND A.event_id=".tosql($id));

		$jawatan_j = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsept_jusa=1 AND A.event_id=".tosql($id));
		$jawatan_p = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_pp=1 AND A.event_id=".tosql($id));
		$jawatan_s = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_sokongan=1 AND A.event_id=".tosql($id));
		
		//$conn->debug=true;
		$kursus_1 = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_pertama=1 AND A.event_id=".tosql($id));
		$kursus_2 = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_kedua=1 AND A.event_id=".tosql($id));
		$kursus_3 = dlookup("_tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B","count(*)",
			"A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.fsetp_ketiga=1 AND A.event_id=".tosql($id));
	
		$sqlu = "UPDATE _tbl_set_penilaian SET jum_online=".tosql($jum).", fset_umur19=".tosql($u19).", fset_umur20=".tosql($u20).", 
		 	fset_umur30=".tosql($u30).",  fset_umur40=".tosql($u40).",  fset_umur50=".tosql($u50).",
			fset_jantina_l=".tosql($jantina_l).", fset_jantina_p=".tosql($jantina_p).", 
			fset_jusa=".tosql($jawatan_j).", fset_pp =".tosql($jawatan_p).", fset_sokongan=".tosql($jawatan_s).", 
			fset_pertama=".tosql($kursus_1).", fset_kedua=".tosql($kursus_2).", fset_ketiga=".tosql($kursus_3)." 
		WHERE fset_event_id=".tosql($id);
		//print $sqlu;
		$conn->Execute($sqlu); if(mysql_errno()!=0){ print mysql_error(); exit; }
		$conn->debug=false;
	}

	//$conn->debug=true;
	$sql_det = "SELECT * FROM _tbl_set_penilaian_bhg_detail WHERE event_id=".tosql($id);
	$rs_det = &$conn->Execute($sql_det);
	$bil=0;
	while(!$rs_det->EOF){ 
		$bil++; $nilai=0; $pp_id='';
		$fsetdet_id 	= $rs_det->fields['fsetdet_id'];
		$nilai1 = dlookup("_tbl_set_penilaian_peserta_detail A, _tbl_kursus_jadual_peserta B","count(*)","A.`id_peserta`= B.InternalStudentId AND A.fsetdet_1=1 AND A.fsetdet_id=".tosql($fsetdet_id));
		$nilai2 = dlookup("_tbl_set_penilaian_peserta_detail A, _tbl_kursus_jadual_peserta B","count(*)","A.`id_peserta`= B.InternalStudentId AND A.fsetdet_2=1 AND A.fsetdet_id=".tosql($fsetdet_id));
		$nilai3 = dlookup("_tbl_set_penilaian_peserta_detail A, _tbl_kursus_jadual_peserta B","count(*)","A.`id_peserta`= B.InternalStudentId AND A.fsetdet_3=1 AND A.fsetdet_id=".tosql($fsetdet_id));
		$nilai4 = dlookup("_tbl_set_penilaian_peserta_detail A, _tbl_kursus_jadual_peserta B","count(*)","A.`id_peserta`= B.InternalStudentId AND A.fsetdet_4=1 AND A.fsetdet_id=".tosql($fsetdet_id));
		$nilai5 = dlookup("_tbl_set_penilaian_peserta_detail A, _tbl_kursus_jadual_peserta B","count(*)","A.`id_peserta`= B.InternalStudentId AND A.fsetdet_5=1 AND A.fsetdet_id=".tosql($fsetdet_id));
		
		/*$sqlsel = "SELECT count(C.*) AS cnts FROM _tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B, _tbl_set_penilaian_peserta_detail C  
		WHERE A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND C.id_peserta=B.InternalStudentId AND A.is_nilai=1 AND A.event_id=".tosql($id);
		$sqlsel .= " AND C.fsetdet_1=1 AND C.fsetdet_id=".tosql($fsetdet_id);
		$rsnilai = $conn->execute($sqlsel); $nilai1 = $rsnilai->fields['cnts'];
		$sqlsel .= " AND C.fsetdet_2=1 AND C.fsetdet_id=".tosql($fsetdet_id);
		$rsnilai = $conn->execute($sqlsel); $nilai2 = $rsnilai->fields['cnts'];
		$sqlsel .= " AND C.fsetdet_3=1 AND C.fsetdet_id=".tosql($fsetdet_id);
		$rsnilai = $conn->execute($sqlsel); $nilai3 = $rsnilai->fields['cnts'];
		$sqlsel .= " AND C.fsetdet_4=1 AND C.fsetdet_id=".tosql($fsetdet_id);
		$rsnilai = $conn->execute($sqlsel); $nilai4 = $rsnilai->fields['cnts'];
		$sqlsel .= " AND C.fsetdet_5=1 AND C.fsetdet_id=".tosql($fsetdet_id);
		$rsnilai = $conn->execute($sqlsel); $nilai5 = $rsnilai->fields['cnts'];*/

		
		$sqlpi = "UPDATE _tbl_set_penilaian_bhg_detail SET 
			fsetdet_1=".tosql($nilai1).",	fsetdet_2=".tosql($nilai2).", fsetdet_3=".tosql($nilai3).", fsetdet_4=".tosql($nilai4).", fsetdet_5=".tosql($nilai5);
		$sqlpi .= " WHERE fsetdet_id=".tosql($fsetdet_id)." AND event_id=".tosql($id);
		//print "<br>".$sqlpi."<br>";
		$conn->execute($sqlpi);
		
		$cnt = $cnt + 1;
		$rs_det->movenext();
	} 
}
	$conn->debug=false;
?>
<script language="javascript">
function do_proses(id){
	var winds = document.ilim.winds.value;
	//alert(winds);
	document.ilim.action = 'modal_form.php?win='+winds+'&id='+id+'&PRO=PROSES';
	document.ilim.submit();
}
function disp_val_main(id,fields,fields_p,fields_jum,val){
	this.formobj = document.forms['frm'];
	var val = this.formobj[fields].value-0;
	var val_p = this.formobj[fields_p].value-0;
	var val_jum = val+val_p;
	//alert(itemobj);
	this.formobj[fields_jum].value=val_jum;
	if(fields=='jum_off'){
		var URL = 'penilaian/peratusan_penilaian_upd.php?frm=main&pkid='+id+"&fields="+fields+"&val="+val+'&val_jum='+val_jum;
	} else {
		var URL = 'penilaian/peratusan_penilaian_upd.php?frm=main&pkid='+id+"&fields="+fields+"&val="+val+'&val_jum=';
	}
	callToServer(URL);
}
function disp_val(val,pkid,ty){
	//alert(val);
	var jk = document.ilim.jk.value;
	var pk1=document.getElementsByName("pk1")[val].value-0;
	var pk2=document.getElementsByName("pk2")[val].value-0;
	if(ty==1){
		var pk3=document.getElementsByName("pk3")[val].value-0;
		var pk4=document.getElementsByName("pk4")[val].value-0;
		var pk5=document.getElementsByName("pk5")[val].value-0;
	} else {
		var pk3=0;
		var pk4=0;
		var pk5=0;
	}
	var jumpk=0;
	jumpk = pk1+pk2+pk3+pk4+pk5;
	//alert(jumpk);
	//if(jumpk>jk){
	//	alert("Jumlah input data melebihi jumlah kehadiran peserta");
	//} else {
		var URL = 'penilaian/peratusan_penilaian_upd.php?frm=detail&pkid='+pkid+"&pk1="+pk1+"&pk2="+pk2+"&pk3="+pk3+"&pk4="+pk4+"&pk5="+pk5;
		//alert(URL);
		callToServer(URL);
		//document.ilim.action=URL;
		//document.ilim.target='_blank';
		//document.ilim.submit();
	//}
	//document.ilim.action=URL;
	//document.ilim.target='_blank';
	//document.ilim.submit();
}
</script>
<?php
function disp_heads(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="45%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="50%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="45%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="10%" align="center" valign="bottom"><b>Amat Tidak Setuju</b></td>
                    <td width="10%" align="center" valign="bottom"><b>Tidak Setuju<br /></b></td>
                    <td width="10%" align="center" valign="bottom"><b>Kurang Setuju<br /></b></td>
                    <td width="10%" align="center" valign="bottom"><b>Setuju<br /></b></td>
                    <td width="10%" align="center" valign="bottom"><b>Sangat Setuju<br /></b></td>
                </tr>';
}
function disp_heads2(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="45%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="50%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="45%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="10%" align="center" colspan=2 valign="bottom"><b>&nbsp;</b></td>
                    <td width="10%" align="center" colspan=3 valign="bottom"><b>&nbsp;</b></td>
                </tr>';
}


$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.id as CID, C.SubCategoryNm, D.startdate, D.enddate, E.kampus_nama 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D, _ref_kampus E 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.kampus_id=E.kampus_id AND D.id = ".tosql($id,"Next");
$rskursus = &$conn->Execute($sSQL);
?>
<form name="ilim" method="post">
<input type="hidden" name="id" value="<?=$id;?>" />
<input type="hidden" name="winds" value="<?=$_GET['win'];?>" />
<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle">
        <div style="float:left">
        	<font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT PERATUSAN PENILAIAN</strong> <font color="#FFFFFF"><?=$id;?></font></font></div>
        <div style="float:right"><input type="button" value="Proses" style="cursor:pointer" onclick="do_proses('<?=$id;?>')" />
        &nbsp;&nbsp;
        <input type="button" value="Tutup" style="cursor:pointer" onclick="javascript:parent.emailwindow.hide();" /></div>
        </td>
    </tr>
    <tr><td colspan="5">
        <table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="25%" align="right"><b>Pusat Latihan</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="74%" align="left"><font color="#0033FF"><b><?php print $rskursus->fields['kampus_nama'];?></b></font></td>            
            </tr>
	        <tr>
                <td width="25%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="74%" align="left"><?php print $rskursus->fields['courseid'] . " - " .$rskursus->fields['coursename'];?></td>            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rskursus->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print dlookup("_tbl_kursus_catsub","SubCategoryDesc","id=".tosql($rskursus->fields['CID']));
				//print pusat_list($rskursus->fields['CID']);; //$rskursus->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rskursus->fields['startdate']);?> - <?php print DisplayDate($rskursus->fields['enddate']);?></td>                
            </tr>
		</table>
    </td></tr>
    <?php
    $sql_data = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($id);
	$rs_nilai = &$conn->execute($sql_data);
	$jum_all_umur = $rs_nilai->fields['fset_umur19_off']+$rs_nilai->fields['fset_umur19']+
					$rs_nilai->fields['fset_umur20_off']+$rs_nilai->fields['fset_umur20']+
					$rs_nilai->fields['fset_umur30_off']+$rs_nilai->fields['fset_umur30']+
					$rs_nilai->fields['fset_umur40_off']+$rs_nilai->fields['fset_umur40']+
					$rs_nilai->fields['fset_umur50_off']+$rs_nilai->fields['fset_umur50'];
	
	?>
    <tr><td colspan="5">&nbsp;</td></tr>
    <?php
	//$conn->debug=true;
	//$jum_tawaran = dlookup("_tbl_kursus_jadual_peserta","count(*)","EventId=".tosql($id)." GROUP BY peserta_icno");
	$sql1 = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE EventId=".tosql($id)."  AND is_selected IN (1) AND is_deleted=0 GROUP BY peserta_icno";
	$rs1 = &$conn->Execute($sql1);
	//print $sql1;
	$jum_tawaran = $rs1->recordcount();
	
	//$jum_hadir = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND EventId=".tosql($id));
	$sql1 = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE EventId=".tosql($id)." AND InternalStudentAccepted= 1 AND is_selected IN (1) GROUP BY peserta_icno";
	$rs1 = &$conn->Execute($sql1);
	//print $sql1;
	$jum_hadir = $rs1->recordcount();

	$conn->debug=false;
	//$jum_nilai = dlookup_cnt("_tbl_penilaian_peserta","distinct pp_peserta_id","pp_eventid=".tosql($id)." GROUP BY pp_peserta_id");
	//$jum_nilai = dlookup_cnt("_tbl_set_penilaian_peserta_bhg","distinct id_peserta","event_id=".tosql($id)." GROUP BY id_peserta");
	$sqlsel = "SELECT A.* FROM _tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B 
	WHERE A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND B.is_selected IN (1) AND A.is_nilai=1 AND A.event_id=".tosql($id);
	$sqlsel .= "  AND B.InternalStudentId IN (SELECT id_peserta FROM _tbl_set_penilaian_peserta WHERE event_id=".tosql($id).")";
	$rsnilai = $conn->execute($sqlsel); $jum_nilai = $rsnilai->recordcount();

	//$conn->debug=false;
	$jum_offs = $rs_nilai->fields['jum_off'];
	$jhadir=$jum_offs+$jum_nilai;
	?>
	<tr>
        <td><strong>Jumlah Tawaran : <?php print $jum_tawaran;?></strong> peserta</td>
        <td><strong>Jumlah Kehadiran : <?php print $jum_hadir;?></strong> peserta hadir
        	<input type="text" size="1" name="jum_off" value="<?php print $rs_nilai->fields['jum_off'];?>" style="text-align:center" 
            	onchange="disp_val_main('<?php print $id;?>','jum_off','jum_online','jk',this.form)" />
        	<input type="text" name="jum_online" size="3" value="<?=$jum_nilai;?>" readonly="readonly" disabled="disabled" style="text-align:center" /> = 
        	<input type="text" name="jk" size="3" value="<?php print $jhadir;?>" readonly="readonly" disabled="disabled" style="text-align:center" />
        </td>
        <?php $href_nilai = "modal_form.php?win=".base64_encode('penilaian/nilai_list.php;'.$id); 
			$sql_det = "SELECT A.*, B.f_peserta_nama, B.BranchCd, B.f_peserta_noic, B.f_title_grade 
			FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B WHERE A.peserta_icno=B.f_peserta_noic AND A.EventId=".tosql($id) . " 
			AND A.InternalStudentAccepted=1 AND A.InternalStudentId IN (SELECT id_peserta FROM _tbl_set_penilaian_peserta WHERE event_id=".tosql($id).")";
			$sql_det .= " GROUP BY B.f_peserta_noic ORDER BY B.f_peserta_nama";
			$rsnilai = $conn->execute($sql_det); $jum_nilai = $rsnilai->recordcount();
		?>
        <td><b>Jumlah Menilai : </b><a onclick="open_modal('<?=$href_nilai;?>','Senarai peserta menilai',1,1)" 
        	style="cursor:pointer"><b><?=$jum_tt;?><?php print $jum_nilai;?></b></a>
        <?php //$conn->debug=true;
			$sqlsel = "SELECT A.* FROM _tbl_set_penilaian_peserta A, _tbl_kursus_jadual_peserta B 
			WHERE A.id_peserta=B.InternalStudentId AND B.InternalStudentAccepted=1 AND A.is_nilai=0 AND B.is_selected IN (1,9)AND A.event_id=".tosql($id);
			$rsnilai = $conn->execute($sqlsel); $jum_thantar = $rsnilai->recordcount();
			//print $sqlsel."<br>";

			//$sql1 = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE EventId=".tosql($id)." AND InternalStudentAccepted= 1 AND is_selected IN (1,9) ";
			$sqlsel = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE InternalStudentAccepted=1 AND EventId=".tosql($id) . " AND is_selected IN (1,9)  
			AND InternalStudentId NOT IN (SELECT id_peserta FROM _tbl_set_penilaian_peserta WHERE event_id=".tosql($id).")";
			$sqlsel .= " GROUP BY peserta_icno";
			$rsnilai = $conn->execute($sqlsel); $jum_tt = $rsnilai->recordcount();
			//print $sqlsel."<br>";
			$conn->debug=false;

		?>
		<?php if($jum_thantar>0){ $href_senarai = "modal_form.php?win=".base64_encode('penilaian/tidak_hantarnilai_list.php;'.$id);?>
        	&nbsp;(<a onclick="open_modal('<?=$href_senarai;?>','Senarai peserta tidak menilai',1,1)" 
        	style="cursor:pointer"><b><?=$jum_thantar;?></b> Orang tidak hantar</a>)
		<?php } ?>
		<?php if($jum_tt>0){ $href_senarai = "modal_form.php?win=".base64_encode('penilaian/tidak_nilai_list.php;'.$id);?>
        	&nbsp;(<a onclick="open_modal('<?=$href_senarai;?>','Senarai peserta tidak menilai',1,1)" 
        	style="cursor:pointer"><b><?=$jum_tt;?></b> Orang tidak menilai</a>)
		<?php } ?>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
	<tr><td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td width="15%">1. Umur :</td>
        <td width="17%">20 ke bawah</td>
        <td width="17%">
        	<input type="text" size="2" name="fset_umur19_off" value="<?php print $rs_nilai->fields['fset_umur19_off'];?>" style="text-align:center" 
            	onchange="disp_val_main('<?php print $id;?>','fset_umur19_off','fset_umur19','umur_19',this.form)" />
        	<input type="text" size="2" name="fset_umur19" value="<?php print $rs_nilai->fields['fset_umur19'];?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="umur_19" value="<?php print $rs_nilai->fields['fset_umur19_off']+$rs_nilai->fields['fset_umur19'];?>" style="text-align:center" disabled="disabled"/>
            (<input type="text" size="3" name="umur_all" value="<?php print $jum_all_umur;?>" style="text-align:center" disabled="disabled"/>)        
        </td>
        <td width="2%">&nbsp;</td>
        <td width="18%">2. Jantina :</td>
        <td width="10%">Lelaki</td>
        <td width="17%">
        	<input type="text" size="2" name="fset_jantina_l_off" value="<?php print $rs_nilai->fields['fset_jantina_l_off'];?>" style="text-align:center" 
            	onchange="disp_val_main('<?php print $id;?>','fset_jantina_l_off','fset_jantina_l','jantina_l',this.form)" />
        	<input type="text" size="2" name="fset_jantina_l" value="<?php print $rs_nilai->fields['fset_jantina_l'];?>" style="text-align:center" disabled="disabled"/>
			= <input type="text" size="2" name="jantina_l" value="<?php print $rs_nilai->fields['fset_jantina_l_off']+$rs_nilai->fields['fset_jantina_l'];?>" 
            	style="text-align:center" disabled="disabled"/>
			 (<input type="text" size="2" name="umur_all2" value="<?php print $rs_nilai->fields['fset_jantina_l_off']+$rs_nilai->fields['fset_jantina_l']+
			 $rs_nilai->fields['fset_jantina_p_off']+$rs_nilai->fields['fset_jantina_p']
			 ;?>" style="text-align:center" disabled="disabled"/>) 
         </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>20-29 tahun</td>
        <td>
        	<input type="text" size="2" name="fset_umur20_off" value="<?php print $rs_nilai->fields['fset_umur20_off'];?>" style="text-align:center" 
            	onchange="disp_val_main('<?php print $id;?>','fset_umur20_off','fset_umur20','umur_20',this.form)" />
        	<input type="text" size="2" name="fset_umur20" value="<?php print $rs_nilai->fields['fset_umur20'];?>" style="text-align:center" disabled="disabled"/>
			= <input type="text" size="2" name="umur_20" value="<?php print $rs_nilai->fields['fset_umur20_off']+$rs_nilai->fields['fset_umur20'];?>" style="text-align:center" disabled="disabled"/>        
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Perempuan</td>
        <td>
        	<input type="text" size="2" name="fset_jantina_p_off" value="<?php print $rs_nilai->fields['fset_jantina_p_off'];?>" style="text-align:center" 
            	onchange="disp_val_main('<?php print $id;?>','fset_jantina_p_off','fset_jantina_p','jantina_p',this.form)" />
        	<input type="text" size="2" name="fset_jantina_p" value="<?php print $rs_nilai->fields['fset_jantina_p'];?>" style="text-align:center" disabled="disabled"/>
			= <input type="text" size="2" name="jantina_p" value="<?php print $rs_nilai->fields['fset_jantina_p_off']+$rs_nilai->fields['fset_jantina_p'];?>" readonly="readonly"style="text-align:center" disabled="disabled"/>        
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>30-39 tahun</td>
        <td>
        	<input type="text" size="2" name="fset_umur30_off" value="<?php print $rs_nilai->fields['fset_umur30_off'];?>" style="text-align:center" 
            	onchange="disp_val_main('<?php print $id;?>','fset_umur30_off','fset_umur30','umur30',this.form)" />
        	<input type="text" size="2" name="fset_umur30" value="<?php print $rs_nilai->fields['fset_umur30'];?>" style="text-align:center" disabled="disabled"/>
			= <input type="text" size="2" name="umur30" value="<?php print $rs_nilai->fields['fset_umur30_off']+$rs_nilai->fields['fset_umur30'];?>" style="text-align:center" disabled="disabled" />        
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>40-49 tahun</td>
        <td>
        	<input type="text" size="2" name="fset_umur40_off" value="<?php print $rs_nilai->fields['fset_umur40_off'];?>" style="text-align:center"  
            	onchange="disp_val_main('<?php print $id;?>','fset_umur40_off','fset_umur40','umur_40',this.form)" />
        	<input type="text" size="2" name="fset_umur40" value="<?php print $rs_nilai->fields['fset_umur40'];?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="umur_40" value="<?php print $rs_nilai->fields['fset_umur40_off']+$rs_nilai->fields['fset_umur40'];?>" style="text-align:center" disabled="disabled"/>        
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>50 tahun ke atas</td>
        <td>
        	<input type="text" size="2" name="fset_umur50_off" value="<?php print $rs_nilai->fields['fset_umur50_off'];?>" style="text-align:center"  
            	onchange="disp_val_main('<?php print $id;?>','fset_umur50_off','fset_umur50','umur_50',this.form)" />
        	<input type="text" size="2" name="fset_umur50" value="<?php print $rs_nilai->fields['fset_umur50'];?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="umur_50" value="<?php print $rs_nilai->fields['fset_umur50_off']+$rs_nilai->fields['fset_umur50'];?>" style="text-align:center" disabled="disabled"/> 
			</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>3.Kumpulan Jawatan :</td>
        <td>JUSA</td>
        <td>
        	<input type="text" size="2" name="fset_jusa_off" value="<?php print $rs_nilai->fields['fset_jusa_off'];?>" style="text-align:center"  
            	onchange="disp_val_main('<?php print $id;?>','fset_jusa_off','fset_jusa','jusa',this.form)" />
        	<input type="text" size="2" name="fset_jusa" value="<?php print $rs_nilai->fields['fset_jusa'];?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="jusa" value="<?php print $rs_nilai->fields['fset_jusa_off']+$rs_nilai->fields['fset_jusa'];?>" style="text-align:center" disabled="disabled"/>
			 (<input type="text" size="3" name="umur_all4" value="<?php print $rs_nilai->fields['fset_jusa_off']+$rs_nilai->fields['fset_jusa']+$rs_nilai->fields['fset_pp_off']+$rs_nilai->fields['fset_pp']+$rs_nilai->fields['fset_sokongan_off']+$rs_nilai->fields['fset_sokongan'];?>" style="text-align:center" disabled="disabled"/>)        
        </td>
        <td>&nbsp;</td>
        <td>4. kekerapan Kursus di ILIM</td>
        <td>Pertama</td>
        <td>
        	<input type="text" size="2" name="fset_pertama_off" value="<?php print $rs_nilai->fields['fset_pertama_off'];?>"style="text-align:center"  
            	onchange="disp_val_main('<?php print $id;?>','fset_pertama_off','fset_pertama','pertama',this.form)" />
        	<input type="text" size="2" name="fset_pertama" value="<?php print $rs_nilai->fields['fset_pertama'];?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="pertama" value="<?php print $rs_nilai->fields['fset_pertama_off']+$rs_nilai->fields['fset_pertama'];?>" style="text-align:center" disabled="disabled" />
			 (<input type="text" size="3" name="umur_all3" value="<?php print $rs_nilai->fields['fset_pertama_off']+$rs_nilai->fields['fset_pertama']+$rs_nilai->fields['fset_kedua_off']+$rs_nilai->fields['fset_kedua']+$rs_nilai->fields['fset_ketiga_off']+$rs_nilai->fields['fset_ketiga'];?>" style="text-align:center" disabled="disabled"/>)        
         </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>P&amp;P</td>
        <td>
        	<input type="text" size="2" name="fset_pp_off" value="<?php print $rs_nilai->fields['fset_pp_off'];?>" style="text-align:center"  
            	onchange="disp_val_main('<?php print $id;?>','fset_pp_off','fset_pp','pp',this.form)" />
        	<input type="text" size="2" name="fset_pp" value="<?php print number_format($rs_nilai->fields['fset_pp'],0);?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="pp" value="<?php print $rs_nilai->fields['fset_pp_off']+$rs_nilai->fields['fset_pp'];?>" style="text-align:center" disabled="disabled" />        
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Kedua</td>
        <td>
        	<input type="text" size="2" name="fset_kedua_off" value="<?php print $rs_nilai->fields['fset_kedua_off'];?>" style="text-align:center"  
            	onchange="disp_val_main('<?php print $id;?>','fset_kedua_off','fset_kedua','kedua',this.form)" />
        	<input type="text" size="2" name="fset_kedua" value="<?php print $rs_nilai->fields['fset_kedua'];?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="kedua" value="<?php print $rs_nilai->fields['fset_kedua_off']+$rs_nilai->fields['fset_kedua'];?>" style="text-align:center" disabled="disabled" />        
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Sokongan</td>
        <td>
        	<input type="text" size="2" name="fset_sokongan_off" value="<?php print $rs_nilai->fields['fset_sokongan_off'];?>" style="text-align:center" 
            	onchange="disp_val_main('<?php print $id;?>','fset_sokongan_off','fset_sokongan','sokongan',this.form)" />
        	<input type="text" size="2" name="fset_sokongan" value="<?php print number_format($rs_nilai->fields['fset_sokongan'],0);?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="sokongan" value="<?php print $rs_nilai->fields['fset_sokongan_off']+$rs_nilai->fields['fset_sokongan'];?>" style="text-align:center" disabled="disabled" />        
        </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Lebih dari dua</td>
        <td>
        	<input type="text" size="2" name="fset_ketiga_off" value="<?php print $rs_nilai->fields['fset_ketiga_off'];?>" style="text-align:center"  
            	onchange="disp_val_main('<?php print $id;?>','fset_ketiga_off','fset_ketiga','ketiga',this.form)" />
        	<input type="text" size="2" name="fset_ketiga" value="<?php print $rs_nilai->fields['fset_ketiga'];?>" style="text-align:center" disabled="disabled" />
			= <input type="text" size="2" name="ketiga" value="<?php print $rs_nilai->fields['fset_ketiga_off']+$rs_nilai->fields['fset_ketiga'];?>" style="text-align:center" disabled="disabled" />        
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="1" valign="top">5. Jabatan/Agensi Tempat Bertugas :&nbsp;</td>
        <td colspan="6">

		<table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr><td colspan="3"><b>Pecahan Jumlah Peserta</b></td></tr>
    	<tr>
        	<td width="5%" align="center"><b>Bil</b></td>
            <td width="75%" align="left"><b>Nama Jabatan/Kementerian</b></td>	    
            <td width="20%" align="center"><b>Jumlah Peserta</b></td>
        </tr>
        <tr>
        	<td align="right">1.</td>	
            <td>Jabatan Kemajuan Islam Malaysia (JAKIM)</td>
            <td align="center"><?php $jum_all=0; 
			//$conn->debug=true;
            $sqlj = "SELECT * FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=1 AND A.InternalStudentAccepted=1 
			AND is_selected IN (1,9) AND B.is_deleted=0 AND A.EventId=".tosql($id);
			$sqlj .= " GROUP BY A.peserta_icno";
			//print $sqlj; //AND A.is_sijil=1 
			$rsj = &$conn->Execute($sqlj); $jakim = $rsj->recordcount(); print $jakim; $jum_all+=$jakim;
			?></td>
        </tr>    
        <tr>
        	<td align="right">2.</td>	
            <td>Jabatan Agama Islam Negeri (JAIN)</td>
            <td align="center"><?php
            $sqlj = "SELECT * FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=2 AND  A.InternalStudentAccepted=1 
			AND is_selected IN (1,9) AND B.is_deleted=0 AND A.EventId=".tosql($id);
			$sqlj .= " GROUP BY A.peserta_icno";
			//print $sqlj; // A.is_sijil=1 AND
			$rsj = &$conn->Execute($sqlj); $jain = $rsj->recordcount(); print $jain; $jum_all+=$jain;
			?></td>
        </tr>    
        <tr>
        	<td align="right">3.</td>	
            <td>Majlis Agama Islam Negeri (MAIN)</td>
            <td align="center"><?php
			$sqlj = "SELECT * FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=3 AND A.InternalStudentAccepted=1 
			AND is_selected IN (1,9) AND B.is_deleted=0 AND A.EventId=".tosql($id);
			$sqlj .= " GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqlj); $main = $rsj->recordcount();	print $main; $jum_all+=$main;	//AND A.is_sijil=1 
			?></td>
        </tr>    
        <tr>
        	<td align="right">4.</td>	
            <td>Jabatan Mufti</td>
            <td align="center"><?php
            $sqlj = "SELECT * FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=4 AND A.InternalStudentAccepted=1 
			AND is_selected IN (1,9) AND B.is_deleted=0 AND A.EventId=".tosql($id);
			$sqlj .= " GROUP BY A.peserta_icno";
			$rsj = &$conn->Execute($sqlj); $jmufti = $rsj->recordcount(); print $jmufti; $jum_all+=$jmufti; //AND A.is_sijil=1 
			?></td>
        </tr> 
        <?php
		$cnts=5;
        $sqljlain = "SELECT distinct B.BranchCd FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid>=5 AND A.InternalStudentAccepted=1 
			AND is_selected IN (1,9) AND B.is_deleted=0 AND A.EventId=".tosql($id);
		$sqljlain .= " GROUP BY A.peserta_icno";
		$rsjlain = &$conn->Execute($sqljlain); //AND A.is_sijil=1 
		while(!$rsjlain->EOF){ 
		?>
        <tr>
        	<td align="right"><? print $cnts++;?>.</td>	
            <td><?php
            	print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rsjlain->fields['BranchCd']));  
			?></td>
            <td align="center"><?php
				//$sql1 = "SELECT * FROM _tbl_kursus_jadual_peserta WHERE EventId=".tosql($id)." AND InternalStudentAccepted= 1 AND is_selected IN (1,9) GROUP BY peserta_icno";

				$sqljlain = "SELECT * FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
				WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND A.InternalStudentAccepted=1 AND D.ref_ktid>=5 
				AND is_selected IN (1,9) AND B.is_deleted=0 AND A.EventId=".tosql($id)." AND B.BranchCd=".$rsjlain->fields['BranchCd']; //AND A.is_sijil=1
				$sqljlain .= " GROUP BY peserta_icno";
				$rsjl = &$conn->Execute($sqljlain); print $rsjl->recordcount(); $jum_all+=$rsjl->recordcount();
            ?></td>
        </tr>    
		<?php $rsjlain->movenext(); }   ?>
        <tr>
        	<td align="right"><?=$cnts++;?>.</td>	
            <td>Lain-Lain</td>
            <td align="center"><?php
            $sqlj = "SELECT * FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
			WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND B.BranchCd='0099' AND B.is_deleted=0 
			AND is_selected IN (1,9) AND A.EventId=".tosql($id);
			$sqlj .= " GROUP BY peserta_icno";
			//print $sqlj;
			$rsj = &$conn->Execute($sqlj); $ll = $rsj->recordcount(); print $ll; $jum_all+=$ll; //AND A.is_sijil=1 
			$conn->debug=false;
			?></td>
        </tr> 
        <tr>
        	<td align="right" colspan="2"><b>JUMLAH</b></td>
            <td align="center"><b><?php print $jum_all;?></b></td>
        </tr> 
    </table>
        &nbsp;</td>
      </tr>
      <tr>
        <td colspan="1" valign="top">6. Gred :&nbsp;</td>
        <td colspan="3" valign="top">
		<table width="100%" border="1" cellpadding="5" cellspacing="0">
        	<tr>
            	<td><b>Bil</b></td>
            	<td><b>Kod Gred Jawatan</b></td>
                <td><b>Jumlah</b></td>
            </tr>
			<?php
            $cnt=0; $cnt_jum=0; $bil=0;//$conn->debug=true; //AND A.is_sijil=1
			$sql1 = "SELECT * FROM _ref_titlegred "; //WHERE f_gred_id=".tosql($rsjlain->fields['f_title_grade']);
			$rsgred = $conn->execute($sql1);
            while(!$rsgred->EOF){ 

				$kodgred = $rsgred->fields['f_gred_name'] . " &nbsp;(".$rsgred->fields['f_gred_code'].")";

				$sqljlain = "SELECT count(*) as grades, B.f_title_grade FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
					WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND A.is_selected IN (1,9) AND B.is_deleted=0 
					AND A.EventId=".tosql($id)." AND B.f_title_grade=".tosql($rsgred->fields['f_gred_id']). " GROUP BY A.peserta_icno";
				$rsjlain = &$conn->Execute($sqljlain);  $cnt=0;
				while(!$rsjlain->EOF){ $cnt++; 
					//$sql1 = "SELECT * FROM _ref_titlegred WHERE f_gred_id=".tosql($rsjlain->fields['f_title_grade']);
					//$rsgred = $conn->execute($sql1);
					$grades = $rsjlain->fields['grades']; $cnt_jum++; //=$grades;
				?>
				<?php $rsjlain->movenext(); }  $conn->debug=false;  ?> 
                <?php if($cnt>0){ $bil++; ?>
				<tr>
					<td align="right"><?php print $bil;?>.</td>
					<td align="left"><?php print $kodgred;?></td>
					<td align="center"><?php print $cnt;?></td>
				</tr>
                <?php } ?>        
			<?php $rsgred->movenext(); }  $conn->debug=false;  ?>
            <tr>
                <td align="right" colspan="2"><b>JUMLAH</b></td>
                <td align="center"><b><?php print $cnt_jum;?></b></td>
            </tr> 
		</table>
        </td>
        <td>&nbsp;</td>
        <td valign="top">7. Negeri Tempat Bertugas</td>
        <td colspan="1" valign="top">
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td><b>Bil</b></td>
                    <td><b>Negeri</b></td>
                    <td><b>Jumlah</b></td>
                </tr>
                <?php
                $cntn=0; $cntn_jum=0; //$conn->debug=true; //AND A.is_sijil=1 
				$sql1 = "SELECT * FROM ref_negeri"; // WHERE kod_negeri=".tosql($rsjlain->fields['f_peserta_negeri']);
				$rsgred = $conn->execute($sql1);
				while(!$rsgred->EOF){ //$cntn++;

					$negeri = $rsgred->fields['negeri'];

					$sqljlain = "SELECT count(*) as negeris, B.f_peserta_negeri FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
								WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND A.is_selected IN (1,9) 
								AND A.EventId=".tosql($id)." AND B.f_peserta_negeri=".tosql($rsgred->fields['kod_negeri'])." 
								AND B.is_deleted=0 GROUP BY A.peserta_icno";
					//print $sqljlain;
					$rsjlain = &$conn->Execute($sqljlain); $tot_neg=0;
					while(!$rsjlain->EOF){ //$cntn++;
						//$sql1 = "SELECT * FROM ref_negeri WHERE kod_negeri=".tosql($rsjlain->fields['f_peserta_negeri']);
						//$rsgred = $conn->execute($sql1);
						//$jumn = $rsjlain->fields['negeris']; $cntn_jum+=$jumn;
						$jumn++; $tot_neg++;
					?>
					<?php $rsjlain->movenext(); }  $conn->debug=false;  ?>
    	            <?php if($tot_neg>0){ $cntn++; ?>
					<tr>
						<td align="right"><?php print $cntn;?>.</td>
						<td align="left"><?php print $negeri;?></td>
						<td align="center"><?php print $tot_neg;?></td>
					</tr>        
	                <?php } ?>        
				<?php $rsgred->movenext(); }  $conn->debug=false;  ?>

                <tr>
                    <td align="right" colspan="2"><b>JUMLAH</b></td>
                    <td align="center"><b><?php print $jumn;?></b></td>
                </tr> 
            </table>
        </tr>

      <!--<tr>
        <td colspan="2">5. Gred Jawatan :</td>
        <td colspan="3" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>
      <tr>
        <td colspan="2">6. Jabatan/Agensi tempat bertugas :</td>
        <td colspan="3" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
        <td colspan="2"></td>
      </tr>
      <tr>
        <td colspan="2">7. Negeri tempat bertugas :</td>
        <td colspan="3" style="border-bottom:thin;border-bottom-style:dotted;">&nbsp;</td>
        <td colspan="2">(sila nyatakan)</td>
      </tr>-->
    </table>
	<br /></td></tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
<?php
$select = "SELECT B.fsetb_id FROM _tbl_kursus_jadual_masa A, _tbl_set_penilaian_bhg B WHERE A.id_jadmasa=B.fsetb_jadmasaid AND B.fsetb_event_id=".tosql($id);
$select .= " ORDER BY tarikh, masa_mula ";
$rssort = $conn->execute($select);
//print $select; exit;
if(!$rssort->EOF){
	$bil=3;
	while(!$rssort->EOF){
		$ids = $rssort->fields['fsetb_id'];
		$ups = "UPDATE _tbl_set_penilaian_bhg SET sorts=".tosql($bil)." WHERE fsetb_id=".tosql($ids);
		$conn->execute($ups);
		$bil++;
		$rssort->movenext();
		//print $ups;
	}
}


$sql_det = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($id);
//$conn->debug=true;
$rs = &$conn->Execute($sql_det);
$fset_id = $rs->fields['fset_id'];

	$sql_det = "SELECT A.*, B.nilai_keterangan FROM _tbl_set_penilaian_bhg A, _tbl_nilai_bahagian B
	WHERE A.fsetb_nilaib_id=B.nilaib_id AND A.fsetb_event_id=".tosql($id)." AND A.fset_id=".tosql($fset_id);
	$sql_det .= " ORDER BY sorts"; //print $sql_det;
	$rs_bhg = &$conn->Execute($sql_det);
	
            if(!$rs_bhg->EOF) {
				$bil_bhg=0; $jum_rec=0;
                while(!$rs_bhg->EOF) {
					$bil_bhg++;
					 $fsetb_id = $rs_bhg->fields['fsetb_id'];
					 $fsetbp_id= $rs_bhg->fields['fsetbp_id'];
					 $fsetb_pensyarah_id = $rs_bhg->fields['fsetb_pensyarah_id'];
					 $fsetb_jadmasaid = $rs_bhg->fields['fsetb_jadmasaid'];
					 $jump=0;
            ?>
                    <tr height="25px" bgcolor="#666666">
                        <td colspan="7" align="left">&nbsp;&nbsp;<b><label><? echo stripslashes($rs_bhg->fields['nilai_keterangan']);?></label></b></td>
                    </tr>
                    <?php
                    if(!empty($fsetb_pensyarah_id)){ // JIKA MELIBATKAN PENSYARAH
                        $sql_p = "SELECT A.tajuk, A.tarikh, A.masa_mula, A.masa_tamat, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($id)." 
						AND A.id_pensyarah=".tosql($fsetb_pensyarah_id)." AND A.id_pensyarah=B.ingenid AND A.id_jadmasa=".tosql($fsetb_jadmasaid);
						$sql_p .= " ORDER BY A.tarikh, A.masa_mula";
                        $rs_pensyarah = $conn->execute($sql_p);
						//print $sql_p;
						print '<tr height="25px" bgcolor="#CCCCCC">
							<td colspan="7" align="left"><b>Nama Pensyarah : '.stripslashes($rs_pensyarah->fields['insname']).'
							<br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).' - ' .
							DisplayDate($rs_pensyarah->fields['tarikh']).' ('.$rs_pensyarah->fields['masa_mula'].' - '.$rs_pensyarah->fields['masa_tamat'].')</b></td>
						</tr>';
					}

					$sql_det = "SELECT A.*, B.f_penilaian_jawab, B.f_penilaian_desc FROM _tbl_set_penilaian_bhg_detail A, _ref_penilaian_maklumat B 
					WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.event_id=".tosql($id). " AND fsetb_id=".tosql($fsetb_id);
					$rs_det = &$conn->Execute($sql_det);
					//print $sql_det;
					$bil=0;
					while(!$rs_det->EOF){ 
						$bil++;
						$fsetdet_id=$rs_det->fields['fsetdet_id'];
						if($rs_det->fields['f_penilaian_jawab']=='1'){
							if($bil==1){ print disp_heads(); }
				?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center"><input type="text" size="4" name="pk1" value="<?=$rs_det->fields['fsetdet_jum1'];?>" maxlength="3" style="text-align:center" 
                                    onchange='disp_val(<?php print $jum_rec;?>,<?php print $fsetdet_id;?>,1)' />
                                    + <?php print $rs_det->fields['fsetdet_1'];?> <br /><b>= <?php print $rs_det->fields['fsetdet_1'] + $rs_det->fields['fsetdet_jum1'];?></b>
                                </td>
                                <td align="center"><input type="text" size="4" name="pk2" value="<?=$rs_det->fields['fsetdet_jum2'];?>" maxlength="3" style="text-align:center" 
                                    onchange='disp_val(<?php print $jum_rec;?>,<?php print $fsetdet_id;?>,1)' />
                                    + <?php print $rs_det->fields['fsetdet_2'];?> <br /><b>= <?php print $rs_det->fields['fsetdet_2'] + $rs_det->fields['fsetdet_jum2'];?></b>                                </td>
                                <td align="center"><input type="text" size="4" name="pk3" value="<?=$rs_det->fields['fsetdet_jum3'];?>" maxlength="3" style="text-align:center" 
                                    onchange='disp_val(<?php print $jum_rec;?>,<?php print $fsetdet_id;?>,1)' />
                                    + <?php print $rs_det->fields['fsetdet_3'];?> <br /><b>= <?php print $rs_det->fields['fsetdet_3'] + $rs_det->fields['fsetdet_jum3'];?></b>
                                </td>
                                <td align="center"><input type="text" size="4" name="pk4" value="<?=$rs_det->fields['fsetdet_jum4'];?>" maxlength="3" style="text-align:center" 
                                    onchange='disp_val(<?php print $jum_rec;?>,<?php print $fsetdet_id;?>,1)' />
                                    + <?php print $rs_det->fields['fsetdet_4'];?> <br /><b>= <?php print $rs_det->fields['fsetdet_4'] + $rs_det->fields['fsetdet_jum4'];?></b>
                                </td>
                                <td align="center"><input type="text" size="4" name="pk5" value="<?=$rs_det->fields['fsetdet_jum5'];?>" maxlength="3" style="text-align:center" 
                                    onchange='disp_val(<?php print $jum_rec;?>,<?php print $fsetdet_id;?>,1)' />
                                    + <?php print $rs_det->fields['fsetdet_5'];?> <br /><b>= <?php print $rs_det->fields['fsetdet_5'] + $rs_det->fields['fsetdet_jum5'];?></b>
                                </td>
                            </tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ 
							if($bil==1){ print disp_heads2(); } ?>
								<tr bgcolor="#FFFFFF">
									<td valign="top" align="right"><?=$bil;?>.</td>
									<td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                    <td align="center" colspan="2">Ya : <input type="text" size="4" name="pk1" value="<?=$rs_det->fields['fsetdet_jum1'];?>" maxlength="3" 
                                    	style="text-align:center" onchange='disp_val(<?php print $jum_rec;?>,<?php print $fsetdet_id;?>,2)' />
                                    	+ <?php print $rs_det->fields['fsetdet_1'];?> <br /><b>= <?php print $rs_det->fields['fsetdet_1'] + $rs_det->fields['fsetdet_jum1'];?></b>
                                	</td>
                                    <td align="center" colspan="3">Tidak : <input type="text" size="4" name="pk2" value="<?=$rs_det->fields['fsetdet_jum2'];?>" maxlength="3" 
                                    	style="text-align:center" onchange='disp_val(<?php print $jum_rec;?>,<?php print $fsetdet_id;?>,2)' />
                                	    + <?php print $rs_det->fields['fsetdet_2'];?> <br /><b>= <?php print $rs_det->fields['fsetdet_2'] + $rs_det->fields['fsetdet_jum2'];?></b>
                                </td>
								</tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ 
							if($bil==1){ print disp_heads2(); }?>
						<tr bgcolor="#FFFFFF">
							<td valign="top" align="right"><?=$bil;?>.</td>
							<td valign="top" align="left" colspan="6">
								<? echo stripslashes($rs_det->fields['f_penilaian_desc']);?><br />
								<textarea rows="10" cols="100" name="remarks" onchange="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',99,'<?=$kursus_id;?>','')"><?php print $pp_remarks;?></textarea>&nbsp;</td>
						</tr>
						<?php
						}
						$cnt = $cnt + 1; $jum_rec++;
						$rs_det->movenext();
					} 
					$bil = $bil + 1;
					/*if(!empty($fsetbp_pensyarah_id)){ ?>
						<tr bgcolor="#FFFFFF">
								<td valign="top" align="left" colspan="7"><br /><div style="border-bottom:thin;border-bottom-style:dotted;">Ulasan : 
                                <textarea name="ulasan<?=$bil_bhg;?>" id="ulasan" rows="3" cols="100" onchange="do_pro('<?=$fsetbp_id;?>','<?=$id;?>',this.form.ulasan<?=$bil_bhg;?>.value,'U')"><?php print $rs_bhg->fields['fsetbp_remarks'];?></textarea></div><br></td>
							</tr>
				<?php	 }*/
				$rs_bhg->movenext();
				}
			} 
             ?>                   
            </table> 
        </td>
    </tr>
    
    <tr>
    	<td colspan="5"><br />
        <?php 
		//$conn->debug=true;
		$sql = "SELECT fsetbp_remarks FROM _tbl_set_penilaian_peserta_bhg WHERE fsetbp_remarks<>'' AND event_id=".tosql($id);
		$rsrem = $conn->query($sql);
		if(!$rsrem->EOF){ print '<b>CADANGAN DAN PANDANGAN</b><ul>';
		while(!$rsrem->EOF){
			print '<li>'. stripslashes(nl2br(strtoupper($rsrem->fields['fsetbp_remarks']))).'</li>';
		$rsrem->movenext(); }
		print '</ul>';
		}
		?>
        </td>
    </tr>
    <tr>
    	<td colspan="5"><BR /><BR />
        <?php $sql = "SELECT fsetp_remarks FROM _tbl_set_penilaian_peserta WHERE fsetp_remarks<>'' AND event_id=".tosql($id);
		$rsrem = $conn->query($sql);
		if(!$rsrem->EOF){ print '<b>CADANGAN DAN PANDANGAN KESELURUHAN KURSUS</b><ul>';
		while(!$rsrem->EOF){
			print '<li>'.stripslashes(nl2br(strtoupper($rsrem->fields['fsetp_remarks']))).'</li>';
		$rsrem->movenext(); }
		print '</ul>';
		}
		?>
        </td>
    </tr>
            <!--<tr bgcolor="#FFFFFF">
                    <td valign="top" align="left" colspan="7"><br /><div style="border-bottom:thin;border-bottom-style:dotted;"><strong>Ulasan Kursus : </strong>
                    <textarea name="ulasan_kursus" id="ulasan_kursus" rows="3" cols="100" onchange="do_pro('<?=$fsetp_id;?>','<?=$id;?>',this.form.ulasan_kursus.value,'K')"><?php print $rs->fields['fsetp_remarks'];?></textarea></div><br></td>
                </tr>-->
    <tr><td colspan="5"></td></tr>
<tr><td align="center" width="100%" colspan="5">
<hr />
	<?php //print $jum_nilai."/".$cnt; ?>
    <input type="hidden" name="jum_nilai" value="<?=$jum_nilai;?>" />
    <input type="hidden" name="cnt" value="<?=$cnt;?>" />
	<input type="button" value="Tutup" style="cursor:pointer" onclick="javascript:parent.emailwindow.hide();" />
    <input type="hidden" name="win" value="<?=$URLs;?>" />
</td></td>
</table> 
</form>
