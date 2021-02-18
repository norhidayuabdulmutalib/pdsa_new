<?php
$href_search = "index.php?data=".base64_encode('user;apps_hostel/paparan_asrama.php;asrama;paparan');
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
if($submenu=='paparan'){ $folder="../apps_hostel/"; } else { $folder=''; }

if($_SESSION["s_level"]<>'99'){ $kampus_id=$_SESSION['SESS_KAMPUS']; }

if(empty($kampus_id)){ $kampus_id=1; }

?>
<form name="ilim" method="post">
<br />
<script language="JavaScript1.2" type="text/javascript">
function do_page(URL){
	document.ilim.action = URL;
	document.ilim.target = '_self';
	document.ilim.submit();
}
</script>
<?php
//$conn->debug=true;
$cnts=0;
$sql_l = "SELECT * FROM _ref_blok_bangunan WHERE f_kb_id=1 AND f_bb_status = 0 AND is_deleted=0 ";
if($_SESSION["s_level"]<>'99'){ $sql_l .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; $kampus_id=$_SESSION['SESS_KAMPUS']; }
if(!empty($kampus_id)){ $sql_l.=" AND kampus_id=".$kampus_id; }
$sql_l .= " ORDER BY kampus_id, f_bb_desc";
$rs_l = &$conn->Execute($sql_l); 
$cnt = $rs_l->recordcount();
$cnts= $cnt+2;
$wid = 100/$cnts;
//print $cnts."/".$wid;
?>
<form name="ilim" method="post">
<?php if($_SESSION["s_level"]=='99'){
  //$conn->debug=true;
	$sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
	$rskks = &$conn->Execute($sqlkks);
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td width="30%" align="right"><b>Pusat Latihan : </b></td>
	<td width="70%" align="left">&nbsp;&nbsp;
		<select name="kampus_id" style="width:80%" onchange="do_page('<?=$href_search;?>')">
			<?php while(!$rskks->EOF){ ?>
			<option value="<?php print $rskks->fields['kampus_id'];?>" <?php if($kampus_id==$rskks->fields['kampus_id']){ print 'selected'; }?>><?php print $rskks->fields['kampus_nama'];?></option>
			<?php $rskks->movenext(); } ?>
		</select>
	</td>
</tr>
</table>
<?php } ?>

<?php
if(empty($cnt)){
	
	print '<div align="center"><br><b>Tiada maklumat</b></div>';

}
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td align="center" valign="top">
    	<table width="100%" align="center" cellpadding="5" cellspacing="0" border="0">
        	<tr>
            <td width="<?=$wid;?>%">&nbsp;</td>
			<?php while(!$rs_l->EOF){ 
				$kampus = dlookup("_ref_kampus","kampus_kod","kampus_id=".tosql($rs_l->fields['kampus_id']));	
			?>
            <?php $href_link = "../modal_form.php?win=".base64_encode($folder.'apps_hostel/asrama/paparan_blok_asrama.php;'.$rs_l->fields['f_bb_id']); ?>
                <td width="<?=$wid;?>%" align="center" height="300px" valign="bottom">
					<table width="98%" align="center" border="0"  bgcolor="#CCCCFF">
                    	<tr><td height="260px" align="center">
                        	<div style="width:80%;border:#FF0000;border-style:double;height:260px;cursor:pointer" align="center" 
                            onclick="open_modal('<?=$href_link;?>&blok=<?=$rs_l->fields['f_bb_id'];?>','Maklumat Blok Asrama',1,1)">
                            Jumlah Bilik : <?php print dlookup("_sis_a_tblbilik","count(*)","is_deleted=0 AND keadaan_bilik=1 AND blok_id=".tosql($rs_l->fields['f_bb_id']));?><br />
                            <?php $sql = "SELECT * FROM _sis_a_tblbilik A, _sis_a_tblasrama B 
							WHERE A.bilik_id=B.bilik_id AND A.is_deleted=0 AND A.keadaan_bilik=1 AND B.is_daftar=1 AND A.blok_id=".tosql($rs_l->fields['f_bb_id'])." GROUP BY A.bilik_id ";
							$rs = $conn->execute($sql); $cnts = $rs->recordcount(); ?>
                            Bilik Diduduki : <?php print $cnts;?><br />
                            <?php $sql = "SELECT * FROM _sis_a_tblbilik A, _sis_a_tblasrama B 
							WHERE A.bilik_id=B.bilik_id AND A.is_deleted=0 AND A.keadaan_bilik=1 AND A.status_bilik=1 AND B.is_daftar=1 
							AND A.blok_id=".tosql($rs_l->fields['f_bb_id'])." GROUP BY A.bilik_id ";
							$rs = $conn->execute($sql); $cnts = $rs->recordcount(); ?>
                            Bilik Penuh : <?php print $cnts;?><br />

                            <?php //$conn->debug=true; 
							$sqlbt = "SELECT * FROM _sis_a_tblasrama_tempah A, _ref_blok_bangunan B, _sis_a_tblbilik C 
							WHERE A.bilik_id=C.bilik_id AND C.blok_id=B.f_bb_id AND B.f_bb_id=".tosql($rs_l->fields['f_bb_id'])." GROUP BY A.bilik_id ";
							$rsbt = $conn->execute($sqlbt); $cnt_bt = $rsbt->recordcount();
							$conn->debug=false;?>
                            Bilik Ditempah : <?php print $cnt_bt;?>
                			<br />
                            <hr />
                            Bilik Diselenggara : <?php print dlookup("_sis_a_tblbilik","count(*)","is_deleted=0 AND keadaan_bilik=0 AND blok_id=".tosql($rs_l->fields['f_bb_id']));?><br />
                            
                            </div>
                        </td></tr>
                    	<tr><td bgcolor="#999999" align="center" height="40px"><b><?=$kampus;?><br />
							<?=$rs_l->fields['f_bb_desc'];?></b></td></tr>
                    </table>
                </td>
            <?php $rs_l->movenext(); } ?>
            <td width="<?=$wid;?>%">&nbsp;</td>
            </tr>
    	</table>
    </td>
</tr>
</table>
</form>
