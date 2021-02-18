<?
$PageNo = $_GET['page'];
if(!empty($_POST['search'])){ $search=$_POST['search']; $_SESSION['s_search']=$search;
} else if($_POST['search']==''){ $search='';
} else { $search=$_SESSION['s_search']; }
if(!empty($_POST['linepage'])){ $_SESSION['linepage'] = $_POST['linepage']; }
//$search =  str_replace(" ","_",$search);
$date_yestarday = date("Y-m-d", time() - 60 * 60 * 24);

if(empty($sub_tab)){ $sub_tab='peserta'; }
if($sub_tab=='peserta'){
	$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, C.startdate, C.enddate, F.coursename, B.InternalStudentId AS GETID 
	FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F
	WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id
	AND B.InternalStudentAccepted=1 AND ".tosql($date_yestarday)." BETWEEN C.startdate AND C.enddate ";  //C.enddate>=".tosql(date("Y-m-d"));
	if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
	$sSQL .= " AND A.f_peserta_noic NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
	$sSQL .= " ORDER BY C.startdate, A.f_peserta_nama";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
} else {
	$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi, C.startdate, C.enddate, F.coursename, A.ingenid AS GETID   
	FROM _tbl_instructor A, _tbl_kursus_jadual_det B, _tbl_kursus_jadual C, _tbl_kursus F
	WHERE A.is_deleted=0 AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=F.id AND ".tosql($date_yestarday)." BETWEEN C.startdate AND C.enddate "; 
	//C.enddate>=".tosql(date("Y-m-d"));
	if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.insid LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
	$sSQL .= " AND A.insid NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
	$sSQL .= $sql_search . " ORDER BY C.startdate, A.insname";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
}

//print "C:".$cnt;
//$conn->debug=false;
//if(!empty($get_jantina)){ $sSQL.=" AND A.p_jantina= '".$get_jantina."' "; } 
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 

$href_search = "index.php?data=".base64_encode('user;asrama/dmasuk_list.php;asrama;masuk');
?>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<br />
<script language="JavaScript1.2" type="text/javascript">
function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
function do_post(){
	var data = document.ilim.data.value;
	document.ilim.action = "index.php?data="+data;
	document.ilim.target = '_self';
	document.ilim.submit();
}
</script>
<?
$data = $_GET['data'];
$kategori = $_POST['kategori'];
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="30%" align="right"><b>Maklumat Carian : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
            <input type="hidden" name="data" value="<?=$data;?>" />
		</td>
	</tr>
	<tr> 
	  <td>&nbsp;</td>
	</tr>
	<tr> 
		<td align="left">Jumlah Rekod : <b><?=$RecordCount;?></b></td>
		<td align="right"><b>Sebanyak 
		<select name="linepage" onChange="do_page('<?=$href_search;?>')">
			<option value="10" <? if($PageSize==10){ echo 'selected'; }?>>10</option>
			<option value="20" <? if($PageSize==20){ echo 'selected'; }?>>20</option>
			<option value="50" <? if($PageSize==50){ echo 'selected'; }?>>50</option>
			<option value="100" <? if($PageSize==100){ echo 'selected'; }?>>100</option>
		</select> rekod dipaparkan bagi setiap halaman.&nbsp;&nbsp;&nbsp;</b> 
	  </td>
	</tr>
</table>
<?php

