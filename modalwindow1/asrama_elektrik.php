<? 
session_start();

include '../common.php'; 

$proses = $_POST['proses'];

if(empty($proses)){

?>

    <html>

    <script language="javascript" type="text/javascript">

    function do_save(){

		if(document.myform.jenis.value==''){

		    alert("Sila masukkan jenis barang.");

			document.myform.jenis.focus();

			return false;

		} else {

			document.myform.submit();

		}

    }

	

	function do_hapus(){

		document.myform.proses.value = 'DELETE';		

		document.myform.submit();

	}

	

	function do_close(){

		parent.emailwindow.hide();

	}

    </script>

    <body style="background: #F3F3F3">

    <?

    $id = $_GET['id'];
	
	$tid = $_GET['tid'];
	
	if(empty($id)){ $proses = "INSERT"; } else { $proses = 'UPDATE'; }
	
	$sql_t = "SELECT * FROM _sis_a_tblelektrik WHERE barang_id=".tosql($id,"Text"); 

    $rs_t = &$conn->execute($sql_t);

    //echo $sql_t;

    ?>

    <form id="myform" name="myform" method="post" action="asrama_elektrik.php">

    <table width="100%" cellpadding="5" cellspacing="0">

        <tr>

            <td>Jenis : </td>

            <td><input type="text" name="jenis" size="60" maxlength="100" value="<?=$rs_t->fields['jenis'];?>"></td>
        </tr>
        <tr>
          <td>Jenama : </td>
          <td><input name="jenama" type="text" id="jenama" value="<?=$rs_t->fields['jenama'];?>" size="60" maxlength="100"></td>
        </tr>

        <tr>

            <td>Model: </td>

            <td><input type="text" name="model" size="30" maxlength="30" value="<?=$rs_t->fields['model'];?>"></td>
        </tr>

        <tr>

            <td>Watt : </td>

            <td><input type="text" name="watt" size="30" maxlength="30" value="<?=$rs_t->fields['watt'];?>"></td>
        </tr>

    

        <tr><td colspan="2" align="center">

            <input type="button" value="Simpan" onClick="do_save()" title="Sila klik untuk menyimpan maklumat">

            <?php if(!empty($id)) { ?>
            		<input type="button" value="Hapus" onClick="do_hapus()" title="Sila klik untuk menghapus maklumat">
            <? } ?>

            <input type="button" value="Tutup" onClick="do_close()" title="Sila klik untuk tutup">

            <input type="hidden" name="id" value="<?=$id;?>">
            
            <input type="hidden" name="tid" value="<?=$tid;?>">

            <input type="hidden" name="proses" value="<?=$proses;?>">

        </td></tr>
    </table>

    </form>

    </body>

    </html>

    <script language="javascript" type="text/javascript">

		document.myform.jenis.focus();

	</script>

<? } else { ?>

    <?

	//$conn->debug=true;
	
	$proses = $_POST['proses'];
	
	$tid = $_POST['tid'];

	$id = $_POST['id'];

	$jenama = $_POST['jenama'];

	$jenis = $_POST['jenis'];

	$model = $_POST['model'];

	$watt = $_POST['watt'];

	

	if($proses=="INSERT"){

		$sql = "INSERT INTO _sis_a_tblelektrik(daftar_id, jenama, jenis, model, watt, create_dt, create_by) 

		VALUES(".tosql($tid,"Text").",".tosql($jenama,"Text").",".tosql($jenis,"Text").",".tosql($model,"Text").",".tosql($watt,"Text").",".tosql(now(),"Text").",
		
		".tosql($_SESSION["s_UserID"],"Text").")";

	} else if($proses=='UPDATE'){

		$sql = "UPDATE _sis_a_tblelektrik SET 

		jenis=".tosql($jenis,"Text").", model=".tosql($model,"Text").", 

		watt=".tosql($watt,"Text").", jenama=".tosql($jenama,"Text").", 
		
		update_dt=".tosql(now(),"Text").", update_by=".tosql($_SESSION["s_UserID"],"Text")."

		WHERE barang_id=".tosql($id,"Text");

	} else if($proses=='DELETE'){

		$sql = "DELETE FROM _sis_a_tblelektrik WHERE barang_id=".tosql($id,"Text");

	}

	$conn->Execute($sql);

    ?>

    <script language="javascript" type="text/javascript">

		<!--

		//parent.location.href="../index.php?data=bW9ob247cGVybW9ob25hbi9wZWxhamFyX2Jpb19wZW5qYWdhLnBocDtiaW9kYXRhO2lidWJhcGE=";

		//parent.location.reload();	
		refresh = parent.location; 
		parent.location = refresh;
		parent.emailwindow.hide();

		//-->

    </script>

<? } ?>

