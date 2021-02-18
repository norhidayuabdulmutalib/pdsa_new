<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses = $_GET['pro'];
//$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
//if(empty($proses)){ 
?>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	var inaka_banknama = document.ilim.inaka_banknama.value;
	var inaka_bankcawangan = document.ilim.inaka_bankcawangan.value;
	var inaka_banknoacct = document.ilim.inaka_banknoacct.value;
	if(inaka_banknama==''){
		alert("Sila masukkan maklumat nama bank terlebih dahulu.");
		document.ilim.inaka_banknama.focus();
		return true;
	} else if(inaka_bankcawangan==''){
		alert("Sila masukkan nama nama cawangan bagi bank terlebih dahulu.");
		document.ilim.inaka_bankcawangan.focus();
		return true;
     } else if(inaka_banknoacct==''){
		alert("Sila masukkan nombor akaun bank terlebih dahulu.");
		document.ilim.inaka_banknoacct.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
//if(!empty($id)){
	$sSQL="SELECT * FROM _tbl_instructor_bank WHERE ingenid_bank = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
//}
?>

<form name="ilim" method="post" enctype="multipart/form-data" >
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT BUKU BANK PENCERAMAH</h4>
	</div>

    <div class="card-body">
        <?php if(!empty($msg)){ ?>
            <tr>
                <td align="center" colspan="3"><b><i><font color="#FF0000"><?php print $msg;?></font></i></b></td>
            </tr>
            <?php } ?>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Nama Bank :</b></label>
                <div class="col-sm-12 col-md-7">
 				    <input class="form-control" type="text" size="80" maxlength="120" name="inaka_banknama" value="<?php print $rs->fields['inaka_banknama'];?>" />
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Cawangan :</b></label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control" maxlength="120" name="inaka_bankcawangan" value="<?php print $rs->fields['inaka_bankcawangan'];?>" />
                </div>
            </div>

            <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>No. Akaun :</b></label>
                <div class="col-sm-12 col-md-7">
                    <input type="text" class="form-control" maxlength="32" name="inaka_banknoacct" value="<?php print $rs->fields['inaka_banknoacct'];?>" />
                </div>
            </div>

			<div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Muatnaik Sijil :</b></label>
                <div class="col-sm-12 col-md-7">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                    <input type="hidden" name="action1" value="1">
                    <input type="file" name="file1" size="50">
                    <!--<br />
                    <input type="radio" name="img_baru" value="Y" />Muatnaik Imej Baru &nbsp;&nbsp;&nbsp;
                    <input type="radio" name="img_baru" value="N" checked="checked" />Kekalkan imej-->
                    <br /><br />
                    <?php if(!empty($rs->fields['fld_image'])){ ?>
                    <img src="all_pic/img_bukubank.php?id=<?php echo $rs->fields['ingenid_bank'];?>" width="150" height="150" border="0"><br />
                    <?php print $rs->fields['fld_image'];?>
                    <?php } ?>
                    <br />Sila pastikan hanya fail imej berikut sahaja yang dibenarkan untuk dimuatnaik ke dalam sistem (PNG, JPG, JPEG, GIF) atau fail PDF sahaja. 
                
                </div>
            </div>

            <hr />
            <div>
                <div colspan="3" align="center">
                    <button class="btn btn-success" value="Simpan" style="cursor:pointer; padding:8px;" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('penceramah/_bukubank_form_do.php')" ><i class="fas fa-save"></i> Simpan</button>
                    <button class="btn btn-secondary" value="Kembali" style="cursor:pointer; padding:8px;" class="button_disp" title="Sila klik untuk kembali ke maklumat penceramah" onClick="form_back()" ><i class="fas fa-undo"></i> Kembali</button>
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                
                </div>
            </div>

        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.inaka_banknama.focus();
</script>
