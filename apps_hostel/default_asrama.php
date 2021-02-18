<script language="javascript" type="text/javascript">
function openModal(URL){
	var returnValue = window.showModalDialog(URL, 'ILIM','help:no;status:no;scroll:yes;resize:yes;tools:yes;dialogHeight:500px;dialogWidth:800px');
	//window.open(URL,'name','height=255,width=250,toolbar=yes,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
} 
</script>
<table width="95%" cellpadding="0" cellspacing="0">
    <tr> 
        <td height="20"> <!--<STRONG>Thoughts of the day:</STRONG>&nbsp;-->
        <MARQUEE HEIGHT=15 SCROLLAMOUNT=3 SCROLLDELAY=150 WIDTH=95%>
        <font color="#000033" size="2" face="Verdana, Arial, Helvetica, sans-serif">Selamat Datang ke Sistem Maklumat Latihan ILIM Jakim. 
        Untuk sebarang pertanyaan sila hantarkan email anda kepada <a href="mailto:info@islam.gov.my">info@islam.gov.my</a></font>
        </MARQUEE></td>
    </tr>
</table>
<?php
$kampus_id=isset($_REQUEST["kampus_id"])?$_REQUEST["kampus_id"]:"";
//$kampus_id=$_POST['kampus_id'];
//print "K:".$kampus_id;
?>
<table width="95%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
        <td> <div align="center"><font color="#0080c0" face="Verdana" size="4"><strong> 
        SISTEM MAKLUMAT LATIHAN ILIM - ASRAMA</font></div>
        <font color="#0080c0" face="Verdana" size="4">
        <hr color="#ff0080" style="HEIGHT: 2px; WIDTH: 100%" align="center">
        </font> 
        </td>
    </tr>
	<?php if($_SESSION["s_level"]=='99'){
	  //$conn->debug=true;
        $sqlkks = "SELECT * FROM _ref_kampus WHERE kampus_status=0 ";
        $rskks = &$conn->Execute($sqlkks);
    ?>
    <tr>
        <td align="right"><b>Pusat Latihan : </b>&nbsp;&nbsp;
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
	if($_SESSION["s_level"]=='PESERTA'){ $title = "Jadual Kursus Dalam Perancangan";} else { $title = "Jadual Kursus"; }
	?>
    <tr>
    	<td align="center" width="100%">
        <table width="100%" cellpadding="5" cellspacing="0" border="1">
        	<tr>
                <td width="50%" height="250px" align="center" valign="top" bgcolor="#CCCCCC">
                	<b><?php print $title;?></b><hr />
	                <table width="98%" cellpadding="4" cellspacing="0" border="0">
    					<tr>
                        	<td width="100%">
                                <?php include 'asrama/penetapan_bilik.php';?>                     
                            </td>
                        </tr>
                	</table>
                </td>
                <?php 
				$kam_id='';
				if($_SESSION["s_level"]<>'99'){ $kam_id=$_SESSION['SESS_KAMPUS']; }
				if(!empty($kampus_id)){ $kam_id=$kampus_id; }
				$href_link = "modal_form.php?win=".base64_encode('kursus/senarai_kursus.php;'.$rs->fields['id']); ?>
                <?php $this_mth = date("m"); $this_year=date("Y"); ?>
                <td width="50%" align="center" valign="top" bgcolor="#CCCCCC"><b>Maklumat Kursus</b><hr />
                	<table width="98%" cellpadding="4" cellspacing="0" border="1" bgcolor="#FFFFFF">
                    	<?php //$jum_bln_ini = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$this_mth' AND year(startdate)='$this_year' AND startdate>=".tosql(date("Y-m-d")));
						//$conn->debug=true;
						$ssql='';
						if($_SESSION["s_level"]<>'99'){ $ssql .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
						if(!empty($kampus_id)){ $ssql.=" AND kampus_id=".$kampus_id; }

						//$jum_bln_ini = dlookup("_tbl_kursus_jadual","count(*)","status IN (0,9) AND month(startdate)='$this_mth' 
						//AND year(startdate)='$this_year' ".$ssql);  
						//AND startdate>=".tosql(date("Y-m-d"))); $conn->debug=false; 
						//$conn->debug=true;
						$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd 
						FROM _tbl_kursus_jadual A, _tbl_kursus B, _tbl_kursus_catsub D 
						WHERE A.courseid=B.id AND B.is_deleted=0"; 
						$sSQL.=" AND B.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
						$sSQL.=" AND A.status NOT IN (0,9) AND month(A.startdate)='$this_mth' AND year(A.startdate)='$this_year'";
						if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
						if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }

						$rsbln = $conn->query($sSQL);
						$jum_bln_ini = $rsbln->recordcount();

						$conn->debug=false;?>
                    	<tr>
                        	<td align="left" width="85%"><label onclick="open_modal('<?=$href_link.'&kampusid='.$kam_id;?>&types=NOW','Senarai kursus yang dijalankan pada bulan ini',70,70)"  
                            style="cursor:pointer"><u>Kursus Bulan Ini</u></label></td>
                            <td align="right" width="15%"><?php print $jum_bln_ini;?></td>
                        </tr>
                    	<?php  
						$next_mth_start = date("m",strtotime("+1 months")); $next_year_start = date("Y",strtotime("+1 months"));
						$next_mth_end = date("m",strtotime("+2 months")); $next_year_end = date("Y",strtotime("+2 months"));
						$start_date=$next_year_start."-".$next_mth_start."-01";
						$end_date=$next_year_end."-".$next_mth_end."-31";
						//$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$next_mth' AND year(startdate)=$next_year"); 
						$ssql='';
						if($_SESSION["s_level"]<>'99'){ $ssql .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
						if(!empty($kampus_id)){ $ssql.=" AND kampus_id=".$kampus_id; }
						//$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","status IN (0,9) AND startdate BETWEEN ".
						//tosql($start_date)." AND ".tosql($end_date)." ".$ssql); 

						$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd 
						FROM _tbl_kursus_jadual A, _tbl_kursus B, _tbl_kursus_catsub D 
						WHERE A.courseid=B.id AND B.is_deleted=0"; 
						$sSQL.= " AND B.subcategory_code=D.id AND D.f_status=0 AND D.is_deleted=0";
						$sSQL.= " AND A.status NOT IN (0,9) AND A.startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date);
						if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
						if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }

						$rsbln = $conn->query($sSQL);
						$jum_bln_depan = $rsbln->recordcount();
						
						?>
                    	<tr>
                        	<td align="left"><label onclick="open_modal('<?=$href_link.'&kampusid='.$kam_id;?>&types=NEXT','Senarai kursus yang dijalankan pada bulan hadapan',70,70)" 
                            style="cursor:pointer"><u>Kursus Bulan Hadapan</u></label></td>
                            <td align="right"><?php print $jum_bln_depan;?></td>
                        </tr>
                    	<tr>
                        	<td align="left" colspan="2"><b>Kursus yang sedang dijalankan : </b><hr />
                            <?php $this_dt = date("Y-m-d");
							$sSQL="SELECT A.* FROM _tbl_kursus_jadual A, _tbl_kursus B, _tbl_kursus_catsub C 
							WHERE B.id=A.courseid AND A.status IN (0,9) 
							AND '$this_dt' BETWEEN A.startdate AND A.enddate ";
							$sSQL.=" AND B.subcategory_code=C.id AND C.f_status=0 AND C.is_deleted=0";
							if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
							if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }
							$sSQL .= " ORDER BY A.startdate";
							$rs_ini = $conn->query($sSQL);
							//print $sSQL;
							if(!$rs_ini->EOF){ $bil=0;
							?>
                            <ul>
                            	<?php while(!$rs_ini->EOF){ $bil++;
								$disp_cetak=1;
								$sqlkursus = "SELECT * FROM _tbl_kursus WHERE id=".tosql($rs_ini->fields['courseid']);
								if($_SESSION["s_level"]<>'99'){ $sqlkursus .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
								if(!empty($kampus_id)){ $sqlkursus.=" AND kampus_id=".$kampus_id; }
								$rskursus = $conn->query($sqlkursus);
								$courseid = $rskursus->fields['courseid'];
								$coursename = $rskursus->fields['coursename'];
								//$SubCategoryCd = $rskursus->fields['SubCategoryCd'];
								if(empty($coursename)){ $coursename = $rs->fields['acourse_name']; $courseid='KL'; $disp_cetak=0; }
								
								$href_link = "modal_form.php?win=".base64_encode('../apps/kursus/cetak_borang_kehadiran.php;'.$rs_ini->fields['id']);
	                            $href_link1 = "modal_form.php?win=".base64_encode('../apps/kursus/cetak_borang_kehadiran1.php;'.$rs_ini->fields['id']); 
								?>
                            	<li style="height:auto;">
                                	<?php if($_SESSION["s_usertype"]=='SYSTEM'){ ?>
                                    <?php if($disp_cetak==1){ ?>
                                    <div style="float:left">
                                    <img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
                                    onclick="open_modal('<?=$href_link;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>
                                    <img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
                                    onclick="open_modal('<?=$href_link1;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>
                                    &nbsp;&nbsp;</div><?php } ?><?php } ?><?php print $courseid. " - ".$coursename.
									" <i>[ ".Displaydate($rs_ini->fields['startdate'])." - ".Displaydate($rs_ini->fields['enddate'])." ]</i>";?>
                                </li><br>
                                <?php $rs_ini->movenext(); } ?>
                            </ul>
                            <?php } ?>
                            </td>
                        </tr>
                    </table>
					<?php if($_SESSION["s_usertype"]=='SYSTEM'){ ?>
                    <br /><div style="float:left">&nbsp;<img src="../images/ico-4.gif" border="0"  /></div> Sila klik untuk mencetak borang kehadiran Peserta
                   	<?php } ?>
                </td>
			</tr>
        </table>
        </td>
    </tr>
</table>