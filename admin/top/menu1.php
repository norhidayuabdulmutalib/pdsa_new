<?php if(empty($idk)){ ?>
	<script language="javascript" type="text/javascript">
		window.open('main.php','_parent')
	</script>
<?php } ?>
<style>
#menu ul {
	width:100%;
	margin: 0;
	padding: 0;
	list-style: none;
	position: relative;
}

#menu li { /* all list items */
	float: left;
	position: relative;
	width:100px;
}

#menu li ul {/* second-level lists */
	position: absolute;
	display: block; 
	top: 2em;
    left: 0;
	width:150px;
}

#menu li>ul {/* to override top and left in browsers other than IE */
	top: auto;
	left: auto;
}

#menu li ul li ul  {/* third-level lists */
	position: absolute;
	display: block; 
	top: 0;
}

/* Fix IE. Hide from IE Mac \*/
* html #menu ul li { float: left; height: 1%; }
* html #menu ul li a { height: 1%; }
/* End */

#menu li:hover ul { display: block; }

#menu li:hover>ul { visibility:visible; }

#menu ul ul { visibility:hidden; }		

/* Make-up syles */
#menu ul, li {
    margin: 0 0 0 0; 
}

/* Styles for Menu Items */
#menu ul a {
	display: block;
	text-decoration: none;
	color: #777;
	background: #fff; /* IE6 Bug */
	padding: 5px;
	border: 1px solid #ccc;
}
/* Hover Styles */
#menu ul a:hover { 
	color: #E2144A; 
	background: #f9f9f9; 
} 

/* Sub Menu Styles */
#menu li ul a {
	text-decoration: none;
	color: #77F;
	background: #fff; /* IE6 Bug */
	border: 1px solid #ccc;
    padding: 5px; 
} 

/* Sub Menu Hover Styles */
#menu li ul a:hover { 
	color: #E2144A; 
	background: #f9f9f9; 
} 

/* Icon Styles */
#menu li a.submenu {background:#fff url("v_arrow.gif") no-repeat right; }
#menu li a.submenu:hover {background:#f9f9f9 url("v_arrow.gif") no-repeat right;}
#menu li ul a.submenu {background:#fff url("r_arrow.gif") no-repeat right;}
#menu li ul a.submenu:hover {background:#f9f9f9 url("r_arrow.gif") no-repeat right;}
</style>

<script>
startList = function() {
	//code only for IE
	if(!document.body.currentStyle) return;
	var subs = document.getElementsByName('submenu');
	for(var i=0; i<subs.length; i++) {
		var li = subs[i].parentNode;
		if(li && li.lastChild.style) {
			li.onmouseover = function() {
				this.lastChild.style.visibility = 'visible';
			}
			li.onmouseout = function() {
				this.lastChild.style.visibility = 'hidden';
			}
		}
	}
}
window.onload=startList;
</script>
<body>
<table width="99%" border="1"><tr><td>
<div id="menu">
  <ul id="menuList">
    <li><a class="submenu" href="index.php?data=<?php print base64_encode('home.php');?>" name="submenu">Laman Utama</a></li>
	<?php 	$sql = "SELECT distinct C.grp_id, C.grp_name FROM tbl_menu_user A, tbl_menu B, kod_grpmenu C 
        WHERE A.menu_id=B.menu_id AND B.grp_id=C.grp_id AND B.menu_status=0 AND A.id_kakitangan=".$idk."
        ORDER BY C.grp_id";
        $rs_menu = &$conn->Execute($sql);
        //echo $sql;
        while($rowm = mysql_fetch_assoc($rs_menu)){
    ?>
    <li><a class="submenu" href="#nogo" name="submenu"><?php print $rowm['grp_name'];?></a>
        <ul>
          <li><a href="#?menu_id=6">All</a>
          </li><li><a href="#?menu_id=7">CodeCharge</a>
          </li><li><a href="#?menu_id=8">CodeCharge Studio</a>
          </li><li><a href="#?menu_id=9">DemoCharge Studio</a>
          </li><li><a href="http://examples.codecharge.com/CCSExamplePack2/HorizontalCSSMenu/HCSSMenu.php?menu_id=10">Comparison</a>
          </li>
        </ul>
    </li>
    <?php } ?>
    <li><a class="submenu" href="index.php?data=<?php print base64_encode('utiliti/doc_view_list.php');?>" name="submenu">Rujukan</a></li>
    <li><a class="submenu" href="index.php?data=<?php print base64_encode('carian/carian.php');?>" name="submenu">Carian</a></li>
    <li><a class="submenu" href="logout.php" name="submenu">Keluar</a></li>
  </ul>
</div>
</td></tr></table>
</body>