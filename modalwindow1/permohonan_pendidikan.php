<? include '../common.php'; 
print "";
$proses = $_POST['proses'];
if(empty($proses)){
?>
    <html>
    <script language="javascript" type="text/javascript">
    function do_save(){
		document.myform.submit();
    }
	
	/*function do_hapus(){
		document.myform.proses.value = 'DELETE';		
		document.myform.submit();
	}*/
	
	function do_close(){
		parent.emailwindow.hide();
	}
    </script>
	<?
    $mohon_id = $_GET['id'];
    //$type = $_GET['type'];
    //$tid = $_GET['tid'];
    //if(empty($tid)){ $proses = "INSERT"; } else { $proses = 'UPDATE'; }
	$proses = 'UPDATE';
    $sql_t = "SELECT * FROM _sis_tblpermohonan_sekolah WHERE mohon_id=".tosql($mohon_id,"Text"); 
    $rs_t = &$conn->execute($sql_t);
    //echo $sql_t;
    ?>
    <body style="background: #F3F3F3">
    <form id="myform" name="myform" method="post" action="permohonan_pendidikan.php">
    <table width="90%" cellpadding="5" cellspacing="0" align="center" border="1">
    	<tr>
        	<td colspan="4" align="center" bgcolor="#999999">Maklumat Pendidikan Menengah</td>
        </tr>
    	<tr>
        	<td width="50%">Nama Sekolah</td>
            <td width="15%">Tahun Tamat</td>
            <td width="25%">Keputusan Tertinggi</td>
            <td width="10%">Hapus</td>
        </tr>
		<? if(!$rs_t->EOF){ 
			while(!$rs_t->EOF){ ?>
        <tr>
        	<td>
            	<input type="hidden" size="5" name="sekolahid[<?=$bil;?>]" value="<?=$rs_t->fields['sekolahid'];?>">
            	<input type="text" size="50" name="sekolah[<?=$bil?>]" value="<?=$rs_t->fields['sekolah'];?>">
            </td>
        	<td align="center"><input type="text" size="5" name="tahun[<?=$bil?>]" value="<?=$rs_t->fields['tahun'];?>" align="middle"></td>
        	<td align="center"><input type="text" size="30" name="keputusan[<?=$bil?>]" value="<?=$rs_t->fields['keputusan'];?>" align="middle"></td>
        	<td align="center"><input type="checkbox" name="del[<?=$bil?>]">&nbsp;</td>
        </tr>	
        <? 	$rs_t->movenext();
			$bil++;
			} 
		} ?>
        <? for($i=$bil; $i<=6; $i++){ ?>
        <tr>
        	<td>
            	<input type="hidden" size="5" name="sekolahid[<?=$i;?>]" value="<?=$rs_t->fields['sekolahid'];?>">
            	<input type="text" size="50" name="sekolah[<?=$i?>]" value="<?=$rs_t->fields['sekolah'];?>">
            </td>
        	<td align="center"><input type="text" size="5" name="tahun[<?=$i?>]" value="<?=$rs_t->fields['tahun'];?>"></td>
        	<td align="center"><input type="text" size="30" name="keputusan[<?=$i?>]" value="<?=$rs_t->fields['keputusan'];?>"></td>
        	<td align="center"><!--<input type="checkbox" name="del[<?=$i?>]">-->&nbsp;</td>
        </tr>	
        <? } ?>   
        <tr><td colspan="4" align="center">
            <input type="button" value="Simpan" onClick="do_save()" title="Sila klik untuk menyimpan maklumat">
            <!--<input type="button" value="Hapus" onClick="do_hapus()" title="Sila klik untuk menghapus maklumat">-->
            <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup paparan maklumat">
            <input type="hidden" name="mohon_id" value="<?=$mohon_id;?>">
            <input type="hidden" name="proses" value="<?=$proses;?>">
        </td></tr>
    </table>
    </form>
    </body>
    </html>
    <script language="javascript" type="text/javascript">
		//document.myform.tid_nama.focus();
	</script>
<? } else { ?>
    <?
	$proses = $_POST['proses'];
	$mohon_id = $_POST['mohon_id'];
	//$nama = $_POST['tid_nama'];
	//$tid_umur = $_POST['tid_umur'];
	//$tid_sekolah = $_POST['tid_sekolah'];
	
	for($i=0;$i<=10;$i++){
		$sekolahid = $_POST['sekolahid'][$i];
		$chk = $_POST['del'][$i];
		$sekolah = strtoupper($_POST['sekolah'][$i]);
		$tahun = strtoupper($_POST['tahun'][$i]);
		$keputusan = strtoupper($_POST['keputusan'][$i]);
		print "ID: ". $id . " - " . $chk . " -> ";
		if(!empty($sekolahid)){
			if($chk=='on'){
				print "DELETE : " . $matapelajaran . "<br>";
				$sql = "DELETE FROM _sis_tblpermohonan_sekolah WHERE sekolahid=".tosql($sekolahid,"Text");
				print $sql."<br>";
				$conn->Execute($sql);
			} else {
				print "Update : " . $matapelajaran . "<br>";
				$sql = "UPDATE _sis_tblpermohonan_sekolah SET 
				sekolah=".tosql($sekolah,"Text").", tahun=".tosql($tahun,"Text").",
				keputusan=".tosql($keputusan,"Text").", update_dt=".tosql(date("Y-m-d H:i:s"),"Text")." 
				WHERE sekolahid=".tosql($sekolahid,"Text");
				print $sql."<br>";
				$conn->Execute($sql);
			}
		} else {
			if($sekolah<>''){
				print "Insert : " . $matapelajaran . "<br>";
				$sql = "INSERT INTO _sis_tblpermohonan_sekolah(mohon_id, sekolah, tahun, 
				keputusan, create_dt) 
				VALUES(".tosql($mohon_id,"Text").", ".tosql($sekolah,"Text").", ".tosql($tahun,"Text").", ".
				tosql($keputusan,"Text").",".tosql(date("Y-m-d H:i:s"),"Text").")";
				print $sql."<br>";	
				$conn->Execute($sql);
			}
		}
	}
	/*if($proses=="INSERT"){
		$sql = "INSERT INTO _sis_tblpermohonan_tanggung(mohon_id, tid_nama, tid_umur, tid_sekolah) 
		VALUES(".tosql($mohon_id,"Text").",".tosql($nama,"Text").",".tosql($tid_umur,"Number").",".tosql($tid_sekolah,"Text").")";
	} else if($proses=='UPDATE'){
		$sql = "UPDATE _sis_tblpermohonan_tanggung SET 
		tid_nama=".tosql($nama,"Text").", tid_umur=".tosql($tid_umur,"Number").", 
		tid_sekolah=".tosql($tid_sekolah,"Text")." 
		WHERE mohon_tid=".tosql($tid,"Text");
	} else if($proses=='DELETE'){
		$sql = "DELETE FROM _sis_tblpermohonan_tanggung WHERE mohon_tid=".tosql($tid,"Text");
	}*/
	//$conn->Execute($sql);
	//exit;
    ?>
    <form id="myform" name="myform" method="post">
    	<table width="100%"><tr><td>&nbsp;</td></tr></table>
    </form>
    <script language="javascript" type="text/javascript">
		<!--
		//parent.location.href="../index.php?data=bW9ob247cGVybW9ob25hbi9wZWxhamFyX2Jpb19wZW5qYWdhLnBocDtiaW9kYXRhO2lidWJhcGE=";
		parent.location.reload();
		parent.emailwindow.hide();
		//-->
    </script>
<? } ?>
