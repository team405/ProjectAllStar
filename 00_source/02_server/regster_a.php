<?php
// 受け取った情報をfileに書き込む
function write($userID, $password) {
    if($userID != "" && $password != ""){
        $regster = "$userID, $password" . PHP_EOL;
        file_put_contents("admin_user.csv", $regster, FILE_APPEND);
        return true;
    }
    return false;
}

$json = file_get_contents("php://input");
$data = json_decode($json, true);

if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"];
  $password = $_GET["password"];
}else {
  $userID = $_POST["userID"]; //浅井追記
  $password = $_POST["password"];
}

//$userID = $_POST["userID"];
//$password = $_POST["password"];
$dm = "";
$a = write($userID, $password);
$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
