<script LANGUAGE="JavaScript">
function form_hantar(URL){
	if(document.ilim.insname.value==''){
		alert("Sila masukkan nama penceramah terlebih dahulu.");
		document.ilim.insname.focus();
		return true;
	} else if(document.ilim.insid.value==''){
		alert("Sila masukkan No. Kad Pengenalan.");
		document.ilim.insid.focus();
		return true;
	} else if(document.ilim.insorganization.value==''){
		alert("Sila masukkan maklumat jabatan.");
		document.ilim.insorganization.focus();
		return true;
	} else if(document.ilim.inskategori.value==''){
		alert("Sila pilih kategori penceramah.");
		document.ilim.inskategori.focus();
		return true;
	} else if (document.ilim.payperhours.value != '' && isNaN(document.ilim.payperhours.value)){
		alert("Sila masukkan angka sahaja pada kadar bayaran sejam.");
		document.ilim.payperhours.focus();
		return true;
	} else {
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function form_hapus(URL){
	var staff = document.ilim.insname.value;
	if(confirm("Adakah anda pasti untuk menghapuskan Rekod Penceramah Ini?\n-"+staff)){
		document.ilim.proses.value = "HAPUS";
		document.ilim.action = URL;
		document.ilim.submit();
	}
}

function do_search(URL){
	var insid = document.ilim.insid.value;
	var kp1=''; var kp2=''; var kp3='';
	insid = cleanIcNum(insid);
	document.ilim.action = URL+"&kp="+insid;
	document.ilim.submit();
}

function cleanIcNum(icValue) {
	//  var icValue = ic.value;
	  var sepArr = new Array("-"," ");
	  for (i = 0; i < sepArr.length; i++) {
		  if (icValue.indexOf(sepArr[i]) != -1) 
			var repStr = eval("/" + sepArr[i] + "/g");
			var myNewIc = icValue.replace(repStr,"");
	   }  
	//  ic.value = myNewIc;
	    return myNewIc;
	  }
	  
function isValidDate(input, inputDesc){
	//var validformat=/^\d{2}\/\d{2}\/\d{4}$/ //Basic check for format validity
	 var sepArr = new Array("/","-",".");
     var strDate = input.value;
	 var sepArrOcc = 0;
	 var returnval=true;
   
     if (strDate=="") return true;
	 for (i = 0; i < sepArr.length; i++) {
      if (strDate.indexOf(sepArr[i]) != -1) {
	      sepArrOcc = sepArrOcc + 1;
		  var sep = sepArr[i];
		  }
	  }
	   if (sepArrOcc != 1) {
				alert("Format "+inputDesc+" tidak sah. Sila masuk format tarikh yang sah (dd/mm/yyyy).");
				returnval=false;
			}
		else {
	        strDateArray = strDate.split(sep);
      		if (strDateArray.length != 3) {
				alert("Format "+inputDesc+" tidak sah. Sila masuk format tarikh yang sah (dd/mm/yyyy).");
				returnval=false;
			}
			 else {
				var repStr = eval("/" + sep + "/g");
  				strDate = strDate.replace(repStr,"/");
			}
		}
		
	 if (returnval==true) { //Detailed check for valid date ranges
	 		var dayfield=strDate.split("/")[0]
			var monthfield=strDate.split("/")[1]
			var yearfield=strDate.split("/")[2]
			if (parseInt(dayfield) < 10 && dayfield.length == 1) dayfield = "0" + dayfield ;
			if (parseInt(monthfield) < 10 && monthfield.length == 1) monthfield = "0" + monthfield ;
			if (yearfield.length != 4) {
					if (parseInt(yearfield) > 30) yearfield = "19" + yearfield ;
      				else yearfield = "20" + yearfield;
				}
            input.value = dayfield + "/" + monthfield + "/" + yearfield;
			
			var dayobj = new Date(yearfield, monthfield-1, dayfield)
			if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield)) {
			returnval=false;
			alert(inputDesc+" yang dimasukkan tidak sah. Sila masuk tarikh yang sah (dd/mm/yyyy).");
			}
	 }
	if (returnval==false) {
    input.focus();
    input.select();
    }
  return returnval;
} 


function do_back(URL){
	document.ilim.action =URL;
	document.ilim.submit();
}

function Update_Img(msg){
	//window.parent.frm.submit();
	document.ilim.pic.value = msg;
	document.ilim.elImage.src = msg;
	//alert(msg);
	//window.refresh();
}

