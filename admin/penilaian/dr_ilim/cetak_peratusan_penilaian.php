<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetakan Penilaian</title>
<script language="javascript" type="text/javascript">	
function do_close(){
	parent.emailwindow.hide();
	//window.close();
}
function handleprint(){
	window.print();
}
</script>
<style type="text/css" media="all">@import"../../css/print_style.css";</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 10px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }

@media all{
 .page-break { display:none; }
}

@media print{
 .page-break { display:block; page-break-before:always; }
}
</style>
</head>
<body>
<?
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
if(empty($id)){ $id=isset($_REQUEST["id"])?$_REQUEST["id"]:""; }
$proses=isset($_REQUEST["PRO"])?$_REQUEST["PRO"]:"";
?>
<script language="javascript">
function do_proses(id){
	var winds = document.ilim.winds.value;
	//alert(winds);
	document.ilim.action = 'modal_form.php?win='+winds+'&id='+id+'&PRO=PROSES';
	document.ilim.submit();
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
	if(jumpk>jk){
		alert("Jumlah input data melebihi jumlah kehadiran peserta");
	} else {
		var URL = 'penilaian/peratusan_penilaian_upd.php?pkid='+pkid+"&pk1="+pk1+"&pk2="+pk2+"&pk3="+pk3+"&pk4="+pk4+"&pk5="+pk5;
		callToServer(URL);
	}
	//document.ilim.action=URL;
	//document.ilim.target='_blank';
	//document.ilim.submit();
}
</script>
<?php
function disp_heads(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="15%" align="center" valign="bottom"><b>&nbsp;</b></td>
                    <td width="10%" align="center" valign="bottom"><b>Bilangan Peserta</b></td>
                    <td width="10%" align="center" valign="bottom"><b>Peratusan<br /></b></td>
                </tr>';
}
function disp_heads2(){
	return '<!--<tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>-->
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="1"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
                    <td width="7%" align="center" colspan=2 valign="bottom"><b>&nbsp;</b></td>
                    <td width="7%" align="center" colspan=3 valign="bottom"><b>&nbsp;</b></td>
                </tr>';
}


