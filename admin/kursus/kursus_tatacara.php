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
	//audit_trail($sql,"");
	//print $sql;
	
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();
		</script>";
}

$sSQL="SELECT * FROM _ref_kandungan WHERE idkandungan = 'TERMA'";
$rs = &$conn->Execute($sSQL);
if($rs->EOF){ $conn->execute("INSERT INTO _ref_kandungan(idkandungan)VALUE('TERMA')"); }
//print $sSQL;
$maklumat = $rs->fields['maklumat'];
?>
<script src="ckeditor/ckeditor.js"></script>
<script LANGUAGE="JavaScript">
function form_hantar(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
</script>
<br>
<section class="section">
	<div class="section-body">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h4>Objektif Pusat/Unit</h4>
					</div>
                    <form name="ilim" method="post">
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <div class="col-sm-12 col-md-12">
                                    <textarea class="form-control" name="maklumat" id="myform"><?php print $maklumat; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12" align="right" style="padding-right:0px;">
                                <button class="btn btn-success" name="Simpan" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('index.php?<?php print $URLs;?>&pro=SAVE')"><i class="fas fa-save"></i><b> Simpan</b></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script language="javascript">
	document.ilim.maklumat.focus();
</script><script>
   CKEDITOR.replace( 'maklumat' );
   var dform = document.getElementById("myform");
   editor.config.height = dform.clientHeight - 10; 
   //editor.resize(editor.config.width, editor.config.height, true, true); 
</script>