function upload_gambar(URL){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Kemaskini Gambar Penceramah', 'width=550px,height=200px,center=1,resize=0,scrolling=1')
} //End "opennewsletter" function
</script>
<?php
//$conn->debug=true;
function dlookupList($Table, $fName, $sWhere, $sOrder){
	global $conn; 
	$sSQL = "SELECT " . $fName . " FROM " . $Table . " " . $sWhere . " ORDER BY ". $sOrder;
	$result = mysql_query($sSQL);
	if(mysql_errno()!= 0){ print 'Error : '.mysql_error(); exit();}
	$intRecCount = mysql_num_rows($result);
	if($intRecCount > 0){  
		return $result;
	} else {
		return "";
	}
}

$PageNo = $_POST['PageNo'];
if(!empty($_GET['kp'])){ 
	$sSQL="SELECT * FROM _tbl_instructor  WHERE is_deleted=0 AND insid = ".tosql($_GET['kp'],"Text");
} else if(!empty($_SESSION["s_logid"]) && $_SESSION["s_usertype"]=='PENSYARAH'){ 
	$sSQL="SELECT * FROM _tbl_instructor  WHERE is_deleted=0 AND insid = ".tosql($_SESSION["s_logid"],"Text");
} else {
	$sSQL="SELECT * FROM _tbl_instructor  WHERE ingenid = ".tosql($id,"Text");
}
$rs = &$conn->Execute($sSQL);
if(!$rs->EOF){ 
	$insid = $rs->fields['insid']; 
	$negara = $rs->fields['insnationality'];
	if(!empty($_GET['kp'])){
		print '<script language="javascript">
			alert("Nama penceramah telah ada dalam pangkalan data.");
		</script>';
		$id = $rs->fields['ingenid'];
	}
} else { 
	$insid=$_GET['kp']; 
	$negara = 'MY';
}
?>
<br>
<div class="section-body">
    <div class="row">
        <div class="col-9" style="padding-right:0px;">
            <div class="card">
                <div class="card-header" >
                    <h4>MAKLUMAT PENCERAMAH</h4>
                </div>
				<form name="ilim" id="frm" method="post">
				<div class="card-body">
					<tr>
						<td colspan="4" class="title" height="30">A.&nbsp;&nbsp;&nbsp;MAKLUMAT AM</td>
					</tr>
					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. K/P <font color="#FF0000">*</font> :</b></label>
						<div class="col-sm-12 col-md-5">
							<input type="text" name="insid" class="form-control" value="<?php print $insid;?>"  
                			<?php if(empty($id)){ ?>onchange="do_search('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_form.php;penceramah;daftar');?>')" <?php } ?>/>
						</div>
						<div class="col-sm-12 col-md-3" style="padding-right:0px;">
							<font color="#FF0000">cth: 700104102478</font>
						</div>
					</div>
            
					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Penuh Peserta <font color="#FF0000">*</font> :</b></label>
						<div class="col-sm-12 col-md-9">
							<input type="text" class="form-control" name="insname" value="<?php print $rs->fields['insname'];?>" />
						</div>
            		</div>

					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Gred Jawatan <font color="#FF0000">*</font> :</b></label>
						<div class="col-sm-12 col-md-9">
							<select name="titlegredcd" class="form-control">
								<option value="0">Sila pilih gred jawatan</option>
								<?php 
								$r_gred = &$conn->query("SELECT * FROM _ref_titlegred ORDER BY f_gred_code ASC");
								while (!$r_gred->EOF) { ?>
								<option value="<?=$r_gred->fields['f_gred_code'] ?>" <?php if($rs->fields['titlegredcd'] == $r_gred->fields['f_gred_code']) echo "selected"; ?> ><?=$r_gred->fields['f_gred_code']?> - <?=$r_gred->fields['f_gred_name']?></option>
								<?php $r_gred->movenext(); } ?>        
							</select>   
                		</div>
            		</div>

					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Organisasi <font color="#FF0000">*</font> :</b></label>
						<div class="col-sm-12 col-md-9">
							<input name="insorganization" class="form-control" type="text" id="insorganization" value="<?php print $rs->fields['insorganization'];?>" />
						</div>
            		</div>

            		<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kategori Penceramah <font color="#FF0000">*</font> :</b></label>
						<div class="col-sm-12 col-md-9">
							<select name="inskategori" class="form-control">
								<option value="">Sila pilih kategori penceramah</option>
									<?php 
									$r_kategori = &$conn->query("SELECT * FROM _ref_kategori_penceramah ORDER BY f_kp_sort ASC");
									while (!$r_kategori->EOF) { ?>
									<option value="<?=$r_kategori->fields['f_kp_id'] ?>" <?php if($rs->fields['inskategori'] == $r_kategori->fields['f_kp_id']) echo "selected"; ?> ><?=$r_kategori->fields['f_kp_kenyataan']?>
								</option>
								<?php $r_kategori->movenext(); }?>        
                   			</select>   
               			</div>
            		</div>

					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>No Telefon Pejabat :</b></label>
						<div class="col-sm-12 col-md-3">
							<input type="text" name="inshometel" class="form-control" maxlength="15" value="<?php print $rs->fields['inshometel'];?>">
						</div>
            		</div>
            
					<div class="form-group row" style="padding-right:0px;">
                        <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No Telefon Bimbit :</b></label>
                        <div class="col-sm-12 col-md-3">
							<input type="text" name="insmobiletel" class="form-control" maxlength="15" value="<?php print $rs->fields['insmobiletel'];?>">
						</div>
            		</div>

					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Faks :</b></label>
						<div class="col-sm-12 col-md-3">
							<input type="text" name="insfaxno" class="form-control" maxlength="15" value="<?php print $rs->fields['insfaxno'];?>">
						</div>
            		</div>

					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Email :</b></label>
						<div class="col-sm-12 col-md-3">
							<input type="text" name="insemail" class="form-control" value="<?php print $rs->fields['insemail'];?>">
						</div>
            		</div>

					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Alamat :</b></label>
						<div class="col-sm-12 col-md-9">
							<textarea cols="100" rows="7" name="insaddress" class="form-control"><?php print $rs->fields['insaddress'];?></textarea>
						</div>
            		</div>

           		 	<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Jantina :</b></label>
						<div class="col-sm-12 col-md-3">
							<select name="insgender" class="form-control">
								<option value="L" <?php if($rs->fields['insgender']=='L'){ print 'selected'; }?>>Lelaki</option>
								<option value="P" <?php if($rs->fields['insgender']=='P'){ print 'selected'; }?>>Perempuan</option>
							</select>
						</div>
					</div>
            
					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Tarikh Lahir :</b></label>
						<div class="col-sm-12 col-md-4">
							<input name="insdob" type="date" id="insdob"  class="form-control" value="<?//=DisplayDate($rs->fields['insdob'])?>" />&nbsp;
							<img src="" alt="Sila klik untuk pilih tarikh" width="18" height="19" onclick="displayCalendar(document.ilim.insdob,'dd/mm/yyyy',this)"  onmouseover="this.style.cursor='pointer'" /> 
						</div>
						<div class="col-sm-12 col-md-4" style="padding-right:0px;">
							<font color="#FF0000">( Cth : 30/04/1977 )</font>
						</div>
					</div>
          
					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Warganegara :</b></label>
						<div class="col-sm-12 col-md-3">
							<select name="insnationality" class="form-control">
								<?php 
								$r_country = &$conn->query("SELECT * FROM _ref_negara ORDER BY nama_negara");
								while (!$r_country->EOF) { ?>
								<option value="<?=$r_country->fields['kod_negara'] ?>" <?php if($negara == $r_country->fields['kod_negara']) echo "selected"; ?> ><?=$r_country->fields['nama_negara']?></option>
								<?php $r_country->movenext(); }?>        
               				</select>   
                		</div>
            		</div>

				</div>
			</div>
		</div>

		<div class="col-3">
			<div class="card">
				<form name="ilim"  id="frm" method="post">
					<div class="card-body">
						<div class="form-group row" style="padding-right:0px;">
							<div class="col-sm-12 col-md-12" align="center">
							<?php if(!empty($id)){ ?>
								<img src="all_pic/imgpenceramah.php?id=<?php echo $rs->fields['ingenid'];?>" width="100" height="120" border="0">
								<br><br>
								<button class="form-control btn btn-success" value="Upload Gambar" onclick="upload_gambar('all_pic/upload_imgpenceramah.php?id=<?=$rs->fields['ingenid'];?>'); return false" > Muatnaik Gambar
								</button>
							<?php } ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
				
