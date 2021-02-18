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
$kampus_id=$_POST['kampus_id'];
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
								<!--<?
                                //2 MONTH FROM TODAY
								$conn->debug=true;
                                $start = date("Y-m-d");
                                $end = date("Y-m-d",strtotime("+3 months"));
								
								//$conn->debug=true;
								$sqlas = "SELECT * FROM _sis_a_tblasrama_tempah WHERE enddt<".tosql($start);
								$rs_asrama = $conn->execute($sqlas);
								while(!$rs_asrama->EOF){
									$conn->execute("DELETE FROM _sis_a_tblasrama_tempah WHERE tempahan_id=".tosql($rs_asrama->fields['tempahan_id']));
									$rs_asrama->movenext();
								}
								//print $sqlas;
								$conn->debug=false;
                                
								$select = "SELECT A.courseid, A.coursename, B.startdate , B.enddate, B.bilik_kuliah 
								FROM _tbl_kursus A, _tbl_kursus_jadual B 
								WHERE A.id=B.courseid AND A.is_deleted=0 AND B.status IN (0,9) 
								AND B.enddate>=".tosql($start,"Text")." AND B.enddate<=".tosql($end,"Text");
								if($_SESSION["s_level"]<>'99'){ $select .= " AND C.kampus_id=".$_SESSION['SESS_KAMPUS']; }
								if(!empty($kampus_id)){ $select.=" AND C.kampus_id=".$kampus_id; }
								$select .= " ORDER BY B.startdate"; 
								//print $select;
                                $rs_marque = &$conn->Execute($select);
                                ?>
                                <marquee width="100%" height=150  scrolldelay="250" direction=up onmouseover="stop()" onmouseout="start()"> 
                                <? 
                                if(!$rs_marque->EOF) {
                                    while (!$rs_marque->EOF) {
									$bilik = strtoupper(dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs_marque->fields['bilik_kuliah'])))
                                ?>
                                        <p align="center"><strong><? echo "[ ".$rs_marque->fields['courseid']." ] - ".$rs_marque->fields['coursename']."<br>". 
                                        "<i>".DisplayDate($rs_marque->fields['startdate'])." - " . DisplayDate($rs_marque->fields['enddate'])."</i>"; ?>
                                        <?php if(empty($bilik)){?><br /><font color="#FF0000">BILIK KULIAH BELUM DITETAPKAN</font><?php } else { print "<br>".$bilik; }?>
                                        
                                        </strong></p>
                                <?
                                        $rs_marque->movenext();
                                    }
                                } else {
                                ?>
                                    <p align="center"><strong>Tiada kursus yang didaftarkan untuk dijalankan.</strong></p>
                                <?
								}
                                ?>
                                </marquee>
                                <br /><br />-->       
                                <?php include 'asrama/penetapan_bilik.php';?>                     
                            </td>
                        </tr>
                	</table>
                </td>
                <?php $href_link = "modal_form.php?win=".base64_encode('kursus/senarai_kursus.php;'.$rs->fields['id']); ?>
                <?php $this_mth = date("m"); $this_year=date("Y"); ?>
                <td width="50%" align="center" valign="top" bgcolor="#CCCCCC"><b>Maklumat Kursus</b><hr />
                	<table width="98%" cellpadding="4" cellspacing="0" border="1" bgcolor="#FFFFFF">
                    	<?php //$jum_bln_ini = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$this_mth' AND year(startdate)='$this_year' AND startdate>=".tosql(date("Y-m-d")));
						//$conn->debug=true;
						$jum_bln_ini = dlookup("_tbl_kursus_jadual","count(*)","status IN (0,9) AND month(startdate)='$this_mth' AND year(startdate)='$this_year'");  
						$conn->debug=false;?>
                    	<tr>
                        	<td align="left" width="85%"><label onclick="open_modal('<?=$href_link;?>&types=NOW','Senarai kursus yang dijalankan pada bulan ini',70,70)"  
                            style="cursor:pointer"><u>Kursus Bulan Ini</u></label></td>
                            <td align="right" width="15%"><?php print $jum_bln_ini;?></td>
                        </tr>
                    	<?php  
						$next_mth_start = date("m",strtotime("+1 months")); $next_year_start = date("Y",strtotime("+1 months"));
						$next_mth_end = date("m",strtotime("+2 months")); $next_year_end = date("Y",strtotime("+2 months"));
						$start_date=$next_year_start."-".$next_mth_start."-01";
						$end_date=$next_year_end."-".$next_mth_end."-31";
						//$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$next_mth' AND year(startdate)=$next_year"); 
						$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","status IN (0,9) AND startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date)); ?>
                    	<tr>
                        	<td align="left"><label onclick="open_modal('<?=$href_link;?>&types=NEXT','Senarai kursus yang dijalankan pada bulan hadapan',70,70)" 
                            style="cursor:pointer"><u>Kursus Bulan Hadapan</u></label></td>
                            <td align="right"><?php print $jum_bln_depan;?></td>
                        </tr>
                    	<tr>
                        	<td align="left" colspan="2"><b>Kursus yang sedang dijalankan : </b><hr />
                            <?php $this_dt = date("Y-m-d");
							//$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND B.is_deleted=0 
							//AND '$this_dt' BETWEEN A.startdate AND A.enddate ORDER BY A.startdate, B.coursename ";
							$sSQL="SELECT A.* FROM _tbl_kursus_jadual A WHERE status IN (0,9) 
							AND '$this_dt' BETWEEN A.startdate AND A.enddate ORDER BY A.startdate";
							if($_SESSION["s_level"]<>'99'){ $sSQL .= " AND A.kampus_id=".$_SESSION['SESS_KAMPUS']; }
							if(!empty($kampus_id)){ $sSQL.=" AND A.kampus_id=".$kampus_id; }
							$rs_ini = &$conn->Execute($sSQL);
							//print $sSQL;
							if(!$rs_ini->EOF){ $bil=0;
							?>
                            <ul>
                            	<?php while(!$rs_ini->EOF){ $bil++;
								$disp_cetak=1;
								$sqlkursus = "SELECT * FROM _tbl_kursus WHERE id=".tosql($rs_ini->fields['courseid']);
								if($_SESSION["s_level"]<>'99'){ $sqlkursus .= " AND kampus_id=".$_SESSION['SESS_KAMPUS']; }
								if(!empty($kampus_id)){ $sqlkursus.=" AND kampus_id=".$kampus_id; }
								$rskursus = $conn->execute($sqlkursus);
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