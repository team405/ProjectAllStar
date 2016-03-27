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
  $quesID = $_GET["quesID"];
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
    $ansText1 = $_POST["choiceText1"];
    $ansText2 = $_POST["choiceText2"];
    $ansText3 = $_POST["choiceText3"];
    $ansText4 = $_POST["choiceText4"];
    $correctText1 = $_POST["ansText1"];
    $correctText2 = $_POST["ansText2"];
    $correctText3 = $_POST["ansText3"];
    $correctText4 = $_POST["ansText4"];
  }
  if($quesKind == "picture"){
    $correctText1 = $_POST["ansText1"];
    $correctText2 = $_POST["ansText2"];
    $correctText3 = $_POST["ansText3"];
    $correctText4 = $_POST["ansText4"];
    $ansText1 = $_POST["choiceText1"];
    $ansText2 = $_POST["choiceText2"];
    $ansText3 = $_POST["choiceText3"];
    $ansText4 = $_POST["choiceText4"];
  }
  $quesID = $_POST["quesID"];
//  $file = $_FILES['titlePic']['name'];
}

//NULLだとエラー吐くかも
$startTimeStamp = "";
$remove = 0;
$a = false;
$updKind = "";

if(!isset($_GET["quesID"]) && !isset($_POST["quesID"])){
    $updKind = "create";
}else{
    $updKind = "update";
}

//quesを作る
$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}

