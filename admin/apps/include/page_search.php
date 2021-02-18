<script language="JavaScript1.2" type="text/javascript">
function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function do_post(){
	var data = document.ilim.data.value;
	document.ilim.action = "index.php?data="+data;
	document.ilim.target = '_self';
	document.ilim.submit();
}
</script>
<script language="javascript" type="text/javascript">	
function do_cetak(strFileName,id){
	kat = document.ilim.kategori.value;
	pus = document.ilim.pusat_id.value;
	sesi = document.ilim.get_sesi.value;
	//alert(kat);
	if(kat=='-'){
		alert("Sila pilih Program Pengajian terlebih dahulu");
		return false;
	} else if(sesi=='-'){
		alert("Sila pilih sesi kemasukan terlebih dahulu");
		return false;
	} else {
		strFileName = strFileName + '?kat='+kat+'&pus='+pus+'&sesi='+sesi;
		window.open(strFileName,"Items","toolbar=no,location=no,directories=no,status=no,menubar=yes,scrollbars=yes,resizable=yes,copyhistory=no,width=900,height=450,top=55,left=160");
	}
}

function do_excell(URL){
		document.ilim.action = URL;
		document.ilim.target = '_blank';
		document.ilim.submit();
}
</script>
<?
$data = $_GET['data'];
//$kategori = $_POST['kategori'];
//$conn->debug=true;
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<?
        $sql_k = "SELECT * FROM ref_kursus WHERE kstatus=0";
		if($pusat<>'1'){ $sql_k .= " AND kid=1"; $kategori=1; }
        $rsk = &$conn->Execute($sql_k);
    ?>
    <tr>
        <td align="right"><b>Program Pengajian :</b></td>
        <td>&nbsp;&nbsp;
            <select name="kategori" onchange="do_post()">
            <?php 	if($pusat=='1'){ ?>
                <option value="-"> -- Semua Program -- </option>
            <?php } ?>
                <?php while(!$rsk->EOF) { ?>
                <option value="<?=$rsk->fields['kid'];?>" <?php if($kategori==$rsk->fields['kid']){ print 'selected';}?>><?=$rsk->fields['kursus'];?></option>
                <?php $rsk->MoveNext(); } ?>
            </select>
        </td>
    </tr>
	<?
	if($kategori==1){
        $sql_p = "SELECT * FROM ref_pusat_pengajian WHERE pusat_status=0 ";
		if($pusat<>'1'){ $sql_p .= " AND pusat_id=".tosql($pusat,"Number"); $pusat_id=$pusat; }
		$sql_p .= " ORDER BY pusat_no";
        $rsp = &$conn->Execute($sql_p);
    ?>
    <tr>
        <td align="right"><b>Pusat Pengajian :</b></td>
        <td>&nbsp;&nbsp;
            <select name="pusat_id" onchange="do_post()">
            <?php 	if($pusat=='1'){ ?>
            	<option value="-"> -- Semua Pusat pengajian -- </option>
            <?php } ?>
                <?php while(!$rsp->EOF) { ?>
                <option value="<?=$rsp->fields['pusat_id'];?>" <?php if($pusat_id==$rsp->fields['pusat_id']){ print 'selected';}?>
                ><?php print "[ ".$rsp->fields['pusat_no'] . " ] ".$rsp->fields['pusat_nama'];?></option>
                <?php $rsp->MoveNext(); } ?>
            </select>
        </td>
    </tr>
	<?php } else {
		print '<input type="hidden" name="pusat_id" value="">';
	}
        $sql_s = "SELECT * FROM ref_sesi";
		$sql_s .= " WHERE sesi_id<>'' ";
		if(!empty($kategori) && $kategori<>'-'){ $sql_s .= " AND kursus_id=".$kategori; }
		$sql_s .= " ORDER BY sesi DESC";
        $rss = &$conn->Execute($sql_s);
    ?>
    <tr>
        <td align="right"><b>Sesi Kemasukan :</b></td>
        <td>&nbsp;&nbsp;
            <select name="get_sesi" onchange="do_post()">
            	<option value="-"> -- Semua Sesi -- </option>
                <?php while(!$rss->EOF) { ?>
                <option value="<?=$rss->fields['sesi_id'];?>" <?php if($get_sesi==$rss->fields['sesi_id']){ print 'selected';}?>><?=$rss->fields['sesi'];?></option>
                <?php $rss->MoveNext(); } ?>
            </select>
        </td>
    </tr>
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<?php echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
            <?php if(!empty($href_cetak)){ ?>
            <input type="button" name="Cari" value="  Cetak Senarai  " onClick="do_cetak('<?=$href_cetak;?>')">
            <?php } ?>
            <?php if(!empty($href_excel)){ ?>
            <input type="button" name="Cari" value="  Salin ke Excel  " onClick="do_excell('<?=$href_excel;?>')">
            <?php } ?>
            <input type="hidden" name="data" value="<?=$data;?>" />
		</td>
	</tr>
	<tr> 
	  <td>&nbsp;</td>
	</tr>
	<tr> 
		<td align="left">Jumlah Rekod : <b><?=$RecordCount;?></b></td>
		<td align="right"><b>Sebanyak 
		<select name="linepage" onChange="do_page('<?=$href_search;?>')">
			<option value="10" <?php if($PageSize==10){ echo 'selected'; }?>>10</option>
			<option value="20" <?php if($PageSize==20){ echo 'selected'; }?>>20</option>
			<option value="50" <?php if($PageSize==50){ echo 'selected'; }?>>50</option>
			<option value="100" <?php if($PageSize==100){ echo 'selected'; }?>>100</option>
		</select> rekod dipaparkan bagi setiap halaman.&nbsp;&nbsp;&nbsp;</b> 
	  </td>
	</tr>
</table>