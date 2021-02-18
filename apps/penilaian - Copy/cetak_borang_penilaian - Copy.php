<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetakan Jadual</title>
<?
//$conn->debug=true;
$id=isset($_REQUEST["pset_id"])?$_REQUEST["pset_id"]:"";
$sSQL="SELECT * FROM _tbl_nilai_bahagian WHERE pset_id=".tosql($id);
$sSQL .= " ORDER BY nilai_sort";
/*$sSQL="SELECT A.*, B.f_penilaian, C.pset_detailid FROM _ref_penilaian_maklumat A, _ref_penilaian_kategori B, _tbl_penilaian_det_detail C 
WHERE A.f_penilaianid=B.f_penilaianid AND A.is_deleted=0 AND A.f_penilaian_detailid=C.f_penilaian_detailid AND C.pset_id=".tosql($id_set);
$sSQL .= " ORDER BY A.f_penilaianid, A.f_penilaian_desc";*/
$rs = &$conn->Execute($sSQL);
$cnt = $rs->recordcount();
$conn->debug=false;

?>
<?php
$sSQL="SELECT A.courseid, A.coursename, B.categorytype, C.SubCategoryNm, D.startdate, D.enddate 
FROM _tbl_kursus A, _tbl_kursus_cat B, _tbl_kursus_catsub C, _tbl_kursus_jadual D 
WHERE A.category_code=B.id AND A.subcategory_code=C.id AND A.id=D.courseid AND D.id = ".tosql($id,"Next");
$rskursus = &$conn->Execute($sSQL);
?>
<script language="javascript" type="text/javascript">	
function do_close(){
	parent.emailwindow.hide();
	//window.close();
}
function handleprint(){
	window.print();
}
</script>
<style type="text/css" media="all">@import"../../css/print_style.css";</style>
<style media="print" type="text/css">
	body{FONT-SIZE: 10px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }
	#ad{ display:none;}
	#leftbar{ display:none;}
	#contentarea{ width:100%;}
</style>
<style type="text/css">
@media all{
 .page-break { display:none; }
}

@media print{
	#ad{ display:none;}
	#leftbar{ display:none;}
	#contentarea{ width:100%;}
 	.page-break { display:block; page-break-before:always; }
}
</style>

