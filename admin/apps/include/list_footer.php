<script language="javascript" type="text/javascript">
	function get_page(URL){
		document.ilim.action = URL;
		document.ilim.target = '_self';
		document.ilim.submit();
	}
</script>
<table width="98%" border="0"  align="center">
  <tr>
    <td class="corporatedesc">
      <div align="center"> 
        <?php
	  //$PageSize=20;
	  //$MaxPage=5;
	  //$NextPage = $_GET['page'];
	  $NextPage=isset($_REQUEST["page"])?$_REQUEST["page"]:"";
	  $NextPage = is_numeric($NextPage);
	  //echo "<br>PG NO : ".$PageNo;
	  //echo "<br>PG Size : ".$PageSize;
	  //echo "<br> Counter Start : ".$CounterStart;
	  //echo "<br> Counter End : ".$CounterEnd;
	  //echo "<br> Max page : ".$MaxPage;
	  //echo "<br>";
	  
        //Print First & Previous Link is necessary
        if($CounterStart != 1){
            $PrevStart = $CounterStart - 1;
            print "<a href=\"#\" onclick=\"get_page('$sFileName&page=1')\">Laman Pertama</a>: ";
            print "<a href=\"#\" onclick=\"get_page('$sFileName&page=$PrevStart')\">Laman Sebelumnya</a>";
        }
        print " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
						print "$c ";
                        //print "<b><font color=\"#FF0000\"><i>$c</i></font></b> ";
                    }else{
						print "$c ,";
                       //print "<b><font color=\"#FF0000\"><i>$c</i></font></b>, ";
                    }
                }elseif($c % $PageSize == 0){
					print "<a href=\"#\" onclick=\"get_page('$sFileName&page=$c')\">$c</a> ";
                    //echo "<a href=$sFileName&page=$c>$c</a> ";
                }else{
					print "<a href=\"#\" onclick=\"get_page('$sFileName&page=$c')\">$c</a> ,";
                    //echo "<a href=$sFileName&page=$c>$c</a>, ";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "$c ";
                    break;
                }else{
					print "<a href=\"#\" onclick=\"get_page('$sFileName&page=$c')\">$c</a> ";
                    //echo "<a href=$sFileName&page=$c>$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      print "] ";

      if($CounterEnd < $MaxPage){
          $NextPage = $CounterEnd + 1;
		  print "<a href=\"#\" onclick=\"get_page('$sFileName&page=$NextPage')\">Laman Seterusnya</a>";
          //echo "<a href=$sFileName&page=$NextPage>Laman Seterusnya</a>";
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

        print " : ";
		print "<a href=\"#\" onclick=\"get_page('$sFileName&page=$MaxPage')\">Laman Terakhir</a>";
        //echo "<a href=$sFileName&page=$MaxPage>Laman Terakhir</a>";
        }
      ?><br> 
	  <?php //echo "<b>Jumlah Rekod : $RecordCount - M/S $PageNo Daripada $MaxPage</b>";  ?>
	  <?php print "Halaman: <b>".$PageNo."</b> daripada: <b>".$MaxPage."</b>";  ?>
      </div>
    </td>
  </tr>
</table>