if ($updKind == "create"){
    //quesNum発番
    $sql = "SELECT * FROM question WHERE contentID = '$contentID'";
    $result = $mysqli->query($sql);
    $quesNum = $result->num_rows;
    $result->close();
        //questionテーブルのcontentNameとquesLinNumは消去している想定。
    $sql = "INSERT INTO question VALUES('$userID','$contentID','$quesNum','$preKind','$preText','$quesKind','$quesText','$quesSec','$ansText1','$ansText2','$ansText3','$ansText4','$correctNum','$correctText1','$correctText2','$correctText3','$correctText4','$startTimeStamp',b'$demo',$remove)";
    if($mysqli->query($sql)){
        $a = true;
        $dm = "Question Create Succes!";
    }
    //quesLinNum発番
    $sql = "SELECT * FROM question WHERE contentID = '$contentID'";
    $result = $mysqli->query($sql);
    $quesLinNum = $result->num_rows;
    $result->close();
    $sql = "UPDATE content SET quesLinNum = '$quesLinNum' WHERE contentID = '$contentID'";
    $mysqli->query($sql);

    $mysqli->close();
    $path = "data/$userID/$contentID/$quesNum";
    //ディレクトリ作成
    mkdir($path,0777);

    switch ($preKind) {
    //    case 'text':
    //    $sql = "UPDATE quesiton preText = '$preText' where quesNum = '$quesNum'";
    //    $mysqli->query($sql);
    //        break;

        case 'picture':
            // $preText = "以下の画像を御覧ください";
            // $sql = "UPDATE question SET preText = '$preText' WHERE quesNum = '$quesNum'";
            // $mysqli->query($sql);
            $file = $_FILES['prePic']['name'];//もしかしたらこれいらんかも
            //画面側から送られてきたファイルを保存
            if(is_uploaded_file($_FILES['prePic']['tmp_name'])){
            //一時ファイルを保存ファイルにコピーできたか
                if(move_uploaded_file($_FILES['prePic']['tmp_name'],"$path"."/pre.jpg")){
                $a = true;//正常
                $dm = "Question Create Success!!";
            }else{
    //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
    //そもそもファイルが来ていない。
        }
        break;

        case 'intro':
            // $preText = "次の音楽をお聴きください";
            // $sql = "UPDATE quesiton preText = '$preText' where quesNum = '$quesNum'";
            // $mysqli->query($sql);
        $file = $_FILES['preIntro']['name'];
            //画面側から送られてきたファイルを保存
        if(is_uploaded_file($_FILES['preIntro']['tmp_name'])){
            //一時ファイルを保存ファイルにコピーできたか
            if(move_uploaded_file($_FILES['preIntro']['tmp_name'],"$path"."/intro.mp3")){
                $a = true;//正常
                $dm = "Question Create Success!!";
            }else{
                //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        break;

        case 'movie':
            // $preText = "以下の動画をご覧ください";
            // $sql = "UPDATE quesiton preText = '$preText' where quesNum = '$quesNum'";
            // $mysqli->query($sql);
        $file = $_FILES['preMovie']['name'];
            //画面側から送られてきたファイルを保存
        if(is_uploaded_file($_FILES['preMovie']['tmp_name'])){
            //一時ファイルを保存ファイルにコピーできたか
            if(move_uploaded_file($_FILES['preMovie']['tmp_name'],"$path"."/intro.mp4")){
                $a = true;//正常
                $dm = "Question Create Success!!";
    //正常
            }else{
            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        break;
    }


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
                $a = true;//正常
                $dm = "Question Create Success!!";
            }else{
                //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic2']['name'];
        if(is_uploaded_file($_FILES['choicePic2']['tmp_name'])){
            if(move_uploaded_file($_FILES['choicePic2']['tmp_name'],"$path"."/choicePic1.jpg")){

            }else{
            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic3']['name'];
        if(is_uploaded_file($_FILES['choicePic3']['tmp_name'])){
            if(move_uploaded_file($_FILES['choicePic3']['tmp_name'],"$path"."/choicePic2.jpg")){

            }else{
            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic4']['name'];
        if(is_uploaded_file($_FILES['choicePic4']['tmp_name'])){
            if(move_uploaded_file($_FILES['choicePic4']['tmp_name'],"$path"."/choicePic3.jpg")){

            }else{
            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            $dm = "file not uploaded.choicePic";//そもそもファイルが来ていない。
        }
        break;
    }
}else{
    //更新処理
    $sql = "
    UPDATE question 
    SET preKind  = '$preKind',
        preText  = '$preText',
        quesKind = '$quesKind',
        quesText = '$quesText',
        quesSec  = '$quesSec',
        ansText1 = '$ansText1',
        ansText2 = '$ansText2',
        ansText3 = '$ansText3',
        ansText4 = '$ansText4',
        correctNum = '$correctNum',
        correctText1 = '$correctText1',
        correctText2 = '$correctText2',
        correctText3 = '$correctText3',
        correctText4 = '$correctText4',
        demo         = '$demo',
        remove       = '$remove'
    WHERE adminUid = '$userID' and contentID = '$contentID' and quesNum = '$quesID'
    ";
    if($mysqli->query($sql)){
        $a = true;
        $dm = "Question Update Succes!";
    }
    $mysqli->query($sql);

    $mysqli->close();
    $path = "data/$userID/$contentID/$quesID";

    switch ($preKind) {
    //    case 'text':
    //    $sql = "UPDATE quesiton preText = '$preText' where quesID = '$quesID'";
    //    $mysqli->query($sql);
    //        break;

        case 'picture':
            // $preText = "以下の画像を御覧ください";
            // $sql = "UPDATE question SET preText = '$preText' WHERE quesID = '$quesID'";
            // $mysqli->query($sql);
            $file = $_FILES['prePic']['name'];//もしかしたらこれいらんかも
            //画面側から送られてきたファイルを保存
            if(is_uploaded_file($_FILES['prePic']['tmp_name'])){
            //一時ファイルを保存ファイルにコピーできたか
                if(move_uploaded_file($_FILES['prePic']['tmp_name'],"$path"."/pre.jpg")){
                $a = true;//正常
                $dm = "Question Update Success!!";
            }else{
    //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
    //そもそもファイルが来ていない。
        }
        break;

        case 'intro':
            // $preText = "次の音楽をお聴きください";
            // $sql = "UPDATE quesiton preText = '$preText' where quesID = '$quesID";
            // $mysqli->query($sql);
        $file = $_FILES['preIntro']['name'];
            //画面側から送られてきたファイルを保存
        if(is_uploaded_file($_FILES['preIntro']['tmp_name'])){
            //一時ファイルを保存ファイルにコピーできたか
            if(move_uploaded_file($_FILES['preIntro']['tmp_name'],"$path"."/intro.mp3")){
                $a = true;//正常
                $dm = "Question Update Success!!";
            }else{
                //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        break;

        case 'movie':
            // $preText = "以下の動画をご覧ください";
            // $sql = "UPDATE quesiton preText = '$preText' where quesID = '$quesID'";
            // $mysqli->query($sql);
        $file = $_FILES['preMovie']['name'];
            //画面側から送られてきたファイルを保存
        if(is_uploaded_file($_FILES['preMovie']['tmp_name'])){
            //一時ファイルを保存ファイルにコピーできたか
            if(move_uploaded_file($_FILES['preMovie']['tmp_name'],"$path"."/intro.mp4")){
                $a = true;//正常
                $dm = "Question Update Success!!";
    //正常
            }else{
            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        break;
    }


    switch ($quesKind) {
    //しょうみif文でいい。textの場合は特に処理なしのはず。
        case 'text':
    //    $sql = "UPDATE quesiton preText = '$preText' where quesID = '$quesID'";
    //    $mysqli->query($sql);
        break;

        case 'picture':
        $file = $_FILES['choicePic1']['name'];
        if(is_uploaded_file($_FILES['choicePic1']['tmp_name'])){
            if(move_uploaded_file($_FILES['choicePic1']['tmp_name'],"$path"."/choicePic0.jpg")){
                $a = true;//正常
                $dm = "Question Update Success!!";
            }else{
                //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic2']['name'];
        if(is_uploaded_file($_FILES['choicePic2']['tmp_name'])){
            if(move_uploaded_file($_FILES['choicePic2']['tmp_name'],"$path"."/choicePic1.jpg")){
                $a = true;//正常
                $dm = "Question Update Success!!";
            }else{
            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic3']['name'];
        if(is_uploaded_file($_FILES['choicePic3']['tmp_name'])){
            if(move_uploaded_file($_FILES['choicePic3']['tmp_name'],"$path"."/choicePic2.jpg")){
                $a = true;//正常
                $dm = "Question Update Success!!";
            }else{
            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        $file = $_FILES['choicePic4']['name'];
        if(is_uploaded_file($_FILES['choicePic4']['tmp_name'])){
            if(move_uploaded_file($_FILES['choicePic4']['tmp_name'],"$path"."/choicePic3.jpg")){
                $a = true;//正常
                $dm = "Question Update Success!!";
            }else{
            //コピーに失敗（だいたい、ディレクトリがないか、パーミッションエラー）
            }
        }else{
            //そもそもファイルが来ていない。
        }
        break;
    }
}

$b = json_encode(array('result' => $a, 'resultdesc' => $dm));
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
