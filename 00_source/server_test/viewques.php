<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
print '{"result":true,"resultdesc":"","ques":[{"demo":0,"preKind":"text","preText":"string","quesID":0,"quesText":"string","choiceKind":"text","choiceText":["a","b","c","d"],"ansText":["aa","bb","cc","dd"],"correctNum":0,"quesSec":10},{"demo":1,"preKind":"text","preText":"11string2","quesID":1,"quesText":"string2","choiceKind":"text","choiceText":["a2","b2","c2","d2"],"ansText":["aa2","bb2","cc2","dd2"],"correctNum":2,"quesSec":20}]}'
?>