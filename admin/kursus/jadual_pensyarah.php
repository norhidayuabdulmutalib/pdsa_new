<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" href="../modalwindow/modal.css" type="text/css" />
<link rel="stylesheet" href="../modalwindow/dhtmlwindow.css" type="text/css" />
<script type="text/javascript" src="../modalwindow/dhtmlwindow.js">
/***********************************************
* DHTML Window Widget- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<script type="text/javascript" src="../modalwindow/modal.js"></script>
<script language="javascript" type="text/javascript">	
function open_modal1(URL,title,width,height){
	emailwindow=dhtmlmodal.open('EmailBox', 'iframe', URL, title, 'width='+width+'px,height='+height+'px,center=1,resize=1,scrolling=0')
} //End "opennewsletter" function
</script>
</head>
<body>
<?php
$href_link_add = "modal_form.php?win=".base64_encode('kursus/jadual_pensyarah_masa.php;'.$id);
$sql_det = "SELECT * FROM _tbl_kursus_jadual_masa WHERE event_id=".tosql($id,"Text");
if(!empty($idnama)){ $sql_det .= " AND id_pensyarah=".tosql($idnama); }
$sql_det .= " ORDER BY tarikh, masa_mula";
$rs_det = $conn->execute($sql_det);
$bil=0;
//print $sql_det;
?>

<div class="card">
    <div class="card-header" >
        <h4>Jadual Kursus : </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th width="5%" align="center"><b>Bil</b></th>
                        <th width="15%" align="center"><b>Tarikh</b></th>
                        <th width="15%" align="center"><b>Masa</b></th>
                        <th width="60%" align="center"><b>Penceramah / Tajuk Kursus</b></th>
                        <th width="5%" align="center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while(!$rs_det->EOF){ $bil++; 
                        $idh=$rs_det->fields['id_jadmasa'];
                    ?>
                    <tr>
                        <td align="right" valign="top"><?php print $bil;?>.</td>
                        <td align="center" valign="top"><?php print DisplayDate($rs_det->fields['tarikh']);?></td>
                        <td align="center" valign="top"><?php print $rs_det->fields['masa_mula']." -<br>" . $rs_det->fields['masa_tamat'];?> &nbsp;</td>
                        <td align="left" valign="top">
                        <?php
                            if($rs_det->fields['id_pensyarah']=='0'){
                                print 'REHAT';
                            } else {
                                print 'Penceramah : '.dlookup("_tbl_instructor","insname","ingenid=".tosql($rs_det->fields['id_pensyarah']));
                                print '<br />';
                                print 'Tajuk : '.$rs_det->fields['tajuk'];
                            }
                        ?>
                        </td>
                        <td align="center">
                            <button class="btn btn-warning" border="0" style="cursor:pointer;padding:8px;" onclick="open_modal1('<?php print $href_link_add;?>&id_masa=<?=$idh;?>','Penambahan Maklumat Jadual',90,90)" /><i class="fas fa-edit"></i></button>
                            <?php if($btn_display==1){ ?>
                            <button class="btn btn-danger" border="0" style="cursor:pointer;padding:8px;" width="20" height="25" onclick="do_hapus('jadual_kursus_maklumat','<?=$idh;?>')" /><i class="fas fa-trash"></i></button>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $rs_det->movenext(); } ?>
                </tbody>
            </table>
        </div>
        <div>
            <div style="float:right">
                <?php if($btn_display==1){ ?>
                    <button type="button" class="btn btn-success" value="Tambah Jadual" style="cursor:pointer" 
                onclick="open_modal1('<?php print $href_link_add;?>','Penambahan Maklumat Jadual',90,90)"><i class="fas fa-plus"></i><b> Tambah Jadual</b></button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
