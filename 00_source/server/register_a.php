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
$dm = "";


$sqla = "SELECT * FROM adminUser WHERE '$userID' = adminUid";
$result = $mysqli->query($sqla);
$adminuser = $result->num_rows;
if($adminuser != 0 ){
 $dm = "User Already";
 $a = false;
}else{
  $sql = "INSERT INTO adminUser VALUES ('$userID','$password','$adminName') ";
  $mysqli->query($sql);
  $a= true;
  $path = "data/$userID";
//ディレクトリ作成
  mkdir($path,0777);
}


// $sqla = "SELECT * FROM adminUser";
// $result = $mysqli->query($sqla);
// $account = $result->num_rows;
// $result->close();
// //処理書き終わったよ
//DB接続を閉じる
$mysqli->close();



//        $regster = "$userID,$password" . PHP_EOL;
//        file_put_contents("admin_user.csv", $regster, FILE_APPEND);
// }else{
//   $a = "false";
// }
// }



//$userID = $_POST["userID"];
//$password = $_POST["password"];

$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
