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

$userID = $_POST["userID"];
$password = $_POST["password"];
var $a = login($userID,$password);
//userIDはゆくゆくはuserNameに変更by kj
$b = array('result' => $a, 'userID' => $userID);
echo json_encode($b);
?>
