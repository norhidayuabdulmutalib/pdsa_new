<?php
$skursus_id=isset($_REQUEST["skursus_id"])?$_REQUEST["skursus_id"]:"";
$spusat_kod=isset($_REQUEST["spusat_kod"])?$_REQUEST["spusat_kod"]:"";
$search=isset($_REQUEST["search"])?$_REQUEST["search"]:"";
$blok_search=isset($_REQUEST["blok_search"])?$_REQUEST["blok_search"]:"";
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
$PageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
if(!empty($_GET['blok_id'])){ $blok_search = $_GET['blok_id']; }
if(!empty($_POST['linepage'])){ $_SESSION['linepage'] = $_POST['linepage']; }
//$search =  str_replace(" ","_",$search);
//$conn->debug=true;
$sSQL="SELECT A.*, B.f_bb_desc FROM _sis_a_tblbilik A, _ref_blok_bangunan B 
WHERE A.blok_id=B.f_bb_id AND A.is_deleted = 0 "; //AND A.status_bilik=0 AND A.keadaan_bilik=1
//if(!empty($skursus_id)){ $sSQL.=" AND A.kursus_id = '".$skursus_id."' "; } 
if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND B.kampus_id=".$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sSQL.=" AND B.kampus_id=".$kampus_id; }
if(!empty($search)){ $sSQL.=" AND A.no_bilik LIKE '%".$search."%' "; } 
if(!empty($blok_search)){ $sSQL.=" AND A.blok_id = ".$blok_search." "; }
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$sSQL.= " ORDER BY blok_id, tingkat_id, no_bilik";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

if(!empty($href_directory)){
	$href_search = "index.php?data=".base64_encode('user;asrama/menu_asrama.php;asrama;bilik;;../apps/asrama/bilik_list.php');
} else {
	$href_search = "index.php?data=".base64_encode('user;asrama/bilik_list.php;asrama;bilik');
} 
?>
<script language="JavaScript1.2" type="text/javascript">
	function do_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
