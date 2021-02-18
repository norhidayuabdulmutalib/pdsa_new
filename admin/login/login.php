<?php
$msg='';
$varUser=isset($_REQUEST["up_userid"])?$_REQUEST["up_userid"]:"";
$varPswd=isset($_REQUEST["up_password"])?$_REQUEST["up_password"]:"";
//print $varUser."/".$varPswd;
if(!empty($varUser) && !empty($varPswd)){	
	//include_once 'common.php';
	//$conn->debug=true;
	$sql = "SELECT A.* FROM _tbl_user A
	WHERE A.is_admin=1 AND A.f_isdeleted=0 AND A.f_aktif=1  
	AND A.f_userid=".tosql($varUser,"Text")." AND A.f_password=".tosql(md5($varPswd),"Text");
	$rslogin = $conn->query($sql);
	// var_dump($rslogin);
	//if( mysql_errno<>0){ print  mysql_error(); }
	//$cnt = $rslogin->recordcount();
	//print "CNT:".$cnt;

	if(!$rslogin->EOF){
		@session_start();
		$_SESSION["s_usertype"]='SYSTEM';
		$_SESSION["s_pusat"]=$rslogin->fields['kod_jabatan'];
		$_SESSION["s_level"]=$rslogin->fields['f_level'];
		$_SESSION["s_userid"]=$rslogin->fields['id_user'];
		$_SESSION["s_logid"]=$rslogin->fields['f_userid'];
		$_SESSION["s_username"]=$rslogin->fields['f_name'];
		$_SESSION["s_jabatan"]=$rslogin->fields['f_jabatan'];
		$_SESSION["s_pages"]='SYSTEM';
		$user_name = $rslogin->fields['f_name'];
		$_SESSION['SESS_KAMPUS']=$rslogin->fields['kampus_id'];
		$_SESSION['s_kampus']=$rslogin->fields['kampus_id'];
		// $_SESSION["s_level"]=$rsmenus->fields['f_level'];
		

		
		
		if(!empty($rslogin->fields['kampus_id'])){ 
			$_SESSION["s_pusatnama"]=dlookup("_ref_kampus","kampus_nama","kampus_id=".tosql($rslogin->fields['kampus_id'])); 
			//$rslogin->fields['kampus_nama'];
		}
		/*session_register("s_level");
		session_register("s_userid");
		session_register("s_username");*/
		//print "S:".$_SESSION["s_userid"].":".$_SESSION["s_jabatan"]; exit;
		$pok=1;
		$msg = 'Anda berjaya log masuk ke dalam sistem.';
		audit_log($msg,'sistem','','');

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
		//$href=base64_encode($_SESSION["s_userid"].';apps/default');
		$href=base64_encode($_SESSION["s_userid"].';default');
		var_dump($href); 
		// var_dump($_SESSION["s_userid"]);
		print '<script>
			alert("Anda berjaya log masuk ke dalam sistem.");
			//parent.location.reload();
			//parent.emailwindow.hide();
			document.location.href="index.php?data='.$href.'";
			</script>';
		
	} else {
		$pok=0;
		$msg = 'Kombinasi ID Pengguna dan Katalaluan anda salah.<br>Sila cuba sekali lagi.';
		audit_log($msg,'sistem',$varUser,'ERR');
		//exit;
		print '<script>
			alert("Kombinasi ID Pengguna dan Katalaluan anda salah. Sila cuba sekali lagi.");
			document.location.href="index.php";
			</script>';
		
	}
}
?>

<header class="masthead" style="padding: 55px;">
	<div class="container">
		<div align="center">
			<img src="../images/logo_ilim.jpg" style="max-height:150px;max-width:100px" alt="image" class="image_parlimen" /></div>
		</div>
		<div class="masthead-heading text-uppercase" style="margin-bottom:0px;">Sistem Maklumat Latihan  (I-TIS)</div>
		<b><p>Sistem ini menyimpan semua maklumat berkaitan urusan permohonan latihan dan kursus bagi pusat latihan yang di bawah seliaan Jakim.</p>
        <p>Sebarang pertanyaan atau cadangan bolehlah diajukan kepada <a href="mailto:eparlimen@islam.gov.my" title="Email">kursus_ilim@islam.gov.my</a></p></b>
		<div class="card float-center" style="background-color: rgba(0, 0, 0, 0.39); width: 750px; margin-left: 180px; margin-right: 180px;">
			<div class="card-body">
				<p class="float-left">Sila log masuk Pengguna ID dan Kata Laluan anda.</p><br><br>
					<form name="form1" method="post" action="index.php?data=<?php print base64_encode(';login/login');?>" onSubmit="validateForm();return document.returnValue"><br>
					<div class="form-group row">
						<label for="staticEmail" class="col-sm-2 col-form-label" style="color:#fff;">ID Pengguna</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" name="up_userid" id="up_userid" value="" placeholder="ID Pengguna"  />
						</div>
					</div>
					<div class="form-group row">
						<label for="inputPassword" class="col-sm-2 col-form-label" style="color:#fff;">Katalaluan</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" name="up_password" value="" placeholder="Katalaluan"  />
						</div>
					</div>

					<div class="form-group row float-right" style="padding-right:10px;">
						<input name="Login" type="submit" value="Log Masuk" class="btn btn-primary btn-md" style="cursor:pointer" />&nbsp;
						<a class="btn btn-secondary btn-md" href="">Lupa Katalaluan</a>
					</div>
				</form>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
</header>
<script language="javascript" type="text/javascript">
document.form1.up_userid.focus();
</script>