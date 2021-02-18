<script language="javascript" type="text/javascript">
function openModal(URL){
	var returnValue = window.showModalDialog(URL, 'ILIM','help:no;status:no;scroll:yes;resize:yes;tools:yes;dialogHeight:500px;dialogWidth:800px');
} 
</script>
<table width="95%" cellpadding="0" cellspacing="0">
    <tr> 
        <td height="20"> <!--<STRONG>Thoughts of the day:</STRONG>&nbsp;-->
        <MARQUEE HEIGHT=15 SCROLLAMOUNT=3 SCROLLDELAY=150 WIDTH=95%>
      <font color="#000033" size="2" face="Verdana, Arial, Helvetica, sans-serif">Selamat Datang ke Sistem Maklumat Latihan ILIM Jakim. 
        <!--  Untuk sebarang pertanyaan sila hantarkan email anda kepada <a href="mailto:info@islam.gov.my">info@islam.gov.my</a>--> </font>
        </MARQUEE></td>
    </tr>
</table>
<table width="95%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
        <td> <div align="center"><font color="#0080c0" face="Verdana" size="4"><strong> 
        SISTEM MAKLUMAT LATIHAN ILIM </strong></font></div>
        <font color="#0080c0" face="Verdana" size="4">
        <hr color="#ff0080" style="HEIGHT: 2px; WIDTH: 100%" align="center">
        </font> 
        </td>
    </tr>
    <?php  
	if($_SESSION["s_level"]=='PESERTA'){ $title = "Jadual Kursus Dalam Perancangan.";} else { $title = "Jadual Kursus"; }
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
                                
								$select = "SELECT A.courseid, A.coursename, B.startdate, B.enddate, C.InternalStudentAccepted, 
								C.InternalStudentId, C.approve_ilim  
								FROM _tbl_kursus A, _tbl_kursus_jadual B, _tbl_kursus_jadual_peserta C 
								WHERE A.id=B.courseid AND B.id=C.EventId AND A.is_deleted=0  
								AND B.startdate>=".tosql($start,"Text"); //." AND B.enddate<=".tosql($end,"Text");
								$select .= " AND C.peserta_icno=".tosql($_SESSION["s_logid"],"Text");
								$select .= " ORDER BY B.startdate"; 
								
								//print $select;
                                $rs_marque = &$conn->Execute($select);
								$conn->debug=false;
                                ?>
                                <marquee width="100%" height=150  scrolldelay="250" direction=up onmouseover="stop()" onmouseout="start()"> 
                                <? 
                                if(!$rs_marque->EOF) {
									$sah_window = "modal_form.php?win=".base64_encode('peserta/kursus_dlmproses_sah.php;'.$rs_marque->fields['InternalStudentId']);
                                    while (!$rs_marque->EOF) {
                                ?>
                                        <p align="center"><strong><? echo "[ ".$rs_marque->fields['courseid']." ] - ".$rs_marque->fields['coursename']."<br>". 
                                        "<i>".DisplayDate($rs_marque->fields['startdate'])." - " . DisplayDate($rs_marque->fields['enddate'])."</i>"; ?></strong>
                                        <?php if($rs_marque->fields['approve_ilim']==1){ ?>
											<?php if($rs_marque->fields['InternalStudentAccepted']==0){ ?><br />
                                            Sila <label onclick="open_modal('<?=$sah_window;?>','Pengesahan kehadiran <?=date("d/m/Y");?>',70,70)" 
                                            style="cursor:pointer"><u><b>klik disini</b></u></label> untuk pengesahan kehadiran
                                            <?php } ?>
                                        <?php } else { ?>
                                            <br /><font color="0000FF">Permohonan kursus dalam semakan pihak ILIM</font>
                                        <?php } ?>
                                        </p>
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
                	</table>
                </td>
                <?php $href_link = "modal_form.php?win=".base64_encode('kursus/senarai_kursus_peserta.php;'.$rs->fields['id']); ?>
                <?php $this_mth = date("m"); $this_year=date("Y"); ?>
                <td width="50%" align="center" valign="top" bgcolor="#CCCCCC"><b>Maklumat Kursus</b><hr />
                	<table width="98%" cellpadding="4" cellspacing="0" border="1" bgcolor="#FFFFFF">
                    	<?php $jum_bln_ini = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$this_mth' AND year(startdate)='$this_year' AND startdate>=".tosql(date("Y-m-d"))); ?>
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
						$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","startdate BETWEEN ".tosql($start_date)." AND ".tosql($end_date)); ?>
                    	<tr>
                        	<td align="left"><label onclick="open_modal('<?=$href_link;?>&types=NEXT','Senarai kursus yang dijalankan pada bulan hadapan',70,70)" 
                            style="cursor:pointer"><u>Kursus Bulan Hadapan</u></label></td>
                            <td align="right"><?php print $jum_bln_depan;?></td>
                        </tr>
                    	<tr>
                        	<td align="left" colspan="2"><b>Kursus yang sedang dijalankan : </b><hr />
                            <?php $this_dt = date("Y-m-d");
							$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND B.is_deleted=0 
							AND '$this_dt' BETWEEN startdate AND enddate ORDER BY A.startdate, B.coursename";
							$sSQL .= $strSort; //"ORDER BY B.coursename";
							$rs_this = &$conn->Execute($sSQL);
							if(!$rs_this->EOF){
							?>
                            <ul>
                            	<?php while(!$rs_this->EOF){ ?>
	                            <?php $href_link = "modal_form.php?win=".base64_encode('kursus/cetak_borang_kehadiran.php;'.$rs_this->fields['id']); ?>
	                            <?php $href_link1 = "modal_form.php?win=".base64_encode('kursus/cetak_borang_kehadiran1.php;'.$rs_this->fields['id']); ?>
                            	<li style="height:25px;">
                                	<?php if($_SESSION["s_level"]!='PESERTA'){ ?>
                                    <div style="float:left">
                                    <img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
                                    onclick="open_modal('<?=$href_link;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>
                                    <img src="../images/ico-4.gif" border="0" style="cursor:pointer" title="Sila klik untuk mencetak kehadiran borang peserta" 
                                    onclick="open_modal('<?=$href_link1;?>&types=NOW','Senarai peserta kursus pada hari ini <?=date("d/m/Y");?>',1,1)"/>
                                    &nbsp;&nbsp;</div>
                                    <?php } ?>
                                	<?php print $rs_this->fields['courseid']. " - ".$rs_this->fields['coursename'].
								" <i>[ ".Displaydate($rs_this->fields['startdate'])." - ".Displaydate($rs_this->fields['enddate'])." ]</i>";?></li>
                                <?php $rs_this->movenext(); } ?>
                            </ul>
                            <?php } ?>
                            </td>
                        </tr>
                    </table>
					<?php if($_SESSION["s_level"]!='PESERTA'){ ?>
                    <br /><div style="float:left">&nbsp;<img src="../images/ico-4.gif" border="0"  /></div> Sila klik untuk mencetak borang kehadiran Peserta
                   	<?php } ?>
                </td>
			</tr>
        </table>
        </td>
    </tr>
</table>