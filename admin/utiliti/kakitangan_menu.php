<?php 
require_once '../common.php';
//require_once '../include/dateformat.php';
$proses = isset($_REQUEST['proses'])?$_REQUEST['proses']:"";
if(empty($proses)){
?>
    <html>
	<link href="../css/template-css.css" rel="stylesheet" type="text/css" media="screen">
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
    <form id="myform" name="myform" method="post" action="kakitangan_menu.php">
    <?php
	$kid = $_GET['kid'];
	//echo $kid;
	$sqlm = "SELECT * FROM kod_grpmenu WHERE status=0 ORDER BY grp_id";
	$rsm = &$conn->Execute($sqlm);
    //echo $sqlm;
	$bil=0;
    ?>
    <table width="100%" cellpadding="5" cellspacing="0">
    	<?php while(!$rsm->EOF){ ?>
		<tr bgcolor="#CCCCCC">
        	<td colspan="5"><b>Kumpulan Menu : <?php print $rsm->fields['grp_name'];?></b></td>
        </tr>
        <tr>
        	<td width="10%" align="right">&nbsp;</td>
            <td width="40%" align="left">Nama Modul</td>
            <td width="10%" align="center">Tambah</td>
            <td width="10%" align="center">Kemaskini</td>
            <td width="10%" align="center">Hapus</td>
        </tr>
		<?
        $sqlmd = "SELECT * FROM tbl_menu WHERE menu_status=0 AND grp_id=".tosql($rsm->fields['grp_id'],"Number")." ORDER BY sort";
        $rsmd = &$conn->Execute($sqlmd);
		while(!$rsmd->EOF){
			$is_menu = 0; $is_add = 0; $is_upd = 0; $is_del = 0;
			$sql_d = "SELECT * FROM tbl_menu_user WHERE id_kakitangan=".tosql($kid,"Number")." AND menu_id=".tosql($rsmd->fields['menu_id'],"Number");
			$rs_data = &$conn->Execute($sql_d);
			//echo $sql_d;
			//$cnt = mysql_num_rows($rs_data);
			if(!$rs_data->EOF){
				//$row_data = mysql_fetch_assoc($rs_data);
				$is_menu = 1;
				$menu_uid = $rs_data->fields['menu_uid'];
				$is_add = $rs_data->fields['is_add'];
				$is_upd = $rs_data->fields['is_upd'];
				$is_del = $rs_data->fields['is_del'];
			} else {
				$is_menu = 0; $is_add = 0; $is_upd = 0; $is_del = 0; $menu_uid='';
			}
		?>
        <tr>
        	<td align="right">&raquo;&nbsp;<input type="checkbox" name="is_menu[<?=$bil;?>]" <?php if($is_menu==1){ print 'checked';}?>>&nbsp;
            <input type="hidden" name="menu_uid[<?=$bil;?>]" value="<?=$menu_uid;?>">
            <input type="hidden" name="menu_id[<?=$bil;?>]" value="<?=$rsmd->fields['menu_id'];?>">
            </td>
            <td align="left"><?php print $rsmd->fields['menu_name'];?></td>
            <td align="center"><input type="checkbox" name="is_add[<?=$bil;?>]" value="1" <?php if($is_add==1){ print 'checked';}?>></td>
            <td align="center"><input type="checkbox" name="is_upd[<?=$bil;?>]" value="1" <?php if($is_upd==1){ print 'checked';}?>></td>
            <td align="center"><input type="checkbox" name="is_del[<?=$bil;?>]" value="1" <?php if($is_del==1){ print 'checked';}?>></td>
        </tr>
		<?php $bil++;
			$rsmd->movenext();
		} ?>
        <tr><td colspan="5">&nbsp;</td></tr>
    	<?php $rsm->movenext();
		} ?>        
	</table>
    <table width="100%" cellpadding="5" cellspacing="0">
        <tr><td colspan="2" align="center">
            <input type="button" value="Simpan" onClick="do_save()" title="Sila klik untuk menyimpan maklumat">
            <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk menyimpan maklumat">
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
<?php
	$proses = isset($_REQUEST['proses'])?$_REQUEST['proses']:"";
	$id_kakitangan = isset($_REQUEST['id_kakitangan'])?$_REQUEST['id_kakitangan']:"";
	$bil = $_POST['bil'];
	for($i=0;$i<$bil;$i++){
		$sql = '';

		$is_menu 		= isset($_REQUEST['is_menu'][$i])?$_REQUEST['is_menu'][$i]:"";
		$menu_uid 	   = isset($_REQUEST['menu_uid'][$i])?$_REQUEST['menu_uid'][$i]:"";
		$menu_id 	    = isset($_REQUEST['menu_id'][$i])?$_REQUEST['menu_id'][$i]:"";
		$is_add 	     = isset($_REQUEST['is_add'][$i])?$_REQUEST['is_add'][$i]:"";
		$is_upd 	     = isset($_REQUEST['is_upd'][$i])?$_REQUEST['is_upd'][$i]:"";
		$is_del 	     = isset($_REQUEST['is_del'][$i])?$_REQUEST['is_del'][$i]:"";
		if($is_add==''){ $is_add=0; }
		if($is_upd==''){ $is_upd=0; }
		if($is_del==''){ $is_del=0; }
		if($is_add==1 || $is_upd==1 || $is_del==1){ $is_menu='on'; }
		//print "<br>".$is_menu."/" . $menu_uid . "/" . $menu_id;
		if(empty($menu_uid) && $is_menu=='on'){
			$sql = "INSERT INTO tbl_menu_user(menu_id, id_kakitangan, is_add, is_upd, is_del)
				VALUES(".tosql($menu_id,"Number").", ".tosql($id_kakitangan,"Number").", 
				".$is_add.", ".$is_upd.", ".$is_del.")";
			//print "<br> : ".$sql;
		} else if(!empty($menu_uid) && $is_menu==''){
			$sql = "DELETE FROM tbl_menu_user WHERE menu_uid=".tosql($menu_uid,"Number");
			//print "<br>D : ".$sql;
		} else if($menu_uid<>''&& $is_menu=='on'){
			$sql = "UPDATE tbl_menu_user SET is_add=".$is_add.", is_upd=".$is_upd.", is_del=".$is_del." 
				WHERE menu_uid=".tosql($menu_uid,"Number");
			//print "<br>".$sql;
		}
		if(!empty($sql)){
			$conn->Execute($sql);
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
		parent.location.reload();
		parent.emailwindow.hide();
		//-->
    </script>
<?php } ?>
