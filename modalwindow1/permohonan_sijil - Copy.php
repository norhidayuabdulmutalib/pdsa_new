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
    $type = $_GET['type'];
    //$tid = $_GET['tid'];
    //if(empty($tid)){ $proses = "INSERT"; } else { $proses = 'UPDATE'; }
	$proses = 'UPDATE';
    $sql_t = "SELECT * FROM _sis_tblpermohonan_pelajaran WHERE type=".tosql($type,"Text")." AND mohon_id=".tosql($mohon_id,"Text"); 
    $rs_t = &$conn->execute($sql_t);
    //echo $sql_t;
	if($type=='SPM'){
		$title = "SIJIL-SIJIL LAIN YANG SETARAF DENGAN SPM";
	} else if($type=='STPM'){
		$title = "Sijil Tinggi Persekolahan (STPM)";
	} else if($type=='AGAMA'){
		$title = "Sijil Agama Negeri ";
	}
	
	$sql_sub = "SELECT * FROM ref_moe_subjek WHERE ref_ms_type='".$type."'";
	$rs_sub = &$conn->execute($sql_sub);
    ?>
    <body style="background: #F3F3F3">
    <form id="myform" name="myform" method="post" action="permohonan_sijil.php">
    <table width="90%" cellpadding="5" cellspacing="0" align="center" border="1">
    	<tr>
        	<td colspan="3" align="center" bgcolor="#999999">MAKLUMAT MATA PELAJARAN [ <?=$title;?> ]</td>
        </tr>
    	<tr align="center" bgcolor="#CCCCCC">
        	<td width="70%">Mata Pelajaran</td>
            <td width="20%">Gred</td>
            <td width="10%">Hapus</td>
        </tr>
		<? if(!$rs_t->EOF){ 
			while(!$rs_t->EOF){ ?>
        <tr>
        	<td>
            	<input type="hidden" size="5" name="mataid[]" value="<?=$rs_t->fields['mmp_id'];?>">
                <select name="matapelajaran[]">
                	<option value=""> -- Sila Pilih -- </option>
                    <? $rs_sub->movefirst();
						while(!$rs_sub->EOF){ ?>
                        <option value="<?=$rs_sub->fields['ref_ms_subjek'];?>" <? if($rs_sub->fields['ref_ms_subjek']==$rs_t->fields['matapelajaran']){ print 'selected'; } ?>
                        ><?=$rs_sub->fields['ref_ms_subjek'];?></option>
                        <? $rs_sub->movenext();
						} ?>
                </select>
            	<!--<input type="text" size="60" name="matapelajaran[<?=$bil?>]" value="<?=$rs_t->fields['matapelajaran'];?>">-->
            </td>
        	<td align="center">
            	<!--<input type="text" size="5" name="gred[<?=$bil?>]" value="<?=$rs_t->fields['gred'];?>" align="middle">-->
                <select name="gred[]">
                    <option value="1A" <? if($rs_t->fields['gred']=='1A'){ print 'selected'; } ?>>1A</option>
                    <option value="2A" <? if($rs_t->fields['gred']=='2A'){ print 'selected'; } ?>>2A</option>
                    <option value="3B" <? if($rs_t->fields['gred']=='3B'){ print 'selected'; } ?>>3B</option>
                    <option value="4B" <? if($rs_t->fields['gred']=='4B'){ print 'selected'; } ?>>4B</option>
                    <option value="5C" <? if($rs_t->fields['gred']=='5C'){ print 'selected'; } ?>>5C</option>
                    <option value="6C" <? if($rs_t->fields['gred']=='6C'){ print 'selected'; } ?>>6C</option>
                    <option value="7D" <? if($rs_t->fields['gred']=='7D'){ print 'selected'; } ?>>7D</option>
                    <option value="8E" <? if($rs_t->fields['gred']=='8E'){ print 'selected'; } ?>>8E</option>
                </select>
                </td>
        	<td align="center"><input type="checkbox" name="del[<?=$bil?>]">&nbsp;</td>
        </tr>	
        <? 	$rs_t->movenext();
			$bil++;
			} 
		} ?>
        <? for($i=$bil; $i<=10; $i++){ ?>
        <tr>
        	<td>
            	<input type="hidden" size="5" name="mataid[]" value="<?=$rs_t->fields['mmp_id'];?>">
                <select name="matapelajaran[]">
                	<option value=""> -- Sila Pilih -- </option>
                    <? $rs_sub->movefirst();
						while(!$rs_sub->EOF){ ?>
                        <option value="<?=$rs_sub->fields['ref_ms_subjek'];?>" <? if($rs_sub->fields['ref_ms_subjek']==$rs_t->fields['matapelajaran']){ print ''; } ?>
                        ><?=$rs_sub->fields['ref_ms_subjek'];?></option>
                        <? $rs_sub->movenext();
						} ?>
                </select>
            	<!--<input type="text" size="60" name="matapelajaran[<?=$i?>]" value="<?=$rs_t->fields['matapelajaran'];?>">-->
            </td>
        	<td align="center">
            	<!--<input type="text" size="5" name="gred[<?=$i?>]" value="<?=$rs_t->fields['gred'];?>">-->
                <select name="gred[]">
                    <option value="1A" <? if($rs_t->fields['gred']=='1A'){ print 'selected'; } ?>>1A</option>
                    <option value="2A" <? if($rs_t->fields['gred']=='2A'){ print 'selected'; } ?>>2A</option>
                    <option value="3B" <? if($rs_t->fields['gred']=='3B'){ print 'selected'; } ?>>3B</option>
                    <option value="4B" <? if($rs_t->fields['gred']=='4B'){ print 'selected'; } ?>>4B</option>
                    <option value="5C" <? if($rs_t->fields['gred']=='5C'){ print 'selected'; } ?>>5C</option>
                    <option value="6C" <? if($rs_t->fields['gred']=='6C'){ print 'selected'; } ?>>6C</option>
                    <option value="7D" <? if($rs_t->fields['gred']=='7D'){ print 'selected'; } ?>>7D</option>
                    <option value="8E" <? if($rs_t->fields['gred']=='8E'){ print 'selected'; } ?>>8E</option>
                </select>
            </td>
        	<td align="center"><!--<input type="checkbox" name="del[<?=$i?>]">-->&nbsp;</td>
        </tr>	
        <? } ?>   
        <tr><td colspan="3" align="center">
            <input type="button" value="Simpan" onClick="do_save()" title="Sila klik untuk menyimpan maklumat">
            <!--<input type="button" value="Hapus" onClick="do_hapus()" title="Sila klik untuk menghapus maklumat">-->
            <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup paparan maklumat">
            <input type="hidden" name="mohon_id" value="<?=$mohon_id;?>">
            <input type="hidden" name="proses" value="<?=$proses;?>">
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
	//$nama = $_POST['tid_nama'];
	//$tid_umur = $_POST['tid_umur'];
	//$tid_sekolah = $_POST['tid_sekolah'];
	
	for($i=0;$i<=10;$i++){
		$id = $_POST['mataid'][$i];
		$chk = $_POST['del'][$i];
		$matapelajaran = $_POST['matapelajaran'][$i];
		$gred = strtoupper($_POST['gred'][$i]);
		//print "ID: ". $id . " - " . $chk . " -> ";
		if(!empty($id)){
			if($chk=='on'){
				//print "DELETE : " . $matapelajaran . "<br>";
				$sql = "DELETE FROM _sis_tblpermohonan_pelajaran WHERE mmp_id=".tosql($id,"Text");
				//print $sql."<br>";
				$conn->Execute($sql);
			} else {
				//print "Update : " . $matapelajaran . "<br>";
				$sql = "UPDATE _sis_tblpermohonan_pelajaran SET 
				matapelajaran=".tosql($matapelajaran,"Text").", gred=".tosql($gred,"Text").", 
				update_dt=".tosql(date("Y-m-d H:i:s"),"Text")." , update_by=".tosql($_SESSION["s_mohon_id"],"Text")." 
				WHERE mmp_id=".tosql($id,"Text");
				//print $sql."<br>";
				$conn->Execute($sql);
			}
		} else {
		//print "billllllllllll=".$i;
			if($matapelajaran<>''){
				//print "Insert : " . $matapelajaran . "<br>";
				$sql = "INSERT INTO _sis_tblpermohonan_pelajaran(mohon_id, type, matapelajaran, 
				gred, create_dt, create_by) 
				VALUES(".tosql($mohon_id,"Text").", ".tosql($type,"Text").", ".tosql($matapelajaran,"Text").", ".
				tosql($gred,"Text").",".tosql(date("Y-m-d H:i:s"),"Text").",".tosql($_SESSION["s_mohon_id"],"Text").")";
				//print $sql."<br>";	
				$conn->Execute($sql);
			}
		}
		//print "bil=".$i;
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
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		parent.emailwindow.hide();
		//-->
    </script>
<? } ?>
