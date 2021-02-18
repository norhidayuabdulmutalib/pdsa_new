<?
$kursus_search=$_POST['kursus_search'];
$search=$_POST['search'];
if(!empty($_POST['linepage'])){ $_SESSION['linepage'] = $_POST['linepage']; }
//$search =  str_replace(" ","_",$search);
//$conn->debug=true;
$sSQL="SELECT A.*, B.kursus, C.bilik_id, C.daftar_id FROM _sis_tblpelajar A, ref_kursus B, _sis_a_tblasrama C 
WHERE A.kursus_id=B.kid AND A.pelajar_id=C.pelajar_id AND A.is_deleted=0 AND C.is_daftar=1";
if(!empty($search)){ $sSQL.=" AND A.p_nama LIKE '%".$search."%' "; } 
if(!empty($kursus_search)){ $sSQL.=" AND A.kursus_id = ".$kursus_search; } 
//$strSQL = $sSQL . " LIMIT $StartRow,$PageSize"; 
$sSQL.= " ORDER BY p_nama";
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();

$href_search = "index.php?data=".base64_encode('user;asrama/dkeluar_list.php;asrama;keluar');
?>
<? include_once 'include/list_head.php'; ?>
<form name="ilim" method="post">
<br />
<? include_once 'include/page_search_asrama.php'; ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr valign="top"> 
        <td height="30" colspan="5" align="center" valign="middle" bgcolor="#80ABF2"><font size="2" face="Arial, Helvetica, sans-serif">
        &nbsp;&nbsp;&nbsp;&nbsp;<strong>MAKLUMAT PENDAFTARAN KELUAR ASRAMA</strong></font></td>
    </tr>
    <tr> 
      <td><div align="center"></div></td>
    </tr>
    <tr> 
      <td width="75%" colspan="5"> <table border="1" width=100% cellspacing="0" cellpadding="5" bordercolorlight="#000000" bordercolordark="#FFFFFF">
          <tr bgcolor="#D1E0F9"> 
            <td width="5%" align="center"><b>Bil</b></td>
            <td width="35%" align="center"><b>Nama Pelajar</b></td>
            <td width="15%" align="center"><b>No Kad Pengenalan</b></td>
            <td width="20%" align="center"><b>Kursus</b></td>
            <td width="10%" align="center"><b>Syukbah</b></td>
            <td width="15%" align="center"><b>Sesi</b></td>
            <td width="10%" align="center"><b>No. Bilik</b></td>
          </tr>
          <?
        if(!$rs->EOF) {
            $cnt = 1;
            $bil = $StartRec;
            while(!$rs->EOF  && $cnt <= $pg) {
                $href_link = "index.php?data=".base64_encode('user;asrama/dkeluar_form.php;asrama;keluar;'.$rs->fields['daftar_id']);
            ?>
          <tr bgcolor="<? if ($cnt%2 == 1) echo $bg1; else echo $bg2 ?>">
            <td align="right"><? echo $bil;?>.&nbsp;</td>
            <td valign="top"><a href='<?=$href_link;?>'><? echo stripslashes($rs->fields['p_nama']);?></a>&nbsp;</td>
            <td align="center"><? echo stripslashes($rs->fields['p_nokp']);?>&nbsp;</td>
            <td align="center"><? echo stripslashes($rs->fields['kursus']);?>&nbsp;</td>
            <td align="center"><? echo dlookup("ref_syukbah","ref_sukbah","ref_sukbah_id=".tosql($rs->fields['syukbah_id'],"Number"));?>&nbsp;</td>
            <td align="center"><? echo stripslashes($rs->fields['sesi_kemasukan']);?>&nbsp;</td>
            <td align="center"><? echo dlookup("_sis_a_tblbilik", "no_bilik", "bilik_id = '".stripslashes($rs->fields['bilik_id'])."'");?>&nbsp;</td>
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