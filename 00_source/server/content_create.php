<?php

if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"]; //浅井追記
  $contentName = $_GET["contentName"];
  $file = $_FILES['titlePic']['name'];
}else {
  $userID = $_POST["userID"]; //浅井追記
  $contentName = $_POST["contentName"];
  $file = $_FILES['titlePic']['name'];
}

$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}

$quesLinNum = 0;
$a = false;

$sql = "SELECT * FROM content";
$result = $mysqli->query($sql);
$contentID = $result->num_rows;
$playTimeStamp = 0;
$result->close();
$sql = "INSERT INTO content VALUES('$userID','$contentID','$contentName','$quesLinNum', '$playTimeStamp')";
if($mysqli->query($sql)){
    $a = true;
    $dm = "DB INSERT Sccess!";
}
// 結果セットを閉じる
//処理書き終わったよ

// DB接続を閉じる
$mysqli->close();

$path = "data/$userID/$contentID";

//ディレクトリ作成
mkdir($path,0777);


//画面側から送られてきた画像を保存
if(is_uploaded_file($_FILES['titlePic']['tmp_name'])){

        //一字ファイルを保存ファイルにコピーできたか
    if(move_uploaded_file($_FILES['titlePic']['tmp_name'],"$path"."/title.jpg")){

            //正常
        $dm = "uploaded";

    }else{

            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
        $dm = "error while saving.";
    }

}else{

        //そもそもファイルが来ていない。
    $dm = "file not uploaded.";

}

$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;

?>