</script>
<?php include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<br />
<?php //include_once 'include/page_search_bilik.php'; ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<?php if($_SESSION["s_level"]=='99'){
	  //$conn->debug=true;
        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td width="30%" align="right"><b>Pusat Latihan : </b></td>
        <td width="70%" align="left">&nbsp;&nbsp;
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
		<td width="30%" align="right"><b>Maklumat Blok : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
	  	<select name="blok_search" onchange="do_page('<?=$href_search;?>')">
      		<option value="">-- semua bilik --</option>
           <?php  	//$conn->debug=true;
		   		$sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_kb_id=1 AND f_bb_status = 0 AND is_deleted=0 ";
				if($_SESSION["s_level"]<>'99'){ $sql_l .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
				if(!empty($kampus_id)){ $sql_l.=" AND kampus_id=".$kampus_id; }
				$sql_l .= " ORDER BY f_bb_desc";
				$rs_l = &$conn->Execute($sql_l); 
				while(!$rs_l->EOF){
					print '<option value="'.$rs_l->fields['f_bb_id'].'"'; 
					if($rs_l->fields['f_bb_id']==$blok_search){ print 'selected'; }
					print '>'. $rs_l->fields['f_bb_desc'] .'</option>';
					$rs_l->movenext();
				}
			?>
         </select></td>
	</tr>
    <tr>
		<td width="30%" align="right"><b>No Bilik : </b></td> 
		<td width="60%" align="left">&nbsp;&nbsp;
			<input type="text" size="30" name="search" value="<? echo stripslashes($search);?>">
			<input type="button" name="Cari" value="  Cari  " onClick="do_page('<?=$href_search;?>')">
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr valign="top" bgcolor="#80ABF2"> 
        <td height="30" colspan="3" valign="middle">
        <font size="2" face="Arial, Helvetica, sans-serif">
	        &nbsp;&nbsp;<strong>SENARAI MAKLUMAT BILIK ASRAMA</strong></font>
        </td>
        <td colspan="2" valign="middle" align="right">
        	<?php 	$href_link = "modal_form.php?win=".base64_encode($href_directory.'asrama/bilik_form.php;');?>
        	<input type="button" value="Tambah Maklumat Bilik" style="cursor:pointer" onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Bilik Hostel',1,1)" />&nbsp;&nbsp;
        </td>
    </tr>
    <tr> 
      <td width="75%" colspan="5"> 
      	<table border="1" width=100% cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
          <tr bgcolor="#D1E0F9"> 
            <td width="5%" align="center"><b>Bil</b></td>
            <td width="10%" align="center"><b>No. Bilik</b></td>
            <td width="30%" align="center"><b>Blok</b></td>
            <td width="15%" align="center"><b>Aras</b></td>
            <td width="15%" align="center"><b>Jenis Bilik</b></td>
            <td width="10%" align="center"><b>Status Bilik</b></td>
            <td width="10%" align="center"><b>Keadaan Bilik</b></td>
          </tr>
          <?php
        if(!$rs->EOF) {
            $cnt = 1;
            $bil = $StartRec;
            while(!$rs->EOF  && $cnt <= $pg) {
				$penghuni=0;
				$href_link = "modal_form.php?win=".base64_encode($href_directory.'asrama/bilik_form.php;'.$rs->fields['bilik_id']);
            ?>
          <tr bgcolor="<?php if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right" valign="top"><?php echo $bil;?>.&nbsp;</td>
            <td align="center"><a onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Bilik Hostel',1,1)" style="cursor:pointer">
				<?php echo stripslashes($rs->fields['no_bilik']);?></a>&nbsp;</td>
            <td align="center"><?php echo $rs->fields['f_bb_desc'];?>&nbsp;</td>
            <td align="center"><?php echo dlookup("_ref_aras_bangunan", "f_ab_desc", "f_ab_id='".$rs->fields['tingkat_id']."'");?>&nbsp;</td>
            <td align="center">
				<?php  if($rs->fields['jenis_bilik']==1){ print 'Bilik Seorang'; $penghuni=1; } 
					else if($rs->fields['jenis_bilik']==2){ print 'Bilik <font color="blue"><b>2</b></font> Orang'; $penghuni=2; } 
					else if($rs->fields['jenis_bilik']==3){ print 'Bilik <font color="red"><b>3</b></font> Orang'; $penghuni=3; } 
				?>&nbsp;
            </td>
				<?php $desc_penghuni = ''; $f_penghuni='';
				$jumlah_penghuni = dlookup("_sis_a_tblasrama", "count(daftar_id)", "bilik_id=".$rs->fields['bilik_id']." AND is_daftar = 1");
 				
				if($rs->fields['keadaan_bilik']=='1'){
					if($rs->fields['status_bilik'] == 0){
						if($jumlah_penghuni==0){
							$desc_penghuni = 'KOSONG'; $f_penghuni='#009900'; $fonts = "#FFFFFF";
						} else if($jumlah_penghuni==2){
							$desc_penghuni = 'PENUH'; $f_penghuni='#FF0000'; $fonts = "#FFFFFF";
						} else { 
							$desc_penghuni = 'BELUM<br>PENUH'; $f_penghuni='#000066'; $fonts = "#FFFFFF";
						}
					}else{ 
						if($jumlah_penghuni==0){
							$desc_penghuni = 'KOSONG'; $f_penghuni='#009900'; $fonts = "#FFFFFF";
						} else { 
							$desc_penghuni = 'PENUH'; $f_penghuni='#FF0000'; $fonts = "#FFFFFF";
						}
					} 
				} else {
						$f_penghuni='#FFFFFF'; $fonts = "#000000"; $desc_penghuni = 'KOSONG'; 
				}
				?>
            <td align="center" bgcolor="<?=$f_penghuni;?>" onclick="open_modal('<?=$href_link;?>','Kemaskini Maklumat Bilik Hostel',1,1)" style="cursor:pointer">
            	<font color="<?=$fonts;?>"><b><?php print $desc_penghuni;?></b></font></td>
			<td align="center">
				<?php 
				if($rs->fields['keadaan_bilik'] == 0)
				echo "DISELENGGARA";
				else 
				echo "BAIK";?>&nbsp;
            </td>
          </tr>
          <?php
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
<?php
if($cnt<>0){
	$sFileName=$href_search;
	include_once 'include/list_footer.php'; 
}
?> 
</td></tr>
</table> 
</form>