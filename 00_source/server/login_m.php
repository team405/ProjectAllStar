<?php
//function getMaxVal(){
//    $tmpVal=0;
//    $lines = file("mobile_user.csv", FILE_IGNORE_NEW_LINES);
//    foreach ($lines as $line){
//      $user = explode(",", $line);
//      if($tmpVal < (int)$user[0]){
//        $tmpVal = (int)$user[0];
//      }
//    }
//    return $tmpVal;
//}
function userEntry($userName,$password,$contentID) {
    $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
    if ($mysqli->connect_error) {
        echo $mysqli->connect_error;
        exit();
    } else {
        $mysqli->set_charset("utf8");
    }

    $now = microtime(true);
    $sql = "SELECT * FROM mobileUser";
    $result = $mysqli->query($sql);
    $mobileUnum = $result->num_rows;
    $result->close();
    $sql = "INSERT INTO mobileUser VALUES('$mobileUnum','$contentID','$userName','$password',$now)";
    $mysqli->query($sql);
// 結果セットを閉じる
//処理書き終わったよ

// DB接続を閉じる
    $mysqli->close();
    return $mobileUnum;
/*
    $userNum = getMaxVal() +1 ;
    $line = $userNum.",".$userName.",".$password. PHP_EOL;
    file_put_contents("mobile_user.csv", $line, FILE_APPEND);
    return $userNum;
*/
}
function userCheck($userName, $password,$contentID) {
    $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
    if ($mysqli->connect_error) {
        echo $mysqli->connect_error;
        exit();
    } else {
        $mysqli->set_charset("utf8");
    }

    $sql = "SELECT * FROM mobileUser WHERE mobileName = '$userName' AND contentID = $contentID";
    $result = $mysqli->query($sql);
    if($row = $result->fetch_assoc()){
      if($row['mobilePass']==$password){
        return $row['mobileUnum'];
      }else{
        return "UnmatchPass";
      }
    }else{
      return "new";
    }
    $result->free();
}

// 結果セットを閉じる

/*
    // file関数はファイル全体を読み込んで配列に格納する
    $lines = file("mobile_user.csv", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $user = explode(",", $line);
        if($user[1] === $userName){
           if($user[2] === $password){
               return (int)$user[0];
           }else{
               return 999999;
           }
        }
    }
    return 0;
*/

if($_SERVER["REQUEST_METHOD"] != "POST"){
   $userName = $_GET["userName"];
   $password = $_GET["password"];
   $contentID = $_GET["contentID"];
}else {
   $userName = $_POST["userName"];
   $password = $_POST["password"];
   $contentID = $_POST["contentID"];
}

//ユーザ名が入力されているかどうかをチェックして、あればtrueにする
if ($userName !== "" && $password !== "" && $contentID !=="") {
  //ユーザチェック関数実行
$check = userCheck($userName,$password,$contentID);
  //ユーザがないため新規ユーザとして登録(true)
  if($check === "new"){
    $a = true;
    $userNum = userEntry($userName,$password,$contentID);
    $dm = "NewEntry";
  //ユーザがあるが名前,パスワードがすでに使われている(false)
  }else if ($check === "UnmatchPass"){
    $a = false;
    $dm = "Password Unmatch";
  //ユーザがある、パスワード一致のためリダイレクトとする(true)
  }else{
    $a = true;
    $userNum = $check;
    $dm = "redirect";
    $now = microtime(true);

    $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
    if ($mysqli->connect_error) {
        echo $mysqli->connect_error;
        exit();
    } else {
        $mysqli->set_charset("utf8");
    }


    $sql = "UPDATE mobileUser SET loginTimeStamp = $now WHERE mobileUnum = '$userNum'";
    $result = $mysqli->query($sql);
    $mysqli->close();
}
} else {
    $a = false;
    $userNum="";
    $dm = "Error";
}
$b = json_encode(array('userNumber' => $userNum, 'result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