</head>
<body>
<div id="ad"></div>
<div id="leftbar"></div>
<div id="contentarea">
<form name="ilim" method="post">
<table width="98%" align="center" cellpadding="0" cellspacing="0" border="0">
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle" align="center">
	        <img src="../images/crestmalaysia.gif" width="50" height="35" border="0" />
        </td>
    </tr>
    <tr valign="top" bgcolosr="#80ABF2"> 
        <td height="30" colspan="5" valign="middle" align="center">
	        <font size="3" face="Arial, Helvetica, sans-serif"><strong>BORANG PENILAIAN PESERTA KURSUS / BENGKEL</strong></font>
        </td>
    </tr>
    <tr><td colspan="5">
        <table width="96%" cellpadding="2" cellspacing="0" border="0" align="center">
	        <tr>
                <td width="25%" align="right"><b>Kursus</b></td>
                <td width="1%" align="center"><b> : </b></td>
                <td width="74%" align="left"><?php print $rskursus->fields['courseid'] . " - " .$rskursus->fields['coursename'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Kategori</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rskursus->fields['categorytype'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Pusat</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print $rskursus->fields['SubCategoryNm'];?></td>                
            </tr>
            <tr>
                <td align="right"><b>Tarikh Kursus</b></td>
                <td align="center"><b> : </b></td>
                <td align="left"><?php print DisplayDate($rskursus->fields['startdate']);?> - <?php print DisplayDate($rskursus->fields['enddate']);?></td>                
            </tr>
		</table>
    </td></tr>
    <tr><td colspan="5">&nbsp;</td></tr>
    <tr>
        <td colspan="5" align="center">
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr bgcolor="#CCCCCC">
                    <td width="5%" align="center" rowspan="2"><b>Bil</b></td>
                    <td width="60%" align="center" rowspan="2"><b>Maklumat Penilaian</b></td>
                    <td width="35%" align="center" colspan="5"><b>Markah Penilaian</b></td>
                </tr>
                <tr bgcolor="#CCCCCC">
                    <td width="7%" align="center" valign="bottom"><b>Sangat Tidak Memuaskan<br />(1)</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Tidak Memuaskan<br />(2)</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Sederhana<br />(3)</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Memuaskan<br />(4)</b></td>
                    <td width="7%" align="center" valign="bottom"><b>Sangat Memuaskan<br />(5)</b></td>
                </tr>
            <?
            if(!$rs->EOF) {
                while(!$rs->EOF) {
					 $id_bhg = $rs->fields['nilaib_id'];
					 $is_pensyarah = $rs->fields['is_pensyarah'];
					 $jump=0;
            ?>
	            <tr height="25px" bgcolor="#666666">
                    <td colspan="7">&nbsp;&nbsp;<b><label><? echo stripslashes($rs->fields['nilai_keterangan']);?></label></b></td>
                </tr>
                <?php
                    if($is_pensyarah==1){
                        $sql_p = "SELECT A.tajuk, B.insname, B.ingenid FROM _tbl_kursus_jadual_masa A, _tbl_instructor B WHERE A.event_id=".tosql($id)." AND A.id_pensyarah=B.ingenid";
                        $rs_pensyarah = $conn->execute($sql_p);
                        //print $sql_p;
                        while(!$rs_pensyarah->EOF){
							$ingenid=$rs_pensyarah->fields['ingenid'];
                            print '<tr height="25px" bgcolor="#CCCCCC">
                                <td colspan="7" align="left"><b>Nama Pensyarah : '.stripslashes($rs_pensyarah->fields['insname']).'
                                <br>Tajuk : '.stripslashes($rs_pensyarah->fields['tajuk']).'</b></td>
                            </tr>';
					
							/*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
							WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
							$sql_det = "SELECT A.*, B.f_penilaian_desc FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
							WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
							$rs_det = &$conn->Execute($sql_det);
							$bil=0;
							while(!$rs_det->EOF){ 
								$bil++;
								?>
								<tr bgcolor="#FFFFFF">
									<td valign="top" align="right"><?=$bil;?>.</td>
									<td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
									<td align="center"> 1 </td>
									<td align="center"> 2 </td>
									<td align="center"> 3 </td>
									<td align="center"> 4 </td>
									<td align="center"> 5 </td>
								</tr>
								<?
								$cnt = $cnt + 1;
							   // $bil = $bil + 1;
								$rs_det->movenext();
							} 
                            $jump++;
							$rs_pensyarah->movenext();
						}
					} else { 
						/*$sql_det = "SELECT A.*, B.f_penilaian_desc, C.f_penilaian FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B, _ref_penilaian_kategori C
						WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND B.f_penilaianid=C.f_penilaianid AND A.nilaib_id=".tosql($id_bhg);*/
						$sql_det = "SELECT A.*, B.f_penilaian_desc, B.f_penilaian_jawab FROM _tbl_nilai_bahagian_detail A, _ref_penilaian_maklumat B
						WHERE A.f_penilaian_detailid=B.f_penilaian_detailid AND A.nilaib_id=".tosql($id_bhg);
						$rs_det = &$conn->Execute($sql_det);
						$bil=0;
						while(!$rs_det->EOF){ 
							$bil++; $nilai=0; $pp_id='';
							if($rs_det->fields['f_penilaian_jawab']=='1'){
							?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center"> 1 </td>
                                <td align="center"> 2 </td>
                                <td align="center"> 3 </td>
                                <td align="center"> 4 </td>
                                <td align="center"> 5 </td>
                            </tr>
							<?php } else if($rs_det->fields['f_penilaian_jawab']=='2'){ ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left"><? echo stripslashes($rs_det->fields['f_penilaian_desc']);?>&nbsp;</td>
                                <td align="center" colspan="2"> Ya <input type="checkbox" /></td>
                                <td align="center" colspan="3"> Tidak  <input type="checkbox" /></td>
                            </tr>
							<?php } else if($rs_det->fields['f_penilaian_jawab']=='3'){ ?>
                            <tr bgcolor="#FFFFFF">
                                <td valign="top" align="right"><?=$bil;?>.</td>
                                <td valign="top" align="left" colspan="6">
									<? echo stripslashes($rs_det->fields['f_penilaian_desc']);?><br />
                                    <textarea rows="10" cols="100"></textarea>&nbsp;</td>
                            </tr>
							<?php }
							$cnt = $cnt + 1;
						   // $bil = $bil + 1;
							$rs_det->movenext();
						} 
					}
                    $cnt = $cnt + 1;
                    $bil = $bil + 1;
                    $rs->movenext();
                } 
            } ?>                   
            </table> 
        </td>
    </tr>
    <tr><td colspan="5">	
</td></tr>
<tr><td align="center" width="100%" colspan="5">
<hr />
	<?php //print $jum_nilai."/".$cnt; ?>
    <input type="hidden" name="jum_nilai" value="<?=$jum_nilai;?>" />
    <input type="hidden" name="cnt" value="<?=$cnt;?>" />
</td></td>
</table> 
</form>
    <div class="printButton" align="center">
        <br>
        <table width="100%" bgcolor="#CCCCCC"><tr><td width="100%" align="center">
        <input type="button" value="Print" onClick="handleprint()" style="cursor:pointer" />
        <input type="button" value="Close" onClick="do_close()" title="Please click to close window" style="cursor:pointer">
        <br>Please change the printing Orientation to <b>Landscape</b> before printing.
        <br /><br />
        </td></tr></table>
    </div>
</div>
</body>
</html>