//$conn->debug=true;
$sSQL_p="SELECT A.* 
FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F 
WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id
AND B.InternalStudentAccepted=1 AND ".tosql($date_yestarday)." BETWEEN C.startdate AND C.enddate ";  //AND C.enddate>=".tosql(date("Y-m-d"));
$sSQL_p .= " AND A.f_peserta_noic NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
$rsp = &$conn->Execute($sSQL_p);
$cnt_peserta = $rsp->recordcount();
print '<br>';
$sSQL_p="SELECT A.* 
FROM _tbl_instructor A, _tbl_kursus_jadual_det B, _tbl_kursus_jadual C, _tbl_kursus F
WHERE A.is_deleted=0 AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=F.id AND ".tosql($date_yestarday)." BETWEEN C.startdate AND C.enddate "; 
$sSQL_p .= " AND A.insid NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
//AND C.enddate>=".tosql(date("Y-m-d"));
$rsp = &$conn->Execute($sSQL_p);
$cnt_penceramah = $rsp->recordcount();
$conn->debug=false;
?>
<ul class="menu5">
    <li <? if($sub_tab=='peserta'){ print 'class="current"'; }?>>
        <a href="index.php?data=<? print base64_encode('user;asrama/dmasuk_list.php;asrama;masuk;'.$id.';peserta');?>" style="cursor:pointer">
        <b>Senarai Penserta Kursus <i>(<?php print $cnt_peserta;?> orang)</i> </b></a></li>
    <li <? if($sub_tab=='penceramah'){ print 'class="current"'; }?>>
        <a href="index.php?data=<? print base64_encode('user;asrama/dmasuk_list.php;asrama;masuk;'.$id.';penceramah');?>" style="cursor:pointer">
        <b>Senarai Penceramah @ Fasilatitor <i>(<?php print $cnt_penceramah;?> orang)</i> </b></a></li>
</ul>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr valign="top"> 
        <td height="30" colspan="5" align="center" valign="middle" bgcolor="#80ABF2"><font size="2" face="Arial, Helvetica, sans-serif">
        &nbsp;&nbsp;&nbsp;&nbsp;<strong>MAKLUMAT PENGHUNI ASRAMA</strong></font></td>
    </tr>
    <tr> 
      <td><div align="center"></div></td>
    </tr>
    <tr> 
      <td width="75%" colspan="5"> <table border="1" width=100% cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
          <tr bgcolor="#D1E0F9"> 
            <td width="5%" align="center"><b>Bil</b></td>
            <td width="40%" align="center"><b>Nama Peserta / Agensi</b></td>
			<td width="30%" align="center"><b>Kursus</b></td>
            <td width="15%" align="center"><b>Tarikh Kursus</b></td>
            <td width="10%" align="center"><b>Daftar Masuk</b></td>
         </tr>
          <?
        if(!$rs->EOF) {
            $cnt = 1;
            $bil = $StartRec;
            while(!$rs->EOF  && $cnt <= $pg) {
                //$href_link = "index.php?data=".base64_encode('user;asrama/dmasuk_form.php;asrama;masuk;'.$rs->fields['daftar_id']);
				$href_link = "modal_form.php?win=".base64_encode('asrama/dmasuk_form.php;'.$rs->fields['NOKP']);
            ?>
          <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right" valign="top"><? echo $bil;?>.&nbsp;</td>
            <td valign="top"><a onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',700,350)" style="cursor:pointer">
				<? echo stripslashes($rs->fields['daftar_nama']);?></a>
            	<br /><i>[<? echo stripslashes($rs->fields['NOKP']);?>]</i><br /><? echo stripslashes($rs->fields['agensi']);?>&nbsp;</td>
            <td align="center"><? echo stripslashes($rs->fields['coursename']);?>&nbsp;</td>
            <td align="center"><? echo DisplayDate($rs->fields['startdate']);?><br>-<br><? echo DisplayDate($rs->fields['enddate']);?></td>
            <td align="center">
            	<img src="../images/btn_web-users_bg.gif" style="cursor:pointer" border="0" 
                onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',700,350)" 
                title="Sila klik untuk daftar masuk peserta / penceramah">
            </td>
         </tr>
          <?
                $cnt = $cnt + 1;
                $bil = $bil + 1;
                $rs->movenext();
            }
            $rs->Close();
        }
            ?>
      </table></td>
    </tr>
    <tr><td colspan="5">	
<?
$sFileName=$href_search;
?>
<? include_once 'include/list_footer.php'; ?> </td></tr>
<tr><td colspan="5" align="center">
	<!--<input type="button" value="Proses Penerimaan" style="cursor:pointer" />-->
</td></tr>
</table> 
</form>
<script language="javascript">
	document.ilim.search.focus();
</script>