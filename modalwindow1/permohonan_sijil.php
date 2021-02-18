<? include '../common.php'; 
print "";
$proses = $_POST['proses'];
if(empty($proses)){
?>
    <html>
	<link rel="stylesheet" href="../css/style.css" type="text/css" />
    <script language="javascript" type="text/javascript">
    function do_save(){
		document.myform.submit();
    }
	
	function do_hapus(){
		if(conform("Adakah anda pasti untuk menghapuskan maklumat matapelajaran?")){
			document.myform.proses.value = 'DELETE';		
			document.myform.submit();
		}
	}
	
	function do_close(){
		parent.emailwindow.hide();
	}
    </script>
	<?
	$proses = 'INSERT';
    $mohon_id = $_GET['id'];
    $type = $_GET['type'];
    $mmp_id = $_GET['mmp_id'];
    //if(empty($tid)){ $proses = "INSERT"; } else { $proses = 'UPDATE'; }
	if(!empty($mmp_id)){
    	$sql_t = "SELECT * FROM _sis_tblpermohonan_pelajaran WHERE type=".tosql($type,"Text")." AND mohon_id=".tosql($mohon_id,"Text")." AND mmp_id=".tosql($mmp_id,"Text"); 
    	$rs_t = &$conn->execute($sql_t);
		$matapelajaran = $rs_t->fields['matapelajaran'];
		$gred = $rs_t->fields['gred'];
    //echo $sql_t;
		$proses = 'UPDATE';
	}
	if($type=='SPM'){
		$title = "SIJIL-SIJIL LAIN YANG SETARAF DENGAN SPM";
	} else if($type=='STPM'){
		$title = "Sijil Tinggi Agama (STAM)";
	} else if($type=='AGAMA'){
		$title = "Sijil Agama Negeri ";
	}
	
	//$sql_sub = "SELECT * FROM ref_moe_subjek WHERE ref_ms_type='".$type."'";
	//$rs_sub = &$conn->execute($sql_sub);
    ?>
    <body style="background: #F3F3F3">
    <form id="myform" name="myform" method="post" action="permohonan_sijil.php">
    <table width="90%" cellpadding="5" cellspacing="0" align="center" border="1">
    	<tr>
        	<td colspan="3" align="center" bgcolor="#999999">MAKLUMAT MATA PELAJARAN [ <?=$title;?> ]</td>
        </tr>
    	<tr align="center" bgcolor="#CCCCCC">
			<td width="10%">Bil</td>
        	<td width="75%">Mata Pelajaran</td>
            <td width="15%" align="center">Gred</td>
        </tr>
        <? if($proses=='INSERT' || $proses=='UPDATE'){ ?>
        <tr>
            <td align="right">1.&nbsp;</td>
            <td><input type="text" name="matapelajaran[]" size="60" maxlength="120" value="<?=$matapelajaran;?>"></td>
            <td align="center"><input type="text" name="gred[]" size="5" maxlength="5" value="<?=$gred;?>"></td>
        </tr>
        <? } ?>
        <? if($proses=='INSERT'){ ?>
        <tr>
            <td align="right">2.&nbsp;</td>
            <td><input type="text" name="matapelajaran[]" size="60" maxlength="120" value=""></td>
            <td align="center"><input type="text" name="gred[]" size="5" maxlength="5" value=""></td>
        </tr>
        <tr>
            <td align="right">3.&nbsp;</td>
            <td><input type="text" name="matapelajaran[]" size="60" maxlength="120" value=""></td>
            <td align="center"><input type="text" name="gred[]" size="5" maxlength="5" value=""></td>
        </tr>
        <tr>
            <td align="right">4.&nbsp;</td>
            <td><input type="text" name="matapelajaran[]" size="60" maxlength="120" value=""></td>
            <td align="center"><input type="text" name="gred[]" size="5" maxlength="5" value=""></td>
        </tr>
        <tr>
            <td align="right">5.&nbsp;</td>
            <td><input type="text" name="matapelajaran[]" size="60" maxlength="120" value=""></td>
            <td align="center"><input type="text" name="gred[]" size="5" maxlength="5" value=""></td>
        </tr>
		<? } ?>
        <tr><td colspan="3" align="center">
            <input type="button" value="Simpan" onClick="do_save()" title="Sila klik untuk menyimpan maklumat">
            <? if(!empty($mmp_id)){ ?><input type="button" value="Hapus" onClick="do_hapus()" title="Sila klik untuk menghapus maklumat"><? } ?>
            <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup paparan maklumat">
            <input type="hidden" name="mohon_id" value="<?=$mohon_id;?>">
            <input type="hidden" name="proses" value="<?=$proses;?>">
            <input type="hidden" name="mmp_id" value="<?=$mmp_id;?>">
            <input type="hidden" name="type" value="<?=$type;?>">
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
	//$conn->debug=true;
	$proses = $_POST['proses'];
	$mohon_id = $_POST['mohon_id'];
	$type = $_POST['type'];
	$mmp_id = $_POST['mmp_id'];

	//print $proses;
	
	if($proses=="INSERT"){
		for($dt=0;$dt<=4;$dt++){
			$matapelajaran = $_POST['matapelajaran'][$dt];
			$gred = $_POST['gred'][$dt];
			
			if(!empty($matapelajaran)){
				$sql = "INSERT INTO _sis_tblpermohonan_pelajaran(mohon_id, type, matapelajaran, 
				gred, create_dt, create_by) 
				VALUES(".tosql($mohon_id,"Text").", ".tosql($type,"Text").", ".tosql($matapelajaran,"Text").", ".
				tosql($gred,"Text").",".tosql(date("Y-m-d H:i:s"),"Text").",".tosql($_SESSION["s_mohon_id"],"Text").")";
				$conn->Execute($sql);
				//print "<br>".$sql;
			}
		}
	} else if($proses=='UPDATE'){
		$matapelajaran = $_POST['matapelajaran'][0];
		$gred = $_POST['gred'][0];

		$sql = "UPDATE _sis_tblpermohonan_pelajaran SET 
		matapelajaran=".tosql($matapelajaran,"Text").", gred=".tosql($gred,"Text").", 
		update_dt=".tosql(date("Y-m-d H:i:s"),"Text")." , update_by=".tosql($_SESSION["s_mohon_id"],"Text")." 
		WHERE mmp_id=".tosql($mmp_id,"Text");
		$conn->Execute($sql);
	} else if($proses=='DELETE'){
		$sql = "DELETE FROM _sis_tblpermohonan_pelajaran WHERE mmp_id=".tosql($mmp_id,"Text");
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
		parent.location.reload();
		parent.emailwindow.hide();
		//-->
    </script>
	<? } ?>
