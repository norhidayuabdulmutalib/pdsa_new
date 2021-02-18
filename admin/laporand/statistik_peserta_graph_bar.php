<?
session_start();
$tahun=$_GET['tahun'];
if(empty($tahun)){
	$tahun=date("Y");
}
include_once ("../common.php");
include_once ("../graph/jpgraph.php");
include_once ("../graph/jpgraph_bar.php");
//echo "THN".$tahun;

$curmth = date("m");
$curyr = date("Y");
if($tahun==$curyr){ $mth = $curmth; } else { $mth=12; }

//if(!empty($bulan)){ $gb=$bulan; $mth=$bulan; } else { $gb=1; }
for($i=1;$i<=12;$i++){
	$datax[] = month($i);
	$bil++; $jum_kilim=0; $jum_kluar=0;
	if($i<10){ $gi='0'.$i; } else { $gi=$i; }
	$sql = "SELECT A.id, A.category_code, B.coursename AS Kursus, A.startdate, A.enddate FROM _tbl_kursus_jadual A, _tbl_kursus B 
		WHERE A.category_code=1 AND A.courseid=B.id AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi);
	$sql .= " UNION ";
	$sql .= "SELECT A.id, A.category_code, A.acourse_name AS Kursus, A.startdate, A.enddate FROM _tbl_kursus_jadual A 
		WHERE category_code<>1 AND year(startdate)=".tosql($tahun)." AND month(startdate)=".tosql($gi);
	$sql .= " ORDER BY startdate";
	$rs = &$conn->execute($sql);
	$cnt = $rs->recordcount();
	//$jum_papar=0;
	$jum_peserta=0;
	if(!$rs->EOF){
		$ilim_lelaki=0; $ilim_perempuan=0;
		$luar_lelaki=0; $luar_perempuan=0;
		while(!$rs->EOF){
			$kursus_cat='';
			$id=$rs->fields['id'];
			//$nama_kursus=$rs->fields['Kursus'];
			$category_code=$rs->fields['category_code'];
			if($category_code==1){
				$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
					WHERE B.f_peserta_noic=A.peserta_icno AND B.f_peserta_jantina='L' AND A.InternalStudentAccepted=1 AND A.is_selected=1 AND A.EventId=".tosql($id);
				$rskursus = &$conn->execute($sql);	
				$ilim_lelaki += $rskursus->fields['jumi'];
				$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
					WHERE B.f_peserta_noic=A.peserta_icno AND B.f_peserta_jantina='P' AND A.InternalStudentAccepted=1 AND A.is_selected=1 AND A.EventId=".tosql($id);
				$rskursus = &$conn->execute($sql);	
				$rskursus = &$conn->execute($sql);	
				$ilim_perempuan += $rskursus->fields['jumi'];
			} else if($category_code==2){
				$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B 
					WHERE B.f_peserta_noic=A.peserta_icno AND B.f_peserta_jantina='L' AND A.InternalStudentAccepted=1 AND A.is_selected=1 AND A.EventId=".tosql($id);
				$rskursus = &$conn->execute($sql);	
				$luar_lelaki += $rskursus->fields['jumi'];
				$sql = "SELECT count(*) AS jumi FROM _tbl_kursus_jadual_peserta A, _tbl_peserta B  
					WHERE B.f_peserta_noic=A.peserta_icno AND B.f_peserta_jantina='P' AND A.InternalStudentAccepted=1 AND A.is_selected=1 AND A.EventId=".tosql($id);
				$rskursus = &$conn->execute($sql);	
				$luar_perempuan += $rskursus->fields['jumi'];
			}
			//if($jum_papar==0){ 
			$rs->movenext();
			//$jum_papar++;
		}
	}
	if(!empty($ilim_lelaki)){
		$datay[]=$ilim_lelaki; $alts[]=$ilim_lelaki." ILIM (Lelaki)";
	} else { 
		$datay[]=''; $alts[]="";
	}

	if($ilim_perempuan<>0){ 
		$data2y[]=$ilim_perempuan;  $alts2[]=$ilim_perempuan." ILIM (Perempuan)";
	} else { 
	 	$data2y[]=''; $alts2[]="";
	}

	if($luar_lelaki<>0){ 
		$data3y[]=$luar_lelaki;  $alts3[]=$luar_lelaki." ILIM (Perempuan)";
	} else { 
	 	$data3y[]=''; $alts3[]="";
	}

	if($luar_perempuan<>0){ 
		$data4y[]=$luar_perempuan;  $alts4[]=$luar_perempuan." ILIM (Perempuan)";
	} else { 
	 	$data4y[]=''; $alts4[]="";
	}

}	
//exit;
// Create the graph. 
// One minute timeout for the cached image
// INLINE_NO means don't stream it back to the browser.
$graph = new Graph(810,450,'auto');
$graph->SetScale("textlin");
$graph->img->SetMargin(60,180,30,160);
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
$graph->xaxis->SetLabelAngle(80);

//$data3y[]="";
// Create a bar pot
$bplot = new BarPlot($datay);
$bplot->SetCSIMTargets($targ,$alts);
$bplot->SetFillColor("orange");
$bplot->SetShadow();
$bplot->value->SetFormat("%2.0f",70);
//$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot->value->SetColor("blue");
$bplot->SetLegend("Ilim (Lelaki)");
$bplot->value->Show();

$bplot1 = new BarPlot($data2y);
$bplot1->SetCSIMTargets($targ2,$alts2);
$bplot1->SetFillColor("blue");
$bplot1->SetShadow();
$bplot1->value->SetFormat("%2.0f",70);
//$bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot1->value->SetColor("blue");
$bplot1->SetLegend("Ilim (Perempuan)");
$bplot1->value->Show();

$bplot2 = new BarPlot($data3y);
$bplot2->SetCSIMTargets($targ3,$alts3);
$bplot2->SetFillColor("green");
$bplot2->SetShadow();
$bplot2->value->SetFormat("%2.0f",70);
//$bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot2->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot2->value->SetColor("green");
$bplot2->SetLegend("Luar (Lelaki)");
$bplot2->value->Show();

$bplot3 = new BarPlot($data4y);
$bplot3->SetCSIMTargets($targ4,$alts4);
$bplot3->SetShadow();
$bplot3->value->SetFormat("%2.0f",70);
//$bplot1->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot3->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$bplot3->SetFillColor("red");
$bplot3->value->SetColor("red");
$bplot3->SetLegend("Luar (Perempuan)");
$bplot3->value->Show();

$gbplot = new GroupBarPlot(array($bplot,$bplot1,$bplot2,$bplot3));
$gbplot->SetWidth(1);
$graph->Add($gbplot);

// SET FONTS
$graph->title->Set("Statistik Peserta Kursus Bagi Tahun ".$tahun);
$graph->xaxis->title->Set("Bulan");
$graph->yaxis->title->Set("Jumlah Peserta");

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