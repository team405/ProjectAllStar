<?php
$loginForm = '
<form action="index.php" method="post">
お名前:<input type="text" name="userName" size="14" maxlength="12" /> <br />
パスワード:<input type="password" name="password" size="14" maxlength="12" /> <br />
コンテンツID:<input type="number" step="1" name="contentID" size="14" maxlength="12" /> <br />
<input type="hidden" name="status" value="login" />
<input type="submit">
</form>
';

if(!isset($_POST["status"])){
	echo "SmaQへようこそ<br /><br />";
	echo $loginForm;
}else if($_POST["status"] == "login"){
	//出力バッファリングを開始
	ob_start();
	//rank.phpを読み込む
	include ("../../server/login_m.php");
	header('Content-Type:text/html; charset=UTF-8');
	$contents = ob_get_contents();
	//出力バッファリングを終了
	ob_end_clean();
	//結果を$jsonにいれる
	$json = json_decode($contents, true);
	//後はその$jsonをつかって良い

	if($json["resultdesc"] == "NewEntry" || $json["resultdesc"] == "redirect"){
		//$userNumber = $json["userNumber"];
		$_POST["userNumber"] = $json["userNumber"];
		echo "ようこそ　$userName さん<br /><br />";
		require("choice.php");
	}else if($json["resultdesc"] == "Password Unmatch"){
		echo "パスワードが違います <br /><br />";
		echo $loginForm;
	}else{
		echo 'エラーが起きました<br />お手数ですが、再度ログイン画面からやり直してください。<br />';
		echo '
		<a href="index.php">ログイン画面へ</a>
		';
	}
}



?>