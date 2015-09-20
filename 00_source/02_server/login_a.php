<?php
header("Content-Type: text/html; charset=UTF-8");
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
