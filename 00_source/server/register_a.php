<?php
// 受け取った情報をfileに書き込む
function NewEntry($userID, $password) {
    if($userID != "" && $password != ""){
// mysqliクラスのオブジェクトを作成
      $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
      if ($mysqli->connect_error) {
        echo $mysqli->connect_error;
        exit();
      } else {
          $mysqli->set_charset("utf8");
        }

$adminName = "tempolaly"

      $sql = "INSERT INTO adminUser VALUES ('$userID','$password','$adminName') ";
      $mysqli->query($sql);
    $sql = "SELECT * FROM adminUser";
    $result = $mysqli->query($sql);
    $account = $result->num_rows;
    $result->close();
//処理書き終わったよ
// DB接続を閉じる
$mysqli->close();

$path = "data/$account";
//ディレクトリ作成
mkdir($path,0777);

//        $regster = "$userID,$password" . PHP_EOL;
//        file_put_contents("admin_user.csv", $regster, FILE_APPEND);
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
$a = NewEntry($userID, $password);
$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
