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
function pilih_buku(nama,caw,noacct){
	parent.update_bank(nama,caw,noacct);
	parent.emailwindow.hide();
}

function form_back(URL){
	parent.emailwindow.hide();
}
</script>
<?php
//print $_SERVER['HTTP_ACCEPT'];
//if(!empty($id)){
	$sSQL="SELECT * FROM _tbl_instructor_bank WHERE ingenid = ".tosql($id,"Number");
	$rs = &$conn->Execute($sSQL);
//}
?>
<form name="ilim" method="post" enctype="multipart/form-data" >
<table width="100%" align="center" cellpadding="0" cellspacing="0" border="1">
    <tr>
    	<td colspan="2" class="title" height="25">SENARAI RUJUKAN BUKU BANK PENCERAMAH
        <div style="float:right"><input type="button" value="Tutup" onclick="form_back('')" style="cursor:pointer" /></div>
        </td>
    </tr>
	<tr><td colspan="2">
    	<table width="98%" cellpadding="3" cellspacing="0" border="1" align="center">
			<tr bgcolor="#CCCCCC">
                <td width="5%"><b>Bil</b></td>
 				<td width="30%"><b>Nama Bank</b></td>
				<td width="30%"><b>Cawangan Bank</b></td>
                <td width="30%"><b>No. Akaun</b></td>
                <td width="5%"><b>&nbsp;</b></td>
            </tr>
		
        	<?php $bil=0;
			while(!$rs->EOF){ $bil++; ?>
            <tr>
            	<td><?php print $bil;?>.</td>
            	<td><?php print $rs->fields['inaka_banknama'];?></td>
            	<td><?php print $rs->fields['inaka_bankcawangan'];?></td>
            	<td><?php print $rs->fields['inaka_banknoacct'];?></td>
                <td align="center"><img src="../img/check.gif" title="Sila klik untuk membuat pilihan"  style="cursor:pointer" 
                onclick="pilih_buku('<?=$rs->fields['inaka_banknama'];?>','<?=$rs->fields['inaka_bankcawangan'];?>','<?=$rs->fields['inaka_banknoacct'];?>')"/></td>
            </tr>
            <?php 	$rs->movenext();
			} ?>

        </table>
        <br />
        Sila klik pada ikon <img src="../img/check.gif" /> untuk membuat pilihan.
      </td>
   </tr>
</table>
</form>