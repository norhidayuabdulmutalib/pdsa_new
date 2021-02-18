<?

$j=$_POST['j'];

$search=$_POST['search'];

//$conn->debug=true;

$sSQL="SELECT * FROM _tbl_claim WHERE is_deleted <> 1 and cl_ins_id = ".tosql($_SESSION['ingenid'],"Text");

$rs = &$conn->Execute($sSQL);

$cnt = $rs->recordcount();

$conn->debug=false;



$href_search = "index.php?data=".base64_encode('user;penceramah/penceramah_list.php;penceramah;daftar');

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

</script>

<script language="javascript" type="text/javascript">

function do_open(URL){

	document.ilim.action = URL;

	document.ilim.submit();

}

</script>

<? include_once 'include/list_head.php'; ?>

<form name="ilim" method="post">

<table width="100%" align="center" cellpadding="0" cellspacing="1" border="0">

	<tr>

		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 

		<td width="60%" align="left">&nbsp;&nbsp;

			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">

			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">

		</td>

	</tr>

<? include_once 'include/page_list.php'; ?>

    <tr valign="top" bgcolor="#80ABF2"> 

        <td height="30" colspan="0" valign="middle">

        <font size="2" face="Arial, Helvetica, sans-serif">

	        &nbsp;&nbsp;<strong>SENARAI TUNTUTAN</strong></font>        </td>

<td colspan="2" valign="middle" align="right">

        	<? $new_page = "index.php?data=".base64_encode('user;penceramah/claim_form.php;penceramah;daftar;');?>

        	<input type="button" value="Tambah Maklumat Tuntutan" style="cursor:pointer" onclick="do_page('<?=$new_page;?>')" />&nbsp;&nbsp;

        </td>

    </tr>

    <tr>

        <td colspan="4" align="center">

            <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">

                <tr bgcolor="#CCCCCC">

                    <td width="5%" align="center"><b>Bil</b></td>

                    <td width="30%" align="center"><b>Bulan</b></td>

                    <td width="15%" align="center"><b>Tahun</b></td>

                    <td width="5%" align="center">&nbsp;</td>

                </tr>

				<?

                if(!$rs->EOF) {

                    $cnt = 1;

                    $bil = $StartRec;

                    while(!$rs->EOF  && $cnt <= $pg) {

                    //while(!$rs->EOF) {

						//$bil = $cnt + ($PageNo-1)*$PageSize;

						$href_link = "index.php?data=".base64_encode('user;penceramah/claim_form.php;penceramah;daftar;'.$rs->fields['cl_id']);

                        ?>

                        <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">

                            <td valign="top" align="right"><?=$bil;?>.</td>

			             	<td valign="top" align="left"><?=dlookup("ref_month", "desc_mal", " id_month = ".$rs->fields['cl_month'])?>&nbsp;</td>

                            <td valign="top" align="center"><? echo $rs->fields['cl_year'];?>&nbsp;</td>

                            <td align="center">

                            	<a href="<?=$href_link;?>"><img src="../img/icon-info1.gif" width="30" height="30" style="cursor:pointer" 

                                title="Sila klik untuk pengemaskinian data" border="0"/></a>

                            </td>

                        </tr>

                        <?

                        $cnt = $cnt + 1;

                        $bil = $bil + 1;

                        $rs->movenext();

                    } 

					$rs->Close();

                } else {

                ?>

                <tr><td colspan="10" width="100%" bgcolor="#FFFFFF"><b>No Record Found.</b></td></tr>

                <? } ?>

                   

            </table> 

        </td>

    </tr>

    <tr><td colspan="5">	

<?

$sFileName=$href_search;

?>

<? include_once 'include/list_footer.php'; ?> </td></tr>

<tr><td>        

</td></td>

</table> 

</form>

