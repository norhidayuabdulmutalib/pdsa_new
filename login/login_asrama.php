<?php

$msg='';
$varUser=isset($_POST["userlog"])?trim($_POST["userlog"]):"";
$varPswd=isset($_POST["upass"])?trim($_POST["upass"]):"";
//print $varUser."/".$varPswd;
if(!empty($varUser) && !empty($varPswd)){	
	//include 'common.php';
	//$conn->debug=true;
	$sql = "SELECT * FROM _tbl_user WHERE is_hostel=1 AND f_isdeleted=0 
	AND f_userid=".tosql($varUser,"Text")." AND f_password=".tosql(md5($varPswd),"Text");
	$rslogin = &$conn->Execute($sql);
	$cnt = $rslogin->recordcount();
	//print "CNT:".$cnt;
	if(!$rslogin->EOF){
		@session_start();
		$_SESSION["s_usertype"]='HOSTEL';
		$_SESSION["s_level"]=$rslogin->fields['f_level'];
		$_SESSION["s_userid"]=$rslogin->fields['id_user'];
		$_SESSION["s_logid"]=$rslogin->fields['f_userid'];
		$_SESSION["s_username"]=$rslogin->fields['f_name'];
		$_SESSION["s_jabatan"]=$rslogin->fields['f_jabatan'];
		$_SESSION["s_pages"]='HOSTEL';
		$user_name = $rslogin->fields['f_name'];
		$_SESSION['SESS_KAMPUS']=$rslogin->fields['kampus_id'];
		//$_SESSION["s_level"]=$rsmenus->fields['f_level'];
		/*session_register("s_level");
		session_register("s_userid");
		session_register("s_username");*/

		if(!empty($_SESSION["s_pusat"])){ 
			$_SESSION["s_pusatnama"]=dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rslogin->fields['kod_jabatan'])); //$rslogin->fields['kampus_nama'];
		}

		$pok=1;
		$msg = 'Anda berjaya log masuk ke dalam sistem.';
		audit_log($msg,'domistik','','');

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
		
		print '<script>
			<!--
			alert("Anda berjaya log masuk ke dalam sistem.");
			//parent.location.reload();
			//parent.emailwindow.hide();
			document.location.href="apps_hostel/index.php?data=dXNlcjtkZWZhdWx0X2FzcmFtYS5waHA7ZGVmYXVsdA==";
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


<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card-body text-white" style="background-color: rgba(0, 0, 0, 0.39);">
                    <h3 class="section-heading text-uppercase" style="font-size: 2rem;"><b>SISTEM MAKLUMAT LATIHAN ILIM (I-TIS)<br>(DOMISTIK)</b></h3> 
                    <br><p>Sila masukkan no. kad pengenalan anda.</p><br>
					
					<form class="form-signin-centre">
                        <div class="form-group row align-items-center justify-content-center">
                            <label for="logid" class="col-sm-2 col-form-label col-form-label-sm">No. KP :</label>
                            <div class="col-sm-6">
                                <input style="border-radius: 2rem" type="text" class="form-control form-control-sm p-3" id="logid" placeholder="No Kad Pengenalan">
                            </div>
                        </div>
                        <div class="form-group row align-items-center justify-content-center">
                            <label for="pass" class="col-sm-2 col-form-label col-form-label-sm">Kata Laluan :</label>
                            <div class="col-sm-6">
                                <input style="border-radius: 2rem" type="password" class="form-control form-control-sm p-3" id="pass" placeholder="Kata Laluan">
                            </div>
                        </div>
                        <hr class="my-4">
                        <!-- <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Remember password</label>
                        </div> -->
						<a href="javascript:void(0);" onClick="do_open('log_systems.php')">
							<button class="btn btn-warning btn-sm" style="cursor:pointer; font-size: 0.8rem; font-weight:bold";>LOG MASUK</button>
						</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>

<br><br>
<?php //} ?>
<script language="javascript" type="text/javascript">
document.ilim.userlog.focus();
</script>