<div class="section-body">
    <div class="row">
        <div class="col-12" style="padding-right:0px;">
            <div class="card">
                <div class="card-header" >
                    <h4></h4>
                </div>
				<div class="card-body">
					<tr>
						<td colspan="4" class="title" height="30">B.&nbsp;&nbsp;&nbsp;MAKLUMAT KEWANGAN</td>
					</tr>
					<tr>
					<div class="form-group row" style="padding-right:0px;">
						<label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kadar Bayaran Sejam</b></label>
						<div class="col-sm-12 col-md-9">
							RM <input type="text" class="form-control" name="payperhours" value="<?php print number_format($rs->fields['payperhours'],2);?>" /> 
							(Masukkan angka sahaja)
						</div>
					</div>

					<tr>
						<div align="center" colspan="4"><br>
							<button class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat penceramah" 
							onClick="form_hantar('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_form_do.php;penceramah;daftar')?>')"><i class="fas fa-save"></i> Simpan</button>

							<?php if(!empty($id)){ ?>
							<button class="btn btn-danger" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat penceramah" 
							onClick="form_hapus('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_form_do.php;penceramah;daftar')?>')"><i class="fas fa-trash"></i> Hapus</button>

							<?php } ?>
							<?php $cetak = "modal_form.php?win=".base64_encode('penceramah/cetak_biodata_penceramah.php;'.$id);?>
							<input type="button" value="Cetak" class="btn btn-warning" class="button_disp" title="Sila klik untuk cetak maklumat penceramah" 
							onclick="open_modal('<?=$cetak;?>','Cetak Biodata Penceramah',1,1)">

							<button class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai penceramah" 
							onClick="do_back('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_list.php;penceramah;daftar');?>')"><i class="fas fa-undo"></i> Kembali</button>

							<input type="hidden" name="id" value="<?=$id?>" />
							<input type="hidden" name="proses" value="" />
							<input type="hidden" name="PageNo" value="<?=$PageNo?>" />
						</div>
					</tr>
					<?php if(!empty($id)){ ?>
						<br><br>
                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
						<tr class="title" >
									<td colspan="3"><b>MAKLUMAT BUKU BANK</b></td>
                            <td colspan="3" align="right"><?php $new_page = "modal_form.php?win=".base64_encode('penceramah/_bukubank_form.php;');?>
				        	
							<button class="btn btn-success" value="Tambah Maklumat Buku Bank" style="cursor:pointer" 
            				<?php if(empty($id)) { 
								print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat buku bank!')\""; 
							} else { 
								print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Buku Bank',70,70)\""; } ?> ><i class="fas fa-plus"></i> Tambah Maklumat Akademik</button>
						</tr>
                	</table>
					<br>
					<div class="table-responsive">
					<table class="table table-striped" id="table-1">
						<thead style="background-color:#f2f2f2;">
							<tr>
								<th width="5%"><strong>Bil</strong></th>
								<th width="25%"><strong>Nama Bank</strong></th>
								<th width="25%"><strong>Cawangan</strong></th>
								<th width="25%"><strong>No. Akaun Bank</strong></th>
								<th width="20%"><strong>Tindakan</strong></th>
							</tr>
						</thead>
						<tbody>
							<?php
							//$conn->debug=true; 	
							$_SESSION['ingenid'] = $id;
							$sSQL2="SELECT * FROM _tbl_instructor_bank WHERE ingenid = ".tosql($id,"Text");
							$sSQL2 .= " ORDER BY inaka_banknama DESC";
							$rs2 = &$conn->Execute($sSQL2);
							$cnt = $rs2->recordcount();
						
							if(!$rs2->EOF) {
							$cnt = 1;
							$bil = 1;
							while(!$rs2->EOF) {
								$href_link = "modal_form.php?win=".base64_encode('penceramah/_bukubank_form.php;'.$rs2->fields['ingenid_bank']);
								$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_bukubank_del.php;'.$rs2->fields['ingenid_bank']);
								$href_img = "modal_form.php?win=".base64_encode('penceramah/_bukubank_sijil.php;'.$rs2->fields['ingenid_bank']);
							?>
							<tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
								<td valign="top" align="right"><?=$bil;?>.</td>
								<td valign="top" align="left"><?=$rs2->fields['inaka_banknama']?>&nbsp;</td>
								<td valign="top" align="left"><?=$rs2->fields['inaka_bankcawangan']?>&nbsp;</td>
								<td valign="top" align="left"><?=$rs2->fields['inaka_banknoacct']?>&nbsp;</td>
								<td align="center">
									<?php if(!empty($rs2->fields['fld_image'])){ ?>
									<button class="btn btn-primary" style="cursor:pointer; padding:8px;" title="Sila klik paparan buku bank" 
									onclick="open_modal('<?=$href_img;?>','Paparan Maklumat Buku Bank',80,80)" ><i class="far fa-file-alt"></i></button>
									<?php } ?>
									<button class="btn btn-warning" style="cursor:pointer; padding:8px;" title="Sila klik untuk pengemaskinian data" 
									onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Buku Bank',80,80)" ><i class="fas fa-edit"></i></button>
									<button class="btn btn-danger" style="cursor:pointer; padding:8px;" title="Sila klik untuk penghapusan data" 
									onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Buku Bank',700,300)" ><i class="fas fa-trash"></i></button>  
								</td>
							</tr>
							<?php
							$cnt = $cnt + 1;
							$bil = $bil + 1;
							$rs2->movenext();
							} 
						} else {
						?>
						<tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
						<?php } ?> 
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="section-body">
    <div class="row">
        <div class="col-12" style="padding-right:0px;">
            <div class="card">
                <div class="card-header" >
                    <h4></h4>
                </div>
				<div class="card-body">
					<tr>
						<td colspan="4" class="title" height="30">C.&nbsp;&nbsp;&nbsp;<b>MAKLUMAT PEKERJAAN</b></td>
					</tr>
					<tr>
						<td colspan="4">
							<table width="100%" cellpadding="3" cellspacing="0" border="0">
								<tr class="title" >
									<td colspan="3"><b>MAKLUMAT KELAYAKAN AKADEMIK</b></td>
									<td colspan="3" align="right"><?php $new_page = "modal_form.php?win=".base64_encode('penceramah/_akademik_form.php;');?>
									
									<button class="btn btn-success" value="Tambah Maklumat Akademik" style="cursor:pointer" 
									<?php if(empty($id)) { 
										print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat akademik!')\""; 
									} else { 
										print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Akademik',70,70)\""; } ?> ><i class="fas fa-plus"></i> Tambah Maklumat Akademik</button>
								</tr>
							</table>
							<br>
							<div class="table-responsive">
							<table class="table table-striped" id="table-1">
								<thead style="background-color:#f2f2f2;">
									<tr>
										<th width="5%"><strong>Bil</strong></th>
										<th width="15%"><strong>Kelulusan Akademik</strong></th>
										<th width="25%"><strong>Nama Kursus</strong></th>
										<th width="25%"><strong>Institusi Pengajian</strong></th>
										<th width="10%"><strong>Tahun</strong></th>
										<th width="20%"><strong>Tindakan</strong></th>
									</tr>
								</thead>
								<tbody>
									<?php
									//$conn->debug=true; 	
									$_SESSION['ingenid'] = $id;
									$sSQL2="SELECT * FROM _tbl_instructor_akademik WHERE ingenid = ".tosql($id,"Text");
									$sSQL2 .= " ORDER BY inaka_tahun DESC";
									$rs2 = &$conn->Execute($sSQL2);
									$cnt = $rs2->recordcount();
								
									if(!$rs2->EOF) {
									$cnt = 1;
									$bil = 1;
									while(!$rs2->EOF) {
										$href_link = "modal_form.php?win=".base64_encode('penceramah/_akademik_form.php;'.$rs2->fields['ingenid_akademik']);
										$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_akademik_del.php;'.$rs2->fields['ingenid_akademik']);
										$href_img = "modal_form.php?win=".base64_encode('penceramah/_akademik_sijil.php;'.$rs2->fields['ingenid_akademik']);
									?>
									<tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
										<td valign="top" align="right"><?=$bil;?>.</td>
										<td valign="top" align="left"><?=dlookup("_ref_akademik", "f_akademik_nama", " f_akademik_id = ".$rs2->fields['inaka_sijil'])?>&nbsp;</td>
										<td valign="top" align="left"><?=$rs2->fields['inaka_kursus']?>&nbsp;</td>
										<td valign="top" align="left"><?=$rs2->fields['inaka_institusi']?>&nbsp;</td>
										<td valign="top" align="center"><?=$rs2->fields['inaka_tahun']?>&nbsp;</td>
										<td align="center">
											<?php if(!empty($rs2->fields['fld_image'])){ ?>
											<button class="btn btn-primary" style="cursor:pointer; padding:8px;" title="Sila klik paparan sijil akademik" 
											onclick="open_modal('<?=$href_img;?>','Paparan Maklumat Sijil Akademik',80,80)"> <i class="far fa-file-alt"></i></button>
											<?php } ?>
											<button class="btn btn-warning" style="cursor:pointer; padding:8px;" title="Sila klik untuk pengemaskinian data" 
											onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Akademik',80,80)"><i class="fas fa-edit"></i></button>
											<button class="btn btn-danger" style="cursor:pointer; padding:8px;" title="Sila klik untuk penghapusan data" 
											onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Akademik',700,300)" ><i class="fas fa-trash"></i></button>  
										</td>
									</tr>
									<?php
									$cnt = $cnt + 1;
									$bil = $bil + 1;
									$rs2->movenext();
										} 
									} else {
									?>
									<tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
									<?php } ?> 
								</tbody>
							</table>
							</div>
					<tr>
								<td colspan="4"><br /><br />
									<table width="100%" cellpadding="1" cellspacing="0" border="0">
										<tr class="title" >
											<td colspan="3"><b>MAKLUMAT BIDANG KEPAKARAN</b></td>
											<td colspan="3" align="right"><?php $new_page = "modal_form.php?win=".base64_encode('penceramah/_kepakaran_form.php;');?>
												
											<button class="btn btn-success" value="Tambah Bidang Kepakaran" style="cursor:pointer" 
												<?php if(empty($id)) { 
													print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah bidang kepakaran!')\""; 
												} else { 
													print "onclick=\"open_modal('".$new_page."','Penambahan Maklumat Kepakaran',700,400)\""; } ?> ><i class="fas fa-plus"></i> Tambah Maklumat Akademik</button>
										</tr>
									</table>
									<br>
									<div class="table-responsive">
									<table class="table table-striped" id="table-1">
										<thead style="background-color:#f2f2f2;">
										<tr>
											<th width="5%"><strong>Bil</strong></th>
											<th width="40%"><strong>Bidang Kepakaran</strong></th>
											<th width="45%"><strong>Pengkhususan</strong></th>
											<th width="10%"><strong>Tindakan</th>
										</tr>
										</thead>
										<tbody>
											<?php 	
													$_SESSION['ingenid'] = $id;
													$sSQL2="SELECT * FROM _tbl_instructor_kepakaran WHERE ingenid = ".tosql($id,"Text");
												//	$sSQL2 .= "ORDER BY inaka_tahun";
													$rs2 = &$conn->Execute($sSQL2);
													$cnt = $rs2->recordcount();
											if(!$rs2->EOF) {
											$cnt = 1;
											$bil = 1;
												while(!$rs2->EOF) {
												$href_link = "modal_form.php?win=".base64_encode('penceramah/_kepakaran_form.php;'.$rs2->fields['inpakar_id']);
												$del_href_link = "modal_form.php?win=".base64_encode('penceramah/_kepakaran_del.php;'.$rs2->fields['inpakar_id']);
												?>
											<tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
												<td valign="top" align="right"><?=$bil;?>.</td>
												<td valign="top" align="left"><?=dlookup("_ref_kepakaran", "f_pakar_nama", " f_pakar_code = ".$rs2->fields['inpakar_bidang'])?>&nbsp;</td>
												<td valign="top" align="left"><?=$rs2->fields['inpakar_pengkhususan']?>&nbsp;</td>
												<td align="center">
													<button class="btn btn-warning" style="cursor:pointer; padding:8px;" title="Sila klik untuk pengemaskinian data" 
													onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Kepakaran',700,400)" ><i class="fas fa-edit"></i></button>
													<button class="btn btn-danger" style="cursor:pointer; padding:8px;" title="Sila klik untuk penghapusan data" onclick="open_modal('<?=$del_href_link;?>','Padam Maklumat Kepakaran',700,300)" ><i class="fas fa-trash"></i></button>  
												</td>
											</tr>
											<?php
											$cnt = $cnt + 1;
											$bil = $bil + 1;
											$rs2->movenext();
											} 
										} else {
										?>
										<tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
										<?php } ?> 
										</tbody>
									</table>
									</div>
							<?php } ?>
        		</div>
			</div>
		</div>
	</div>
</div>
<script LANGUAGE="JavaScript">
	document.ilim.insid.focus();
</script>