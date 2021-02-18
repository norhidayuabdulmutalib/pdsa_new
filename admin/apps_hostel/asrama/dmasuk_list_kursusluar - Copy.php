<?
$PageNo = $_GET['page'];
if(!empty($_POST['search'])){ $search=$_POST['search']; $_SESSION['s_search']=$search;
} else if($_POST['search']==''){ $search='';
} else { $search=$_SESSION['s_search']; }
if(!empty($_POST['linepage'])){ $_SESSION['linepage'] = $_POST['linepage']; }
$kursus = $_POST['kursus'];
//$search =  str_replace(" ","_",$search);
$conn->debug=true;
$sSQL="SELECT A.*, B.acourse_name, B.startdate, B.enddate, C.no_bilik 
FROM _sis_a_tblasrama_tempah A, _tbl_kursus_jadual B, _sis_a_tblbilik C 
WHERE A.event_id=B.id AND A.bilik_id=C.bilik_id AND ".tosql(date("Y-m-d"))." BETWEEN B.startdate AND B.enddate ";  //C.enddate>=".tosql(date("Y-m-d"));
if(!empty($kursus)){ $sSQL .= " AND B.id=".tosql($kursus); }
//if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%' OR D.no_bilik LIKE '%".$search."%')"; }
//$sSQL .= " AND A.f_peserta_noic NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
$sSQL .= " ORDER BY B.startdate, B.id, C.no_bilik";

$sSQL = "SELECT * FROM _tbl_kursus_luarpeserta A, _tbl_kursus_jadual B
WHERE A.event_id=B.id AND ".tosql(date("Y-m-d"))." BETWEEN B.startdate AND B.enddate "; 
if(!empty($kursus)){ $sSQL .= " AND A.event_id=".tosql($kursus); }
$sSQL .=" ORDER BY pids, nama_peserta";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
//$conn->debug=false;
//if(!empty($get_jantina)){ $sSQL.=" AND A.p_jantina= '".$get_jantina."' "; } 
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 

$href_search = "index.php?data=".base64_encode('user;asrama/dmasuk_list_kursusluar.php;kursusluar;kursusluar');
?>
<? include_once 'include/list_head.php'; ?>
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
$href_new = "modal_form.php?win=".base64_encode('asrama/dmasuk_form_luar_baru.php;');
?>
<form name="ilim" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<?php
	$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE ".tosql(date("Y-m-d"))." BETWEEN startdate AND enddate ORDER BY startdate";
	$rsku = &$conn->execute($sqlk);
	?>
	<tr>
		<td width="30%" align="right"><b>Nama Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	<select name="kursus"  onchange="do_page('<?=$href_search;?>')">
            	<option value="">-- Sila pilih --</option>
            <?php while(!$rsku->EOF){ ?>
            	<option value="<?=$rsku->fields['id'];?>" <?php if($rsku->fields['id']==$kursus){ print 'selected'; }?>><?=$rsku->fields['acourse_name'].
				"&nbsp; [ Tarikh Kursus : ".DisplayDate($rsku->fields['startdate'])." - " .displayDate($rsku->fields['enddate'])." ]";?></option>
            <?php $rsku->movenext(); } ?>
            </select>
		</td>
	</tr>
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
/*$sSQL_p="SELECT A.*, C.acourse_name 
FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F 
WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id
AND B.InternalStudentAccepted=1 AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate ";  //AND C.enddate>=".tosql(date("Y-m-d"));
if(!empty($kursus)){ $sSQL_p .= " AND C.id=".tosql($kursus); }
$sSQL_p .= " AND A.f_peserta_noic NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
$rsp = &$conn->Execute($sSQL_p);
$cnt_peserta = $rsp->recordcount();*/
//print '<br>';
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td colspan="5">
        	<div style="float:left">
                <ul class="menu5">
                    <li <? if($sub_tab=='peserta'){ print 'class="current"'; }?>>
                        <a href="<? print $href_search;?>" style="cursor:pointer">
                        <b>Senarai Penserta Kursus <i>(<?php print $cnt;?> orang)</i> </b></a></li>
                </ul>
			</div>
            <div style="float:right;padding-top:15px">
            	<img src="../images/btn_web-users_bg.gif" border="0" width="20" height="20" /> Daftar Masuk Penghuni Asrama
                &nbsp;&nbsp;
            </div>
    <tr valign="top"> 
        <td height="30" colspan="5" align="center" valign="middle" bgcolor="#80ABF2">
        	<table width="100%">
                <td width="60%" align="left">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">
        			<strong>MAKLUMAT PENGHUNI ASRAMA - KURSUS LUAR</strong></font></td>
                <td width="40%" align="right">
                	<img src="../images/btn_user-new_bg.gif" border="0" width="24" height="24" style="cursor:pointer" 
                    onclick="open_modal('<?=$href_new;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',780,380)" />&nbsp;Tambah Peserta Baru&nbsp;
                </td>
                </tr>
             </table>
    	</td>
    </tr>
    <tr> 
      <td><div align="center"></div></td>
    </tr>
    <tr> 
      <td width="75%" colspan="5"> <table border="1" width=100% cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
          <tr bgcolor="#D1E0F9"> 
            <td width="5%" align="center"><b>Bil</b></td>
           <!-- <td width="40%" align="center"><b>Nama Peserta</b></td>-->
			<td width="40%" align="center"><b>Kursus</b></td>
            <td width="15%" align="center"><b>Tarikh Kursus</b></td>
            <td width="25%" align="center"><b>Nama Peserta</b></td>
            <td width="10%" align="center"><b>No. Bilik</b></td>
            <td width="5%" align="center"><b>Daftar Masuk</b></td>
         </tr>
          <?
        if(!$rs->EOF) {
            $cnt = 1;
            $bil = $StartRec;
            while(!$rs->EOF  && $cnt <= $pg) {
				$ev_id = $rs->fields['event_id'];
                //$href_link = "index.php?data=".base64_encode('user;asrama/dmasuk_form.php;asrama;masuk;'.$rs->fields['daftar_id']);
				$href_link = "modal_form.php?win=".base64_encode('asrama/dmasuk_form_luar.php;'.$rs->fields['tempahan_id']);
				$seld = "SELECT B.no_bilik FROM _sis_a_tblasrama_tempah A, _sis_a_tblbilik B WHERE A.bilik_id=B.bilik_id AND A.event_id=".tosql($ev_id);
				$rs_bilikt = &$conn->execute($seld);
            ?>
          <tr bgcolor="<? if ($cnt%2 == 1) print $bg1; else print $bg2 ?>">
            <td align="right" valign="top"><? echo $bil;?>.&nbsp;</td>
           <!-- <td valign="top"><a onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',700,350)" style="cursor:pointer">
				<? print stripslashes($rs->fields['nama_peserta']);?></a>
            	<br /><i>[<? print stripslashes($rs->fields['NOKP']);?>]</i><br /><? print stripslashes($rs->fields['agensi']);?>&nbsp;</td>-->
            <td align="left" valign="top"><? print stripslashes($rs->fields['acourse_name']);?>&nbsp;</td>
            <td align="center" valign="top"><? print DisplayDate($rs->fields['startdate']);?> - <? echo DisplayDate($rs->fields['enddate']);?></td>
            <td align="left" valign="top"><? print stripslashes($rs->fields['nama_peserta']);?>&nbsp;</td>
            <td align="center" valign="top"><? print stripslashes($rs_bilikt->fields['no_bilik']);?>&nbsp;</td>
            <td align="center">
            	<img src="../images/btn_web-users_bg.gif" style="cursor:pointer" border="0" width="25" height="25" 
                onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',700,480)" 
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