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
if(empty($sub_tab)){ $sub_tab='peserta'; }
if($sub_tab=='peserta'){
	$sSQL="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, 
	C.startdate, C.enddate, F.coursename, 
	B.InternalStudentId AS GETID, B.InternalStudentSelectedDt AS ins_dt 
	FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F
	WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id ";
	$sSQL .= " AND C.status IN (0,9) AND C.asrama_perlu='ASRAMA' AND B.is_selected IN (1) AND B.InternalStudentAccepted=1 ";
	//$sSQL .= "  AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate ";
	if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND C.kampus_id=".$_SESSION['SESS_KAMPUS']; }
	if(!empty($kampus_id)){ $sSQL.=" AND C.kampus_id=".$kampus_id; }
	$sSQL.=" AND ".tosql($date_yestarday)." <= C.startdate ";
	//$sSQL.="  AND C.enddate <= ".tosql($date_tomorrow);  //C.enddate>=".tosql(date("Y-m-d")); 
	if(!empty($kursus)){ $sSQL .= " AND C.id=".tosql($kursus); } //AND B.InternalStudentAccepted=1 
	if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%')"; }
	$sSQL .= " AND A.f_peserta_noic NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
	$sSQL .= " GROUP BY A.f_peserta_noic ORDER BY C.startdate, A.f_peserta_jantina, A.f_peserta_nama";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
} else {
	$sSQL="SELECT A.insname AS daftar_nama, A.insid AS NOKP, A.insorganization AS agensi, C.startdate, 
	C.enddate, F.coursename, A.ingenid AS GETID, B.create_dt AS ins_dt   
	FROM _tbl_instructor A, _tbl_kursus_jadual_det B, _tbl_kursus_jadual C, _tbl_kursus F
	WHERE A.is_deleted=0 AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=F.id ";
	if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND C.kampus_id=".$_SESSION['SESS_KAMPUS']; }
	if(!empty($kampus_id)){ $sSQL.=" AND C.kampus_id=".$kampus_id; }
	$sSQL .= " AND C.status IN (0,9) AND C.asrama_perlu='ASRAMA' ";
	//$sSQL .= "  AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate ";
	$sSQL.=" AND ".tosql($date_yestarday)." <= C.startdate ";
	$sSQL.="  AND C.enddate <= ".tosql($date_tomorrow);  //C.enddate>=".tosql(date("Y-m-d")); 
	if(!empty($kursus)){ $sSQL .= " AND C.id=".tosql($kursus); }
	if(!empty($search)){ $sSQL .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.insid LIKE '%".$search."%')"; }
	$sSQL .= " AND A.insid NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
	$sSQL .= $sql_search . " ORDER BY C.startdate, A.insname";
	$rs = &$conn->Execute($sSQL);
	$cnt = $rs->recordcount();
}
$conn->debug=false;
//print $sSQL;
//if(!empty($get_jantina)){ $sSQL.=" AND A.p_jantina= '".$get_jantina."' "; } 
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 

$href_search = "index.php?data=".base64_encode('user;asrama/dmasuk_list.php;peserta;peserta');
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
//print "LVL:".$_SESSION["s_level"];
$data = $_GET['data'];
$kategori = $_POST['kategori'];
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
	$sqlk = "SELECT A.*, B.id AS JID, B.startdate, B.enddate FROM _tbl_kursus A, _tbl_kursus_jadual B 
	WHERE A.id=B.courseid AND B.asrama_perlu='ASRAMA' AND B.startdate >= ".tosql($date_yestarday);
