<?php 
require_once '../../common.php';
$proses = $_POST['proses'];
if(empty($proses)){
?>
    <html>
	<link href="../../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
    <script language="javascript" type="text/javascript">
    function do_save(){
		document.myform.proses.value = 'UPDATE';		
		document.myform.submit();
    }
	
	function do_hapus(){
		document.myform.proses.value = 'DELETE';		
		document.myform.submit();
	}
	
	function do_close(){
		parent.emailwindow.hide();
	}
    </script>
    <body style="background: #F3F3F3">
    <form id="myform" name="myform" method="post" action="staff_menu.php">
    <?
	//$conn->debug=true;
	$kid = $_GET['kid'];
	//echo $kid;
	$sql = "SELECT * FROM _tbl_user WHERE id_user='".$kid."'";
	$rs = &$conn->execute($sql);
	$sqlm = "SELECT * FROM ref_grpmenu WHERE status=0 ORDER BY sort";
	$rs_m = &$conn->execute($sqlm);
    //echo $sqlm;
	$bil=0;
    ?>
    <table width="100%" cellpadding="5" cellspacing="0">
		<tr bgcolor="#009999">
        	<td colspan="5"><b>Nama Kakitangan : <?php print stripslashes($rs->fields['fld_staff']);?></b></td>
        </tr>
    	<?php  //while($rowm = mysql_fetch_assoc($rsm)){
			while(!$rs_m->EOF){ 
				$sqlmd = "SELECT * FROM _tbl_menu WHERE menu_status=0 AND grp_id=".$rs_m->fields['grp_id']." ORDER BY sort";
				//$rsmd = mysql_query($sqlmd);
				$rsmd = &$conn->execute($sqlmd);
				//while($rowmd = mysql_fetch_assoc($rsmd)){
				if(!$rsmd->EOF){
				?>
				<tr bgcolor="#CCCCCC">
					<td colspan="5"><b>Kumpulan Menu : <?php print $rs_m->fields['grp_name'];?></b></td>
				</tr>
				<tr>
					<td width="10%" align="right">&nbsp;</td>
					<td width="40%" align="left"><b>Nama Modul</b></td>
					<td width="10%" align="center"><b>Tambah</b></td>
					<td width="10%" align="center"><b>Kemaskini</b></td>
					<td width="10%" align="center"><b>Hapus</b></td>
				</tr>
				<?
				while(!$rsmd->EOF){
					$menu_id = $rsmd->fields['menu_id'];
					$is_menu = 0; $is_add = 0; $is_upd = 0; $is_del = 0;
					$sql_d = "SELECT * FROM _tbl_menu_user WHERE id_kakitangan=".tosql($kid,"Text")." AND menu_id=".tosql($menu_id,"Number");
					//$rs_data = mysql_query($sql_d);
					$rs_data = &$conn->execute($sql_d);
					//echo $sql_d;
					$is_menu=0;
					//$cnt = $rs_data->recordcount();//mysql_num_rows($rs_data);
					if(!$rs_data->EOF){
						//echo "<br>".$sql_d;
						//$row_data = mysql_fetch_assoc($rs_data);
						$is_menu = 1;
						$menu_uid = $rs_data->fields['menu_uid']; //$row_data['menu_uid'];
						$is_add = $rs_data->fields['is_add']; //$row_data['is_add'];
						$is_upd = $rs_data->fields['is_upd']; //$row_data['is_upd'];
						$is_del = $rs_data->fields['is_del']; //$row_data['is_del'];
					} else {
						$is_menu = 0; $is_add = 0; $is_upd = 0; $is_del = 0; $menu_uid='';
					}
				?>
				<tr>
					<td align="right">&raquo;&nbsp;<input type="checkbox" name="is_menu[<?=$bil;?>]" <?php if($is_menu==1){ print 'checked';}?>>&nbsp;
					<input type="hidden" name="menu_uid[<?=$bil;?>]" value="<?=$menu_uid;?>">
					<input type="hidden" name="menu_id[<?=$bil;?>]" value="<?=$menu_id;?>">
					</td>
					<td align="left"><?php print $rsmd->fields['menu_name'];?></td>
					<td align="center"><input type="checkbox" name="is_add[<?=$bil;?>]" value="1" <?php if($is_add==1){ print 'checked';}?>></td>
					<td align="center"><input type="checkbox" name="is_upd[<?=$bil;?>]" value="1" <?php if($is_upd==1){ print 'checked';}?>></td>
					<td align="center"><input type="checkbox" name="is_del[<?=$bil;?>]" value="1" <?php if($is_del==1){ print 'checked';}?>></td>
				</tr>
				<?php $bil++; $rsmd->movenext();
				} 
			}?>
        <tr><td colspan="5">&nbsp;</td></tr>
    	<?php $rs_m->movenext();
		} ?>        
	</table>
    <table width="100%" cellpadding="5" cellspacing="0">
        <tr><td colspan="2" align="center">
            <input type="button" value="Simpan" onClick="do_save()" title="Sila klik untuk menyimpan maklumat" style="cursor:pointer">
            <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menutup paparan maklumat" style="cursor:pointer">
            <input type="hidden" name="id_kakitangan" value="<?=$kid;?>">
            <input type="hidden" name="proses" value="<?=$proses;?>">
            <input type="hidden" name="bil" value="<?=$bil;?>">
        </td></tr>
    </table>
    </form>
    </body>
    </html>
    <script language="javascript" type="text/javascript">
		//document.myform.tid_nama.focus();
	</script>
<?php } else { ?>
    <?
	$proses = $_POST['proses'];
	$id_kakitangan = $_POST['id_kakitangan'];
	$bil = $_POST['bil'];
	for($i=0;$i<$bil;$i++){
		$sql = '';
		$is_menu 	= $_POST['is_menu'][$i];
		$menu_uid 	= $_POST['menu_uid'][$i];
		$menu_id 	= $_POST['menu_id'][$i];
		$is_add 	= $_POST['is_add'][$i];
		$is_upd 	= $_POST['is_upd'][$i];
		$is_del 	= $_POST['is_del'][$i];
		if($is_add==''){ $is_add=0; }
		if($is_upd==''){ $is_upd=0; }
		if($is_del==''){ $is_del=0; }
		//if($is_add==1 || $is_upd==1 || $is_del==1){ $is_menu='on'; }
		//print "<br>".$is_menu."/" . $menu_uid . "/" . $menu_id;
		if(empty($menu_uid) && $is_menu=='on'){
			$sql = "INSERT INTO _tbl_menu_user(menu_id, id_kakitangan, is_add, is_upd, is_del)
				VALUES('$menu_id', '$id_kakitangan', '$is_add', '$is_upd', '$is_del')";
			//print "<br> : ".$sql;
		} else if($menu_uid<>''&& $is_menu==''){
			$sql = "DELETE FROM _tbl_menu_user WHERE menu_uid=".$menu_uid;
			//print "<br>D : ".$sql;
		} else if($menu_uid<>''&& $is_menu=='on'){
			$sql = "UPDATE _tbl_menu_user SET is_add='$is_add', is_upd='$is_upd', is_del='$is_del'
				WHERE menu_uid=".$menu_uid;
			//print "<br>".$sql;
		}
		if(!empty($sql)){
			$conn->execute($sql);
			//if($rs_data->ErrorNo()<>0){ print ErrorMsg(); exit; }
			//if(mysql_errno()<>0){ print "Invalid query : " . mysql_error(); exit(); }
		}
	}
	//exit;
    ?>
    <form id="myform" name="myform" method="post">
    	<table width="100%"><tr><td>&nbsp;</td></tr></table>
    </form>
    <script language="javascript" type="text/javascript">
		<!--
		//parent.location.href="../index.php?data=bW9ob247cGVybW9ob25hbi9wZWxhamFyX2Jpb19wZW5qYWdhLnBocDtiaW9kYXRhO2lidWJhcGE=";
		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		parent.emailwindow.hide();
		//-->
    </script>
<?php } ?>
