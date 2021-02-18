<?php 
$uri = explode("?",$_SERVER['REQUEST_URI']);
$URLs = $uri[1];
//$conn->debug=true;
$proses=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$msg='';
if(empty($proses)){ 
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
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,

		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url : "lists/link_list.js",
		//external_image_list_url : "lists/image_list.js",
		//media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],

	});
</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
if(!empty($id)){
	$sSQL="SELECT * FROM _ref_template_sijil WHERE ref_ts_id = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
}
?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SELENGGARA MAKLUMAT CONTOH SIJIL</td>
    </tr>
	<tr><td colspan="2">
    	<table width="100%" cellpadding="5" cellspacing="1" border="1" align="center">
        	<tr>
            	<td width="50%" align="center">
                	<table width="100%" cellpadding="5" cellspacing="1" border="0" align="center">
						<tr>
                      	  <td width="100%" align="center">SIJIL PENYERTAAN<br />INSTITUT LATIHAN ISLAM MALAYSIA<BR />JABATAN KEMAJUAN ISLAM MALAYSIA</td>
                    	</tr>
                        <tr>
			                <td align="center">Dengan Ini Disahkan Bahawa<br /><br /><b>ALIMAN BIN ABDUL HASSAN</b><br /><i>Cetakan Nama Peserta</i></td>
                        </tr>
                        <tr>
               				<td align="center">Telah Mengikuti Dengan Jayanya</td>
                        </tr>
                        <tr>
			                <td align="center"><b>KURSUS OPENOFFICE</b><br /><i>Cetakan Nama Kursus</i></td>
                        </tr>
                        <tr>
			                <td align="center">Yang Telah Diadakan Mulai</td>
                        </tr>
                        <tr>
                            <td align="center"><i>15 hingga 17 Jun 2010<br />Bersamaan<br />02 hingga 04 Rejab 1431</td>
                        </tr>
                        <tr>
			                <td align="center"><b>(HAJI PAIMUZI BIN YAHAYA)</b><br />Pengarah<br />Institut Latihan Islam Malaysia<br />Jabatan Kemajuan Islam Malaysia</td>
                        </tr>
                    </table>
                </td>
                <td width="50%" align="center">
                	<table width="100%" cellpadding="5" cellspacing="1" border="0" align="center">
						<tr>
                      	  <td width="100%" align="center">Masukkan maklumat bahagian atas sijil<br />
                          	<textarea rows="15" cols="60" name="ref_ts_head"><?php print $rs->fields['ref_ts_head'];?></textarea>
                          </td>
                    	</tr>
                        <tr>
			                <td align="center">Dengan Ini Disahkan Bahawa<br /><br /><b>ALIMAN BIN ABDUL HASSAN</b><br /><i>Cetakan Nama Peserta</i></td>
                        </tr>
                        <tr>
               				<td align="center">Telah Mengikuti Dengan Jayanya</td>
                        </tr>
                        <tr>
			                <td align="center"><b>KURSUS OPENOFFICE</b><br /><i>Cetakan Nama Kursus</i></td>
                        </tr>
                        <tr>
			                <td align="center">Yang Telah Diadakan Mulai</td>
                        </tr>
                        <tr>
                            <td align="center"><i>15 hingga 17 Jun 2010<br />Bersamaan<br />02 hingga 04 Rejab 1431</td>
                        </tr>
                        <tr>
			                <td align="center">Masukkan nama pengarah<br />
                            <input type="text" name="ref_ts_oleh" size="70" value="<?php print $rs->fields['ref_ts_oleh'];?>" />
                            <br />Pengarah<br />Institut Latihan Islam Malaysia<br />Jabatan Kemajuan Islam Malaysia</td>
                        </tr>
                        <tr>
			                <td align="center">Status Contoh Sijil : 
                      			 <select name="ref_ts_status">
                                 	<option value="0" <?php if($rs->fields['ref_ts_status']==0){ print 'selected'; }?>>Aktif</option>
                                 	<option value="1" <?php if($rs->fields['ref_ts_status']==1){ print 'selected'; }?>>Tidak Aktif</option>
                                 </select>    	
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>    
        <tr>
            <td colspan="3" align="center">
                <input type="button" value="Simpan" class="button_disp" title="Sila klik untuk menyimpan maklumat" onClick="form_hantar('modal_form.php?<?php print $URLs;?>&pro=SAVE')" >
                <input type="button" value="Kembali" class="button_disp" title="Sila klik untuk kembali ke senarai rujukan disiplin" onClick="form_back()" >
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
<?php } else {
	//print 'simpan';
	include '../loading_pro.php';
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$ref_ts_head=isset($_REQUEST["ref_ts_head"])?$_REQUEST["ref_ts_head"]:"";
	$ref_ts_oleh=isset($_REQUEST["ref_ts_oleh"])?$_REQUEST["ref_ts_oleh"]:"";
	$ref_ts_status=isset($_REQUEST["ref_ts_status"])?$_REQUEST["ref_ts_status"]:"";

	/*$id 			= $_POST['id'];
	$category_code 	= strtoupper($_POST['category_code']);
	$categorytype 	= $_POST['categorytype'];
	$status 		= $_POST['status'];*/
	
	if(empty($id)){
		$sql = "INSERT INTO _ref_template_sijil(ref_ts_head, ref_ts_oleh, ref_ts_status) 
		VALUES(".tosql(strtoupper($ref_ts_head),"Text").", ".tosql($ref_ts_oleh,"Text").", ".tosql($ref_ts_status,"Number").")";
		$rs = &$conn->Execute($sql);
	} else {
		$sql = "UPDATE _ref_template_sijil SET 
			ref_ts_head=".tosql(strtoupper($ref_ts_head),"Text").",
			ref_ts_oleh=".tosql($ref_ts_oleh,"Text").",
			ref_ts_status=".tosql($ref_ts_status,"Number")."
			WHERE ref_ts_id=".tosql($id,"Text");
		$rs = &$conn->Execute($sql);
	}
	
	print "<script language=\"javascript\">
		alert('Rekod telah disimpan');
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		</script>";
}
?>