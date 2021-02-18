<?php 
//include_once '../common.php';
//$conn->debug=true;
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
$nokp=isset($_REQUEST["nokp"])?$_REQUEST["nokp"]:"";
$proses = $_GET['pro'];
$msg='';
?>
<script LANGUAGE="JavaScript">
function do_pages(URL){
	//alert(URL);
	document.ilim.action = URL;
	document.ilim.submit();
}
function do_delete(URL){
	if(confirm("Adakah anda pasti?")){
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function do_logs(URL){
	//alert(URL);
	parent.document.ilim.action = URL;
	parent.document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}

function openModal(URL){
	//alert(URL);
	var height=screen.height-150;
	var width=screen.width-200;

	var returnValue = window.showModalDialog(URL, 'ILIM','help:no;status:yes;scroll:yes;resize:yes;toolbar=yes;dialogHeight:'+height+'px;dialogWidth:'+width+'px');
} 
</script>
<form name="ilim" method="post">
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr><td colspan="3" height="30px" align="center" valign="middle" bgcolor="#66CC99">
    	<b>Sila masukkan No. kad Pengenalan anda / Kad Kuasa (Polis/Tentera)</b>
    </td></tr>
    <tr>
        <td width="28%" align="right"><b> No. Kad Pengenalan : </b></td> 
   	  	<td width="72%" colspan="2" align="left">
        	<input type="text" size="20" name="nokp" value="<?=$nokp;?>" />&nbsp;
      		<input type="button" value="Semak" style="cursor:pointer" 
            onclick="do_pages('modal_form.php?win=<?=base64_encode('katalog/semakan_permohonan.php;');?>')" />
            <input type="button" value="Tutup" style="cursor:pointer" onclick="form_back()" />
        </td>
    </tr>
</table>
<?php
//print $nokp;
if(!empty($nokp)){ 
	//$conn->debug=true;
	$idp=isset($_REQUEST["idp"])?$_REQUEST["idp"]:"";
	if(!empty($idp)){
		$sqld = "UPDATE _tbl_kursus_jadual_peserta SET is_deleted=1, delete_dt=".tosql(date("Y-m-d H:i:s")).", delete_by=".tosql($nokp)." 
			WHERE InternalStudentId=".tosql($idp);
		$conn->Execute($sqld);
		//print $sqld;	
	}

	//$conn->debug=true;
	$sql_det = "SELECT B.f_peserta_noic, A.*, B.f_peserta_nama, B.BranchCd, B.f_title_grade, 
	D.courseid, D.coursename, C.startdate, C.enddate, A.is_selected, C.penyelaras, C.penyelaras_notel, 
	C.penyelaras_email, C.status AS status_kursus  
	FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B, _tbl_kursus_jadual C, _tbl_kursus D 
	WHERE A.peserta_icno=B.f_peserta_noic AND A.is_deleted=0 AND A.peserta_icno=".tosql($nokp);
	$sql_det .= " AND A.EventId=C.id AND C.courseid=D.id AND C.startdate>".tosql(date("Y-m-d"));
	$sql_det .= " GROUP BY A.EventId, B.f_peserta_noic ORDER BY C.enddate ASC";
	$rs = &$conn->Execute($sql_det); //AND A.is_selected=1 
	$conn->debug=false;
	if(!$rs->EOF){
?>
        <br />
        <hr />
        <table width="96%" cellpadding="5" cellspacing="1" border="0" align="center">
            <tr>
            	<td colspan="1" align="left" valign="middle" width="25%"><b>No. Kad Pengenalan :</b></td> 
				<td colspan="2" align="left" width="75%"><?php print strtoupper(stripslashes($rs->fields['f_peserta_noic']));?></td>
            </tr>
            <tr>
            	<td colspan="1" align="left" valign="middle"><b>Nama :</b></td> 
				<td colspan="2"><?php print strtoupper(stripslashes($rs->fields['f_peserta_nama']));?></td>
            </tr>
            <tr>
            	<td colspan="1" align="left" valign="middle"><b>Kementerian/Jabatan :</b></td> 
				<td colspan="2"><?php print dlookup("_ref_tempatbertugas","f_tempat_nama","f_tbcode=".tosql($rs->fields['BranchCd']));?></td>
            </tr>

        </table>    
        <hr />
        <table width="96%" cellpadding="5" cellspacing="0" border="1" align="center">
        	<tr bgcolor="#CCCCCC">
            	<td width="30%" align="center"><b>Nama Kursus</b></td>
            	<td width="8%" align="center"><b>Mula Kursus</b></td>
            	<td width="8%" align="center"><b>Tamat Kursus</b></td>
            	<td width="8%" align="center"><b>Status</b></td>
            	<td width="20%" align="center"><b>Penyelaras Kursus</b></td>
            	<td width="10%" align="center"><b>Telefon</b></td>
            	<!--<td width="20%" align="center"><b>Email</b></td>
            	<td width="5%" align="center"><b>Kehadiran</b></td>-->
            </tr>
<?		while(!$rs->EOF){ 
			if($rs->fields['is_selected']=='1'){ $stat = '<b>Berjaya</b>'; } 
			else if($rs->fields['is_selected']=='9'){ $stat = '<font color="#FF0000">Tidak Berjaya</font>'; } 
			else { $stat='<font color="#0000FF">Dalam Proses</font>'; }
			$href_surat = "modal_form.php?win=".base64_encode('apps/kursus/jadual_peserta_surat.php;'.$rs->fields['InternalStudentId']);
			$href_kehadiran = "modal_form.php?win=".base64_encode('apps/kursus/jadual_peserta_kehadiran.php;'.$rs->fields['InternalStudentId']);
			if($rs->fields['status_kursus']==2){ $stat = '<font color="#FF0000"><b><i>Kursus Dibatalkan</i></b></font>'; }
			//if($rs->fields['status_kursus']==3){ $stat .= '<br><font color="#FF0000"><b><i>Kursus Ditukarkan Ke Tarikh Lain</i></b></font>'; }
?>
			<tr>
            	<td align="left"><?=$rs->fields['courseid']." - ".$rs->fields['coursename'];?></td>
            	<td align="center"><?=DisplayDate($rs->fields['startdate']);?></td>
            	<td align="center"><?=DisplayDate($rs->fields['enddate']);?></td>
            	<td align="center"><?=$stat;?>&nbsp;</td>
            	<td align="left"><?=$rs->fields['penyelaras'];?>&nbsp;</td>
            	<td align="left"><?=$rs->fields['penyelaras_notel'];?>&nbsp;</td>
            	<!--<td align="left"><?=$rs->fields['penyelaras_email'];?>&nbsp;</td>
            	<td align="center">
					<?=$hadir;?>
                	<?php //if($rs->fields['is_selected']!='9'){ ?>
						<?php //if($rs->fields['is_selected']=='1'){ ?>
                            <img src="images/printicon.gif" border="0" style="cursor:pointer" width="25" height="22" 
                            onclick="openModal('<?php// print $href_surat;?>&ty=S')" title="Cetak surat pengesahan kehadiran kursus" />
                            <img src="images/printer.png" border="0" style="cursor:pointer" width="25" height="22" 
                            onclick="openModal('<?php// print $href_kehadiran;?>&ty=S')" title="Cetak surat pengesahan kehadiran kursus" />
                    	<?php //} else { ?> 
                            <img src="img/off.gif" width="23" height="23" style="cursor:pointer" 
                            onclick="do_delete('modal_form.php?win=<?//=base64_encode('katalog/semakan_permohonan.php;');?>&idp=<?=$rs->fields['InternalStudentId'];?>')" />
                    	<?php //} ?> 
                    <?php //} ?> 
                </td>-->
            	
            </tr>

<?php 
			$rs->movenext();
		}
?>
        </table>
        <br /><br />
        <b>NOTA : </b><br />
        Kepada peserta yang menginap di asrama, kaunter pendaftaran asrama hanya dibuka dari jam 7.00 pagi hingga 7.00 petang pada hari bekerja.<br />
        Sila berurusan pada waktu yang ditetapkan.<br />
        Sekian, Terima Kasih.
<?php		
	} else { ?>
<br />
<hr /><br />
<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
	<tr><td colspan="3" height="30px" align="center" valign="middle">
		Tiada maklumat dijumpai.<br /><br />
        <input type="button" value="Tutup" style="cursor:pointer" onclick="form_back()" />
	</td></tr>
</table>
<?php
}
}
?>
</form>