$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate, D.penyelaras 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Next");
$rskursus = &$conn->Execute($sSQL);
$jum_hadir = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND EventId=".tosql($id));
?>
<form name="ilim" method="post">
<input type="hidden" name="id" value="<?=$id;?>" />
<input type="hidden" name="winds" value="<?=$_GET['win'];?>" />
<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
  <THEAD>
    <tr valign="top" bgcolosr="#80ABF2">
    	<td width="30%">&nbsp;</td> 
        <td width="40%" height="30" colspan="3" valign="middle" align="center">            
	        <img src="../images/crestmalaysia.gif" width="50" height="35" border="0" /><br />
        </td>
    	<td width="30%"><div style="float:right;vertical-align:text-top" align="right"><b>BPP(2)</b><br /><b>Institut Latihan Islam Malaysia 2011</b></div></td> 
    </tr>
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle" align="center" width="100%">            
            Institut Latihan Islam Malaysia<br />
            Jalan Sungai Merab, Seksyen 12,<br />
            43650 Bandar Baru Bangi, Selangor<br />
        </td>
    </tr>
  </THEAD>
  <TBODY style="width:100%">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle" align="center">
	        <font size="3" face="Arial, Helvetica, sans-serif"><strong>BORANG RUMUSAN PENYELARAS KURSUS</strong></font>
        </td>
    </tr>
    <tr><td colspan="5">
        <table width="100%" cellpadding="2" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="16%" align="left"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="83%" align="left"><?php print $rskursus->fields['courseid'] . " - " .$rskursus->fields['coursename'];?></td>                
            </tr>
            <tr>
                <td align="left"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rskursus->fields['startdate']);?> - <?php print DisplayDate($rskursus->fields['enddate']);?></td>                
            </tr>
            <!--<tr>
                <td align="left"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php //print $rskursus->fields['categorytype'];?></td>                
            </tr>-->
            <tr>
                <td align="left"><b>Bilangan Peserta</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $jum_hadir;?></td>                
            </tr>
            <tr>
                <td align="left"><b>Nama Penyelaras</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rskursus->fields['penyelaras'];?></td>                
            </tr>
            <tr>
                <td align="left"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rskursus->fields['SubCategoryNm'];?></td>                
            </tr>
		</table>
    </td></tr>
    <tr><td colspan="5">&nbsp;</td></tr>
    <?php
    $sql_data = "SELECT * FROM _tbl_set_penilaian WHERE fset_event_id=".tosql($id);
	$rs_nilai = &$conn->execute($sql_data);
	//$conn->debug=true;
	$jum_tawaran = dlookup("_tbl_kursus_jadual_peserta","count(*)","EventId=".tosql($id));
	//$jum_nilai = dlookup_cnt("_tbl_penilaian_peserta","distinct pp_peserta_id","pp_eventid=".tosql($id)." GROUP BY pp_peserta_id");
	$jum_nilai = dlookup_cnt("_tbl_set_penilaian_peserta_bhg","distinct id_peserta","event_id=".tosql($id)." GROUP BY id_peserta");	
	$sqlsel = "SELECT id_peserta FROM _tbl_set_penilaian_peserta WHERE is_nilai=0 AND event_id=".tosql($id);
	$rsnilai = $conn->execute($sqlsel); $jum_xhantar = $rsnilai->recordcount();
	//$jum_hadir = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND EventId=".tosql($id));
	//$conn->debug=false;
	//$jum_peserta=$rs_nilai->fields['jum_hadir'];
	$jum_peserta = dlookup("_tbl_kursus_jadual_peserta","count(*)","InternalStudentAccepted= 1 AND EventId=".tosql($id));
	$xnilai = $jum_peserta-$jum_nilai;
	?>
	<tr>
        <td valign="top" colspan="5"><!--<strong>Jumlah Tawaran : <?php //print $jum_tawaran;?></strong> peserta
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
        <strong>Jumlah Kehadiran : <?php print $jum_peserta;?></strong> peserta hadir<input type="hidden" name="jk" value="<?=$jum_hadir;?>" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Jumlah Peserta Menilai : <?php print $jum_nilai;?></strong> membuat penilaian
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Jumlah Tidak Nilai :</strong> <?php print $xnilai;?> orang
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    
    
    <?php
	//print "U:".$jum_peserta;
	if(empty($jum_peserta)){ $jum_peserta=1; }
	$pct_19 = (($rs_nilai->fields['fset_umur19']+$rs_nilai->fields['fset_umur19_off'])/$jum_peserta)*100;
	$pct_20 = (($rs_nilai->fields['fset_umur20']+$rs_nilai->fields['fset_umur20_off'])/$jum_peserta)*100;
	$pct_30 = (($rs_nilai->fields['fset_umur30']+$rs_nilai->fields['fset_umur30_off'])/$jum_peserta)*100;
	$pct_40 = (($rs_nilai->fields['fset_umur40']+$rs_nilai->fields['fset_umur40_off'])/$jum_peserta)*100;
	$pct_50 = (($rs_nilai->fields['fset_umur50']+$rs_nilai->fields['fset_umur50_off'])/$jum_peserta)*100;
	$jum_pumur = $rs_nilai->fields['fset_umur19']+$rs_nilai->fields['fset_umur19_off']+
				 $rs_nilai->fields['fset_umur20']+$rs_nilai->fields['fset_umur20_off']+
				 $rs_nilai->fields['fset_umur30']+$rs_nilai->fields['fset_umur30_off']+
				 $rs_nilai->fields['fset_umur40']+$rs_nilai->fields['fset_umur40_off']+
				 $rs_nilai->fields['fset_umur50']+$rs_nilai->fields['fset_umur50_off'];
	if(!empty($jum_nilai)){ $pct_jum_pumur = ($jum_pumur/$jum_peserta)*100; }

	$pct_lelaki = (($rs_nilai->fields['fset_jantina_l']+$rs_nilai->fields['fset_jantina_l_off'])/$jum_peserta)*100;
	$pct_wanita = (($rs_nilai->fields['fset_jantina_p']+$rs_nilai->fields['fset_jantina_p_off'])/$jum_peserta)*100;
	$jum_jantina =  $rs_nilai->fields['fset_jantina_l']+$rs_nilai->fields['fset_jantina_l_off']+
				 	$rs_nilai->fields['fset_jantina_p']+$rs_nilai->fields['fset_jantina_p_off'];
	if(!empty($jum_nilai)){ $pct_jum_jantina = ($jum_jantina/$jum_peserta)*100; }

	$pct_jusa = (($rs_nilai->fields['fset_jusa']+$rs_nilai->fields['fset_jusa_off'])/$jum_peserta)*100;
	$pct_pp = (($rs_nilai->fields['fset_pp']+$rs_nilai->fields['fset_pp_off'])/$jum_peserta)*100;
	$pct_sokongan = (($rs_nilai->fields['fset_sokongan']+$rs_nilai->fields['fset_sokongan_off'])/$jum_peserta)*100;
	$jum_jawatan = $rs_nilai->fields['fset_jusa']+$rs_nilai->fields['fset_jusa_off']+
				 $rs_nilai->fields['fset_pp']+$rs_nilai->fields['fset_pp_off']+
				 $rs_nilai->fields['fset_sokongan']+$rs_nilai->fields['fset_sokongan_off'];
	if(!empty($jum_nilai)){ $pct_jum_jawatan = ($jum_jawatan/$jum_peserta)*100; }

	$pct_pertama = (($rs_nilai->fields['fset_pertama']+$rs_nilai->fields['fset_pertama_off'])/$jum_peserta)*100;
	$pct_kedua = (($rs_nilai->fields['fset_kedua']+$rs_nilai->fields['fset_kedua_off'])/$jum_peserta)*100;
	$pct_ketiga = (($rs_nilai->fields['fset_ketiga']+$rs_nilai->fields['fset_ketiga_off'])/$jum_peserta)*100;	
	$jum_kkursus = $rs_nilai->fields['fset_pertama']+$rs_nilai->fields['fset_pertama_off']+
				 $rs_nilai->fields['fset_kedua']+$rs_nilai->fields['fset_kedua_off']+
				 $rs_nilai->fields['fset_ketiga']+$rs_nilai->fields['fset_ketiga_off'];
	if(!empty($jum_nilai)){ $pct_jum_kkursus = ($jum_kkursus/$jum_peserta)*100; }
	?>
	<tr><td colspan="5"><table width="100%" border="1" cellspacing="0" cellpadding="1">
        <tr bgcolor="#CCCCCC">
            <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
            <td width="15%" align="center" valign="bottom"><b>&nbsp;</b></td>
            <td width="10%" align="center" valign="bottom"><b>Bilangan Peserta</b></td>
            <td width="10%" align="center" valign="bottom"><b>Peratusan<br /></b></td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" rowspan="6">Umur</td>
            <td align="center" valign="bottom">20 ke bawah&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_umur19']+$rs_nilai->fields['fset_umur19_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_19,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">20 - 29 tahun&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_umur20']+$rs_nilai->fields['fset_umur20_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_20,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">30 - 39 tahun&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_umur30']+$rs_nilai->fields['fset_umur30_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_30,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">40 - 49 tahun&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_umur40']+$rs_nilai->fields['fset_umur40_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_40,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">50 tahun keatas&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_umur50']+$rs_nilai->fields['fset_umur50_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_50,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">Jumlah</td>
            <td align="center" valign="bottom"><?php print $jum_pumur;?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_jum_pumur,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#CCCCCC">
            <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
            <td width="15%" align="center" valign="bottom"><b>&nbsp;</b></td>
            <td width="10%" align="center" valign="bottom"><b>Bilangan Peserta</b></td>
            <td width="10%" align="center" valign="bottom"><b>Peratusan<br /></b></td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" rowspan="3">Jantina</td>
            <td align="center" valign="bottom">Lelaki&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_jantina_l']+$rs_nilai->fields['fset_jantina_l_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_lelaki,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">Perempuan&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_jantina_p']+$rs_nilai->fields['fset_jantina_p_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_wanita,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">Jumlah</td>
            <td align="center" valign="bottom"><?php print $jum_jantina;?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_jum_jantina,2);?>%&nbsp;</td>
        </tr>

        <tr bgcolor="#CCCCCC">
            <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
            <td width="15%" align="center" valign="bottom"><b>&nbsp;</b></td>
            <td width="10%" align="center" valign="bottom"><b>Bilangan Peserta</b></td>
            <td width="10%" align="center" valign="bottom"><b>Peratusan<br /></b></td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" rowspan="4">Kumpulan Jawatan</td>
            <td align="center" valign="bottom">JUSA&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_jusa']+$rs_nilai->fields['fset_jusa_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_jusa,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">P&P&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_pp']+$rs_nilai->fields['fset_pp_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_pp,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">Sokongan&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_sokongan']+$rs_nilai->fields['fset_sokongan_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_sokongan,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">Jumlah</td>
            <td align="center" valign="bottom"><?php print $jum_jawatan;?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_jum_jawatan,2);?>%&nbsp;</td>
        </tr>


        <tr bgcolor="#CCCCCC">
            <td width="60%" align="center" rowspan="1"><b>Maklumat Penilaian</b></td>
            <td width="15%" align="center" valign="bottom"><b>&nbsp;</b></td>
            <td width="10%" align="center" valign="bottom"><b>Bilangan Peserta</b></td>
            <td width="10%" align="center" valign="bottom"><b>Peratusan<br /></b></td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" rowspan="4">Kekerapan Kursus di ILIM</td>
            <td align="center" valign="bottom">Pertama&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_pertama']+$rs_nilai->fields['fset_pertama_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_pertama,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">Kedua&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_kedua']+$rs_nilai->fields['fset_kedua_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_kedua,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">Lebih dari dua&nbsp;</td>
            <td align="center" valign="bottom"><?php print $rs_nilai->fields['fset_ketiga']+$rs_nilai->fields['fset_ketiga_off'];?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_ketiga,2);?>%&nbsp;</td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td align="center" valign="bottom">Jumlah</td>
            <td align="center" valign="bottom"><?php print $jum_kkursus;?>&nbsp;</td>
            <td align="center" valign="bottom"><?php print number_format($pct_jum_kkursus,2);?>%&nbsp;</td>
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
    </table><br /></td></tr>
	<tr><td colspan="5"><table width="100%" border="1" cellpadding="5" cellspacing="0">
		<tr>
		  <td colspan="3"><b>Pecahan Jumlah Peserta :</b></td>
		</tr>
    	<tr>
        	<td width="5%" align="center"><b> Bil </b></td>
            <td width="85%" align="left"><b>Nama Jabatan/Kementerian</b></td>	    
            <td width="10%" align="center"><b>Jumlah Peserta</b></td>
        </tr>
        <tr>
        	<td align="right">1.</td>	
            <td>Jabatan Kemajuan Islam Malaysia (JAKIM)</td>
            <td align="center"> <?php  
            $sqlj = "SELECT A.* as cnt FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=1 AND A.InternalStudentAccepted=1 AND A.EventId=".tosql($id);
			//AND A.is_sijil=1 
			$rsj = &$conn->Execute($sqlj); $jakim = $rsj->recordcount(); print $jakim; $jum_all+=$jakim;
			?></td>
        </tr>    
        <tr>
        	<td align="right">2.</td>	
            <td>Jabatan Agama Islam Negeri (JAIN)</td>
            <td align="center"><?php
            $sqlj = "SELECT A.* as cnt FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=2 AND  A.InternalStudentAccepted=1 AND A.EventId=".tosql($id);
			// A.is_sijil=1 
			$rsj = &$conn->Execute($sqlj); $jain = $rsj->recordcount(); print $jain; $jum_all+=$jain;
			?></td>
        </tr>    
        <tr>
        	<td align="right">3.</td>	
            <td>Majlis Agama Islam Negeri (MAIN)</td>
            <td align="center"><?php
			$sqlj = "SELECT A.* as cnt FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=3 AND  A.InternalStudentAccepted=1 AND A.EventId=".tosql($id); 
			//A.is_sijil=1
			$rsj = &$conn->Execute($sqlj); $main = $rsj->recordcount();	print $main; $jum_all+=$main;	 	
			?></td>
        </tr>    
        <tr>
        	<td align="right">4.</td>	
            <td>Jabatan Mufti</td>
            <td align="center"><?php
            $sqlj = "SELECT A.* as cnt FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
			WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=4 AND  A.InternalStudentAccepted=1 AND A.EventId=".tosql($id);
			//A.is_sijil=1
			$rsj = &$conn->Execute($sqlj); $jmufti = $rsj->recordcount(); print $jmufti; $jum_all+=$jmufti;
			?></td>
        </tr> 
        <?php
		$cnts=5;
        $sqljlain = "SELECT distinct B.BranchCd FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
					WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND D.ref_ktid=5 AND A.InternalStudentAccepted=1 AND A.EventId=".tosql($id);
					//A.is_sijil=1
		$rsjlain = &$conn->Execute($sqljlain); 
		while(!$rsjlain->EOF){ 
		?>
        <tr>
        	<td align="right"><?php print $cnts++;?>.</td>	
            <td><?php
            	print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rsjlain->fields['BranchCd']));  
			?></td>
            <td align="center"><?php
				$sqljlain = "SELECT A.* as cnt FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _ref_tempatbertugas C, _ref_tempat_kategori D
				WHERE A.peserta_icno=B.f_peserta_noic AND B.BranchCd=C.f_tbcode AND C.ref_ktid=D.ref_ktid AND A.InternalStudentAccepted=1 AND D.ref_ktid=5 
				AND A.EventId=".tosql($id)." AND B.BranchCd=".$rsjlain->fields['BranchCd'];// AND A.is_sijil=1 
				$rsjl = &$conn->Execute($sqljlain); print $rsjl->recordcount(); $jum_all+=$rsjl->recordcount();
            ?></td>
        </tr>    
		<?php $rsjlain->movenext(); }   ?>
        <tr>
        	<td align="right"><?=$cnts++;?>.</td>	
            <td>Lain-Lain</td>
            <td align="center"><?php
            $sqlj = "SELECT A.* as cnt FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
			WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND B.BranchCd='0099' AND A.EventId=".tosql($id);
			//print $sqlj;
			$rsj = &$conn->Execute($sqlj); $ll = $rsj->recordcount(); print $ll; $jum_all+=$ll; //AND A.is_sijil=1 
			?></td>
        </tr> 
        <tr>
        	<td align="right" colspan="2"><b>JUMLAH</b></td>
            <td align="center"><b><?php print $jum_all;?></b></td>
        </tr> 
    </table><br /></td></tr>
      <tr>
        <td colspan="2" valign="top"><b>Gred : </b><br />
		<table width="150%" height="96" border="1" cellpadding="5" cellspacing="0">
    <tr>
            	<td><b>Bil</b></td>
            	<td><b>Kod Gred Jawatan</b></td>
                <td><b>Jumlah</b></td>
            </tr>
			<?php
            $cnt=0; $cnt_jum=0;//$conn->debug=true;
            $sqljlain = "SELECT count(*) as grades, B.f_title_grade FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
                        WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND A.EventId=".tosql($id)." GROUP BY B.f_title_grade"; //A.is_sijil=1
            $rsjlain = &$conn->Execute($sqljlain); 
            while(!$rsjlain->EOF){ $cnt++; 
				$sql1 = "SELECT * FROM _ref_titlegred WHERE f_gred_id=".tosql($rsjlain->fields['f_title_grade']);
				$rsgred = $conn->execute($sql1);
				$kodgred = $rsgred->fields['f_gred_name'] . " &nbsp;(".$rsgred->fields['f_gred_code'].")";
				$grades = $rsjlain->fields['grades']; $cnt_jum+=$grades;
            ?>
    		<tr>
            	<td align="right"><?php print $cnt;?>.</td>
                <td align="left"><?php print $kodgred;?></td>
                <td align="center"><?php print $grades;?></td>
            </tr>        
			<?php $rsjlain->movenext(); }  $conn->debug=false;  ?>
            <tr>
                <td align="right" colspan="2"><b>JUMLAH</b></td>
                <td align="center"><b><?php print $cnt_jum;?></b></td>
            </tr> 
		</table>
        </td>
        <td>&nbsp;</td>
        <td colspan="2" valign="top"><b>Negeri Tempat Bertugas : </b><br />
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td><b>Bil</b></td>
                    <td><b>Negeri</b></td>
                    <td><b>Jumlah</b></td>
                </tr>
                <?php
                $cntn=0; $cntn_jum=0;
				//$conn->debug=true;
                $sqljlain = "SELECT count(*) as negeris, B.f_peserta_negeri FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B
                            WHERE A.peserta_icno=B.f_peserta_noic AND A.InternalStudentAccepted=1 AND A.EventId=".tosql($id)." GROUP BY B.f_peserta_negeri";//A.is_sijil=1
                $rsjlain = &$conn->Execute($sqljlain); 
				$conn->debug=false;
                while(!$rsjlain->EOF){ $cntn++;
                    $sql1 = "SELECT * FROM ref_negeri WHERE kod_negeri=".tosql($rsjlain->fields['f_peserta_negeri']);
                    $rsgred = $conn->execute($sql1);
                    $negeri = $rsgred->fields['negeri'];
                    $jumn = $rsjlain->fields['negeris']; $cntn_jum+=$jumn;
                ?>
                <tr>
                    <td align="right"><?php print $cntn;?>.</td>
                    <td align="left"><?php print $negeri;?></td>
                    <td align="center"><?php print $jumn;?></td>
                </tr>        
                <?php $rsjlain->movenext(); }  $conn->debug=false;  ?>
                <tr>
                    <td align="right" colspan="2"><b>JUMLAH</b></td>
                    <td align="center"><b><?php print $cntn_jum;?></b></td>
                </tr> 
            </table>
      </tr>

	<tr><td>&nbsp;</td></tr>


    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
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
	$sql_det .= " ORDER BY sorts";
	$rs_bhg = &$conn->Execute($sql_det);
            if(!$rs_bhg->EOF) {
				$bil_bhg=0;
                while(!$rs_bhg->EOF) {
					$bil_bhg++;
					 $fsetb_id = $rs_bhg->fields['fsetb_id'];
					 $fsetbp_id= $rs_bhg->fields['fsetbp_id'];
					 $fsetb_pensyarah_id = $rs_bhg->fields['fsetb_pensyarah_id'];
					 $fsetb_jadmasaid = $rs_bhg->fields['fsetb_jadmasaid'];
					 $jump=0;
            ?>
                    <tr height="25px" bgcolor="#666666">
                        <td colspan="7" align="left">&nbsp;&nbsp;<b><label><?php echo stripslashes($rs_bhg->fields['nilai_keterangan']);?></label></b></td>
                    </tr>
                    <?php
                    /*if(!empty($fsetb_pensyarah_id)){ // JIKA MELIBATKAN PENSYARAH
                        $sql_p = "SELECT A.tajuk, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($id)." 
						AND A.id_pensyarah=".tosql($fsetb_pensyarah_id)." AND A.id_pensyarah=B.ingenid AND A.id_jadmasa=".tosql($fsetb_jadmasaid);
                        $rs_pensyarah = $conn->execute($sql_p);
						print '<tr height="25px" bgcolor="#CCCCCC">
							<td colspan="7" align="left"><b>Nama Pensyarah : '.stripslashes($rs_pensyarah->fields['insname']).'
							<br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).'</b></td>
						</tr>';
					}*/
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
					$bil=0;
					$jum_set=0;
					while(!$rs_det->EOF){ 
						$bil++;
						$pct_set1=0;$pct_set2=0;$pct_set3=0;$pct_set4=0;$pct_set5=0;$jum_set=0;
						$fsetdet_id=$rs_det->fields['fsetdet_id'];
						$set1 = $rs_det->fields['fsetdet_1'];
						$set2 = $rs_det->fields['fsetdet_2'];
						$set3 = $rs_det->fields['fsetdet_3'];
						$set4 = $rs_det->fields['fsetdet_4'];
						$set5 = $rs_det->fields['fsetdet_5'];
						$jum_set=$set1+$set2+$set3+$set4+$set5;
						if(!empty($set1)){ $pct_set1=($set1/$jum_set)*100; }
						if(!empty($set2)){ $pct_set2=($set2/$jum_set)*100; }
						if(!empty($set3)){ $pct_set3=($set3/$jum_set)*100; }
						if(!empty($set4)){ $pct_set4=($set4/$jum_set)*100; }
						if(!empty($set5)){ $pct_set5=($set5/$jum_set)*100; }
						if($rs_det->fields['f_penilaian_jawab']=='1'){
							if($bil==1){ print disp_heads(); }
				?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right" rowspan="6" width="5%"><?=$bil;?>.</td>
                                <td valign="top" align="left" rowspan="6" width="45%"><?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td valign="top" align="left" width="25%">Amat Tidak Setuju&nbsp;</td>
                                <td align="center" width="9%"><?=$set1;?></td>
                              <td align="center" width="16%"><?=number_format($pct_set1,2);?></td>
              </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Tidak Setuju&nbsp;</td>
                              <td align="center"><?=$set2;?></td>
                                <td align="center"><?=number_format($pct_set2,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Kurang Setuju&nbsp;</td>
                                <td align="center"><?=$set3;?></td>
                                <td align="center"><?=number_format($pct_set3,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left"> Setuju&nbsp;</td>
                              <td align="center"><?=$set4;?></td>
                                <td align="center"><?=number_format($pct_set4,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Sangat Setuju&nbsp;</td>
                              <td align="center"><?=$set5;?></td>
                                <td align="center"><?=number_format($pct_set5,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left"><strong>Jumlah</strong>&nbsp;</td>
                                <td align="center"><strong><?=$jum_set;?></strong></td>
                                <td align="center"><strong><?php if(!empty($jum_nilai)){ print number_format(($jum_set/$jum_peserta)*100,2); }?>%</strong></td>
                            </tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ 
							if($bil==1){ print disp_heads2(); } ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right" rowspan="3"><?=$bil;?>.</td>
                                <td valign="top" align="left" rowspan="3"><?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td valign="top" align="left">Ya&nbsp;</td>
                                <td align="center"><?=$set1;?></td>
                                <td align="center"><?=number_format($pct_set1,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left">Tidak&nbsp;</td>
                                <td align="center"><?=$set2;?></td>
                                <td align="center"><?=number_format($pct_set2,2);?></td>
                            </tr>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="left"><strong>Jumlah</strong>&nbsp;</td>
                                <td align="center"><strong><?=$jum_set;?></strong></td>
                                <td align="center"><strong>100%</strong></td>
                            </tr>
						<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ 
							if($bil==1){ print disp_heads2(); }?>
						<tr bgcolor="#FFFFFF">
							<td valign="top" align="right"><?=$bil;?>.</td>
							<td valign="top" align="left" colspan="6">
								<?php echo stripslashes($rs_det->fields['f_penilaian_desc']);?><br />
								<textarea rows="10" cols="100" name="remarks" onchange="do_pro('<?=$pp_id;?>','<?=$id;?>','<?=$ppset_id;?>',99,'<?=$kursus_id;?>','')"><?php print $pp_remarks;?></textarea>&nbsp;</td>
						</tr>
						<?php
						}
						$cnt = $cnt + 1;
						$rs_det->movenext();
					} 
					$bil = $bil + 1;
				$rs_bhg->movenext();
				}
			} 
             ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5"></td></tr>
<?php
$sql_det = "SELECT * FROM _tbl_set_penilaian_peserta WHERE fsetp_remarks IS NOT NULL AND is_nilai=1 AND event_id=".tosql($id);
//$conn->debug=true;
$rs_remarks = &$conn->Execute($sql_det);
$cnt_n = $rs_remarks->recordcount();
if($cnt_n<>0){ $bilr=0;
?>
	<div class="page-break">&nbsp;</div>
    <tr><td colspan="5">
    	<table width="100%" cellpadding="5" cellspacing="0" border="1">
        	<tr><td colspan="2">Senarai maklumat tambahan penilaian</td></tr>
        	<tr>
            	<td id="5%">Bil</td>
                <td width="95%">Kenyataan</td>
            </tr>
			<?php while(!$rs_remarks->EOF){ $bilr++; ?>
            <tr>
            	<td align="right"><?php print $bilr; ?>.</td>
                <td align="left"><?php print $rs_remarks->fields['fsetp_remarks'];?></td>
            </tr>
            <?php $rs_remarks->movenext(); } ?>
        </table>
    </td></tr>
<?php } ?>
    </TBODY>
</table> 
</form>
<div class="printButton" align="center">
	<br>
	<table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
   	<input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
    <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
    <br>Please change the printing Orientation to <b>Potrait</b> before printing.
	<br /><br />
    </td></tr></table>
</div>
</body>
</html>
