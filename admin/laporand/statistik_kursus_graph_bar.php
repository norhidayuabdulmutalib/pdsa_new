<?php
session_start();
$tahun=$_GET['tahun'];
if(empty($tahun)){
	$tahun=date("Y");
}
include '../common_modal.php';
include_once ("../graph/jpgraph.php");
include_once ("../graph/jpgraph_bar.php");
//echo "THN".$tahun;

$curmth = date("m");
$curyr = date("Y");
if($tahun==$curyr){ $mth = $curmth; } else { $mth=12; }

for($i=1;$i<=$mth;$i++){
	$datax[] = month($i);
	$bil++; $jum_kilim=0; $jum_kluar=0;
	if($i<10){ $gi='0'.$i; } else { $gi=$i; }
	$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual WHERE category_code=1 AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi);
	$rskursus = &$conn->execute($sql);	
	$jum_kilim = $rskursus->fields['jumi'];
	if(!empty($jum_kilim)){
		$datay[]=$jum_kilim; 
		$alts[]=$jum_kilim." kursus";
	} else { 
		$datay[]=''; 
		$alts[]="";
	}


	$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual WHERE category_code<>1 AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi);
	$rskursus = &$conn->execute($sql);	
	$jum_kluar = $rskursus->fields['jumi'];
	if($jum_kluar<>0){ 
		$data2y[]=$jum_kluar; 
		$alts2[]=$jum_kluar." kursus luar";
	} else { 
	 	$data2y[]=''; 
		$alts2[]="";
	}
}

//exit;
// Create the graph. 
// One minute timeout for the cached image
// INLINE_NO means don't stream it back to the browser.
$graph = new Graph(810,450,'auto');
$graph->SetScale("textlin");
$graph->img->SetMargin(60,160,20,160);
$graph->yaxis->SetTitleMargin(45);
$graph->xaxis->SetTitleMargin(85);
$graph->yaxis->scale->SetGrace(40);
$graph->SetShadow();

// Turn the tickmarks
$graph->xaxis->SetTickSide(SIDE_DOWN);
$graph->yaxis->SetTickSide(SIDE_LEFT);
// Setup font for axis
//$graph->xaxis->SetFont(FF_VERDANA,FS_NORMAL,10);
//$graph->yaxis->SetFont(FF_VERDANA,FS_NORMAL,10);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,10);
$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,10);
// Setup X-axis labels
$graph->xaxis->SetTickLabels($datax);
$graph->xaxis->SetLabelAngle(50);

//$data3y[]="";
// Create a bar pot

// Create targets for the image maps. One for each column
//$targ=array("graph_bar_det.php#1","bar_clsmex1.php#2","bar_clsmex1.php#3","bar_clsmex1.php#4","bar_clsmex1.php#5","bar_clsmex1.php#6");
//$alts=array("Kemalangan=%d","Kemalangan=%d","Kemalangan=%d","val=%d","val=%d","val=%d");

$bplot = new BarPlot($datay);
$bplot->SetCSIMTargets($targ,$alts);
$bplot->SetFillColor("orange");
$bplot->SetShadow();
$bplot->value->SetFormat("%2.0f",90);
//$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot->value->SetColor("blue");
$bplot->SetLegend("Kursus ILIM");
$bplot->value->Show();

$bplot1 = new BarPlot($data2y);
$bplot1->SetCSIMTargets($targ2,$alts2);
$bplot1->SetShadow();
$bplot1->value->SetFormat("%2.0f",70);
//$bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot1->value->SetColor("blue");
$bplot1->SetLegend("Kursus Luar");
$bplot1->value->Show();

$gbplot = new GroupBarPlot(array($bplot,$bplot1));
$gbplot->SetWidth(0.7);
$graph->Add($gbplot);

// SET FONTS
$graph->title->Set("Statistik Kursus Yang Dijalankan Bagi Tahun ".$tahun);
$graph->xaxis->title->Set("Bulan");
$graph->yaxis->title->Set("Jumlah Kursus");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Send back the HTML page which will call this script again
// to retrieve the image.
$graph->StrokeCSIM();
?>
<style media="print" type="text/css">
	body{FONT-SIZE: 14px;FONT-FAMILY: Arial;COLOR: #000000}
	.printButton { display: none; }
</style>
<script language="javascript" type="text/javascript">
function handleprint(){
	window.print();
}
</script>

<div class="printButton" align="center">
<table width="100%" align="center" border="0">
<!--<tr><td><a onclick="javascript:window.close();" style="cursor:pointer"><u>Tutup</u></a></td></tr>-->
<tr><td>
	<!--<a onclick="javascript:parent.emailwindow.hide();" style="cursor:pointer"><u>Tutup</u></a>-->
    <input type="button" value="Tutup" onclick="javascript:window.close();" style="cursor:pointer" />
    <input type="button" value="Cetak" onClick="handleprint()" style="cursor:pointer" />
</td></tr>
</table>
</div>