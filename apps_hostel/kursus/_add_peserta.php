<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
//$proses = $_GET['pro'];
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
if(!empty($_GET['pro'])){ $proses  =$_GET['pro']; }
if(empty($proses)){ 
$jum = dlookup("_tbl_kursus_jadual","sum(lelaki+perempuan+vip)","id=".tosql($id));
$jkl = dlookup("_tbl_kursus_luarpeserta","count(*)","event_id=".tosql($id));
$jum_peserta = $jum-$jkl;
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
		document.ilim.action = URL;
		document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">TAMBAH MAKLUMAT PESERTA KURSUS LUAR</td>
    </tr>
	<tr><td colspan="2">
    	<table width="90%" cellpadding="5" cellspacing="1" border="0" align="center">
        	<tr><td colspan="3" align="center">Sila masukkan jumlah peserta Kursus/Bengkel untuk dimasukkan ke dalam senarai<br />
            	<input type="text" size="5" maxlength="3"  name="jumlah" value="<?=$jum_peserta;?>"/>
            </td></tr>
            <tr><td colspan="3"><hr /></td></tr>
            <tr>
                <td colspan="3" align="center">
                    <input type="button" value="Ya" class="button_disp" title="Sila klik untuk padam maklumat" onClick="form_hantar('modal_form.php?<? print $URLs;?>&pro=PRO')" >
                    <input type="button" value="Tidak" class="button_disp" title="Sila klik untuk kembali" onClick="form_back()" >
                    <input type="hidden" name="id" value="<?=$id?>" />
				</td>
            </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script language="javascript">document.ilim.jumlah.focus();</script>
<?php } else {

	//print 'simpan';
	include '../loading_pro.php';
	if($proses=='DEL'){
		$pids=isset($_REQUEST["pids"])?$_REQUEST["pids"]:"";
		$sql = "DELETE FROM _tbl_kursus_luarpeserta WHERE event_id=".tosql($id)." AND pids=".tosql($pids);
		$rs = &$conn->Execute($sql); //exit;
		print "<script language=\"javascript\">
			alert('Rekod telah dihapuskan');
			//parent.location.reload();	
			refresh = parent.location; 
			parent.location = refresh;
			parent.emailwindow.hide()
			</script>";
	} else if($proses=='UPD'){
		$pids=isset($_REQUEST["pids"])?$_REQUEST["pids"]:"";
		$nama=isset($_REQUEST["nama"])?$_REQUEST["nama"]:"";
		$nokp=isset($_REQUEST["nokp"])?$_REQUEST["nokp"]:"";
		$sql = "UPDATE _tbl_kursus_luarpeserta SET nama_peserta=".tosql($nama).", no_kp=".tosql($nokp)." 
			WHERE pids=".tosql($pids);
		$rs = &$conn->Execute($sql); //exit;
	} else {
		$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
		$jumlah=isset($_REQUEST["jumlah"])?$_REQUEST["jumlah"]:"";
		//$jkl = dlookup("_tbl_kursus_luarpeserta","count(*)","event_id=".tosql($id));
		if(!empty($id)){
			for($i=0;$i<$jumlah;$i++){
				$sql = "INSERT INTO _tbl_kursus_luarpeserta(event_id) VALUES(".tosql($id).")";
				$rs = &$conn->Execute($sql);
			}
			//audit_trail($sql,"");
		}
		print "<script language=\"javascript\">
			alert('Rekod telah ditambah');
			//parent.location.reload();	
			refresh = parent.location; 
			parent.location = refresh;
			parent.emailwindow.hide()
			</script>";
	}
	//exit;
}
?>