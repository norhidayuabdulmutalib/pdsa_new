<?php session_start(); 
include_once('../common.php'); ?>
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
        <font color="#000033" size="2" face="Verdana, Arial, Helvetica, sans-serif">Selamat Datang ke Sistem Maklumat Latihan ILIM Jakim. </font>
        </MARQUEE></td>
    </tr>
</table>
<table width="95%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
        <td> <div align="center"><font color="#0080c0" face="Verdana" size="4"><strong> 
        SISTEM MAKLUMAT LATIHAN ILIM</strong></font></div>
        <font color="#0080c0" face="Verdana" size="4">
        <hr color="#ff0080" style="HEIGHT: 2px; WIDTH: 100%" align="center">
        </font> 
        </td>
    </tr>
    <?php  
	if($_SESSION["s_level"]=='PESERTA'){ $title = "Jadual Kursus Dalam Perancangan";} else { $title = "Jadual Kursus"; }
	?>
    <tr>
    	<td align="center" width="100%"><!--<img src="../img/banner/bg_img.jpg" border="0" />-->
        <table width="100%" cellpadding="5" cellspacing="0" border="1">
        	<tr>
                <td width="50%" height="250px" align="center" valign="top" bgcolor="#CCCCCC"><b><?php print $title;?></b><hr />
	                <table width="98%" cellpadding="4" cellspacing="0" border="0">
    					<tr>
                        	<td width="100%">
								<?
                                //2 MONTH FROM TODAY
								//$conn->debug=true;
                                $start = date("Y-m-d");
                                $end = date("Y-m-d",strtotime("+3 months"));
                                
								if($_SESSION["s_level"]=='PESERTA'){
									$select = "SELECT A.courseid, A.coursename, B.startdate, B.enddate  
									FROM _tbl_kursus A, _tbl_kursus_jadual B, _tbl_kursus_jadual_peserta C 
									WHERE A.id=B.courseid AND B.id=C.EventId AND A.is_deleted=0 AND B.startdate>=".tosql($start,"Text")." AND B.enddate<=".tosql($end,"Text");
									$select .= " AND C.peserta_icno=".tosql($_SESSION["s_logid"],"Text");
									$select .= " ORDER BY B.startdate"; 
								} else {
									$select = "SELECT A.courseid, A.coursename, B.startdate , B.enddate, B.bilik_kuliah FROM _tbl_kursus A, _tbl_kursus_jadual B 
									WHERE A.id=B.courseid AND A.is_deleted=0 AND B.startdate>=".tosql($start,"Text")." AND B.enddate<=".tosql($end,"Text");
									$select .= " ORDER BY B.startdate"; 
								}								
								
								//print $select;
                                $rs_marque = &$conn->Execute($select);
                                ?>
                                <marquee width="100%" height=150  scrolldelay="250" direction=up> 
                                <?php 
                                if(!$rs_marque->EOF) {
                                    while (!$rs_marque->EOF) {
									$bilik = strtoupper(dlookup("_tbl_bilikkuliah","f_bilik_nama","f_bilikid=".tosql($rs_marque->fields['bilik_kuliah'])))
                                ?>
                                        <p align="center"><strong><?php echo "[ ".$rs_marque->fields['courseid']." ] - ".$rs_marque->fields['coursename']."<br>". 
                                        "<i>".DisplayDate($rs_marque->fields['startdate'])." - " . DisplayDate($rs_marque->fields['enddate'])."</i>"; ?>
                                        <?php if(empty($bilik)){?><br /><font color="#FF0000">BILIK KULIAH BELUM DITETAPKAN</font><?php } ?>
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
                            </td>
                        </tr>
                        <tr>
                        	<td><br /></td>
                        </tr>
                        <!--
                        <?php
						//$gdate = date('Y-m-d', strtotime('-5 day')); //print $gdate;
						//$sqlk = "SELECT DISTINCT A.*, B.courseid, B.coursename, B.SubCategoryCd AS SUB, B.subcategory_code FROM _tbl_kursus_jadual A, _tbl_kursus B 
						//	WHERE A.courseid=B.id AND B.is_deleted=0 AND year(A.enddate)>=2012 AND A.enddate<=".tosql($gdate,"Text");
						//$sqlk .= " AND (A.jumkos_sebenar IS NULL OR jumkceramah_sebenar IS NULL) ";
						//$sqlk .= " AND B.subcategory_code=".tosql($_SESSION["s_jabatan"]);
						//$sqlk .= " GROUP BY A.id ORDER BY A.enddate DESC";
						//$sqlk .= " LIMIT 0, 5";
						//print $sqlk;
						//$rsgd = &$conn->execute($sqlk);
						//$cntgd = $rsgd->recordcount(); //print $cntgd;
						//if($cntgd>0){
						//	$bil=0;
						?>
                        <tr>
                        	<td><b>Senarai Kursus - Kemaskini Kos Sebenar</b><br />
                            <table width="100%" border="1" cellpadding="4" cellspacing="0">
                            	<tr>
                                	<td width="5%" align="center"><b>Bil</b></td>
                                    <td width="75%" align="center"><b>Nama Kursus</b></td>
                                    <td width="15%" align="center"><b>Tarikh Akhir</b></td>
                                    <td width="5%" align="center">&nbsp;</td>
                                </tr>
                                <?php //while(!$rsgd->EOF){ $bil++; 
								//$href_link = "modal_form.php?win=".base64_encode('kursus/kemaskini_kos.php;'.$rsgd->fields['id']);?>
                            	<tr bgcolor="#FFFFFF">
                                	<td align="right"><?//=$bil;?>.</td>
                                    <td align="left"><?//=$rsgd->fields['coursename'];?></td>
                                    <td align="left"><?//=DisplayDate($rsgd->fields['enddate']);?></td>
                                    <td align="center"><img src="../img/item.gif" style="cursor:pointer" title="Kemaskini maklumat kos sebenar kursus" 
                                    onclick="open_modal('<?//=$href_link;?>','Kemaskini Maklumat Kos Kursus',70,70)" /></td>
                                </tr>
                                <?php //$rsgd->movenext(); } ?>
                            </table>
                            </td>
                        </tr>
                        <?php //} ?>
                        <tr>
                        	<td><br /></td>
                        </tr>
                        !-->
                        <!--
                        <?php
						$sqlk = "SELECT DISTINCT A.*, B.courseid, B.coursename, C.kat_perubahan 
							FROM _tbl_kursus_jadual A, _tbl_kursus B, _tbl_kursus_jadual_tukar C 
							WHERE A.courseid=B.id AND A.id=C.id_jadual_kursus AND B.is_deleted=0"; // AND C.status=0";
						//$sqlk .= " AND (A.jumkos_sebenar IS NULL OR jumkceramah_sebenar IS NULL) ";
						//$sqlk .= " AND B.subcategory_code=".tosql($_SESSION["s_jabatan"]);
						$sqlk .= " GROUP BY A.id ORDER BY A.enddate DESC";
						//$sqlk .= " LIMIT 0, 5";
						//print $sqlk;
						$rsgd = &$conn->execute($sqlk);
						$cntgd = $rsgd->recordcount(); //print $cntgd;
						if($cntgd>0){
							$bil=0;
						?>
                        <tr>
                        	<td><b>Senarai Perubahan Tarikh Kursus @ Pembatalan Kursus</b><br />
                            <table width="100%" border="1" cellpadding="4" cellspacing="0">
                            	<tr>
                                	<td width="5%" align="center"><b>Bil</b></td>
                                    <td width="75%" align="center"><b>Nama Kursus</b></td>
                                    <td width="15%" align="center"><b>Tarikh</b></td>
                                    <td width="5%" align="center">&nbsp;</td>
                                </tr>
                                <?php while(!$rsgd->EOF){ $bil++; 
								$href_link = "modal_form.php?win=".base64_encode('kursus/view_jadual_kursus.php;'.$rsgd->fields['id'])."&idk=".$rsgd->fields['id'];
								if($rsgd->fields['status']==2){ $status = '<font color="#FF0000"><b><i>Pembatalan Kursus</i></b></font>'; }
								else { $status=''; }
								?>
                            	<tr bgcolor="#FFFFFF">
                                	<td align="right" valign="top"><?=$bil;?>.<?=$rsgd->fields['status'];?></td>
                                    <td align="left" valign="top"><?=$rsgd->fields['coursename'];?>
                                    <?php if(!empty($status)){ print '<br>'.$status; }?></td>
                                    <td align="left" valign="top"><?=DisplayDate($rsgd->fields['startdate']);?><br />-<br />
									<?=DisplayDate($rsgd->fields['enddate']);?></td>
                                    <td align="center" valign="top"><img src="../img/item.gif" style="cursor:pointer" title="Maklumat Pembatalan @ Perubahan Tarikh Kursus" 
                                    onclick="open_modal('<?=$href_link;?>','Maklumat Pembatalan @ Perubahan Tarikh Kursus',70,70)" /></td>
                                </tr>
                                <?php $rsgd->movenext(); } ?>
                            </table>
                            </td>
                        </tr>
                        <?php } ?>
					-->
                	</table>
                </td>
                <?php $href_link = "modal_form.php?win=".base64_encode('kursus/senarai_kursus.php;'.$rs->fields['id']); ?>
                <?php $this_mth = date("m"); $this_year=date("Y"); ?>
                <td width="50%" align="center" valign="top" bgcolor="#CCCCCC"><b>Maklumat Kursus</b><hr />
                	<table width="98%" cellpadding="4" cellspacing="0" border="1" bgcolor="#FFFFFF">
                    	<?php //$conn->debug=true; 
							$jum_bln_ini = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$this_mth' AND year(startdate)='$this_year'"); 
							//AND startdate>=".tosql(date("Y-m-d"))); $conn->debug=false; ?>
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
						//$conn->debug=true;
						//$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$next_mth' AND year(startdate)=$next_year"); 
						$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date)); 
						$conn->debug=false;
						?>
                    	<tr>
                        	<td align="left"><label onclick="open_modal('<?=$href_link;?>&types=NEXT','Senarai kursus yang dijalankan pada bulan hadapan',70,70)" 
                            style="cursor:pointer"><u>Kursus Bulan Hadapan</u></label></td>
                            <td align="right"><?php print $jum_bln_depan;?></td>
                        </tr>
                    	<tr>
                        	<td align="left" colspan="2"><b>Kursus yang sedang dijalankan : </b><hr />
                            <?php 
							$this_dt = date('Y-m-d',strtotime("+1 days")); 
							$today_dt = date('Y-m-d'); 
							//$this_dt = date("Y-m-d");
							$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd FROM _tbl_kursus_jadual A, _tbl_kursus B 
							WHERE A.courseid=B.id AND B.is_deleted=0"; 
							$sSQL .= " AND (('$this_dt' BETWEEN startdate AND enddate) OR enddate='$today_dt')";
							//$sSQL .= " AND startdate>='$this_dt' AND enddate='$today_dt'"; 
							$sSQL .= " ORDER BY A.startdate, B.coursename";
							$sSQL .= $strSort; //"ORDER BY B.coursename";
							//print $sSQL;
							$rs_this = &$conn->Execute($sSQL);
							if(!$rs_this->EOF){
							?>
                            <table cellpadding="5" cellspacing="0" border="0" width="100%">
                            	<?php while(!$rs_this->EOF){ 
	                             $href_link = "modal_form.php?win=".base64_encode('kursus/cetak_borang_kehadiran.php;'.$rs_this->fields['id']); 
	                             $href_link1 = "modal_form.php?win=".base64_encode('kursus/cetak_borang_kehadiran1.php;'.$rs_this->fields['id']); 
	                             $href_links = "modal_form.php?win=".base64_encode('kursus/cetak_borang_kehadiran_slot.php;'.$rs_this->fields['id']); 
								 ?>
                            	<tr>
                                	<?php if($_SESSION["s_usertype"]=='SYSTEM'){ ?>
                                    <td align="left" width="10%" valign="top">
                                    <img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
                                    onclick="open_modal('<?=$href_link;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>
                                    <img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
                                    onclick="open_modal('<?=$href_link1;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>&nbsp;&nbsp;
                                    <br /><img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
                                    onclick="open_modal('<?=$href_links;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>
                                    </td>
                                    <?php } ?>
                                    <td width="90%" align="left" valign="top">
                                	<?php print $rs_this->fields['courseid']. " - ".$rs_this->fields['coursename'].
									" <i>[ ".Displaydate($rs_this->fields['startdate'])." - ".Displaydate($rs_this->fields['enddate'])." ]</i>";?>
                                <br /></td></tr>
                                <?php $rs_this->movenext(); } ?>
                            </table>
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