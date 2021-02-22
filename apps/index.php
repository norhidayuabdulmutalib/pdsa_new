<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
            <?php include 'header_system.php';
            
            if($_SESSION["s_usertype"]=='PESERTA'){ 
                include 'menu/left_peserta_system.php';
            } else if($_SESSION["s_usertype"]=='PENSYARAH'){ 
                include 'menu/left_pensyarah.php';
            } else { 
                include 'menu/left_menu.php';
            } ?>
			
			<div class="main-content" id="content">
				<section class="section">
					<div class="section-header" style="margin:0px;">
                        <h1><?php print $pages; ?></h1>
                        <?php
                            if(!empty($page)){ 
                                include $page; //"utiliti/bahagian.php";s
                            } else { 
                                include 'default.php';
                            }
                        ?>
                    </div>
                </section>
            </div>

            <footer class="main-footer">';
			    <?php include_once('footer_system.php'); ?>
            </footer> 
        </div>
    </div>
</div>