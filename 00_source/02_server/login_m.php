<?php

function entry($userID) {
    $line = $userID. PHP_EOL;
    file_put_contents("user.csv", $line, FILE_APPEND);
}

$userID = $_POST["userID"];

if ($userID !== "") {
    // entry関数を呼び出す
    entry($userID);
    // セッションを開始
    session_start();
    // セッションにユーザIDを保存
    $_SESSION["userID"] = $userID ;   

    // ログイン成功 choice.htmlへリダイレクト
    header("location: ./choice.html");
} else {
    // 登録失敗 login.phpへリダイレクト
    header("location: ./login.html");
}
?>