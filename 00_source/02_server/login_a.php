<?php
header("Content-Type: text/html; charset=UTF-8");
function login($userID, $password) {

    // file関数はファイル全体を読み込んで配列に格納する
@@ -13,10 +14,13 @@ function login($userID, $password) {
    return false;
}
$json = file_get_contents("php://input");
$data = json_decode($json, true);
$userID = $data["userID"];
$password = $data["password"];
$a = login($userID, $password);
//userIDはゆくゆくはuserNameに変更by kj
$b = json_encode(array('result' => $a, 'userID' => $userID));
//header('Content-Type: text/javascript; charset=utf-8');
echo $b;
?>
