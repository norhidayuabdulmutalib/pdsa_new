<script language="JavaScript1.2" type="text/javascript">
function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_blank';
	document.ilim.submit();
}

function do_page1(URL,targets){
	document.ilim.action = URL;
	document.ilim.target = targets;
	document.ilim.submit();
}

function do_post(){
	var data = document.ilim.data.value;
	document.ilim.action = "index.php?data="+data;
	document.ilim.target = '_self';
	document.ilim.submit();
}
</script>
<br /><br />
<?
$data = $_GET['data'];
$kategori = $_POST['kategori'];
$sesi = $_POST['sesi'];
$semester = $_POST['semester'];
$ref_sukbah_id = $_POST['ref_sukbah_id'];
//$conn->debug=true;
$sql = "SELECT * FROM _ref_laporan WHERE types='L'";
$rslaporan = $conn->execute($sql);
?>
<form name="ilim" method="post">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
	<tr><td colspan="2" align="center"><b>PROSES CETAKAN LAPORAN</b><BR /><BR /></td></tr>
    <? while(!$rslaporan->EOF){ 
		if($rslaporan->fields['targets']=='_self'){
			$href = "index.php?data=".base64_encode('user;../'.$rslaporan->fields['href'].';laporan;laporan');
		} else {
			$href = "../".$rslaporan->fields['href'];
		}
	?>
	<tr>
		<td width="100%" align="center" colspan="2">
            <input type="button" name="" value="<?php print $rslaporan->fields['tajuk'];?>" 
            onClick="do_page1('<?php print$href;?>','<?php print $rslaporan->fields['targets'];?>')" 
            style="width:400px; text-align:left; cursor:pointer;">
            <?php $rslaporan->movenext(); 
			if($rslaporan->fields['targets']=='_self'){
				$href = "index.php?data=".base64_encode('user;../'.$rslaporan->fields['href'].';laporan;laporan');
			} else {
				$href = "../".$rslaporan->fields['href'];
			}
			?>
            <input type="button" name="" value="<?php print $rslaporan->fields['tajuk'];?>" 
            onClick="do_page1('<?php print $href;?>','<?php print $rslaporan->fields['targets'];?>')" 
            style="width:400px; text-align:left; cursor:pointer;">
		</td>
	</tr>
    <? $rslaporan->movenext(); } ?>
	<tr> 
	  <td><input type="hidden" name="data" value="<?=$data;?>" /></td>
	</tr>
</table>
</form>