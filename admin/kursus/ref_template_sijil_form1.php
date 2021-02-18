<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$forms=isset($_REQUEST["forms"])?$_REQUEST["forms"]:"";
if($forms=='cetak'){ include_once '../../common.php'; }

$msg='';
?>
<script LANGUAGE="JavaScript">
function form_hapus(URL){
	if(confirm("Adakah anda pasti untuk menghapuskan data ini?")){
		document.ilim.action = URL;
		document.ilim.submit();
	}
}
function form_hantar(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
function form_back(URL){
	parent.emailwindow.hide();
}

</script>
<?php
//$conn->debug=true;
//$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

if(!empty($proses)){ 
	if($proses=='DEL'){
		$conn->execute("UPDATE _ref_template_sijil SET ref_ts_delete=1 WHERE ref_ts_id = ".tosql($id,"Number"));
		print "<script language=\"javascript\">
			//alert('Rekod telah disimpan');
			//parent.location.reload();	
			refresh = parent.location; 
			parent.location = refresh;
			</script>";
	} else {
		extract($_POST);
		/*$ref_ts_head=isset($_REQUEST["ref_ts_head"])?$_REQUEST["ref_ts_head"]:"";
		$ref_ts_oleh=isset($_REQUEST["ref_ts_oleh"])?$_REQUEST["ref_ts_oleh"]:"";
		$ref_ts_status=isset($_REQUEST["ref_ts_status"])?$_REQUEST["ref_ts_status"]:"";*/
	
		if(empty($id)){
			$sql = "INSERT INTO _ref_template_sijil(kampus_id, ref_tajuk_sijil, ref_ts_head1, ref_ts_head1_font, 
				ref_ts_head1_size, ref_ts_head1_fontstyle,
				ref_ts_head2, ref_ts_head2_font, ref_ts_head2_size, ref_ts_head2_fontstyle, 
				ref_ts_head3, ref_ts_head3_font, ref_ts_head3_size, ref_ts_head3_fontstyle,
				ref_ts_sah_font, ref_ts_sah_fontstyle, ref_ts_sah_size,
				ref_ts_nama_font, ref_ts_nama_fontstyle, ref_ts_nama_size,
				ref_ts_kp_font, ref_ts_kp_fontstyle, ref_ts_kp_size,
				ref_ts_telah_font, ref_ts_telah_fontstyle, ref_ts_telah_size,
				ref_ts_kursus_font, ref_ts_kursus_fontstyle, ref_ts_kursus_size,
				ref_ts_mulai_font, ref_ts_mulai_fontstyle, ref_ts_mulai_size,
				ref_ts_tkh_font, ref_ts_tkh_fontstyle, ref_ts_tkh_size, 
				ref_ts_status, tarikh_hijrah, ref_ts_oleh, ref_ts_jawatan, ref_ts_position) 
			VALUES(".tosql($kampus_id).", ".tosql(strtoupper($ref_tajuk_sijil),"Text").", ".tosql(strtoupper($ref_ts_head1),"Text").", 
			".tosql($ref_ts_head1_font,"Text").", ".tosql($ref_ts_head1_size,"Text").", ".tosql($ref_ts_head1_fontstyle,"Text").", 
			".tosql(strtoupper($ref_ts_head2),"Text").", ".tosql($ref_ts_head2_font,"Text").", ".tosql($ref_ts_head2_size,"Text").", 
			".tosql($ref_ts_head2_fontstyle,"Text").", 
			".tosql(strtoupper($ref_ts_head3),"Text").", ".tosql($ref_ts_head3_font,"Text").", ".tosql($ref_ts_head3_size,"Text").", 
			".tosql($ref_ts_head3_fontstyle,"Text").", 
			".tosql(strtoupper($ref_ts_sah_font),"Text").", ".tosql($ref_ts_sah_fontstyle,"Text").", ".tosql($ref_ts_sah_size,"Text").", 
			".tosql(strtoupper($ref_ts_nama_font),"Text").", ".tosql($ref_ts_nama_fontstyle,"Text").", ".tosql($ref_ts_nama_size,"Text").", 
			".tosql(strtoupper($ref_ts_kp_font),"Text").", ".tosql($ref_ts_kp_fontstyle,"Text").", ".tosql($ref_ts_kp_size,"Text").", 
			".tosql(strtoupper($ref_ts_telah_font),"Text").", ".tosql($ref_ts_telah_fontstyle,"Text").", ".tosql($ref_ts_telah_size,"Text").", 
			".tosql(strtoupper($ref_ts_kursus_font),"Text").", ".tosql($ref_ts_kursus_fontstyle,"Text").", ".tosql($ref_ts_kursus_size,"Text").", 
			".tosql(strtoupper($ref_ts_mulai_font),"Text").", ".tosql($ref_ts_mulai_fontstyle,"Text").", ".tosql($ref_ts_mulai_size,"Text").", 
			".tosql(strtoupper($ref_ts_tkh_font),"Text").", ".tosql($ref_ts_tkh_fontstyle,"Text").", ".tosql($ref_ts_tkh_size,"Text").", 
			".tosql($ref_ts_status,"Text").", ".tosql($tarikh_hijrah,"Text").", ".tosql($ref_ts_oleh,"Text").", 
			".tosql($ref_ts_jawatan,"Text").", ".tosql($ref_ts_position,"Text").")";
			$rs = &$conn->Execute($sql);
		} else {
			$sql = "UPDATE _ref_template_sijil SET kampus_id=".tosql($kampus_id).", 
				ref_tajuk_sijil=".tosql(strtoupper($ref_tajuk_sijil)).", 
				ref_ts_head1=".tosql(strtoupper($ref_ts_head1)).", ref_ts_head1_font=".tosql($ref_ts_head1_font).", 
				ref_ts_head1_size=".tosql($ref_ts_head1_size).", ref_ts_head1_fontstyle=".tosql($ref_ts_head1_fontstyle).", 
				ref_ts_head2=".tosql(strtoupper($ref_ts_head2)).", ref_ts_head2_font=".tosql($ref_ts_head2_font).", 
				ref_ts_head2_size=".tosql($ref_ts_head2_size).", ref_ts_head2_fontstyle=".tosql($ref_ts_head2_fontstyle).", 
				ref_ts_head3=".tosql(strtoupper($ref_ts_head3)).", ref_ts_head3_font=".tosql($ref_ts_head3_font).", 
				ref_ts_head3_size=".tosql($ref_ts_head3_size).", ref_ts_head3_fontstyle=".tosql($ref_ts_head3_fontstyle).", 
				ref_ts_sah_font=".tosql($ref_ts_sah_font).", ref_ts_sah_fontstyle=".tosql($ref_ts_sah_fontstyle).", ref_ts_sah_size=".tosql($ref_ts_sah_size).", 
				ref_ts_nama_font=".tosql($ref_ts_nama_font).", ref_ts_nama_fontstyle=".tosql($ref_ts_nama_fontstyle).", ref_ts_nama_size=".tosql($ref_ts_nama_size).", 
				ref_ts_kp_font=".tosql($ref_ts_kp_font).", ref_ts_kp_fontstyle=".tosql($ref_ts_kp_fontstyle).", ref_ts_kp_size=".tosql($ref_ts_kp_size).", 
				ref_ts_telah_font=".tosql($ref_ts_telah_font).", ref_ts_telah_fontstyle=".tosql($ref_ts_telah_fontstyle).", ref_ts_telah_size=".tosql($ref_ts_telah_size).", 
				ref_ts_kursus_font=".tosql($ref_ts_kursus_font).", ref_ts_kursus_fontstyle=".tosql($ref_ts_kursus_fontstyle).", ref_ts_kursus_size=".tosql($ref_ts_kursus_size).", 
				ref_ts_mulai_font=".tosql($ref_ts_mulai_font).", ref_ts_mulai_fontstyle=".tosql($ref_ts_mulai_fontstyle).", ref_ts_mulai_size=".tosql($ref_ts_mulai_size).", 
				ref_ts_tkh_font=".tosql($ref_ts_tkh_font).", ref_ts_tkh_fontstyle=".tosql($ref_ts_tkh_fontstyle).", ref_ts_tkh_size=".tosql($ref_ts_tkh_size).", 
				ref_ts_status=".tosql($ref_ts_status,"Number").", tarikh_hijrah=".tosql($tarikh_hijrah,"Text").", 
				ref_ts_oleh=".tosql($ref_ts_oleh).", ref_ts_jawatan=".tosql($ref_ts_jawatan).", ref_ts_position=".tosql($ref_ts_position)."  
				WHERE ref_ts_id=".tosql($id,"Text");
			$rs = &$conn->Execute($sql);
		}
		
		//$conn->debug=false;
	
		print "<script language=\"javascript\">
			//alert('Rekod telah disimpan');
			//parent.location.reload();	
			//refresh = parent.location; 
			//parent.location = refresh;
			</script>";
	}
}
//print $_SERVER['HTTP_ACCEPT'];
if(empty($id)){ $id=$_GET['tsid']; }
if(!empty($id)){
	$sSQL="SELECT * FROM _ref_template_sijil WHERE ref_ts_id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>

<form name="ilim" method="post">
<div class="card">
	<div class="card-header" >
		<h4>SELENGGARA MAKLUMAT CONTOH SIJIL</h4>
    <div style="float:right">
			Status Contoh Sijil : 
        <select name="ref_ts_status">
          <option value="0" <?php if($rs->fields['ref_ts_status']==0){ print 'selected'; }?>>Aktif</option>
          <option value="1" <?php if($rs->fields['ref_ts_status']==1){ print 'selected'; }?>>Tidak Aktif</option>
        </select>    	

    </div>
	</div>

  <div class="card-body">

        <div class="form-group row mb-4" style="float:right">
					<div>
					  <?php if(empty($forms)){ ?>
    	    	<input type="button" class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                <?php if($_SESSION["s_level"]=='99'){ ?>
    	    	<input type="button" class="btn btn-danger" value="HAPUS" class="button_disp" title="Sila klik untuk menghapuskan maklumat" onClick="form_hapus('modal_form.php?<?php print $URLs;?>&pro=DEL')" >
                <?php } ?>
            <?php } else { ?>
	        	<input type="button" class="btn btn-success" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" 
                onClick="form_hantar('ref_template_sijil_form1.php?forms=cetak&tsid=<?=$id;?>&pro=SAVE')" >
            <?php } ?>
            <input type="button" class="btn btn-secondary" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >
					</div>
				</div>
            
        <?php 
        //$conn->debug=true;
        $sqlb = "SELECT * FROM _ref_kampus WHERE kampus_status=0".$sql_kampus;
          $rs_kb = &$conn->Execute($sqlb);
          ?>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Pusat Latihan :</b></label>
            <div class="col-sm-12 col-md-7">
              <select name="kampus_id" class="form-control">
              <?php while(!$rs_kb->EOF){ ?>
                  <option value="<?php print $rs_kb->fields['kampus_id'];?>" <?php if($rs_kb->fields['kampus_id']==$rs->fields['kampus_id']){ print 'selected="selected"';}?>><?php print $rs_kb->fields['kampus_nama'];?></option>
              <?php $rs_kb->movenext(); } ?>
              </select>
            </div>
          </div>

        <div class="form-group row mb-4">
          <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><b>Tajuk Sijil :</b></label>
          <div class="col-sm-12 col-md-7">
            <input type="text" class="form-control" name="ref_tajuk_sijil" value="<?php print $rs->fields['ref_tajuk_sijil'];?>" />
          </div>
        </div>

	  <tr><td colspan="2">
    	<table width="100%" cellpadding="5" cellspacing="1" border="1" align="center">
        	<tr>
            <td width="50%" align="center" valign="top">
            	<table width="100%" cellpadding="5" cellspacing="1" border="1" align="center">
						<tr>
              <td width="100%" align="center"  valign="bottom"><br /><br />
                <div style="widows:100%;height:<?php print $rs->fields['ref_ts_head1_size'];?>">
                  <label style="font-family:'<?php print $rs->fields['ref_ts_head1_font']?>';font-size:<?php print $rs->fields['ref_ts_head1_size'];?>;font-style:<?php print $rs->fields['ref_ts_head1_fontstyle']?>">
							<?php print $rs->fields['ref_ts_head1'];?></label></div>
							
              <div style="widows:100%;height:<?php print $rs->fields['ref_ts_head2_size'];?>"">
                <label style="font-family:'<?php print $rs->fields['ref_ts_head2_font']?>';font-size:<?php print $rs->fields['ref_ts_head2_size'];?>;font-style:<?php print $rs->fields['ref_ts_head2_fontstyle']?>">
							<?php print $rs->fields['ref_ts_head2'];?></label></div>
							
                          <div style="widows:100%;height:<?php print $rs->fields['ref_ts_head3_size'];?>"">
                          	<label style="font-family:'<?php print $rs->fields['ref_ts_head3_font']?>';font-size:<?php print $rs->fields['ref_ts_head3_size'];?>;font-style:<?php print $rs->fields['ref_ts_head3_fontstyle']?>">
							<?php print $rs->fields['ref_ts_head3'];?></label></div>
                            </td>
                    	</tr>
                        <tr>
			                <td align="center" height="50px">
                            <label style="font-family:'<?php print $rs->fields['ref_ts_sah_font']?>';font-size:<?php print $rs->fields['ref_ts_sah_size'];?>;font-style:<?php print $rs->fields['ref_ts_sah_fontstyle']?>">Dengan Ini Disahkan Bahawa</label></td>
                        </tr>

                        <tr>
			                <td align="center" height="100px">
                            <b><label style="font-family:'<?php print $rs->fields['ref_ts_nama_font']?>';font-size:<?php print $rs->fields['ref_ts_nama_size'];?>;font-style:<?php print $rs->fields['ref_ts_nama_fontstyle']?>">ALIMAN BIN ABDUL HASSAN</label></b><br />
							<b><label style="font-family:'<?php print $rs->fields['ref_ts_kp_font']?>';font-size:<?php print $rs->fields['ref_ts_kp_size'];?>;font-style:<?php print $rs->fields['ref_ts_kp_fontstyle']?>">(700105-64-3456)</label></b><br />                            
                            </td>
                        </tr>

                        <tr>
               				<td align="center" height="50px">
                            	<label style="font-family:'<?php print $rs->fields['ref_ts_telah_font']?>';font-size:<?php print $rs->fields['ref_ts_telah_size'];?>;font-style:<?php print $rs->fields['ref_ts_telah_fontstyle']?>">Telah Mengikuti Dengan Jayanya</label></td>
                        </tr>
                        <tr>
			                <td align="center" height="150px">
                            	<b><label style="font-family:'<?php print $rs->fields['ref_ts_kursus_font']?>';font-size:<?php print $rs->fields['ref_ts_kursus_size'];?>;font-style:<?php print $rs->fields['ref_ts_kursus_fontstyle']?>">KURSUS OPENOFFICE</label></b><br /></td>
                        </tr>
                        <tr>
			                <td align="center" height="50px">
                            	<label style="font-family:'<?php print $rs->fields['ref_ts_mulai_font']?>';font-size:<?php print $rs->fields['ref_ts_mulai_size'];?>;font-style:<?php print $rs->fields['ref_ts_mulai_fontstyle']?>">Yang Telah Diadakan Mulai</label></td>
                        </tr>
                        <tr>
                            <td align="center" height="100px"><label style="font-family:'<?php print $rs->fields['ref_ts_tkh_font']?>';font-size:<?php print $rs->fields['ref_ts_tkh_size'];?>;font-style:<?php print $rs->fields['ref_ts_tkh_fontstyle']?>">15 hingga 17 Jun 2010<br />Bersamaan<br /><?php print $rs->fields['tarikh_hijrah'];?></label></td>
                        </tr>
                        <tr>
                        <?php $loksi = $rs->fields['ref_ts_position']; 
							if(empty($loksi)){ $loksi='center'; } ?>
			                <td align="<?php print $loksi;?>" height="150px">
                            	<div align="center" style="width:400px">
                            	<b>(<?php print $rs->fields['ref_ts_oleh'];?>)</b><br />
                                <?php print $rs->fields['ref_ts_jawatan'];?><br />
                                <?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['kampus_id'])); ?>
                                <br />Jabatan Kemajuan Islam Malaysia
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>

                <td width="50%" align="center" valign="top">
                	<table width="100%" cellpadding="5" cellspacing="1" border="0" align="center">
						      <tr>
                    <td width="100%" align="center">Masukkan maklumat bahagian atas sijil<br />
                      <input type="text" size="80" name="ref_ts_head1" value="<?php print $rs->fields['ref_ts_head1'];?>" maxlength="120" style="text-align:center;background-color:#CCCCCC" /><br />
                      Font:<select  name="ref_ts_head1_font">
                        <option value="Times New Roman" <?php if($rs->fields['ref_ts_head1_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                        <option value="Arial" <?php if($rs->fields['ref_ts_head1_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                        <option value="Verdana" <?php if($rs->fields['ref_ts_head1_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                      </select>&nbsp;&nbsp;
                      Font Style:<select name="ref_ts_head1_fontstyle">
                        <option value="" <?php if($rs->fields['ref_ts_head1_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                        <option value="italic" <?php if($rs->fields['ref_ts_head1_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                      </select>&nbsp;&nbsp;
                      Font Size:<select name="ref_ts_head1_size">
                        <option value="16px" <?php if($rs->fields['ref_ts_head1_size']=='16px'){ print 'selected'; }?>>16px</option>
                        <option value="18px" <?php if($rs->fields['ref_ts_head1_size']=='18px'){ print 'selected'; }?>>18px</option>
                        <option value="20px" <?php if($rs->fields['ref_ts_head1_size']=='20px'){ print 'selected'; }?>>20px</option>
                        <option value="24px" <?php if($rs->fields['ref_ts_head1_size']=='24px'){ print 'selected'; }?>>24px</option>
                        <option value="28px" <?php if($rs->fields['ref_ts_head1_size']=='28px'){ print 'selected'; }?>>28px</option>
                        <option value="32px" <?php if($rs->fields['ref_ts_head1_size']=='32px'){ print 'selected'; }?>>32px</option>
                        <option value="36px" <?php if($rs->fields['ref_ts_head1_size']=='36px'){ print 'selected'; }?>>36px</option>
                        <option value="42px" <?php if($rs->fields['ref_ts_head1_size']=='42px'){ print 'selected'; }?>>42px</option>
                        <option value="50px" <?php if($rs->fields['ref_ts_head1_size']=='50px'){ print 'selected'; }?>>50px</option>
                      </select>
                      <input type="text" size="80" name="ref_ts_head2" value="<?php print $rs->fields['ref_ts_head2'];?>" maxlength="120" style="text-align:center;background-color:#CCCCCC" /><br />
                      Font:<select name="ref_ts_head2_font">
                        <option value="Times New Roman" <?php if($rs->fields['ref_ts_head2_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                        <option value="Arial" <?php if($rs->fields['ref_ts_head2_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                        <option value="Verdana" <?php if($rs->fields['ref_ts_head2_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                      </select>&nbsp;&nbsp;
                      Font Style:<select name="ref_ts_head2_fontstyle">
                        <option value="" <?php if($rs->fields['ref_ts_head2_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                        <option value="italic" <?php if($rs->fields['ref_ts_head2_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                      </select>&nbsp;&nbsp;
                      Font Size:<select name="ref_ts_head2_size">
                        <option value="16px" <?php if($rs->fields['ref_ts_head2_size']=='16px'){ print 'selected'; }?>>16px</option>
                        <option value="18px" <?php if($rs->fields['ref_ts_head2_size']=='18px'){ print 'selected'; }?>>18px</option>
                        <option value="20px" <?php if($rs->fields['ref_ts_head2_size']=='20px'){ print 'selected'; }?>>20px</option>
                        <option value="24px" <?php if($rs->fields['ref_ts_head2_size']=='24px'){ print 'selected'; }?>>24px</option>
                        <option value="28px" <?php if($rs->fields['ref_ts_head2_size']=='28px'){ print 'selected'; }?>>28px</option>
                        <option value="32px" <?php if($rs->fields['ref_ts_head2_size']=='32px'){ print 'selected'; }?>>32px</option>
                      </select>
                      <input type="text" size="80" name="ref_ts_head3" value="<?php print $rs->fields['ref_ts_head3'];?>" maxlength="120" style="text-align:center;background-color:#CCCCCC" /><br />
                      Font:<select name="ref_ts_head3_font">
                        <option value="Times New Roman" <?php if($rs->fields['ref_ts_head3_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                        <option value="Arial" <?php if($rs->fields['ref_ts_head3_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                        <option value="Verdana" <?php if($rs->fields['ref_ts_head3_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                      </select>&nbsp;&nbsp;
                      Font Style:<select name="ref_ts_head3_fontstyle">
                        <option value="" <?php if($rs->fields['ref_ts_head3_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                        <option value="italic" <?php if($rs->fields['ref_ts_head3_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                      </select>&nbsp;&nbsp;
                      Font Size:<select name="ref_ts_head3_size">
                        <option value="16px" <?php if($rs->fields['ref_ts_head3_size']=='16px'){ print 'selected'; }?>>16px</option>
                        <option value="18px" <?php if($rs->fields['ref_ts_head3_size']=='18px'){ print 'selected'; }?>>18px</option>
                        <option value="20px" <?php if($rs->fields['ref_ts_head3_size']=='20px'){ print 'selected'; }?>>20px</option>
                        <option value="24px" <?php if($rs->fields['ref_ts_head3_size']=='24px'){ print 'selected'; }?>>24px</option>
                        <option value="28px" <?php if($rs->fields['ref_ts_head3_size']=='28px'){ print 'selected'; }?>>28px</option>
                        <option value="32px" <?php if($rs->fields['ref_ts_head3_size']=='32px'){ print 'selected'; }?>>32px</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
			                <td height="89" align="center">Dengan Ini Disahkan Bahawa<br />
                            Font:<select name="ref_ts_sah_font">
                            	<option value="Times New Roman" <?php if($rs->fields['ref_ts_sah_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                            	<option value="Arial" <?php if($rs->fields['ref_ts_sah_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                            	<option value="Verdana" <?php if($rs->fields['ref_ts_sah_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                            </select>&nbsp;&nbsp;
                            Font Style:<select name="ref_ts_sah_fontstyle">
                            	<option value="" <?php if($rs->fields['ref_ts_sah_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                            	<option value="italic" <?php if($rs->fields['ref_ts_sah_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                            </select>&nbsp;&nbsp;
                            Font Size:<select name="ref_ts_sah_size">
                            	<option value="14px" <?php if($rs->fields['ref_ts_sah_size']=='14px'){ print 'selected'; }?>>14px</option>
                            	<option value="16px" <?php if($rs->fields['ref_ts_sah_size']=='16px'){ print 'selected'; }?>>16px</option>
                            	<option value="18px" <?php if($rs->fields['ref_ts_sah_size']=='18px'){ print 'selected'; }?>>18px</option>
                            	<option value="20px" <?php if($rs->fields['ref_ts_sah_size']=='20px'){ print 'selected'; }?>>20px</option>
                            	<option value="24px" <?php if($rs->fields['ref_ts_sah_size']=='24px'){ print 'selected'; }?>>24px</option>
                            	<option value="28px" <?php if($rs->fields['ref_ts_sah_size']=='28px'){ print 'selected'; }?>>28px</option>
                            	<option value="32px" <?php if($rs->fields['ref_ts_sah_size']=='32px'){ print 'selected'; }?>>32px</option>
                            	<option value="36px" <?php if($rs->fields['ref_ts_sah_size']=='36px'){ print 'selected'; }?>>36px</option>
                            	<option value="42px" <?php if($rs->fields['ref_ts_sah_size']=='42px'){ print 'selected'; }?>>42px</option>
                            	<option value="50px" <?php if($rs->fields['ref_ts_sah_size']=='50px'){ print 'selected'; }?>>50px</option>
                            </select>
						      </tr>
                        <tr>
			                <td height="67" align="center"><b>ALIMAN BIN ABDUL HASSAN</b><br />
			                  Font:
			                  <select name="ref_ts_nama_font">
                                <option value="Times New Roman" <?php if($rs->fields['ref_ts_nama_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                                <option value="Arial" <?php if($rs->fields['ref_ts_nama_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                                <option value="Verdana" <?php if($rs->fields['ref_ts_nama_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                              </select>
			                  &nbsp;&nbsp;
                            Font Style:
                            <select name="ref_ts_nama_fontstyle">
                              <option value="" <?php if($rs->fields['ref_ts_nama_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                              <option value="italic" <?php if($rs->fields['ref_ts_nama_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                            </select>
                            &nbsp;&nbsp;
                            Font Size:
                            <select name="ref_ts_nama_size">
                              <option value="14px" <?php if($rs->fields['ref_ts_nama_size']=='14px'){ print 'selected'; }?>>14px</option>
                              <option value="16px" <?php if($rs->fields['ref_ts_nama_size']=='16px'){ print 'selected'; }?>>16px</option>
                              <option value="18px" <?php if($rs->fields['ref_ts_nama_size']=='18px'){ print 'selected'; }?>>18px</option>
                              <option value="20px" <?php if($rs->fields['ref_ts_nama_size']=='20px'){ print 'selected'; }?>>20px</option>
                              <option value="24px" <?php if($rs->fields['ref_ts_nama_size']=='24px'){ print 'selected'; }?>>24px</option>
                              <option value="28px" <?php if($rs->fields['ref_ts_nama_size']=='28px'){ print 'selected'; }?>>28px</option>
                              <option value="32px" <?php if($rs->fields['ref_ts_nama_size']=='32px'){ print 'selected'; }?>>32px</option>
                              <option value="36px" <?php if($rs->fields['ref_ts_nama_size']=='36px'){ print 'selected'; }?>>36px</option>
                              <option value="42px" <?php if($rs->fields['ref_ts_nama_size']=='42px'){ print 'selected'; }?>>42px</option>
                              <option value="50px" <?php if($rs->fields['ref_ts_nama_size']=='50px'){ print 'selected'; }?>>50px</option>
                            </select></td>
                      </tr>

                        <tr>
			                <td height="66" align="center"><b>(700105-64-3456)</b><br />
			                  Font:
			                  <select name="ref_ts_kp_font">
                                <option value="Times New Roman" <?php if($rs->fields['ref_ts_kp_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                                <option value="Arial" <?php if($rs->fields['ref_ts_kp_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                                <option value="Verdana" <?php if($rs->fields['ref_ts_kp_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                              </select>
			                  &nbsp;&nbsp;
                            Font Style:
                            <select name="ref_ts_kp_fontstyle">
                              <option value="" <?php if($rs->fields['ref_ts_kp_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                              <option value="italic" <?php if($rs->fields['ref_ts_kp_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                            </select>
                            &nbsp;&nbsp;
                            Font Size:
                            <select name="ref_ts_kp_size">
                              <option value="14px" <?php if($rs->fields['ref_ts_kp_size']=='14px'){ print 'selected'; }?>>14px</option>
                              <option value="16px" <?php if($rs->fields['ref_ts_kp_size']=='16px'){ print 'selected'; }?>>16px</option>
                              <option value="18px" <?php if($rs->fields['ref_ts_kp_size']=='18px'){ print 'selected'; }?>>18px</option>
                              <option value="20px" <?php if($rs->fields['ref_ts_kp_size']=='20px'){ print 'selected'; }?>>20px</option>
                              <option value="24px" <?php if($rs->fields['ref_ts_kp_size']=='24px'){ print 'selected'; }?>>24px</option>
                              <option value="28px" <?php if($rs->fields['ref_ts_kp_size']=='28px'){ print 'selected'; }?>>28px</option>
                              <option value="32px" <?php if($rs->fields['ref_ts_kp_size']=='32px'){ print 'selected'; }?>>32px</option>
                              <option value="36px" <?php if($rs->fields['ref_ts_kp_size']=='36px'){ print 'selected'; }?>>36px</option>
                              <option value="42px" <?php if($rs->fields['ref_ts_kp_size']=='42px'){ print 'selected'; }?>>42px</option>
                              <option value="50px" <?php if($rs->fields['ref_ts_kp_size']=='50px'){ print 'selected'; }?>>50px</option>
                            </select></td>
                      </tr>

                        <tr>
               				<td height="91" align="center">Telah Mengikuti Dengan Jayanya<br />
               				  Font:
               				  <select name="ref_ts_telah_font">
                                <option value="Times New Roman" <?php if($rs->fields['ref_ts_telah_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                                <option value="Arial" <?php if($rs->fields['ref_ts_telah_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                                <option value="Verdana" <?php if($rs->fields['ref_ts_telah_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                              </select>
               				  &nbsp;&nbsp;
                            Font Style:
                            <select name="ref_ts_telah_fontstyle">
                              <option value="" <?php if($rs->fields['ref_ts_telah_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                              <option value="italic" <?php if($rs->fields['ref_ts_telah_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                            </select>
                            &nbsp;&nbsp;
                            Font Size:
                            <select name="ref_ts_telah_size">
                              <option value="14px" <?php if($rs->fields['ref_ts_telah_size']=='14px'){ print 'selected'; }?>>14px</option>
                              <option value="16px" <?php if($rs->fields['ref_ts_telah_size']=='16px'){ print 'selected'; }?>>16px</option>
                              <option value="18px" <?php if($rs->fields['ref_ts_telah_size']=='18px'){ print 'selected'; }?>>18px</option>
                              <option value="20px" <?php if($rs->fields['ref_ts_telah_size']=='20px'){ print 'selected'; }?>>20px</option>
                              <option value="24px" <?php if($rs->fields['ref_ts_telah_size']=='24px'){ print 'selected'; }?>>24px</option>
                              <option value="28px" <?php if($rs->fields['ref_ts_telah_size']=='28px'){ print 'selected'; }?>>28px</option>
                              <option value="32px" <?php if($rs->fields['ref_ts_telah_size']=='32px'){ print 'selected'; }?>>32px</option>
                              <option value="36px" <?php if($rs->fields['ref_ts_telah_size']=='36px'){ print 'selected'; }?>>36px</option>
                              <option value="42px" <?php if($rs->fields['ref_ts_telah_size']=='42px'){ print 'selected'; }?>>42px</option>
                              <option value="50px" <?php if($rs->fields['ref_ts_telah_size']=='50px'){ print 'selected'; }?>>50px</option>
                            </select></td>
                      </tr>
                        <tr>
			                <td height="84" align="center"><b>KURSUS OPENOFFICE</b><br />
			                  Font:
			                  <select name="ref_ts_kursus_font">
                                <option value="Times New Roman" <?php if($rs->fields['ref_ts_kursus_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                                <option value="Arial" <?php if($rs->fields['ref_ts_kursus_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                                <option value="Verdana" <?php if($rs->fields['ref_ts_kursus_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                              </select>
			                  &nbsp;&nbsp;
                            Font Style:
                            <select name="ref_ts_kursus_fontstyle">
                              <option value="" <?php if($rs->fields['ref_ts_kursus_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                              <option value="italic" <?php if($rs->fields['ref_ts_kursus_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                            </select>
                            &nbsp;&nbsp;
                            Font Size:
                            <select name="ref_ts_kursus_size">
                              <option value="14px" <?php if($rs->fields['ref_ts_kursus_size']=='14px'){ print 'selected'; }?>>14px</option>
                              <option value="16px" <?php if($rs->fields['ref_ts_kursus_size']=='16px'){ print 'selected'; }?>>16px</option>
                              <option value="18px" <?php if($rs->fields['ref_ts_kursus_size']=='18px'){ print 'selected'; }?>>18px</option>
                              <option value="20px" <?php if($rs->fields['ref_ts_kursus_size']=='20px'){ print 'selected'; }?>>20px</option>
                              <option value="24px" <?php if($rs->fields['ref_ts_kursus_size']=='24px'){ print 'selected'; }?>>24px</option>
                              <option value="28px" <?php if($rs->fields['ref_ts_kursus_size']=='28px'){ print 'selected'; }?>>28px</option>
                              <option value="32px" <?php if($rs->fields['ref_ts_kursus_size']=='32px'){ print 'selected'; }?>>32px</option>
                              <option value="36px" <?php if($rs->fields['ref_ts_kursus_size']=='36px'){ print 'selected'; }?>>36px</option>
                              <option value="42px" <?php if($rs->fields['ref_ts_kursus_size']=='42px'){ print 'selected'; }?>>42px</option>
                              <option value="50px" <?php if($rs->fields['ref_ts_kursus_size']=='50px'){ print 'selected'; }?>>50px</option>
                            </select></td>
                      </tr>
                        <tr>
			                <td height="80" align="center">Yang Telah Diadakan Mulai<br />
			                  Font:
			                  <select name="ref_ts_mulai_font">
                                <option value="Times New Roman" <?php if($rs->fields['ref_ts_mulai_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                                <option value="Arial" <?php if($rs->fields['ref_ts_mulai_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                                <option value="Verdana" <?php if($rs->fields['ref_ts_mulai_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                              </select>
			                  &nbsp;&nbsp;
                            Font Style:
                            <select name="ref_ts_mulai_fontstyle">
                              <option value="" <?php if($rs->fields['ref_ts_mulai_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                              <option value="italic" <?php if($rs->fields['ref_ts_mulai_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                            </select>
                            &nbsp;&nbsp;
                            Font Size:
                            <select name="ref_ts_mulai_size">
                              <option value="14px" <?php if($rs->fields['ref_ts_sah_size']=='14px'){ print 'selected'; }?>>14px</option>
                              <option value="16px" <?php if($rs->fields['ref_ts_sah_size']=='16px'){ print 'selected'; }?>>16px</option>
                              <option value="18px" <?php if($rs->fields['ref_ts_sah_size']=='18px'){ print 'selected'; }?>>18px</option>
                              <option value="20px" <?php if($rs->fields['ref_ts_sah_size']=='20px'){ print 'selected'; }?>>20px</option>
                              <option value="24px" <?php if($rs->fields['ref_ts_sah_size']=='24px'){ print 'selected'; }?>>24px</option>
                              <option value="28px" <?php if($rs->fields['ref_ts_sah_size']=='28px'){ print 'selected'; }?>>28px</option>
                              <option value="32px" <?php if($rs->fields['ref_ts_sah_size']=='32px'){ print 'selected'; }?>>32px</option>
                              <option value="36px" <?php if($rs->fields['ref_ts_sah_size']=='36px'){ print 'selected'; }?>>36px</option>
                              <option value="42px" <?php if($rs->fields['ref_ts_sah_size']=='42px'){ print 'selected'; }?>>42px</option>
                              <option value="50px" <?php if($rs->fields['ref_ts_sah_size']=='50px'){ print 'selected'; }?>>50px</option>
                            </select></td>
                      </tr>
                        <tr>
                            <td height="129" align="center"><i>15 hingga 17 Jun 2010<br />
                            Bersamaan<br />
                            <input type="text" name="tarikh_hijrah" size="70" value="<?php print $rs->fields['tarikh_hijrah'];?>" style="text-align:center;background-color:#CCCCCC" />
                            <!--02 hingga 04 Rejab 1431--></i><br />
                              Font:
                              <select name="ref_ts_tkh_font">
                                <option value="Times New Roman" <?php if($rs->fields['ref_ts_tkh_font']=='Times New Roman'){ print 'selected'; }?>>Times New Roman</option>
                                <option value="Arial" <?php if($rs->fields['ref_ts_tkh_font']=='Arial'){ print 'selected'; }?>>Arial</option>
                                <option value="Verdana" <?php if($rs->fields['ref_ts_tkh_font']=='Verdana'){ print 'selected'; }?>>Verdana</option>
                              </select>
                              &nbsp;&nbsp;
                            Font Style:
                            <select name="ref_ts_tkh_fontstyle">
                              <option value="" <?php if($rs->fields['ref_ts_tkh_fontstyle']==''){ print 'selected'; }?>>Normal</option>
                              <option value="italic" <?php if($rs->fields['ref_ts_tkh_fontstyle']=='italic'){ print 'selected'; }?>>italic</option>
                            </select>
                            &nbsp;&nbsp;
                            Font Size:
                            <select name="ref_ts_tkh_size">
                              <option value="14px" <?php if($rs->fields['ref_ts_tkh_size']=='14px'){ print 'selected'; }?>>14px</option>
                              <option value="16px" <?php if($rs->fields['ref_ts_tkh_size']=='16px'){ print 'selected'; }?>>16px</option>
                              <option value="18px" <?php if($rs->fields['ref_ts_tkh_size']=='18px'){ print 'selected'; }?>>18px</option>
                              <option value="20px" <?php if($rs->fields['ref_ts_tkh_size']=='20px'){ print 'selected'; }?>>20px</option>
                              <option value="24px" <?php if($rs->fields['ref_ts_tkh_size']=='24px'){ print 'selected'; }?>>24px</option>
                              <option value="28px" <?php if($rs->fields['ref_ts_tkh_size']=='28px'){ print 'selected'; }?>>28px</option>
                              <option value="32px" <?php if($rs->fields['ref_ts_tkh_size']=='32px'){ print 'selected'; }?>>32px</option>
                              <option value="36px" <?php if($rs->fields['ref_ts_tkh_size']=='36px'){ print 'selected'; }?>>36px</option>
                              <option value="42px" <?php if($rs->fields['ref_ts_tkh_size']=='42px'){ print 'selected'; }?>>42px</option>
                              <option value="50px" <?php if($rs->fields['ref_ts_tkh_size']=='50px'){ print 'selected'; }?>>50px</option>
                            </select></td>
                      </tr>
                        <tr>
			                <td align="center">
                            Lokasi Tandatangan Pengarah<br />
                            <select name="ref_ts_position">
                            	<option value="center" <?php if($rs->fields['ref_ts_position']=='center'){ print 'selected'; }?>>Center</option>
                            	<option value="left" <?php if($rs->fields['ref_ts_position']=='left'){ print 'selected'; }?>>Left</option>
                            	<option value="right" <?php if($rs->fields['ref_ts_position']=='right'){ print 'selected'; }?>>Right</option>
                            </select><br />
                            Masukkan nama pengarah<br />
                            <input type="text" name="ref_ts_oleh" size="70" value="<?php print $rs->fields['ref_ts_oleh'];?>" 
                            style="text-align:center;background-color:#CCCCCC" />
                            <br />
                            Masukkan maklumat jawatan
                            <br />
                            <input type="text" name="ref_ts_jawatan" size="70" value="<?php print $rs->fields['ref_ts_jawatan'];?>" 
                            style="text-align:center;background-color:#CCCCCC" />
                            <br /><!--Institut Latihan Islam Malaysia-->
                            <?php print dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rs->fields['kampus_id'])); ?>
                            <br />Jabatan Kemajuan Islam Malaysia</td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>    
        <tr>
            <td colspan="3" align="center">
                <input type="hidden" name="id" value="<?=$id?>" />
                <input type="hidden" name="PageNo" value="<?=$PageNo?>" />
            </td>
        </tr>
        </table>
      </td>
   </tr>
</table>
</form>
<script LANGUAGE="JavaScript">
	document.ilim.ref_ts_head.focus();
</script>
