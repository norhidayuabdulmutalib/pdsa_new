<?php
@session_start();
$_SESSION['session_id_kakitangan']='';
$_SESSION['session_userid']='';
unset($_SESSION['session_id_kakitangan']);
unset($_SESSION['session_userid']);
session_destroy();
//header('Location: left.php');
print '<script language="javascript">
	window.open(\'index.php\',\'_parent\')
	</script>';
?>