<?php
function login($userID, $password) {
    // file関数はファイル全体を読み込んで配列に格納する
//    $lines = file("admin_user.csv", FILE_IGNORE_NEW_LINES);
//    foreach ($lines as $line) {
// mysqliクラスのオブジェクトを作成
    $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
    if ($mysqli->connect_error) {
        echo $mysqli->connect_error;
        exit();
    } else {
        $mysqli->set_charset("utf8");
    }

    $sql = "SELECT adminPass FROM adminUser WHERE adminUid = '$userID'";
    if ( $result = $mysqli->query($sql)) {
        if($row = $result->fetch_assoc()){
            if($row['adminPass']==$password){
                return true;
            }
        }
        $result->free();
// 結果セットを閉じる

//        while( $row = $result->fetch_assoc() ) {
//            if ( $row['adminPass'] == $password ) {
 //               return true;
 //           }
 //       $result->free();
 //       }
// 結果セットを閉じる
    }
//処理書き終わったよ

// DB接続を閉じる
    $mysqli->close();

//        $user = explode(",", $line);
//        if ($user[0] === $userID && $user[1] === $password) {
            // ログインOK
//            return true;
    return false;
}

if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"];
  $password = $_GET["password"];
}else {
  $userID = $_POST["userID"]; //浅井追記
  $password = $_POST["password"];
}

$a = login($userID, $password);
if($a){
  $dm ="";
}else{
  $dm ="Error";
}
//userIDはゆくゆくはuserNameに変更by kj
$b = json_encode(array('result' => $a, 'userID' => $userID, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>