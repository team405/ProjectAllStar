<?php

if($_SERVER["REQUEST_METHOD"] != "POST"){
  $userID = $_GET["userID"];
  $password = $_GET["password"];
  $contentID = $_GET["contentID"];
  $preKind = $_GET["preKind"];
  $preText = $_GET["preText"];
  $quesKind = $_GET["choiceKind"];
  $quesText = $_GET["quesText"];
  $quesSec = $_GET["quesSec"];
  $correctNum = $_GET["correctNum"];
  $demo =  $_GET["demo"];
     if($quesKind == "text"){
    $ansText1 = $_GET["ansText1"];
    $ansText2 = $_GET["ansText2"];
    $ansText3 = $_GET["ansText3"];
    $ansText4 = $_GET["ansText4"];
    $correctText1 = "";
    $correctText2 = "";
    $correctText3 = "";
    $correctText4 = "";
}
     if($quesKind == "picture"){
    $correctText1 = $_GET["choiceText1"];
    $correctText2 = $_GET["choiceText2"];
    $correctText3 = $_GET["choiceText3"];
    $correctText4 = $_GET["choiceText4"];
    $ansText1 = "";
    $ansText2 = "";
    $ansText3 = "";
    $ansText4 = "";
}
//  $file = $_FILES['titlePic']['name'];
}else {
  $userID = $_POST["userID"];
  $password = $_POST["password"];
  $contentID = $_POST["contentID"];
  $preKind = $_POST["preKind"];
  $preText = $_POST["preText"];
  $quesKind = $_POST["choiceKind"];
  $quesText = $_POST["quesText"];
  $quesSec = $_POST["quesSec"];
  $correctNum = $_POST["correctNum"];
  $demo =  $_POST["demo"];
     if($quesKind == "text"){
    $ansText1 = $_POST["ansText1"];
    $ansText2 = $_POST["ansText2"];
    $ansText3 = $_POST["ansText3"];
    $ansText4 = $_POST["ansText4"];
    $correctText1 = "";
    $correctText2 = "";
    $correctText3 = "";
    $correctText4 = "";
}
     if($quesKind == "picture"){
    $correctText1 = $_POST["choiceText1"];
    $correctText2 = $_POST["choiceText2"];
    $correctText3 = $_POST["choiceText3"];
    $correctText4 = $_POST["choiceText4"];
    $ansText1 = "";
    $ansText2 = "";
    $ansText3 = "";
    $ansText4 = "";
}
//  $file = $_FILES['titlePic']['name'];
}

//NULLだとエラー吐くかも
$startTimeStamp = "";
$remove = 0;

//quesを作る
    $mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
    if ($mysqli->connect_error) {
        echo $mysqli->connect_error;
        exit();
    } else {
        $mysqli->set_charset("utf8");
    }

//quesNum発番
    $sql = "SELECT * FROM question";
    $result = $mysqli->query($sql);
    $quesNum = $result->num_rows;
    $result->close();
    //questionテーブルのcontentNameとquesLinNumは消去している想定。
    $sql = "INSERT INTO question VALUES('$userID','$contentID','$quesNum','$preKind','$preText','$quesKind','$quesText','$quesSec','$ansText1','$ansText2','$ansText3','$ansText4','$correctNum','$correctText1','$correctText2','$correctText3','$correctText4','$startTimeStamp','$demo',$remove)";
    $mysqli->query($sql);
    echo $quesKind;

$path = "data/$userID/$contentID/$quesNum";
//ディレクトリ作成
mkdir($path,0777);

