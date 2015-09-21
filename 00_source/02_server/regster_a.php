<!DOCTYPE html>
<head>
<html lang="ja">
<meta charset="UTF-8">
<title>SmaQ - ログインページ</title>
</head>
<body>
<?php
    // 受け取った情報をfileに書き込む
function write($firstname,$lastname,$userID, $password) {
    $regster = "$firstname,$lastname,$userID, $password" . PHP_EOL;
    file_put_contents("admin_user.csv.", $regster);
}

//受け取りうんぬんは後ほどアップデート予定 $_POST
$json = file_get_contents("php://input");
$data = json_decode($json, true);
//ここまで

$firstname = $data["firstname"];
$lastname = $data["lastname"];
$userID = $data["userID"];
$password = $data["password"];
$a = write($firstname,$lastname,$userID, $password);
$b = json_encode(array('result' => $a, 'userID' => $userID));
//header('Content-Type: text/javascript; charset=utf-8');
echo $b;
?>
</body>
</html>
