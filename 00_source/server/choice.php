<?php
// 受け取った情報をDBに書き込む
function write($userNumber,$choice,$contentID) {
  if($userNumber != ""){
    $now = microtime(true);

    $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
    if ($mysqli->connect_error) {
      echo $mysqli->connect_error;
      exit();
    } else {
      $mysqli->set_charset("utf8");
    }

//ここに処理書くよ
    $sql = "INSERT INTO ansTime VALUES('$contentID','$userNumber','$choice','$now')";
    if ( $mysqli->query($sql)) {
    // 結果セットを閉じる
    }
//処理書き終わったよ

// DB接続を閉じる
    $mysqli->close();
    $result = "true";
  } else{
    $resultDesc="fuck";
  }

  return true;
}

if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userNumber = $_GET["userNumber"];
  $choice = $_GET["choice"];
  $contentID = $_GET["contentID"];
}else {
  $userNumber = $_POST["userNumber"]; //浅井追記
  $choice = $_POST["choice"];
  $contentID = $_POST["contentID"];
}

//$userID = $_POST["userID"];
//$password = $_POST["password"];
$dm = "";
$a = write($userNumber,$choice,$contentID);
$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
