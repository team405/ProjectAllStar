<?php
//処理内容は関数に！
function sampleFunction($var1, $ver2,,,) {

}

//$POST_["name"]的に、普通にPOSTとして受け取れる！
$var1 = $_POST[0];
$var2 = $_POST[1];

$dm = "dummy";

//処理を実行！
$a = sampleFuntion($var1, $var2,,,);
//出力させるためのJSONをつくるよ
$b = json_encode(array('userID' => $userID, 'result' => $a, 'resultDesc' => $dm));

//おまじないを唱えて、echoする。
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>
