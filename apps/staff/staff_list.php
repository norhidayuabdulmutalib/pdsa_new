<?php
$j=$_POST['j'];
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
//$conn->debug=true;
$sSQL="SELECT A.*, B.kampus_kod FROM _tbl_user A, _ref_kampus B 
WHERE A.kampus_id=B.kampus_id AND f_isdeleted=0 AND id_user<>'su' "; //f_staffid <> '' AND 
//if(!empty($j)){ $sSQL.=" AND f_jawatan='P' "; } 
$sSQL .= $sql_filter;
if(!empty($search)){ $sSQL.=" AND f_name LIKE '%".$search."%' "; } else { $sSQL.=" AND 	f_userid <>'1' "; }
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
$sSQL .= " ORDER BY f_name";
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

$href_search = "index.php?data=".base64_encode('user;staff/staff_list.php;admin;staff');
?>
<link rel="stylesheet" href="modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="modalwindow/dhtmlwindow.js">

/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>
<script type="text/javascript" src="modalwindow/modal.js"></script>
<script type="text/javascript">
function opennewsletter(kid, staff){
	var URL = "staff/staff_menu.php";
	//var id = document.ilim.mohon_id.value;
	//var tid = document.ilim.tid.value;
	URL = URL + '?kid=' + kid;
	//alert(URL);
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Maklumat Capaian Menu - ' + staff, 'width=750px,height=500px,center=1,resize=0,scrolling=1')

	/*emailwindow.onclose=function(){ //Define custom code to run when window is closed
		var theform=this.contentDoc.forms[0] //Access first form inside iframe just for your reference
		var theemail=this.contentDoc.getElementById("emailfield") //Access form field with id="emailfield" inside iframe
		if (theemail.value.indexOf("@")==-1){ //crude check for invalid email
			alert("Please enter a valid email address")
			return false //cancel closing of modal window
		}
		else{ //else if this is a valid email
			//alert("refresh");
			//document.getElementById("youremail").innerHTML=theemail.value //Assign the email to a span on the page
			//jah('./cal/calendar_akhbar.php?nextMonth='+mth+'&curYear='+yr+'&p=NEXT','calender');
			//document.ilim.reload();
			return true; //allow closing of window
		}
	}*/
} //End "opennewsletter" function
function reset_pass(kid, staff){
	var URL = "staff/staff_reset_pwd.php";
	URL = URL + '?kid=' + kid;
	if(confirm("Adakah anda pasti untuk 'RESET' katalaluan baru kepada pengguna ini " + staff )){
		emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, 'Menjana katalaluan baru - ' + staff, 'width=750px,height=500px,center=1,resize=0,scrolling=1')
	}
} //End "opennewsletter" function
</script>
<script language="javascript" type="text/javascript">
function do_open(URL){
	document.ilim.action = URL;
	document.ilim.submit();
}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">

	<?php if($_SESSION["s_level"]=='99'){
	  //$conn->debug=true;
        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td width="30%" align="right"><b>Pusat Latihan : </b></td>
        <td width="70%" align="left">
            <select name="kampus_id" style="width:80%" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih kampus --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <?php } ?>
	<tr>
		<td align="right"><b>Maklumat Carian : </b></td>
        <td align="left">
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
		</td>
	</tr>
	<?php include_once 'include/page_list.php'; ?>
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="0" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT STAF / KAKITANGAN</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<? $new_page = "index.php?data=".base64_encode('user;staff/staff_form.php;admin;staff;');?>
        	<input type="button" value="Tambah Maklumat Kakitangan" style="cursor:pointer" onclick="do_page('<?=$new_page;?>')" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="4" align="center">
            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center"><b>Bil</b></td>
                    <td width="30%" align="center"><b>Nama Kakitangan</b></td>
                    <td width="10%" align="center"><b>No. K/P</b></td>
                    <td width="10%" align="center"><b>Kampus</b></td>
                    <td width="10%" align="center"><b>Pusat</b></td>
                    <td width="10%" align="center"><b>ID Pengguna</b></td>
                    <!--<td width="15%" align="center"><b>Jabatan</b></td>-->
                    <td width="10%" align="center"><b>Menu</b></td>
                </tr>
				<?php
                if(!$rs->EOF) {
                    $cnt = 1;
                    $bil = $StartRec;
                    while(!$rs->EOF  && $cnt <= $pg) {
                    //while(!$rs->EOF) {
						//$bil = $cnt + ($PageNo-1)*$PageSize;
						$href_link = "index.php?data=".base64_encode('user;staff/staff_form.php;admin;staff;'.$rs->fields['id_user']);
						$unit = dlookup("_tbl_kursus_catsub","SubCategoryNm","id=".tosql($rs->fields['f_jabatan'],"Text"));
						$pwd=md5("Password@123");
                        ?>
                        <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
                            <td valign="top" align="right"><?=$bil;?>.</td>
			             	<td align="left" valign="top"><a href="<?=$href_link;?>"><? echo stripslashes($rs->fields['f_name']);?></a>&nbsp;</td>
                            <td valign="top" align="center"><?php echo $rs->fields['f_noic'];?>&nbsp;</td>
                            <td valign="top" align="center"><?php echo $rs->fields['kampus_kod'];?>&nbsp;</td>
                            <td valign="top" align="center"><?php echo stripslashes($unit);?>&nbsp;</td>
                            <td valign="top" align="center"><?php echo $rs->fields['f_userid'];?>&nbsp;</td>
    						<td align="center">
                                <img src="../images/btn_file-manager_bg.gif" border="0" style="cursor:pointer" 
                                onclick="opennewsletter('<?=$rs->fields['id_user'];?>','<? print addslashes($rs->fields['f_name']);?>'); return false"  />
   							<?php if($rs->fields['f_password']==$pwd){ print 'PWD Asal'; } else { ?>
                                <img src="../img/s_pass.gif" border="0" style="cursor:pointer" title="Sila klik untuk reset password" 
                                onclick="reset_pass('<?php print $rs->fields['id_user'];?>','<?php print $rs->fields['f_name'];?>'); return false"  />
	                        <?php } ?>
                            </td>
                        </tr>
                        <?php
                        $cnt = $cnt + 1;
                        $bil = $bil + 1;
                        $rs->movenext();
                    } 
					$rs->Close();
                } else {
                ?>
                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>No Record Found.</b></td></tr>
                <?php } ?>
                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
<?php
$sFileName=$href_search;
?>
<?php include_once 'include/list_footer.php'; ?> </td></tr>
<tr><td>        
</td></td>
</table> 
</form>
