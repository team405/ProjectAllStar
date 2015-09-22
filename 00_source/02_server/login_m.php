<?php
function maxUserNumber(){
    $maxVal = 0;
    $lines = file("mobile_user.csv", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $user = explode(",", $line);
        $tmp_num = (int)$user[0];
        if($maxVal < $tmp_num){
            $maxVal = $tmp_num;
        }
    }
    return $maxVal;
}
function userEntry($userName,$password) {
    $userNum = maxUserNumber() + 1;
    $line = $userNum.",".$userName.",".$password. PHP_EOL;
    file_put_contents("mobile_user.csv", $line, FILE_APPEND);
    return $userNum;
}
function userCheck($userName,$password) {
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
    $dm = "This user already exists";
  //ユーザがある、パスワード一致のためリダイレクトとする(true)
  }else{
    $a = true;
    $userNum = userCheck($userName,$password);
    $dm = "redirect";
  }
} else {
    $a = false;
    $userNum="";
    $dm = "fuck";
}
$b = json_encode(array('userNumber' => $userNum, 'result' => $a, 'resultDesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
