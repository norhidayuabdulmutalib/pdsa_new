<div id="wapper">
  <div id="box1">
    <div class="boxleft"><img src="../images/logo_ilim.jpg" style="max-height:386px;max-width:400px" alt="image" class="image_parlimen" /></div>
    <div class="boxright">
      <div class="box_content">
        <h1>Sistem Maklumat Latihan ILIM (I-TIS)</h1>
        <p>Sistem ini menyimpan semua maklumat berkaitan urusan permohonan latihan dan kursus yang dianjurkan oleh pihak di ILIM.</p>
        <p>Sebarang pertanyaan atau cadangan bolehlah diajukan kepada <a href="mailto:eparlimen@islam.gov.my" title="Email">kursus_ilim@islam.gov.my</a></p>
      </div>
    </div>
    <div style="clear:both;"></div>
  </div>
  <div id="box2">
    <div class="boxleft2">
    <img src="images/lock_key.png" alt="key" class="key" />
    </div>
    <div class="boxright2">
      <div class="box_content2">
        <h2>Sila login masuk User ID dan Kata Laluan anda</h2>
		<form name="form1" method="post" action="index.php?data=<?php print base64_encode(';login_do.php');?>" 
        	onSubmit="validateForm();return document.returnValue">
          <p><b>ID Pengguna : </b><br />
            <input type="text" name="up_userid" onclick="this.value='';" onfocus="this.select()" size="20" 
            onblur="this.value=!this.value?'User ID':this.value;" value="" class="input_login" />
          </p>
          
          <p><b>Kata Laluan : </b><br />
            <input type="password" name="up_password" onclick="this.value='';" onfocus="this.select()" 
            onblur="this.value=!this.value?'Kata Laluan':this.value;" value="" class="input_login" />
          </p>
       	  <p>
            <input name="Login" type="submit" value="Login" class="button" style="cursor:pointer" />
            &nbsp;&nbsp;
          	<small><b>Lupa Kata Laluan</b></small>
          </p>
        </form>
      </div>
    </div>
    <div style="clear:both;"></div>
  </div>
</div>
<script language="javascript" type="text/javascript">
document.form1.up_userid.focus();
</script>