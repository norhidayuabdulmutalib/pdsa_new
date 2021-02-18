<?php
$PageNo = $_GET['page'];
if(!empty($_POST['search'])){ $search=$_POST['search']; $_SESSION['s_search']=$search;
} else if($_POST['search']==''){ $search='';
} else { $search=$_SESSION['s_search']; }
if(!empty($_POST['linepage'])){ $_SESSION['linepage'] = $_POST['linepage']; }
$kursus = $_POST['kursus'];
$date_yestarday = date("Y-m-d", time() - 60 * 60 * 60);
$date_tomorrow = date("Y-m-d", time() + 60 * 60 * 60);
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
//$search =  str_replace(" ","_",$search);
//$conn->debug=true;
//print "LVL:".$_SESSION["s_level"];
$data = $_GET['data'];
$kategori = $_POST['kategori'];
$href_new = "modal_form.php?win=".base64_encode('asrama/dmasuk_form_luar_baru.php;');
/*
$sSQL="SELECT A.*, B.acourse_name, B.startdate, B.enddate, C.no_bilik 
FROM _sis_a_tblasrama_tempah A, _tbl_kursus_jadual B, _sis_a_tblbilik C 
WHERE A.event_id=B.id AND A.bilik_id=C.bilik_id AND ".tosql($date_yestarday)." BETWEEN B.startdate AND B.enddate ";  //C.enddate>=".tosql(date("Y-m-d"));
*/
$sSQL="SELECT A.*, B.acourse_name, B.startdate, B.enddate 
	FROM _tbl_kursus_luarpeserta A, _tbl_kursus_jadual B 
	WHERE A.event_id=B.id AND B.asrama_perlu='ASRAMA' AND A.nama_peserta<>''";  //C.enddate>=".tosql(date("Y-m-d"));
	if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
	if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
$sSQL .= " AND ".tosql($date_yestarday)." <= B.startdate ";
//$sSQL.=" AND enddate <= ".tosql($date_tomorrow);
if(!empty($kursus)){ $sSQL .= " AND B.id=".tosql($kursus); }
if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%')"; }
//$sSQL .= " AND A.f_peserta_noic NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
$sSQL .= " ORDER BY A.nama_peserta, B.startdate, B.id";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();


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
<?php
?>
<form name="ilim" method="post">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<?php if($_SESSION["s_level"]=='99'){
	  //$conn->debug=true;
        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td width="30%" align="right"><b>Pusat Latihan : </b></td>
        <td width="60%" align="left">&nbsp;&nbsp;
            <select name="kampus_id" style="width:80%" onchange="do_page('<?=$href_search;?>')">
                <option value="">-- Sila pilih kampus --</option>
                <?php while(!$rskks->EOF){ ?>
                <option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
                <?php $rskks->movenext(); } ?>
            </select>
        </td>
    </tr>
    <?php } ?>
	<?php
	//$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE ".tosql($date_yestarday)." BETWEEN startdate AND enddate ORDER BY startdate";
	$sqlk = "SELECT * FROM _tbl_kursus_jadual WHERE (acourse_name IS NOT NULL OR acourse_name<>'' ) 
		AND status IN (0,9) AND asrama_perlu='ASRAMA' AND ".tosql($date_yestarday)." <= startdate ";
	//$sqlk .= " AND enddate <= ".tosql($date_tomorrow);
 	if($_SESSION["s_level"]<>'99'){ $sqlk .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
	if(!empty($kampus_id)){ $sqlk .= " AND kampus_id=".$kampus_id; }
  	$sqlk .= " ORDER BY startdate";
	//print $sqlk;
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
                        <a href="index.php?data=<? print base64_encode('user;asrama/dmasuk_list_kursusluar.php;kursusluar;kursusluar;'.$id.';peserta');?>" style="cursor:pointer">
                        <b>Senarai Peserta Kursus <i>(<?php print $RecordCount;?> orang)</i> </b></a></li>
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
                    onclick="open_modal('<?=$href_new;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',80,80)" />&nbsp;Tambah Peserta Baru&nbsp;
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
			<td width="30%" align="center"><b>Nama Peserta</b></td>
			<td width="35%" align="center"><b>Kursus</b></td>
            <td width="15%" align="center"><b>Tarikh Kursus</b></td>
            <td width="10%" align="center"><b>No. Bilik</b></td>
            <td width="5%" align="center"><b>Daftar Masuk</b></td>
         </tr>
          <?
        if(!$rs->EOF) {
            $cnt = 1;
            $bil = $StartRec;
            while(!$rs->EOF  && $cnt <= $pg) {
                //$href_link = "index.php?data=".base64_encode('user;asrama/dmasuk_form.php;asrama;masuk;'.$rs->fields['daftar_id']);
				if(!empty($rs->fields['tempahan_id'])){
					$href_link = "modal_form.php?win=".base64_encode('asrama/dmasuk_form_luar.php;'.$rs->fields['tempahan_id']);
				} else {
					$href_link = "modal_form.php?win=".base64_encode('asrama/dmasuk_form_luar_baru.php;').
					"&kp=".$rs->fields['no_kp']."&nama=".$rs->fields['nama_peserta']."&kursus=".$rs->fields['event_id'];
				}
            ?>
          <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right" valign="top"><? echo $bil;?>.&nbsp;</td>
            <td valign="top"><? echo stripslashes($rs->fields['nama_peserta']);?>&nbsp;</td>
            <td align="left" valign="top"><? echo stripslashes($rs->fields['acourse_name']);?>&nbsp;</td>
            <td align="center" valign="top"><? echo DisplayDate($rs->fields['startdate']);?> - <? echo DisplayDate($rs->fields['enddate']);?></td>
            <td align="center" valign="top"><? echo stripslashes($rs->fields['no_bilik']);?>&nbsp;</td>
            <td align="center">
            	<img src="../images/btn_web-users_bg.gif" style="cursor:pointer" border="0" width="25" height="25" 
                onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',80,80)" 
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