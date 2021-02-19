<?php

$msg='';
$varUser=isset($_POST["userlog"])?trim($_POST["userlog"]):"";
$varPswd=isset($_POST["upass"])?trim($_POST["upass"]):"";
//print $varUser."/".$varPswd;
if(!empty($varUser) && !empty($varPswd)){	
	//include 'common.php';
	//$conn->debug=true;
	$sql = "SELECT * FROM  _tbl_instructor WHERE is_deleted=0 AND insid=".tosql($varUser,"Text")." AND passwd=".tosql(md5($varPswd),"Text");
	$rslogin = &$conn->Execute($sql);

	if(!$rslogin->EOF){
	
		$_SESSION["s_usertype"]='PENSYARAH';
		$_SESSION["s_level"]='1';
		$_SESSION["s_userid"]=$rslogin->fields['ingenid'];
		$_SESSION["s_logid"]=$rslogin->fields['insid'];
		$_SESSION["s_username"]=$rslogin->fields['insname'];
		$_SESSION["s_pages"]='PENSYARAH';
		//$user_name = $rslogin->fields['f_name'];
		/*session_register("s_level");
		session_register("s_userid");
		session_register("s_username");*/
		$pok=1;
		$msg = 'Anda berjaya log masuk ke dalam sistem.';
		audit_log($msg,'Pensyarah','','');

		//include_once("include/usersOnline.class.php");
		//function ipCheck() {
		/*
		This function will try to find out if user is coming behind proxy server. Why is this important?
		If you have high traffic web site, it might happen that you receive lot of traffic
		from the same proxy server (like AOL). In that case, the script would count them all as 1 user.
		This function tryes to get real IP address.
		Note that getenv() function doesn't work when PHP is running as ISAPI module
		*/
			if (getenv('HTTP_CLIENT_IP')) {
				$ip = getenv('HTTP_CLIENT_IP');
			}
			elseif (getenv('HTTP_X_FORWARDED_FOR')) {
				$ip = getenv('HTTP_X_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_X_FORWARDED')) {
				$ip = getenv('HTTP_X_FORWARDED');
			}
			elseif (getenv('HTTP_FORWARDED_FOR')) {
				$ip = getenv('HTTP_FORWARDED_FOR');
			}
			elseif (getenv('HTTP_FORWARDED')) {
				$ip = getenv('HTTP_FORWARDED');
			}
			else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			//return $ip;
		//}
		$dt = date("m-d");
		$yr = date("Y")-1;
		$get_dt = $yr."-".$dt." 00:00:00";
		
		//$sqld = "DELETE FROM auditrail WHERE trans_date < ".tosql($get_dt);
		//print $sqld;
		//$conn->execute($sqld);
		//exit;

		$tout = time()-300;
		$sqld = "DELETE FROM useronline WHERE timestamp < ".tosql($tout);
		$conn->execute($sqld);

		
		$sqli = "INSERT INTO useronline(timestamp, ip, user_name) VALUES ('".time()."', '$ip', '$user_name')";
		$conn->execute($sqli);
		
		$mnu = base64_encode('user;default_pensyarah.php');
		print '<script>
			<!--
			alert("Anda berjaya log masuk ke dalam sistem.");
			//parent.location.reload();
			//parent.emailwindow.hide();
			document.location.href="apps/index.php?data='.$mnu.'";
			//-->
			</script>';
		
	} else {
		$pok=0;
		$msg = 'Kombinasi ID Pengguna dan Katalaluan anda salah.<br>Sila cuba sekali lagi.';
		audit_log($msg,'sistem',$varUser,'ERR');
		//exit;
		/*print '<script>
			alert("Kombinasi ID Pengguna dan Katalaluan anda salah. Sila cuba sekali lagi.");
			document.location.href="systems.php";
			</script>';
		*/
	}
}
?>
<link href="login-box.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
<!--
	function do_logs(URL){
		if(document.ilim.userlog.value==''){
			alert("Please enter your login id");
			document.ilim.userlog.focus();
		} else if(document.ilim.upass.value==''){
			alert("Please enter your password");
			document.ilim.upass.focus();
		} else {
			//alert(URL);
			document.ilim.action=URL;
			document.ilim.submit();
		}
	}
-->
</script>

<head>
<title>Login V12</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">

<!-- <link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css"> -->

<link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">

<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">

<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">

<link rel="stylesheet" type="text/css" href="login/css/util.css">
<link rel="stylesheet" type="text/css" href="login/css/main.css">

</head>

<body>
    <div class="container">
		<div class="row justify-content-center">
            <div class="col-10">
				<div class="card-body text-white" style="background-color: rgba(204, 149, 30, 0.59);">
					<i class="fa fa-address-card  fa-6x pb-3 pt-3"></i>
                    <h3 class="section-heading text-uppercase" style="font-size: 2.5em;">SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)<br>(PENSYARAH)<b></h3> 
					<br><p><div class="text-white">Sila masukkan no. kad pengenalan anda.</div></p><br>
					
                    <form class="form-signin">
                        <div class="form-group row align-items-center justify-content-center">
                            <!-- <label for="logid" class="col-sm-3 col-form-label col-form-label-lg"></label> -->
                            <div class="col-sm-9">
                                <input style="border-radius: 2rem" type="text" class="form-control form-control-lg" id="logid" placeholder="No Kad Pengenalan">
                            </div>
                        </div>

                        <div class="form-group row align-items-center justify-content-center">
                            <!-- <label for="pass" class="col-sm-3 col-form-label col-form-label-lg"></label> -->
                            <div class="col-sm-9">
                                <input style="border-radius: 2rem" type="password" class="form-control form-control-lg" id="pass" placeholder="Kata Laluan">
                            </div>
                        </div>
                        <hr class="my-4">
                        <!-- <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Remember password</label>
                        </div> -->
                                <a href="javascript:void(0);" onClick="do_logs('index.php?pages=login_pensyarah')">
                                <button class="btn btn-warning btn-sm" style="cursor:pointer; font-size: 0.8rem; font-weight:bold";>LOG MASUK</button>
                            </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<?php //} ?>
<script language="javascript" type="text/javascript">
document.ilim.userlog.focus();
</script>