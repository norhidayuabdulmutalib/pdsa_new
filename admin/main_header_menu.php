<?php //$conn->debug=true;?>
    <!-- menu css start -->
    <div id="cssmenu">
      <ul>
        <li <?php if($menus=='main'){ print ' class="active"';}?>>
        	<a href="index.php?data=<?php print base64_encode($userid.';default;main;;');?>">Muka Hadapan</a>
        </li>
            <?php	$sql_menu = "SELECT DISTINCT C.grp_name, C.grp_kod, B.menu_link 
              FROM _tbl_menu_user A, _tbl_menu B, ref_grpmenu C 
              WHERE C.status=0 AND B.menu_status=0 AND A.menu_id=B.menu_id AND B.grp_id=C.grp_id 
              AND A.id_kakitangan=".tosql($_SESSION["s_userid"],"Text"). " 
              GROUP BY C.grp_name ORDER BY C.sort, B.sort DESC";

                $rs_menu = &$conn->query($sql_menu);
                //echo $sql;
                while(!$rs_menu->EOF){
            ?>
        <li class="has-sub <?php if($menus==$rs_menu->fields['grp_kod']){ print ' active';}?>"><a href="#"><?php print $rs_menu->fields['grp_name'];?></a>
          <ul>
              <?php  $sql_menu = "SELECT DISTINCT B.menu_name, B.menu_link, B.sub_menu, C.grp_name FROM _tbl_menu_user A, _tbl_menu B, ref_grpmenu C
              WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND A.id_kakitangan=".tosql($_SESSION["s_userid"],"Text"). " 
              AND C.grp_kod=".tosql($rs_menu->fields['grp_kod'],"Text")." AND B.menu_status=0 ORDER BY B.sort, B.menu_id";
                    $rs_menud = &$conn->query($sql_menu);
                    //echo $sql;
                    while(!$rs_menud->EOF){
              $glink = $rs_menud->fields['menu_link'];
              $ggrp = $rs_menu->fields['grp_kod'];
              $gsub = $rs_menud->fields['menu_name'];
              $urls = $glink.";".$ggrp .";".$gsub.";";
              ?>
              <li style="background-color:#09F">
                <a href="index.php?data=<?php print base64_encode($urls);?>" style="width:250px">
                  <?php print $rs_menud->fields['menu_name'];?><?//=$urls;?></a>
              </li>
              <?php $rs_menud->movenext(); } ?>
          </ul>
        </li>

      <?php 
        $rs_menu->movenext(); // END LOOP MAIN $sql
      } ?>
       <!-- <li <?php if($menus=='rujukan'){ print ' class="active"';}?>><a href="index.php?data=<?php print base64_encode('rujukan;utiliti/doc_view_list.php');?>">Rujukan</a></li>
        <li <?php if($menus=='carian'){ print ' class="active"';}?>><a href="index.php?data=<?php print base64_encode('carian;carian/carian.php');?>">Carian</a></li>-->
      </ul>
    </div>
    <!-- menu css end -->
