<?php
$con=mysql_connect("smartq.ddo.jp","dbsmaq","ufbn516");
mysql_set_charset('utf8'$con);
//mysql_query("SET NAMES 'SJIS'",$con);
mysql_select_db("dbsmaq",$con)



$sql='SELECT * FROM adminUser WHERE adminUid="aaa";
$rs=mysql_query($sql,$con);
$row=mysql_fetch_assoc($rs);
echo $row[adminPass];
echo $row[adminName];
?>