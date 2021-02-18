<?php  
if (empty($_SESSION["session_id_kakitangan"])) {
	$_SESSION["session_id_kakitangan"]='';
?>
	<script language="JavaScript1.2">
		alert("MAAF! Anda tiada kebenaran untuk melihat data ini..\nSORRY! You no access to view this data..");
		window.open('index.php','_parent');
	</script>
<?php } ?>	