<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.php?data=<?php print base64_encode($userid.';default;main;;');?>"><img src="images/logo_ilim.jpg" style="width:30px; height: 30px;"> Sistem PDSA</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html" style="color:#000">PDSA</a>
        </div>
        <ul class="sidebar-menu">
            <li <?php if($menus==$rs_menu->fields['grp_kod']){ print ' class="active"';}?>>
                <a class="nav-link" href="index.php?data=<?php print base64_encode($userid.';default;main;;');?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Muka Hadapan</span>
                </a>
            </li>

            <?php	
                $sql_menu = "SELECT DISTINCT C.grp_name, C.grp_kod, B.menu_link, B.icon_menu 
                FROM _tbl_menu_user A, _tbl_menu B, ref_grpmenu C 
                WHERE C.status=0 AND B.menu_status=0 AND A.menu_id=B.menu_id AND B.grp_id=C.grp_id 
                AND A.id_kakitangan=".tosql($_SESSION["s_userid"],"Text"). " 
                GROUP BY C.grp_name ORDER BY C.sort, B.sort DESC";

                $rs_menu = &$conn->query($sql_menu);
                //echo $sql;
                while(!$rs_menu->EOF){
            ?>

            <li class="nav-item dropdown <?php if($menus==$rs_menu->fields['grp_kod']){ print ' active';}?>">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><?php print $rs_menu->fields['icon_menu'];?><span><?php print $rs_menu->fields['grp_name'];?> </span></a>

                <ul class="dropdown-menu">
                    <?php  
                        $sql_menu = "SELECT DISTINCT B.menu_name, B.menu_link, B.sub_menu, C.grp_name FROM _tbl_menu_user A, _tbl_menu B, ref_grpmenu C
                        WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND A.id_kakitangan=".tosql($_SESSION["s_userid"],"Text"). " 
                        AND C.grp_kod=".tosql($rs_menu->fields['grp_kod'],"Text")." AND B.menu_status=0 ORDER BY B.sort, B.menu_id";
                                $rs_menud = &$conn->query($sql_menu);
                                //echo $sql;
                                while(!$rs_menud->EOF){
                        $glink = $rs_menud->fields['menu_link'];
                        $ggrp = $rs_menu->fields['grp_kod'];
                        $gsub = $rs_menud->fields['menu_name'];
                        $urls = $userid.';'.$glink.";".$ggrp .";".$gsub.";";

                    ?>

                
                    <li <?php if($pages == $glink){ print ' active';}?>><a class="nav-link" href="index.php?data=<?php print base64_encode($urls);?>"><i class="fas fa-pencil-alt"></i><?php print $rs_menud->fields['menu_name'];?></a></li>
                    <?php $rs_menud->movenext(); } ?>
                </ul>
            </li>

            <?php 
                $rs_menu->movenext(); // END LOOP MAIN $sql
            } ?>
          
        </ul>
    </aside>
</div>