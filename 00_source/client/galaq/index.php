<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>SmaQ</title>
</head>
<body>
<?php
/*
if($_SERVER["REQUEST_METHOD"] != "POST"){
   $userNumber = $_GET["userNumber"];
   $userName = $_GET["userName"];
   $password = $_GET["password"];
   $contentID = $_GET["contentID"];
   $choice = $_GET["choice"];
   $status = $_GET["status"];
}else {
   $userNumber = $_POST["userNumber"];
   $mobileName = $_POST["mobileName"];
   $password = $_POST["password"];
   $contentID = $_POST["contentID"];
   $choice = $_POST["choice"];
   $status = $_POST["status"];
}
*/
if(!isset($_POST["status"]) || $_POST["status"] == "login"){
	require("login.php");
}else if($_POST["status"] == "choise"){
	require("choice.php");
}else if($_POST["status"] == "logoff"){
	echo 'ログオフしました<br /><br />';
	echo '
	<a href="index.php">ログイン画面へ</a>
';
}

?>
</body>
</html>
