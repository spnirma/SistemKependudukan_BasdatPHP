<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';

function excelDateToDate($readDate){
    $phpexcepDate = $readDate-25569; //to offset to Unix epoch
    return strtotime("+$phpexcepDate days", mktime(0,0,0,1,1,1970));
}

$data = new Spreadsheet_Excel_Reader("tes.xls");
?>
<html>
<head>
<style>
table.excel {
	border-style:ridge;
	border-width:1;
	border-collapse:collapse;
	font-family:sans-serif;
	font-size:12px;
}
table.excel thead th, table.excel tbody th {
	background:#CCCCCC;
	border-style:ridge;
	border-width:1;
	text-align: center;
	vertical-align:bottom;
}
table.excel tbody th {
	text-align:center;
	width:20px;
}
table.excel tbody td {
	vertical-align:bottom;
}
table.excel tbody td {
    padding: 0 3px;
	border: 1px solid #EEEEEE;
}
</style>
</head>

<body>
<?php //echo $data->dump(true,true); 
    echo $data->val(2,3);
    echo "<br>";

$data = new Spreadsheet_Excel_Reader("example.xls");
echo "<br>";echo "<br>";
echo $data->val(11,2);

?>
</body>
</html>
