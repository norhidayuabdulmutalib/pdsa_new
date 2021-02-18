<?php

$con = mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($db_name, $con) or die(mysql_error());

$q = strtolower($_GET["q"]);
if (!$q) return;

$sql = "select DISTINCT course_name as course_name from course where course_name LIKE '%$q%'";
$rsd = &$conn->Execute($sql);
while($rs = mysql_fetch_array($rsd)) {
$cname = $rs['course_name'];
echo "$cname\n";
}
?>