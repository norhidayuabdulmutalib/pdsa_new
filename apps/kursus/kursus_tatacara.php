<?php
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
$proses = $_GET['pro'];
$msg='';
//$conn->debug=true;
if($proses=='SAVE'){ 
	$maklumat 		= $_POST['maklumat'];

	$sql = "UPDATE _ref_kandungan SET 
		maklumat=".tosql($maklumat,"Text").",
		update_by=".tosql($update_by,"Text").",
		update_dt=".tosql(date("Y-m-d"),"Text")."
		WHERE idkandungan='TERMA'";
	$rs = &$conn->Execute($sql);
	//audit_trail($sql);
	//print $sql;
	
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();
		</script>";
}

$dir='';
$pathtoscript='../editor/';
include_once($dir."../editor/config.inc.php");
include_once($dir."../editor/FCKeditor/fckeditor.php") ;

$sSQL="SELECT * FROM _ref_kandungan WHERE idkandungan = 'TERMA'";
$rs = &$conn->Execute($sSQL);
if($rs->EOF){ $conn->execute("INSERT INTO _ref_kandungan(idkandungan)VALUE('TERMA')"); }
//print $sSQL;
$maklumat = $rs->fields['maklumat'];
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
</script>

<form name="ilim" method="post">
<table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
    <tr>
        <td align="right" valign="top"><b>Objektif</b></td>
        <td align="center" valign="top"><b> : </b></td>
        <td align="left" valign="top" colspan="2"> <div class="rte"> 
                  <?  if ($wysiwyg===true){ 
                    $oFCKeditor = new FCKeditor('maklumat') ;
                    $oFCKeditor->BasePath = $pathtoscript.'../editor/FCKeditor/';
                    $oFCKeditor->Value = $maklumat;
                    $oFCKeditor->Width = "100%";
                    $oFCKeditor->Height = 350;
                    $oFCKeditor->Create() ;
                 } else {
                  ?>
                      <textarea name="maklumat" cols="60" rows="5"><?php print $maklumat; ?></textarea>
                 <? }?>
                    </div>
    </td></tr>
    <tr>
        <td colspan="5" align="center">
            <?php //if($btn_display==1){ ?>
            <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('index.php?<? print $URLs;?>&pro=SAVE')" >
            <?php //} ?>
            <!--<input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >-->
        </td>
    </tr>
</table>
</form>
<script language="javascript">
	document.ilim.maklumat.focus();
</script>