switch ($preKind) {
//    case 'text':
//    $sql = "UPDATE quesiton preText = '$preText' where quesNum = '$quesNum'";
//    $mysqli->query($sql);
//        break;

    case 'picture':
        $preText = "以下の画像を御覧ください";
        $sql = "UPDATE question SET preText = '$preText' WHERE quesNum = '$quesNum'";
        $mysqli->query($sql);
        $file = $_FILES['prePic']['name'];//もしかしたらこれいらんかも
        //画面側から送られてきたファイルを保存
        if(is_uploaded_file($_FILES['prePic']['tmp_name'])){
        //一時ファイルを保存ファイルにコピーできたか
        if(move_uploaded_file($_FILES['prePic']['tmp_name'],"$path"."/pre.jpg")){
            echo "uploaded";//正常
        }else{
            echo "error while saving.";//コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
        }
        }else{
        echo "file not uploaded.";//そもそもファイルが来ていない。
        }
        break;

    case 'intro':
        $preText = "次の音楽をお聴きください";
        $sql = "UPDATE quesiton preText = '$preText' where quesNum = '$quesNum'";
        $mysqli->query($sql);
        $file = $_FILES['preIntro']['name'];
        //画面側から送られてきたファイルを保存
        if(is_uploaded_file($_FILES['preIntro']['tmp_name'])){
        //一時ファイルを保存ファイルにコピーできたか
        if(move_uploaded_file($_FILES['preIntro']['tmp_name'],"$path"."/intro.mp3")){
            echo "uploaded";//正常
        }else{
            echo "error while saving.";//コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
        }
        }else{
        echo "file not uploaded.";//そもそもファイルが来ていない。
        }
        break;

    case 'movie':
        $preText = "以下の動画をご覧ください";
        $sql = "UPDATE quesiton preText = '$preText' where quesNum = '$quesNum'";
        $mysqli->query($sql);
        $file = $_FILES['preMovie']['name'];
        //画面側から送られてきたファイルを保存
        if(is_uploaded_file($_FILES['preMovie']['tmp_name'])){
        //一時ファイルを保存ファイルにコピーできたか
        if(move_uploaded_file($_FILES['preMovie']['tmp_name'],"$path"."/intro.mp4")){
            echo "uploaded";//正常
        }else{
            echo "error while saving.";//コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
        }
        }else{
        echo "file not uploaded.";//そもそもファイルが来ていない。
        }
        break;
}
    $mysqli->close();

switch ($quesKind) {
//しょうみif文でいい。textの場合は特に処理なしのはず。
    case 'text':
//    $sql = "UPDATE quesiton preText = '$preText' where quesNum = '$quesNum'";
//    $mysqli->query($sql);
        break;

    case 'picture':
        $file = $_FILES['choicePic1']['name'];
        if(is_uploaded_file($_FILES['choicePic1']['tmp_name'])){
        if(move_uploaded_file($_FILES['choicePic1']['tmp_name'],"$path"."/choicePic0.jpg")){
            echo "uploaded";
        }else{
            echo "error while saving.";//コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
        }
        }else{
        echo "file not uploaded.choicePic1";//そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic2']['name'];
        if(is_uploaded_file($_FILES['choicePic2']['tmp_name'])){
        if(move_uploaded_file($_FILES['choicePic2']['tmp_name'],"$path"."/choicePic1.jpg")){
            echo "uploaded";
        }else{
            echo "error while saving.";//コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
        }
        }else{
        echo "file not uploaded.choicePic2";//そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic3']['name'];
        if(is_uploaded_file($_FILES['choicePic3']['tmp_name'])){
        if(move_uploaded_file($_FILES['choicePic3']['tmp_name'],"$path"."/choicePic2.jpg")){
            echo "uploaded";
        }else{
            echo "error while saving.";//コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
        }
        }else{
        echo "file not uploaded.choicePic3";//そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic4']['name'];
        if(is_uploaded_file($_FILES['choicePic4']['tmp_name'])){
        if(move_uploaded_file($_FILES['choicePic4']['tmp_name'],"$path"."/choicePic3.jpg")){
            echo "uploaded";
        }else{
            echo "error while saving.";//コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
        }
        }else{
        echo "file not uploaded.choicePic4";//そもそもファイルが来ていない。
        }
        break;
}

?>