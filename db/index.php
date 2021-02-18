<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	//header('Location: '.$uri.'/xampp/');
	header('Location: '.$uri.'/dquran/');
	exit;
?>
Something is wrong with the installation :-(
