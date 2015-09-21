<?php
function login($userID, $password) {
    // file関数はファイル全体を読み込んで配列に格納する
    $lines = file("admin_user.csv", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $user = explode(",", $line);
        if ($user[0] === $userID && $user[1] === $password) {
            // ログインOK
            return true;
        }
    }
    return false;
}

$userID = $_POST["userID"]; //浅井追記
$password = $_POST["password"];
$a = login($userID, $password);
if($a){
  $dm ="";
}else{
  $dm ="fuck";
}
//userIDはゆくゆくはuserNameに変更by kj
$b = json_encode(array('result' => $a, 'userID' => $userID, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>