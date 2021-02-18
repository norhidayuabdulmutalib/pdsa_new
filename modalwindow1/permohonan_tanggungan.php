<? include '../common.php'; 
$proses = $_POST['proses'];
if(empty($proses)){
?>
    <html>
	<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
    <script language="javascript" type="text/javascript">
    function do_save(){
		/*if(document.myform.tid_nama.value==''){
			alert("Sila masukkan nama anak dibawah tanggungan penjaga.");
			document.myform.tid_nama.focus();
			return false;
		} else {*/
			document.myform.submit();
		//}
    }
	
	function do_hapus(){
		document.myform.proses.value = 'DELETE';		
		document.myform.submit();
	}
	
	function do_close(){
		parent.emailwindow.hide();
	}
    </script>
    <body style="background: #F3F3F3">
    <?
    $mohon_id = $_GET['id'];
    $tid = $_GET['tid'];
	if(empty($tid)){ $proses = "INSERT"; } else { $proses = 'UPDATE'; }
    $sql_t = "SELECT * FROM _sis_tblpermohonan_tanggung WHERE mohon_tid=".tosql($tid,"Text"); 
    $rs_t = &$conn->execute($sql_t);
    //echo $sql_t;
    ?>
    <form id="myform" name="myform" method="post" action="permohonan_tanggungan.php">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>Nama Tanggungan (1): </td>
            <td><input type="text" name="tid_nama[]" size="80" maxlength="120" value="<?=$rs_t->fields['tid_nama'];?>"></td>
        </tr>
        <tr>
            <td>Umur: </td>
            <td><input type="text" name="tid_umur[]" size="5" maxlength="2" value="<?=$rs_t->fields['tid_umur'];?>"></td>
        </tr>
        <tr>
            <td>Sekolah / Institusi : </td>
            <td><input type="text" name="tid_sekolah[]" size="80" maxlength="120" value="<?=$rs_t->fields['tid_sekolah'];?>"></td>
        </tr>
		<tr><td colspan="2"><hr></td></tr>
        <tr>
            <td>Nama Tanggungan (2): </td>
            <td><input type="text" name="tid_nama[]" size="80" maxlength="120" value="<?=$rs_t->fields['tid_nama'];?>"></td>
        </tr>
        <tr>
            <td>Umur: </td>
            <td><input type="text" name="tid_umur[]" size="5" maxlength="2" value="<?=$rs_t->fields['tid_umur'];?>"></td>
        </tr>
        <tr>
            <td>Sekolah / Institusi : </td>
            <td><input type="text" name="tid_sekolah[]" size="80" maxlength="120" value="<?=$rs_t->fields['tid_sekolah'];?>"></td>
        </tr>
		<tr><td colspan="2"><hr></td></tr>
        <tr>
            <td>Nama Tanggungan (3): </td>
            <td><input type="text" name="tid_nama[]" size="80" maxlength="120" value="<?=$rs_t->fields['tid_nama'];?>"></td>
        </tr>
        <tr>
            <td>Umur: </td>
            <td><input type="text" name="tid_umur[]" size="5" maxlength="2" value="<?=$rs_t->fields['tid_umur'];?>"></td>
        </tr>
        <tr>
            <td>Sekolah / Institusi : </td>
            <td><input type="text" name="tid_sekolah[]" size="80" maxlength="120" value="<?=$rs_t->fields['tid_sekolah'];?>"></td>
        </tr>
		<tr><td colspan="2"><hr></td></tr>
        <tr>
            <td>Nama Tanggungan (4): </td>
            <td><input type="text" name="tid_nama[]" size="80" maxlength="120" value="<?=$rs_t->fields['tid_nama'];?>"></td>
        </tr>
        <tr>
            <td>Umur: </td>
            <td><input type="text" name="tid_umur[]" size="5" maxlength="2" value="<?=$rs_t->fields['tid_umur'];?>"></td>
        </tr>
        <tr>
            <td>Sekolah / Institusi : </td>
            <td><input type="text" name="tid_sekolah[]" size="80" maxlength="120" value="<?=$rs_t->fields['tid_sekolah'];?>"></td>
        </tr>
		<tr><td colspan="2"><hr></td></tr>

    
        <tr><td colspan="2" align="center">
            <input type="button" value="Simpan" onClick="do_save()" title="Sila klik untuk menyimpan maklumat">
            <? if(!empty($tid)){ ?><input type="button" value="Hapus" onClick="do_hapus()" title="Sila klik untuk menghapus maklumat"><? } ?>
            <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup paparan maklumat">
            <input type="hidden" name="mohon_id" value="<?=$mohon_id;?>">
            <input type="hidden" name="tid" value="<?=$tid;?>">
            <input type="hidden" name="proses" value="<?=$proses;?>">
        </td></tr>
    </table>
    </form>
    </body>
    </html>
    <script language="javascript" type="text/javascript">
		document.myform.tid_nama.focus();
	</script>
<? } else { ?>
    <?
	$proses = $_POST['proses'];
	$mohon_id = $_POST['mohon_id'];
	
	//print $proses;
	
	if($proses=="INSERT"){
		for($dt=0;$dt<=3;$dt++){

			$nama = $_POST['tid_nama'][$dt];
			$tid_umur = $_POST['tid_umur'][$dt];
			$tid_sekolah = $_POST['tid_sekolah'][$dt];
			
			if(!empty($nama)){
				$sql = "INSERT INTO _sis_tblpermohonan_tanggung(mohon_id, tid_nama, tid_umur, tid_sekolah) 
				VALUES(".tosql($mohon_id,"Text").",".tosql($nama,"Text").",".tosql($tid_umur,"Number").",".tosql($tid_sekolah,"Text").")";
				$conn->Execute($sql);
				//print "<br>".$sql;
			}
		}
	} else if($proses=='UPDATE'){
		$tid = $_POST['tid'];
		$nama = $_POST['tid_nama'];
		$tid_umur = $_POST['tid_umur'];
		$tid_sekolah = $_POST['tid_sekolah'];

		$sql = "UPDATE _sis_tblpermohonan_tanggung SET 
		tid_nama=".tosql($nama,"Text").", tid_umur=".tosql($tid_umur,"Number").", 
		tid_sekolah=".tosql($tid_sekolah,"Text")." 
		WHERE mohon_tid=".tosql($tid,"Text");
		$conn->Execute($sql);
	} else if($proses=='DELETE'){
		$sql = "DELETE FROM _sis_tblpermohonan_tanggung WHERE mohon_tid=".tosql($tid,"Text");
		$conn->Execute($sql);
	}
	//exit;
    ?>
    <form id="myform" name="myform" method="post">
    	<table width="100%"><tr><td>&nbsp;</td></tr></table>
    </form>
    <script language="javascript" type="text/javascript">
		<!--
		//parent.location.href="../index.php?data=bW9ob247cGVybW9ob25hbi9wZWxhamFyX2Jpb19wZW5qYWdhLnBocDtiaW9kYXRhO2lidWJhcGE=";
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		parent.emailwindow.hide();
		//-->
    </script>
<? } ?>
