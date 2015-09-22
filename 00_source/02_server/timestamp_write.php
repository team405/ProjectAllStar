<?php
// 受け取った情報をfileに書き込む
function quesstart($contentID,$quesID) {
    if($content !="" && $$quesID != ""){
        $now = microtime(true);
        $write = $quesID "," . $now . PHP_EOL;
        file_put_contents("data/aaa/$contentID/timestmp.csv", $write,FILE_APPEND);
        return true;
    }
    return false;
}
?>
