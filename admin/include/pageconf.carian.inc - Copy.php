<?php
$bg1 =  "#FFFFFF";
$bg2 = "#FFFCCC";

//Set the page size
if($_GET['pglst'] == '' || empty($_GET['pglst'])) {
	if(!empty($_SESSION['pglst'])){
		$PageQUERY = $_SESSION['pglst'];
	} else {
		$PageQUERY = '10';
	}
} else {
	if(!empty($_GET['pglst'])){
		$PageQUERY = $_GET['pglst'];
	} else {
		$PageQUERY = $_SESSION['pglst'];
	}
}
//echo $PageQUERY;

$_SESSION['pglst'] = $PageQUERY;

$PageSize = $PageQUERY;
$StartRow = 0;
//Set the page no
if(empty($_GET['PageNo'])){
    if($StartRow == 0){
        $PageNo = $StartRow + 1;
    }
}else{
    $PageNo = $_GET['PageNo'];
    $StartRow = ($PageNo - 1) * $PageSize;
}

//Set the counter start
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}
//Counter End
$CounterEnd = $CounterStart + ($PageSize - 1);
$sOrder = " ORDER BY ref_id, type DESC";
$strSQL = $sSQL." GROUP BY ref_id " . $sOrder . " LIMIT $StartRow,$PageSize"; 
$strSC = $sSQL." GROUP BY ref_id " . $sOrder;
//$strSC .= ;
//echo $strSC;
$TRecord = &$conn->Execute($strSC);
$result = &$conn->Execute($strSQL);
if(mysql_errno()!= 0){ print 'Error : '.mysql_error();	}
//Total of record
$RecordCount = mysql_num_rows($TRecord);
//Set Maximum Page
$MaxPage = $RecordCount % $PageSize;
if($RecordCount % $PageSize == 0){
   $MaxPage = $RecordCount / $PageSize;
}else{
   $MaxPage = ceil($RecordCount / $PageSize);
}
?>