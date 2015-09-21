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

//受け取りうんぬんは後ほどアップデート予定 $_POST
$json = file_get_contents("php://input");
$data = json_decode($json, true);

$userID = $_POST["userID"];
$password = $_POST["password"];
$dm = "";
$a = write($userID, $password);
$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
