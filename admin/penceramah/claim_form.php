<script LANGUAGE="JavaScript">
function form_hantar(URL){
		document.ilim.action = URL;
		document.ilim.submit();
}

function form_hapus(URL){
	var staff = document.ilim.cl_name.value;
	if(confirm("Adakah anda pasti untuk menghapuskan Rekod Tuntutan bagi penceramah ini?\n-"+staff)){
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

function update_bank(name,caw,acct){
	document.ilim.cl_bank.value=name;
	document.ilim.cl_bankbrch.value=caw;
	document.ilim.cl_akaun.value=acct;

}
</script>
<?php
//$conn->debug=true;
function dlookupList($Table, $fName, $sWhere, $sOrder){
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
//$ingid = $_GET['ingid'];
$PageNo = $_POST['PageNo'];
$sSQL="SELECT * FROM _tbl_claim  WHERE cl_id= ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
$ingid=$rs->fields['cl_ins_id'];
?>

<br>
<div class="section-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Borang Tuntutan Penceramah</h4>
        </div>
        <div class="card-body">

        <!-- <table width="98%" align="center" cellpadding="1" cellspacing="0" border="0">
            <tr bgcolor="#00CCFF">
              <td colspan="2" height="30">&nbsp;<b>BORANG TUNTUTAN PENCERAMAH</b></td>
            </tr>
          <tr><td colspan="2"> -->
          <label class="col-form-label col-12 col-md-8 col-lg-5"><b>BAHAGIAN 1 : BUTIR-BUTIR PERIBADI</b></label>
          </br>
          <?php
            $sqlinst = "SELECT * FROM _tbl_instructor WHERE ingenid=".tosql($rs->fields['cl_ins_id']);
            $rs_inst = $conn->execute($sqlinst);
          ?>
          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Penuh :</b></label>
            <div class="col-sm-12 col-md-5">
              <input type="text" class="form-control" name="cl_name" value="<?php print $rs_inst->fields['insname'];?>" />
              <?php if(empty($id)){ $new_penc = "modal_form.php?win=".base64_encode('penceramah/_penceramah_list.php;'); ?>
            </div>
            <div class="col-sm-12 col-md-3">
              <input type="button" class="btn btn-warning" value="Pilih Penceramah" style="cursor:pointer" title="Sila klik untuk pemilihan maklumat penceramah" 
              onclick="open_modal('<?=$new_penc;?>','Senarai Nama Penceramah',80,80)" />
              <?php } ?>
            </div>
          </div>

          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No K/P :</b></label>
            <div class="col-sm-12 col-md-5">
              <input name="cl_kp" class="form-control" type="text" id="cl_kp"  value="<?php print $rs_inst->fields['insid'];?>"/>
            </div>
          </div>

          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Gred / Jawatan Yang Disandang :</b></label>
            <div class="col-sm-12 col-md-5">
              <input name="cl_titlegredcd" class="form-control" type="text" id="cl_titlegredcd"  value="<?php print $rs_inst->fields['titlegredcd'];?>"/>
            </div>
          </div>

          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Taraf Jawatan :</b></label>
            <div class="col-sm-12 col-md-5">
              <select class="form-control" name="cl_tarafpost">
                <option value="01" <?php if($rs->fields['cl_tarafpost'] == '01') echo "selected"; ?> >TETAP</option>
                <option value="02" <?php if($rs->fields['cl_tarafpost'] == '02') echo "selected"; ?> >SAMBILAN</option>
                <option value="03" <?php if($rs->fields['cl_tarafpost'] == '03') echo "selected"; ?> >KONTRAK</option>
              </select>              
            </div>
          </div>

          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Gaji Pokok :</b></label>
            <div class="col-sm-12 col-md-5">
              <input name="cl_gaji" class="form-control" type="text" id="cl_gaji" value="<?php print $rs->fields['cl_gaji'];?>" size="20" maxlength="15">
            </div>
          </div>
  
          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Elaun Memangku (Jika ada) :</b></label>
            <div class="col-sm-12 col-md-5">
              <input name="cl_elaun" class="form-control" type="text" id="cl_elaun" value="<?php print $rs->fields['cl_elaun'];?>" size="20" maxlength="15">
            </div>
          </div>

          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Gaji / Pekerja :</b></label>
            <div class="col-sm-12 col-md-5">
              <input name="cl_gajino" class="form-control" type="text" id="cl_gajino" value="<?php print $rs->fields['cl_gajino'];?>" size="20" maxlength="15">
            </div>
          </div>

          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kadar Bayaran Sejam :</b></label>
            <div class="col-sm-12 col-md-5">
              <input name="payperhours" class="form-control" type="text" id="cl_gajino" value="<?php print $rs_inst->fields['payperhours'];?>" size="20" maxlength="15">
            </div>
          </div>
  
          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Bank :</b></label>
            <div class="col-sm-12 col-md-5">
              <input type="text" name="cl_bank" class="form-control" value="<?php print $rs->fields['cl_bank'];?>" />
              <?php $new_page = "modal_form.php?win=".base64_encode('penceramah/_bukubank_list.php;'.$ingid);?>
            </div>
            <div class="col-sm-12 col-md-3">
              <input type="button" class="btn btn-warning" value="Pilih Bank" title="Sila klik untuk membuat pilihan Bank" 
              onclick="open_modal('<?=$new_page;?>&idp=<?=$ingid;?>','Senarai Maklumat Bank Penceramah',800,350)" />
            </div>
          </div>
  
          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Cawangan Bank :</b></label>
            <div class="col-sm-12 col-md-3">
              <input type="text" name="cl_bankbrch" class="form-control" value="<?php print $rs->fields['cl_bankbrch'];?>" />
            </div>
          </div>
  
          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Akaun Bank :</b></label>
            <div class="col-sm-12 col-md-3">
              <input type="text" name="cl_akaun" class="form-control" value="<?php print $rs->fields['cl_akaun'];?>" />
            </div>
          </div>
                
          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Nama Kementerian / Jabatan / Agensi :</b></label>
            <div class="col-sm-12 col-md-3">
              <input name="cl_orgdesc" type="text" class="form-control" id="cl_orgdesc" value="<?php print $rs->fields['cl_orgdesc'];?>" size="80" />
            </div>
          </div>

          <div class="form-group row" style="padding-right:0px;">
            <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Alamat Kementerian / Jabatan / Agensi :</b></label>
            <div class="col-sm-12 col-md-3">
              <textarea cols="80" rows="4" class="form-control" name="cl_orgadd" id="cl_orgadd"><?php print $rs->fields['cl_orgadd'];?></textarea>
            </div>
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
                <h4>KEMENTERIAN / JABATAN / AGENSI PENGANJUR</h4>
            </div>
            
            <div class="card-body">
              <div class="form-group row" style="padding-right:0px;">
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kod Jabatan :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_depcd" class="form-control" maxlength="15" value="<?php print $rs->fields['cl_depcd'];?>" />
                </div>
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kod Jabatan :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input name="cl_accoffcd" type="text" id="cl_accoffcd" value="<?php print $rs->fields['cl_accoffcd'];?>" class="form-control" maxlength="15" />
                </div>
              </div>
             
              <div class="form-group row" style="padding-right:0px;">
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>PTJ :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_ptjdesc" class="form-control" value="<?php print $rs->fields['cl_ptjdesc'];?>" />
                </div>
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kod PTJ :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_ptjcd" class="form-control" maxlength="15" value="<?php print $rs->fields['cl_ptjcd'];?>" />
                </div>
              </div>
              
              <div class="form-group row" style="padding-right:0px;">
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Pusat Pembayaran :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_payctrdesc" class="form-control" value="<?php print $rs->fields['cl_payctrdesc'];?>" />
                </div>
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kod Pusat Pembayaran:</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_payctrcd" class="form-control" maxlength="15" value="<?php print $rs->fields['cl_payctrcd'];?>" />
                </div>
              </div>

              <div class="form-group row" style="padding-right:0px;">
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Cawangan :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_brchdesc" class="form-control" value="<?php print $rs->fields['cl_brchdesc'];?>" />
                </div>
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Kod Cawangan :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_brchcd" class="form-control" maxlength="15" value="<?php print $rs->fields['cl_brchcd'];?>" />
                </div>
              </div>
             
              <div class="form-group row" style="padding-right:0px;">
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Jenis Dok. Asal :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_doctype" class="form-control" value="<?php print $rs->fields['cl_doctype'];?>" />
                </div>
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>No. Rujukan Dok. Asal :</b></label>
                <div class="col-sm-12 col-md-3">
                  <input type="text" name="cl_docno" class="form-control" maxlength="15" value="<?php print $rs->fields['cl_docno'];?>" />
                </div>
              </div>

              <div class="form-group row" style="padding-right:0px;">
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Bulan :</b></label>
                <div class="col-sm-12 col-md-3">
                  <select class="form-control" id="cl_month" name="cl_month">
                      <?php $mth = date('m');?>
                    <option value= "1" <?php if($rs->fields['cl_month'] == 1) echo "selected"; ?>>Januari</option>
                    <option value= "2" <?php if($rs->fields['cl_month'] == 2) echo "selected"; ?>>Februari</option>
                    <option value= "3" <?php if($rs->fields['cl_month'] == 3) echo "selected"; ?>>Mac</option>
                    <option value= "4" <?php if($rs->fields['cl_month'] == 4) echo "selected"; ?>>April</option>
                    <option value= "5" <?php if($rs->fields['cl_month'] == 5) echo "selected"; ?>>Mei</option>
                    <option value= "6" <?php if($rs->fields['cl_month'] == 6) echo "selected"; ?>>Jun</option>
                    <option value= "7" <?php if($rs->fields['cl_month'] == 7) echo "selected"; ?>>Julai</option>
                    <option value= "8" <?php if($rs->fields['cl_month'] == 8) echo "selected"; ?>>Ogos</option>
                    <option value= "9" <?php if($rs->fields['cl_month'] == 9) echo "selected"; ?>>September</option>
                    <option value= "10" <?php if($rs->fields['cl_month'] == 10) echo "selected"; ?>>Oktober</option>
                    <option value= "11" <?php if($rs->fields['cl_month'] == 11) echo "selected"; ?>>November</option>
                    <option value= "12" <?php if($rs->fields['cl_month'] == 12) echo "selected"; ?>>Disember</option>		
                  </select>
                </div>
                <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Tahun :</b></label>
                <div class="col-sm-12 col-md-3">
                  <select class="form-control" id="cl_year" name="cl_year">
                    <?php 
                    $yr = date('Y');
                      for ($t = $yr; $t >= $yr-10; $t--) { ?>
                    <option value= "<?=$t?>" <?php if($rs->fields['cl_year'] == $t) echo "selected"; ?>>
                      <?=$t?>
                    </option>		
                    <?php }?>
                  </select>
                </div>
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
                <h4>BUTIR - BUTIR PERMOHONAN</h4>
            </div>
            <div class="card-body">
                	<table width="100%" cellpadding="3" cellspacing="0" border="0">
                    	<tr class="title" >
                        	<td colspan="3"><strong>MAKLUMAT KURSUS / CERAMAH</strong></td>
                            <td colspan="3" align="right"><?php $new_page = "modal_form.php?win=".base64_encode('penceramah/_claim_event_form.php;');?>
                            <button class="btn btn-success" value="Tambah Maklumat Kursus / Ceramah" style="cursor:pointer" 
            			      	<?php if(empty($id)) { print "onclick=\"alert('Sila tekan SIMPAN dahulu sebelum menambah maklumat Kursus / Ceramah!')\""; } 
							            else { print "onclick=\"open_modal('".$new_page."&m=".$rs->fields['cl_month']."&y=".$rs->fields['cl_year']."&iding=".$ingid."','Penambahan Maklumat Kursus / Ceramah',800,400)\""; } ?> > <i class="fas fa-plus"></i> Tambah Maklumat Kursus / Ceramah </button> </td>
                      </tr>
                  </table>
                  <br>
                </td>
                <div class="table-responsive">
                  <table class="table table-striped" id="table-1">
                    <thead style="background-color:#f2f2f2;">
                    	<tr class="title" >
                          <th width="5%">Bil</th>
                          <th width="40%">Nama Jabatan yg menganjurkan kursus / ceramah</th>
                          <th width="15%" align="center">Tarikh Kursus / Ceramah</th>
                          <th width="10%" align="center">Tempoh (Dalam jam)</th>
                          <th width="13%" align="center">Tuntutan (RM)</th>
                          <th width="25%">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(!empty($id)) {	
                        $_SESSION['cl_id'] = $id;
                        $payperhour = dlookup("_tbl_instructor", "payperhours", " ingenid = ".tosql($rs->fields['cl_ins_id']));
                        $sSQL2="SELECT * FROM _tbl_claim_event WHERE cl_id = ".tosql($id,"number");
                        $sSQL2 .= " ORDER BY cl_eve_startdate";
                        $rs2 = &$conn->Execute($sSQL2);
                        $cnt = $rs2->recordcount();
                        if(!$rs2->EOF) {
                        $cnt = 1;
                        $bil = 1;
                        $sum = 0;
                        while(!$rs2->EOF) {
                          $href_link = "modal_form.php?win=".base64_encode('penceramah/_claim_event_form.php;'.$rs2->fields['cl_eve_id']);
                          $del_href_link = "modal_form.php?win=".base64_encode('penceramah/_claim_event_form.php;'.$rs2->fields['cl_eve_id']);
                          $pay = $rs2->fields['cl_eve_tempoh']*$payperhour;
                          $sum += $pay;
                        ?>      
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
            				        <td valign="top" align="left"><?=dlookup("_tbl_kursus", "coursename", " id = ".tosql($rs2->fields['cl_eve_course_id']))?>&nbsp;</td>
                            <td valign="top" align="center"><?php //echo DisplayDate($rs2->fields['cl_eve_startdate'])." - ".DisplayDate($rs2->fields['cl_eve_enddate']);?>&nbsp;</td>
                            <td valign="top" align="center"><?=$rs2->fields['cl_eve_tempoh']?>&nbsp;</td>
                            <td valign="top" align="center"><?php echo number_format($pay,2); ?>&nbsp;</td>
                            <td align="center">
                            <button class="btn btn-warning" style="cursor:pointer;padding:8px;" title="Sila klik untuk pengemaskinian data" 
                                onclick="open_modal('<?=$href_link;?>&iding=<?=$ingid?>&m=<?=$rs->fields['cl_month']?>&y=<?=$rs->fields['cl_year']?>','Kemaskini Maklumat Kursus / Ceramah',800,400)" ><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger" style="cursor:pointer;padding:8px;" title="Sila klik untuk penghapusan data" 
                                onclick="open_modal('<?=$del_href_link;?>&pro=DEL&iddel=<?=$rs2->fields['cl_eve_id'];?>','Padam Maklumat Kursus / Ceramah',700,300)" ><i class="fas fa-trash"></i></button>                            </td>
                        </tr>
                        <?php
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs2->movenext();
                          }  ?>
                              <tr class="title" >
                                <td colspan="4" align="right">Jumlah &nbsp;(RM)&nbsp;</td>
                              <td width="13%" align="center"><?=number_format($sum,2)?>&nbsp;</td>
                              <td width="7%">&nbsp;</td>
                              </tr>
                        <?php
                      } else {
                      ?>
                      <tr><td colspan="10" bgcolor="#FFFFFF"><b>Tiada rekod dalam senarai.</b></td></tr>
                      <?php } } ?> 
                    </tbody>
                  </table>
                </div>

                <div class="form-group row" style="padding-right:0px;">
                  <label class="col-form-label col-12 col-md-3 col-lg-3"><b>Status Tuntutan</b></label>
                  <div class="col-sm-12 col-md-4">
                      <select class="form-control" class="form-control" name="is_process">
                          <option value="0" <?php if($rs->fields['is_process']==0){ print 'selected'; }?>>Baru</option>
                          <option value="1" <?php if($rs->fields['is_process']==1){ print 'selected'; }?>>Dalam Proses</option>
                          <option value="2" <?php if($rs->fields['is_process']==2){ print 'selected'; }?>>Telah Dijelaskan</option>
                        </select>
                    </div>
                </div>

                <tr  align="center">
                    <td><br>
                      <?php if($rs->fields['is_process']!=2){ ?>
                      <input type="button" class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat tuntutan" 
                        onClick="form_hantar('index.php?data=<?php print base64_encode($userid.';penceramah/claim_form_do.php;penceramah;tuntutan')?>')">
                        <?php } ?>
                      <?php if(!empty($id)){ 
                        $href_surat = "modal_form.php?win=".base64_encode('penceramah/claim_print.php;'.$id);
                      ?>
                      <?php if($rs->fields['is_process']!=2){ ?>
                        <input type="button" class="btn btn-danger" value="Hapus" class="button_disp" title="Sila klik untuk hapus maklumat tuntutan" 
                        onClick="form_hapus('index.php?data=<?php print base64_encode($userid.';penceramah/claim_form_do.php;penceramah;tuntutan')?>')">
                      <?php } ?>
                        <input type="button" class="btn btn-info" value="Cetak" class="button_disp" title="Sila klik untuk cetak maklumat tuntutan" 
                        onClick="open_modal('<?=$href_surat;?>','Cetakan borang tuntutan penceramah',1,1)">
                        <?php } ?>
                      <input type="button" class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk ke senarai tuntutan" 
                        onClick="do_back('index.php?data=<?php print base64_encode($userid.';penceramah/penceramah_claim.php;penceramah;tuntutan;');?>')">
                        <input type="hidden" name="id" value="<?=$id;?>" />
                        <input type="hidden" name="ingid" value="<?=$ingid;?>" />
                        <input type="hidden" name="kampus_id" value="<?=$_SESSION['SESS_KAMPUS'];?>" />
                        <input type="hidden" name="proses" value="" />
                        <input type="hidden" name="PageNo" value="<?=$PageNo?>" />                
                    </td>
                </tr>
            </div>
      </div>
    </div>
  </div>
</div>

