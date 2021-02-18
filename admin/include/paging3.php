<script language="javascript" type="text/javascript">
	function get_page(URL){
		document.frm3.action = URL;
		document.frm3.submit();
	}
</script>
<table width="100%" border="0" class="TableTDTextWhite">
  <tr>
    <td>
      <div align="center" class="normalTextSmall"><b>
	  <?php
	    //Print First & Previous Link is necessary
        if($CounterStart != 1){
            $PrevStart = $CounterStart - 1;
            print "<a href=\"#\" onclick=\"get_page('$namafail&$syarat&PageNo=1')\">First </a>: ";
            print "<a href=\"#\" onclick=\"get_page('$namafail&$syarat&PageNo=$PrevStart')\">Previous </a>";
        }
        print " [ ";
        $c = 0;

        //Print Page No
        for($c=$CounterStart;$c<=$CounterEnd;$c++){
            if($c < $MaxPage){
                if($c == $PageNo){
                    if($c % $PageSize == 0){
                        print "$c ";
                    }else{
                        print "$c ,";
                    }
                }elseif($c % $PageSize == 0){
                    echo "<a href=\"#\" onclick=\"get_page('$namafail&$syarat&PageNo=$c')\">$c</a> ";
                }else{
                    echo "<a href=\"#\" onclick=\"get_page('$namafail&$syarat&PageNo=$c')\">$c</a> ,";
                }//END IF
            }else{
                if($PageNo == $MaxPage){
                    print "$c ";
                    break;
                }else{
                    echo "<a href=\"#\" onclick=\"get_page('$namafail&$syarat&PageNo=$c')\">$c</a> ";
                    break;
                }//END IF
            }//END IF
       }//NEXT

      echo "] ";

      if($CounterEnd < $MaxPage){
          $NextPage = $CounterEnd + 1;
          echo "<a href=\"#\" onclick=\"get_page('$namafail&$syarat&PageNo=$NextPage')\">Next</a>";
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
        echo "<a href=\"#\" onclick=\"get_page('$namafail&$syarat&PageNo=$MaxPage')\">Last</a>";
        }
      ?>
    </b></div>
    </td>
  </tr>
</table>