//	$sqlk .= " AND B.enddate <= ".tosql($date_tomorrow);
//	$sqlk .= " AND ".tosql($date_tomorrow)." >= B.enddate ";
	if($_SESSION["s_level"]<>'99'){ $sqlk .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
	if(!empty($kampus_id)){ $sqlk .= " AND B.kampus_id=".$kampus_id; }
	$sqlk .= " AND B.status IN (0,9) AND B.asrama_perlu='ASRAMA' ";
	$sqlk .= " ORDER BY B.startdate";
	$rsku = &$conn->execute($sqlk);
	//print $sqlk; 
	?>
	<tr>
		<td width="30%" align="right"><b>Nama Kursus : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
        	<select name="kursus"  onchange="do_page('<?=$href_search;?>')" style="max-width:600px">
            	<option value="">-- Sila pilih --</option>
            <?php while(!$rsku->EOF){ ?>
            	<option value="<?=$rsku->fields['JID'];?>" <?php if($rsku->fields['JID']==$kursus){ print 'selected'; }?>><?=$rsku->fields['coursename'].
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
$sSQL_p="SELECT A.f_peserta_nama AS daftar_nama, A.f_peserta_noic AS NOKP, E.f_tempat_nama AS agensi, C.startdate, C.enddate, F.coursename, 
B.InternalStudentId AS GETID, B.InternalStudentSelectedDt AS ins_dt 
FROM _tbl_peserta A, _tbl_kursus_jadual_peserta B, _tbl_kursus_jadual C, _ref_tempatbertugas E, _tbl_kursus F
WHERE A.f_peserta_noic=B.peserta_icno AND B.EventId=C.id AND A.is_deleted=0 AND A.BranchCd=E.f_tbcode AND C.courseid=F.id ";
if($_SESSION["s_level"]<>'99'){ $sSQL_p .= " AND C.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL_p.=" AND C.kampus_id=".$kampus_id; }
$sSQL_p .= " AND C.status IN (0,9) AND C.asrama_perlu='ASRAMA' AND B.is_selected IN (1) AND B.InternalStudentAccepted=1 ";
//$sSQL .= "  AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate ";
$sSQL_p.=" AND ".tosql($date_yestarday)." <= C.startdate ";
//$sSQL_p.="  AND C.enddate <= ".tosql($date_tomorrow);  //C.enddate>=".tosql(date("Y-m-d")); 
if(!empty($kursus)){ $sSQL_p .= " AND C.id=".tosql($kursus); } //AND B.InternalStudentAccepted=1 
if(!empty($search)){ $sSQL_p .= " AND (A.f_peserta_nama LIKE '%".$search."%' OR A.f_peserta_noic LIKE '%".$search."%')"; }
$sSQL_p .= " AND A.f_peserta_noic NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
$sSQL_p .= " GROUP BY A.f_peserta_noic ORDER BY C.startdate, A.f_peserta_jantina, A.f_peserta_nama";
$rsp = &$conn->Execute($sSQL_p);
$cnt_peserta = $rsp->recordcount();
//print '<br>';
$sSQL_p="SELECT A.* 
FROM _tbl_instructor A, _tbl_kursus_jadual_det B, _tbl_kursus_jadual C, _tbl_kursus F
WHERE A.is_deleted=0 AND A.ingenid=B.instruct_id AND B.event_id=C.id AND C.courseid=F.id ";
if($_SESSION["s_level"]<>'99'){ $sSQL_p .= " AND C.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL_p.=" AND C.kampus_id=".$kampus_id; }
$sSQL_p .= " AND C.status IN (0,9) AND C.asrama_perlu='ASRAMA' ";
//AND ".tosql(date("Y-m-d"))." BETWEEN C.startdate AND C.enddate "; 
//$sSQL_p.=" AND ".tosql($date_yestarday)." <= C.startdate AND C.enddate <= ".tosql($date_tomorrow);  //C.enddate>=".tosql(date("Y-m-d")); 
$sSQL_p.=" AND ".tosql($date_yestarday)." <= C.startdate ";  //C.enddate>=".tosql(date("Y-m-d")); 
if(!empty($kursus)){ $sSQL_p .= " AND C.id=".tosql($kursus); }
$sSQL_p .= " AND A.insid NOT IN (SELECT peserta_id FROM _sis_a_tblasrama WHERE is_daftar=1 AND is_keluar=0) ";
//AND C.enddate>=".tosql(date("Y-m-d"));
$rsp = &$conn->Execute($sSQL_p);
$cnt_penceramah = $rsp->recordcount();
$conn->debug=false;
$href_new = "modal_form.php?win=".base64_encode('asrama/dmasuk_form_baru.php;');
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td colspan="5">
        	<div style="float:left">
                <ul class="menu5">
                    <li <? if($sub_tab=='peserta'){ print 'class="current"'; }?>>
                        <a href="index.php?data=<? print base64_encode('user;asrama/dmasuk_list.php;peserta;peserta;'.$id.';peserta');?>" style="cursor:pointer">
                        <b>Senarai Peserta Kursus <i>(<?php print $cnt_peserta;?> orang)</i> </b></a></li>
                    <li <? if($sub_tab=='penceramah'){ print 'class="current"'; }?>>
                        <a href="index.php?data=<? print base64_encode('user;asrama/dmasuk_list.php;peserta;peserta;'.$id.';penceramah');?>" style="cursor:pointer">
                        <b>Senarai Penceramah @ Fasilitator <i>(<?php print $cnt_penceramah;?> orang)</i> </b></a></li>
                </ul>
			</div>
            <div style="float:right;padding-top:15px">
            	<img src="../images/btn_web-users_bg.gif" border="0" width="20" height="20" /> Daftar Masuk Penghuni Asrama
                &nbsp;&nbsp;
            	<img src="../images/btn_user-new_bg.gif" border="0" width="20" height="20" /> Daftar Peserta Baru @ Ganti
                &nbsp;&nbsp;
            </div>
        </td>
    </tr>
    <tr valign="top"> 
        <td height="30" colspan="5" align="center" valign="middle" bgcolor="#80ABF2">
        	<table width="100%">
                <td width="60%" align="left">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">
        			<strong>MAKLUMAT PENGHUNI ASRAMA</strong></font></td>
                <td width="40%" align="right">
                	<img src="../images/btn_user-new_bg.gif" border="0" width="24" height="24" style="cursor:pointer" 
                    onclick="open_modal('<?=$href_new;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',1,1)" />&nbsp;Tambah Peserta Baru @ Ganti&nbsp;
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
            <td width="40%" align="center"><b>Nama Peserta / Agensi</b></td>
			<td width="30%" align="center"><b>Kursus<br /><i>Tarikh Kursus</i></b></td>
            <td width="15%" align="center"><b>Tarikh Kemaskini</b></td>
            <td width="10%" align="center"><b>Daftar Masuk</b></td>
         </tr>
          <?
        if(!$rs->EOF) {
            $cnt = 1;
            $bil = $StartRec;
            while(!$rs->EOF  && $cnt <= $pg) {
				$masalah=''; //$conn->debug=true;
                //$href_link = "index.php?data=".base64_encode('user;asrama/dmasuk_form.php;asrama;masuk;'.$rs->fields['daftar_id']);
				$href_link = "modal_form.php?win=".base64_encode('asrama/dmasuk_form.php;'.$rs->fields['NOKP']);
				$sql_m = "SELECT * FROM _sis_a_tblasrama WHERE status_keluar=2 AND peserta_id=".tosql($rs->fields['NOKP']);
				$rs_m = &$conn->execute($sql_m);
				if(!$rs_m->EOF){ $mbil=0;
					while(!$rs_m->EOF){
						$mbil++; if($mbil>1){ $masalah .= ", "; }
						$masalah .= $rs_m->fields['kenyataan'];
						$rs_m->movenext();
					}
				}
            ?>
          <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right" valign="top"><? echo $bil;?>.&nbsp;</td>
            <td valign="top"><a onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',70,70)" style="cursor:pointer">
				<? echo stripslashes($rs->fields['daftar_nama']);?></a>
            	<br /><i>[<? echo stripslashes($rs->fields['NOKP']);?>]</i><br /><? echo stripslashes($rs->fields['agensi']);?>
                <?php if(!empty($masalah)){ print '<br><font color="#FF0000"><b>Peserta Bermasalah:</b> '.$masalah.'</font>'; } ?>
                &nbsp;</td>
            <td align="center"><? echo stripslashes($rs->fields['coursename']);?><br />
            <i><? echo DisplayDate($rs->fields['startdate']);?> - <? echo DisplayDate($rs->fields['enddate']);?></i>&nbsp;</td>
            <td align="center"><? echo $rs->fields['ins_dt'];?></td>
            <td align="center">
            	<img src="../images/btn_web-users_bg.gif" style="cursor:pointer" border="0" 
                onclick="open_modal('<?=$href_link;?>&tab=<?=$sub_tab;?>','Daftar Masuk Penghuni Asrama',70,70)" 
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