<link type="text/css" rel="stylesheet" href="cal/dhtmlgoodies_calendar.css" media="screen"></LINK>
<SCRIPT type="text/javascript" src="cal/dhtmlgoodies_calendar.js"></script>
<script language="javascript">
function do_submit(URL){
	if(document.frm.j_dewan.value==''){
		alert("Sila pilih jenis dewan persidangan");
		document.frm.j_dewan.focus();
	} else if(document.frm.persidangan.value==''){
		alert("Sila masukkan maklumat persidangan");
		document.frm.persidangan.focus();
	} else if(document.frm.start_dt.value==''){
		alert("Sila masukkan tarikh mula penggal persidangan");
		document.frm.start_dt.focus();
	} else if(document.frm.end_dt.value==''){
		alert("Sila masukkan tarikh akhir penggal persidangan");
		document.frm.end_dt.focus();
	} else {
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}

function do_back(URL){
	document.frm.action = URL;
	document.frm.target = '_self';
	document.frm.submit();
}

function do_hapus(URL){
	if(confirm("Adakah anda pasti?")){
		document.frm.actions.value = 'DELETE';
		document.frm.action = URL;
		document.frm.target = '_self';
		document.frm.submit();
	}
}
</script>
<?php
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$actions = "INSERT";
if(!empty($id)){
	$sql = "SELECT * FROM kod_sidang WHERE id_sidang=".tosql($id,"Number");
	$result = &$conn->Execute($sql);
	//if(!$result){ echo "Invalid query : " . mysql_errno(); }
	//$row = mysql_fetch_array($result, MYSQL_BOTH);
	$actions = "UPDATE";
	$title = "Kemaskini Maklumat Persidangan";
} else {
	$title = "Tambah Maklumat Persidangan";
}
?>
<table width="900px" cellpadding="0" cellspacing="0" align="center">
	<tr><td>
<table width="100%" border="0" cellspacing="1" cellpadding="5" align="center">
	<tr>
    	<td colspan="2" height="40">
        	<table width="100%" cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%" align="center"><h2><?=$title;?></h2></td>
                    <td width="2%" align="right">&nbsp;</td>
                </tr>
                <tr>
                	<td width="2%" height="40" align="left">&nbsp;</td>
                    <td width="96%">
                    	<table width="100%">
						  <?
                          $sqlkd = "SELECT * FROM kod_dewan";
                          $res_kd = &$conn->Execute($sqlkd);
                          ?>
                          <tr>
                            <td align="left">Dewan <div style="float:right">: </div>
                            <td align="left">
                                <select name="j_dewan">
                                    <option value="">-- Sila pilih --</option>
                                <?php while(!$res_kd->EOF){ ?>
                                    <option value="<?=$res_kd->fields['j_dewan']?>" <?php if($result->fields['j_dewan']==$res_kd->fields['j_dewan']){ echo 'selected'; }?>>
                                    <?=strtoupper($res_kd->fields['dewan']);?></option>
                                <?php $res_kd->movenext(); } ?>
                                </select>
                            </td>
                          </tr>
                          <tr>
                            <td width="25%" valign="top" align="left">Maklumat Persidangan <div style="float:right">: </div>
                            <td width="75%" align="left"><textarea rows="3" name="persidangan" cols="60"><?=$result->fields['persidangan'];?></textarea></td>
                          </tr>
                          <tr>
                            <td align="left">Tahun Persidangan <div style="float:right">: </div>
                            <td align="left">
                            	<select name="tahun">
                                <?php for($t=date("Y")+1;$t>=2008;$t--){ ?>
                                	<option value="<?=$t;?>" <?php if($result->fields['tahun']==$t){ print 'selected'; }?>><?=$t;?></option>
                                <?php } ?>
                                </select>
                             </td>
                          </tr>
                          <tr>
                            <td width="20%" align="left">Tarikh Mula <div style="float:right">: </div>
                            <td width="80%" align="left"><input name="start_dt" type="text" size="10" maxlength="10" value="<?php print DisplayDate($result->fields['start_dt']);?>" />
                             <img src="cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                             onclick="displayCalendar(document.forms[0].start_dt,'dd-mm-yyyy',this)"/> [dd-mm-yyyy]</font> </td>
                          </tr>
                          <tr>
                            <td align="left">Tarikh Hingga <div style="float:right">: </div>
                            <td align="left"><input name="end_dt" type="text" size="10" maxlength="10" value="<?php print DisplayDate($result->fields['end_dt']);?>" />
                             <img src="cal/img/screenshot.gif" alt="" width="21" height="22" align="absmiddle" style="cursor:pointer" 
                             onclick="displayCalendar(document.forms[0].end_dt,'dd-mm-yyyy',this)"/> [dd-mm-yyyy]</font> </td>
                          </tr>
                          <tr>
                            <td align="left">Status <div style="float:right">: </div>
                            <td align="left">
                            	<select name="status">
                                	<option value="0" <?php if($result->fields['status']=='0'){ print 'selected'; }?>>Aktif</option>
                                	<option value="1" <?php if($result->fields['status']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                                </select>
                             </td>
                          </tr>
                          <tr><td>&nbsp;</td></tr>
                          <tr>
                            <td colspan="2" align="center"><input type="button" name="button" id="button" value="Simpan" 
                            onclick="do_submit('index.php?data=<?=base64_encode('4;utiliti/sidang_do.php;');?>')" />
                            <?php if(!empty($id)){ ?>  
                              <input type="button" name="button2" id="button" value="Hapus" 
                              onclick="do_hapus('index.php?data=<?=base64_encode('4;utiliti/sidang_do.php;');?>')" />
                            <?php } ?>
                              <input type="button" name="button3" id="button" value="Kembali" 
                              onclick="do_back('index.php?data=<?=base64_encode('4;utiliti/sidang.php;');?>&PageNo=<?php echo $PageNo?>')" />
                              <input type="hidden" name="id_sidang" value="<?php echo $result->fields['id_sidang']?>" />
                              <input type="hidden" name="actions" id="actions" value="<?php echo $actions?>" />
                              <input type="hidden" name="PageNo" value="<?php echo $PageNo?>" />
                            </td>
                          </tr>
                                                </table>
                    </td>
                    <td width="2%" align="right" >&nbsp;</td>
                </tr>
            </table>
    	</td>
    </tr>
</table>
</td></tr></table>
