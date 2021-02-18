<?
//Set the page size
//echo "PG SES: ".$_SESSION['linepage'];
$getpages=isset($_REQUEST["linepage"])?$_REQUEST["linepage"]:"";
if(!empty($_SESSION['linepage'])){
	if(!empty($getpages)){
		$PageSize = $getpages;
		//echo "<br>PG SIZE 11: ".$PageSize;
	} else {
		if(!empty($_SESSION['linepage'])){
			$PageSize = $_SESSION['linepage'];
		} else {
			$PageSize = 10;
		}
		//echo "<br>PG SIZE 12: ".$PageSize;
	}
	$_SESSION['linepage'] = $PageSize;
} else {
	if(!empty($getpages)){
		$PageSize = $getpages;
	} else {
		$PageSize = 10;
	}
	$_SESSION['linepage'] = $PageSize;
//echo "<br>PG SIZE 2: ".$PageSize;
}

$StartRow = 0;
$pg=$PageSize;
$perpage=10;

$gPageNo=isset($_REQUEST["PageNo"])?$_REQUEST["PageNo"]:"";
$gPage=isset($_REQUEST["page"])?$_REQUEST["page"]:"";
//Set the page no
if(!empty($gPageNo)){
	$PageNo = $gPageNo;
	$StartRow = ($PageNo - 1) * $PageSize;
	$page=$gPageNo;
} else {
	if(empty($gPage)){
		if($StartRow == 0){
			$PageNo = $StartRow + 1;
		}
		$page=$PageNo;
		//echo "PG:".$PageNo;
	}else{
		$PageNo = $gPage;
		$StartRow = ($PageNo - 1) * $PageSize;
		$page=$PageNo;
	}
	/*if(!empty($_SESSION['page'])){
		$PageNo = $_SESSION['page'];
		$StartRow = ($PageNo - 1) * $PageSize;
		$page=$PageNo;
	} else */
	//$page=$_GET['page'];
	//$PageNo = $page;
}

/*
//Set the counter start
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}

//Counter End
$CounterEnd = $CounterStart + ($PageSize - 1);
*/
//Set the counter start
if($PageNo % $perpage == 0){
    $CounterStart = $PageNo - ($perpage - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $perpage) + 1;
}

//Counter End
$CounterEnd = $CounterStart + ($perpage - 1);

?>

<?
//	 BEGIN : cater for number of records and page to be displayed --------------------------------->
//if (empty($pg)) {$pg = 10;}

$rs->Move($StartRec-1);
if (empty($page)){
	$page = 1;
	$curPage=$page;
	$StartRec = 1;
} else {
	$curPage=$page;
	if($page==1){
		$StartRec = 1;
	} else {
		$page = $page - 1;
		$StartRec = ($PageSize * $page) + 1;
	}
}

//echo $StartRec;

$rs->Move($StartRec-1);
 
	$TotalRec = $rs->RowCount();
	$TotalPage =  ($TotalRec/$pg);

	if ($StartRec < $TotalRec) {
		if (($TotalRec-($StartRec + $pg)) < 0) {
			$NextRec = $StartRec;
		} else {
			$NextRec = $StartRec + $pg;
		}
	} else {
		$NextRec = $StartRec;
	}
	if ($StartRec != 1) {
		$PrevRec = $StartRec - $pg;
	} else {
		$PrevRec = 1;
	}		
	if ($TotalRec != 0) {
		if (($TotalRec % $pg) == 0) {
			$LastRec = ($TotalPage * $pg) - $pg + 1;
		} else {
			$LastRec = ($TotalPage * $pg) + 1;
		}
	} else {
		$LastRec = 1;
	}
//	 END   : cater for number of records and page to be displayed --------------------------------->

//Total of record
$RecordCount = $rs->RowCount();
//Set Maximum Page
$MaxPage = $RecordCount % $PageSize;
if($RecordCount % $PageSize == 0){
   $MaxPage = $RecordCount / $PageSize;
}else{
   $MaxPage = ceil($RecordCount / $PageSize);
}
//echo "LVL: ".$levelid;
?>