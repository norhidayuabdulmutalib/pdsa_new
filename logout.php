<?php
// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();
//$_SESSION["s_level"]='PESERTA';
$users=$_SESSION["s_user"];
if($_SESSION["s_usertype"]=='SYSTEM'){
	$urll = "../index.php?pages=login_staff";
} else if($_SESSION["s_usertype"]=='HOSTEL'){
	$urll = "../index.php?pages=login_asrama";
} else if($_SESSION["s_usertype"]=='PENSYARAH'){
	$urll = "../index.php?pages=login_pensyarah";
} else if($_SESSION["s_usertype"]=='PESERTA'){
	$urll = "../index.php?pages=login_peserta";
}
// Unset all of the session variables.
$_SESSION = array();
// Finally, destroy the session.
session_destroy();
//mysql_close();
if($users=='PESERTA'){ 
?>
<script language="Javascript">
	window.open('../index.php?pages=login_peserta','_parent');
</script>
<?php } else { ?>
<script language="Javascript">
	window.open('<?=$urll;?>','_parent');
</script>
<?php } ?>