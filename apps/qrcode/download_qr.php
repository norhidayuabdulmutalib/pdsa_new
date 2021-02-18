<?php
$kid=isset($_REQUEST["kid"])?$_REQUEST["kid"]:"";
print '<img src="php/qr_img.php?d="'.$kid.' >';
?>
