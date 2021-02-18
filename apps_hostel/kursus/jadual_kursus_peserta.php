<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="../modalwindow/modal.js"></script>
<Script Language='JavaScript1.2' src='../../script/RemoteScriptServer.js'></Script>
<script language="javascript" type="text/javascript">	
function open_modal1(URL,title,width,height){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
} //End "opennewsletter" function

function upd_data(val){
	//alert(val);
	var pids=document.getElementsByName("pids")[val].value;
	var nama=document.getElementsByName("nama")[val].value;
	var nokp=document.getElementsByName("nokp")[val].value;

	var URL = 'kursus/_upd_peserta.php?pids='+pids+"&nama="+nama+"&nokp="+nokp;
	//alert(URL);
	callToServer(URL);
	//document.peserta.action=URL;
	//document.peserta.target='_blank';
	//document.peserta.submit();
}

</script>
</head>
<body>
<?php
//$conn->debug=true;;
$sSQL="SELECT A.*, B.categorytype, C.SubCategoryNm 
FROM _tbl_kursus_jadual A, _tbl_kursus_cat B, _tbl_kursus_catsub C WHERE A.category_code=B.id AND A.sub_category_code=C.id AND A.id = ".tosql($id,"Text");
$rs = &$conn->Execute($sSQL);
//print $sSQL;
$jum_l = $rs->fields['lelaki']-0;
$jum_p = $rs->fields['perempuan']-0;
$jum_v = $rs->fields['vip']-0;
$jum = $jum_l+$jum_p+$jum_v;
//print "Jum:".$jum;

//$sql_jum = "SELECT lelaki, perempuan, vip FROM _tbl_kursus_jadual
//$jum_peserta = dlookup("_tbl_kursus_jadual","sum(lelaki+perempuan+vip)","id=".tosql($id));
if($jum>0){ $pilih=0; } else { $pilih=1; }
$pilih=0;

//$sql_det = "SELECT A.*, B.insname, B.insorganization FROM _tbl_kursus_jadual_det A, _tbl_instructor B WHERE A.instruct_id=B.ingenid AND A.event_id=".tosql($id,"Number");
$sql_det = "SELECT * FROM _tbl_kursus_luarpeserta WHERE event_id=".tosql($id)." ORDER BY pids, nama_peserta";
$rs_det = $conn->execute($sql_det);
$jkl=$rs_det->recordcount();

//print $sql_det;
$bil=0;
//$conn->debug=true;

$href_peserta = "modal_form.php?win=".base64_encode('kursus/_add_peserta.php;'.$rs->fields['id']);
?>
<form name="peserta" method="post">
<table width="100%" align="center" cellpadding="4" cellspacing="0" border="1">
    <tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="15%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="54%" align="left"><?php print $rs->fields['acourse_name'];?></td>
                <td width="30%" align="right" rowspan="4" valign="top">
                <?php if($pilih==0){ ?>
                <input type="button" value="Tambah Peserta" 
                onclick="open_modal1('<?=$href_peserta;?>&kid=<?=$rs->fields['id'];?>','Tambah Peserta Kursus / Seminar',1,1)"  />
                <?php } ?>
                <br /></td>    
            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Sub Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rs->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rs->fields['startdate']);?> - <?php print DisplayDate($rs->fields['enddate']);?></td>                
            </tr>
		</table>
    </td></tr>
	<tr><td colspan="3">
        <table width="96%" cellpadding="4" cellspacing="0" border="1" align="center">
            <tr bgcolor="#CCCCCC">
              <td colspan="6"><b>Senarai nama peserta bagi kursus : <?php print $rs->fields['acourse_name'];?></b></td>
            </tr>
            <tr bgcolor="#CCCCCC">
                <td width="5%" align="center"><b>Bil</b></td>
                <td width="60%" align="center"><b>Nama Peserta</b></td>
                <td width="20%" align="center"><b>No. KP</b></td>
                <td width="10%" align="center"><b>&nbsp;</b></td>
            </tr>
            <?php 
			$rec=0; $bil=0;
			while(!$rs_det->EOF){ $bil++; 
				$pids = $rs_det->fields['pids'];
				$nama_peserta = $rs_det->fields['nama_peserta'];
				$no_kp = $rs_det->fields['no_kp'];
			?>
            <tr>
                <td align="right"><?php print $bil;?>.&nbsp;<input type="hidden" name="pids" value="<?php print $pids;?>" /></td>
                <td align="left"><input type="text" size="70" name="nama" value="<?php print $nama_peserta;?>" onchange="upd_data('<?php print $rec;?>')" />&nbsp;</td>
                <td align="center"><input type="text" size="15" name="nokp" value="<?php print $no_kp;?>" onchange="upd_data('<?php print $rec;?>')" />&nbsp;</td>
                <td align="center">
                    <img src="../img/off.gif" width="22" height="22" style="cursor:pointer" title="Sila klik untuk menghapuskan data" 
                    onclick="open_modal('<?=$href_peserta;?>&pids=<?=$rs_det->fields['pids'];?>&pro=DEL','Hapus maklumat nama peserta',10,10)" />
				</td>
            </tr>
            <?php $rs_det->movenext(); $rec++; } ?>
        </table>
    </td></tr>
</table>
</form>
</body>
</html>
