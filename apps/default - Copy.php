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
<table width="95%" align="center" cellpadding="0" cellspacing="0">
    <tr> 
        <td> <div align="center"><font color="#0080c0" face="Verdana" size="4"><strong> 
        SISTEM MAKLUMAT LATIHAN ILIM </font></div>
        <font color="#0080c0" face="Verdana" size="4">
        <hr color="#ff0080" style="HEIGHT: 2px; WIDTH: 100%" align="center">
        </font> 
        </td>
    </tr>
    <tr>
    	<td align="center" width="100%"><!--<img src="../img/banner/bg_img.jpg" border="0" />-->
        <table width="100%" cellpadding="5" cellspacing="0" border="1">
        	<tr>
                <td width="50%" align="center" valign="top" bgcolor="#CCCCCC"><b>Jadual Kursus</b><hr />
	                <table width="98%" cellpadding="4" cellspacing="0" border="0">
    					<tr>
                        	<td width="100%">
								<?
                                //2 MONTH FROM TODAY
								//$conn->debug=true;
                                $start = date("Y-m-d");
                                $end = date("Y-m-d",strtotime("+2 months"));
                                $select = "SELECT A.courseid, A.coursename, B.startdate , B.enddate  FROM _tbl_kursus A, _tbl_kursus_jadual B 
                                WHERE A.id=B.courseid AND A.is_deleted=0 AND B.startdate>=".tosql($start,"Text")." AND B.enddate<=".tosql($end,"Text");
								$select .= " ORDER BY B.startdate"; 
                                $rs_marque = &$conn->Execute($select);
                                
                                ?>
                                <marquee width="100%" height=150  scrolldelay="250" direction=up> 
                                <? 
                                if(!$rs_marque->EOF) {
                                    while (!$rs_marque->EOF) {
                                ?>
                                        <p align="center"><strong><? echo "[ ".$rs_marque->fields['courseid']." ] - ".$rs_marque->fields['coursename']."<br>". 
                                        "<i>".DisplayDate($rs_marque->fields['startdate'])." - " . DisplayDate($rs_marque->fields['enddate'])."</i>"; ?></strong></p>
                                <?
                                        $rs_marque->movenext();
                                    }
                                }
                                ?>
                                </marquee>                            
                            </td>
                        </tr>
                	</table>
                </td>
                <?php $href_link = "modal_form.php?win=".base64_encode('kursus/senarai_kursus.php;'.$rs->fields['id']); ?>
                <?php $this_mth = date("m"); $this_year=date("Y"); ?>
                <td width="50%" align="center" valign="top" bgcolor="#CCCCCC"><b>Maklumat Kursus</b><hr />
                	<table width="98%" cellpadding="4" cellspacing="0" border="1" bgcolor="#FFFFFF">
                    	<?php $jum_bln_ini = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$this_mth' AND year(startdate)=$this_year"); ?>
                    	<tr>
                        	<td align="left" width="85%"><label onclick="open_modal('<?=$href_link;?>&types=NOW','Senarai kursus yang dijalankan pada bulan ini',70,70)"  
                            style="cursor:pointer"><u>Kursus Bulan Ini</u></label></td>
                            <td align="right" width="15%"><?php print $jum_bln_ini;?></td>
                        </tr>
                    	<?php  $next_mth = date("m",strtotime("+1 months")); $next_year = date("Y",strtotime("+1 months"));
						//print $end;
						$jum_bln_depan = dlookup("_tbl_kursus_jadual","count(*)","month(startdate)='$next_mth' AND year(startdate)=$next_year"); ?>
                    	<tr>
                        	<td align="left"><label onclick="open_modal('<?=$href_link;?>&types=NEXT','Senarai kursus yang dijalankan pada bulan hadapan',70,70)" 
                            style="cursor:pointer"><u>Kursus Bulan Hadapan</u></label></td>
                            <td align="right"><?php print $jum_bln_depan;?></td>
                        </tr>
                    	<tr>
                        	<td align="left" colspan="2"><b>Kursus yang dijalankan pada hari ini : </b><hr />
                            <?php $this_dt = date("Y-m-d");
							$sSQL="SELECT A.*, B.courseid, B.coursename, B.SubCategoryCd FROM _tbl_kursus_jadual A, _tbl_kursus B WHERE A.courseid=B.id AND B.is_deleted=0 
							AND '$this_dt' BETWEEN startdate AND enddate ORDER BY B.coursename";
							$sSQL .= $strSort; //"ORDER BY B.coursename";
							$rs_this = &$conn->Execute($sSQL);
							if(!$rs_this->EOF){
							?>
                            <ul>
                            	<?php while(!$rs_this->EOF){ ?>
                            	<li><?php print $rs_this->fields['courseid']. " - ".$rs_this->fields['coursename'].
								" <i>[ ".Displaydate($rs_this->fields['startdate'])." - ".Displaydate($rs_this->fields['enddate'])." ]</i>";?></li>
                                <?php $rs_this->movenext(); } ?>
                            </ul>
                            <?php } ?>
                            </td>
                        </tr>
                    </table>
                </td>
			</tr>
        </table>
        </td>
    </tr>
</table>