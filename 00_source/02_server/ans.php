<?
if($_SERVER["REQUEST_METHOD"] != "POST"){
   $userID = $_GET["userID"];
   $contentID = $_GET["contentID"];
   $quesID = $_GET["quesID"];
}else {
   $userID = $_POST["userID"];
   $contentID = $_POST["contentID"];
   $quesID = $_POST["quesID"];
}

$choice = array(0, 0, 0, 0);
//各選択肢毎の人数。初期値は全部0

$fp = fopen('/data/'.$userID.'/'.$contentID.'/answer.csv', "r")

while($oneanswer = fgetcsv($fp)){
	//$oneanswer 1行ごとにanswer.csvを格納

	if($oneanswer[2] - $starttimestamp < $quesSec){
		//$oneanswer[2]はモバイルが回答したタイムスタンプ

		$choice($oneanswer[1])++;
		//$oneanwer[1]はモバイルが回答した選択肢
	}
}

fclose($fp);


if ($userID !== "" && $contentID !== "" && $quesID !== "" ) {

  $filename = "data/".$userID.'/'.$contentID.'/'.$quesID.'/'.'config.ini'; 
  $fileData = file_get_contents($filename);
  $decode = json_decode($fileData, true);

  $result = "true";

} else{
  $resultDesc="fuck";
}

$b = json_encode(array('correctID' => $decode['correctNumber'], 'ansText' => $decode['ansText'], 'ansSum' => $choice), 'result' => $result, 'resultdesc' => $resultDesc);
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo $b;
?>