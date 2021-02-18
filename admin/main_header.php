<style media="screen">
.banner{
    border-radius: 10px 80px 0px 0px;
    width: 100%;
    height: 120px; 
}
</style>
  <div id="header">
    <div class="bannerleft"><img src="../images/banner_itis2.png" alt="banner" class="banner" /></div>
    <div class="banneright">
      <div class="welcome"><b><?//=$_SESSION['s_username'].":".$_SESSION["s_userid"].":".$_SESSION['SESS_KAMPUS'].":".$_SESSION["s_level"];?></b>
      <br />:[ <?//=$_SESSION['s_pusatnama'];?> ]<br />
      <!--<a href="index.php?data=<?php print base64_encode($_SESSION["s_userid"].';main_home');?>"><strong>Laman Utama</strong></a> |--> 
      <a href="index.php?data=<?=base64_encode($_SESSION["s_userid"].';utiliti/kakitangan_pass_upd;');?>">
      <img src="../img/pwd_icon.png" height="22" /><strong>Tukar Katalaluan</strong></a> | 
      <a href="logout.php"><img src="../img/door.gif" height="20" width="20" /><strong>Keluar</strong></a>
    </div></div>
    <div style="clear:both;"></div>
  </div>
