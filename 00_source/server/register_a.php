<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"];
  $password = $_GET["password"];
}else {
  $userID = $_POST["userID"]; //浅井追記
  $password = $_POST["password"];
}


// mysqliクラスのオブジェクトを作成
$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
  echo $mysqli->connect_error;
  exit();
} else {
  $mysqli->set_charset("utf8");
}

$adminName = "tempolaly";

echo $userID;
$sql = "INSERT INTO adminUser VALUES ('$userID','$password','$adminName') ";
$mysqli->query($sql);

$sqla = "SELECT * FROM adminUser";
$result = $mysqli->query($sqla);
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
$a = "true";
// }else{
//   $a = "false";
// }
// }



//$userID = $_POST["userID"];
//$password = $_POST["password"];
$dm = "";
$a = true;
$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
