<div style="height:30px;width:100%">&nbsp;</div>
<div id="container" class="clickable clearfix isotope" style="overflow: hidden;" align="center">
   <!-- <li><a href="#">1</a></li>-->
<!--<script language="javascript" type="text/javascript">
	function get_page(URL){
		document.agama.action = URL;
		document.agama.target = '_self';
		document.agama.submit();
	}
</script>-->

  <ul class="pagination pagination-sm">
      <?php
	  $disp_page = '';
	  $q=isset($_REQUEST["q2"])?$_REQUEST["q2"]:"";
	  $NextPage=isset($_REQUEST["page"])?$_REQUEST["page"]:"";
	  $NextPage = is_numeric($NextPage);
	  
	  if(!empty($q2)){ $disp_q2 = "&q2=".$q; } else { $disp_q2=""; }
        //Print First & Previous Link is necessary
        if($CounterStart != 1){
            $PrevStart = $CounterStart - 1;
            print "<li><a href=\"$sFileName&page=1$disp_q2\">Pertama</a></li>";
            print "<li><a href=\"$sFileName&page=$PrevStart$disp_q2\">Sebelumnya</a></i>";
        }
        //$disp_page .= " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
					$disp_page .=  "<li  class=\"disabled\"><a href=\"$sFileName&page=$c$disp_q2\" title=\"Sila klik untuk paparan senarai bagi mukasurat ke $c\">$c</a></li>";
                }elseif($c % $PageSize == 0){
					$disp_page .=  "<li><a href=\"$sFileName&page=$c$disp_q2\" title=\"Sila klik untuk paparan senarai bagi mukasurat ke $c\">$c</a></li>";
                }else{
					$disp_page .=  "<li><a href=\"$sFileName&page=$c$disp_q2\" title=\"Sila klik untuk paparan senarai bagi mukasurat ke $c\">$c</a></li>";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    $disp_page .=  "<li  class=\"disabled\"><a href=\"$sFileName&page=$c$disp_q2\">$c</li> ";
                    break;
                }else{
					$disp_page .=  "<li><a href=\"$sFileName&page=$c$disp_q2\" title=\"Sila klik untuk paparan senarai bagi mukasurat ke $c\">$c</a></li>";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      //$disp_page .=  "] ";
	  
	  $paparan = str_replace(", ]"," ]",$disp_page);
	  
	  print $paparan;

      if($CounterEnd < $MaxPage){
          $NextPage = $CounterEnd + 1;
		  print "<li><a href=\"$sFileName&page=$NextPage$disp_q2\">Seterusnya</a></li>";
      }
      
      //Print Last link if necessary
      if($CounterEnd < $MaxPage){
       $LastRec = $RecordCount % $PageSize;
        if($LastRec == 0){
            $LastStartRecord = $RecordCount - $PageSize;
        }
        else{
            $LastStartRecord = $RecordCount - $LastRec;
        }

        //print " : ";
		print "<li><a href=\"$sFileName&page=$MaxPage$disp_q2\">Terakhir</a></li>";
        }
      ?><br> 
  </ul>
</div>
<div align="center">
	  <?php //echo "<b>Jumlah Rekod : $RecordCount - M/S $PageNo Daripada $MaxPage</b>";  ?>
	  <!--<div align="center">-->
	  <?php print "Halaman: <b>".$PageNo."</b> daripada: <b>".$MaxPage."</b>";  ?>
      <!--</div>-->
</div>