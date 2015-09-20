<?php
function login($userID, $password) {

    // file関数はファイル全体を読み込んで配列に格納する
    $lines = file("user.csv", FILE_IGNORE_NEW_LINES);
    foreach ($lines as $line) {
        $user = explode(",", $line);
        if (？？？) {
            // ログインOK
            return true;
        }
    }
    return false;
}

$userID = $_POST["userID"];
$password = $_POST["password"];

if (？？？) {
    // セッションを開始
    session_start();
    // セッションにユーザIDを保存
    $_SESSION["userID"] = $userID;

    // ログイン成功 menu.phpへリダイレクト
    header("Location: menu.php");
}else{
    // ログイン失敗 login.phpへリダイレクト
    header("Location: login.php");
}