<?php
include '../common.php';
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
if(!empty($pro) && !empty($id)){
	print $pro.":".$id;
	$dt=date("Y-m-d H:i:s");
	$conn->debug=true;
	$conn->execute("UPDATE `_tbl_peserta` SET is_deleted=1, delete_dt='{$dt}', delete_by='ADMIN' WHERE id_peserta='{$id}'");
	$conn->debug=false;
}

//$conn->debug=true;
//$sSQL = "SELECT * FROM tbl_pelajar WHERE length(ic)=13 AND ic like '099%' ";
$sSQL = "SELECT `f_peserta_noic`, count(*) AS CNT FROM `_tbl_peserta` WHERE is_deleted=0 GROUP BY `f_peserta_noic` 
	ORDER BY CNT DESC, f_peserta_nama LIMIT 20";
$rs = $conn->query($sSQL);
//print $rs->recordcount(); exit;
?>
<script language="javascript">
function do_del(val){
	document.ilim.action='semak_peserta.php?pro=DEL&id='+val;
	document.ilim.target='_self';
	document.ilim.submit();
}
</script>
<form name="ilim" method="post" action="">
<table width="100%" cellpadding="5" cellspacing="0" border="1">
<?php $bil=0;
while(!$rs->EOF){
	$bil++;
	$sqls = "SELECT * FROM _tbl_peserta WHERE is_deleted=0 AND f_peserta_noic=".tosql($rs->fields['f_peserta_noic']);
	$rs1 = $conn->query($sqls);
	while(!$rs1->EOF){
		$id=$rs1->fields['id_peserta'];
		$cnt = dlookup("_tbl_peserta_akademik`","count(*)","id_peserta='{}'");
?>	
	<tr>
    	<td width="5%"><?=$bil;?></td>
        <td width="10%" align="right"><?=$rs1->fields['f_peserta_noic'];?></td>
        <td align="center" width="5%"><img src="../images/del.gif" style="cursor:pointer" onclick="do_del('<?=$id;?>')"  /></td>
        <td width="80%"><?=$rs1->fields['f_peserta_nama'];?></td>
        <td width="5%"><?=$cnt;?></td>
    </tr>		
<?php
	//$conn->execute($sqls);
		$rs1->movenext();
	}
	$rs->movenext();
	if($rs->fields['CNT']==1){ $rs->movelast(); }
}	

//print "<br><br>Sama : " . $sama;
//echo "<br><br>selesai";

?>
</table>
