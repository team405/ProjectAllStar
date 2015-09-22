<?php
// 受け取った情報をfileに書き込む
function write($userNumber,$choice) {
    if($userNumber != ""){
        $now = microtime(true);
        $answer = $userNumber. "," . $choice. "," . $now. PHP_EOL;
        file_put_contents("data/$userNumber/0/answer.csv", $answer, FILE_APPEND);
        return true;
    }
    return false;
}


if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userNumber = $_GET["userNumber"];
  $choice = $_GET["choice"];
}else {
  $userNumber = $_POST["userNumber"]; //浅井追記
  $choice = $_POST["choice"];
}

//$userID = $_POST["userID"];
//$password = $_POST["password"];
$dm = "";
$a = write($userNumber, $choice);
$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
