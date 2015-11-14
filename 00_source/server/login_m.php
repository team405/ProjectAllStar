<?php
function getMaxVal(){
    $tmpVal=0;
    $lines = file("mobile_user.csv", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line){
      $user = explode(",", $line);
      if($tmpVal < (int)$user[0]){
        $tmpVal = (int)$user[0];
      }
    }
    return $tmpVal;
}
function userEntry($userName,$password) {
    $userNum = getMaxVal() +1 ;
    $line = $userNum.",".$userName.",".$password. PHP_EOL;
    file_put_contents("mobile_user.csv", $line, FILE_APPEND);
    return $userNum;
}
function userCheck($userName, $password) {
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
}

if($_SERVER["REQUEST_METHOD"] != "POST"){
   $userName = $_GET["userName"];
   $password = $_GET["password"];
}else {
   $userName = $_POST["userName"];
   $password = $_POST["password"];
}

//ユーザ名が入力されているかどうかをチェックして、あればtrueにする
if ($userName !== "" && $password !== "") {
  //ユーザチェック関数実行
  //ユーザがないため新規ユーザとして登録(true)
  if(userCheck($userName,$password) === 0){
    $a = true;
    $userNum = userEntry($userName,$password);
    $dm = "NewEntry";
  //ユーザがあるが名前がすでに使われている(false)
  }else if (userCheck($userName,$password) === 999999){
    $a = false;
    $userNum = userCheck($userName,$password);
    $dm = "already exists";
  //ユーザがある、パスワード一致のためリダイレクトとする(true)
  }else{
    $a = true;
    $userNum = userCheck($userName,$password);
    $dm = "redirect";
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
