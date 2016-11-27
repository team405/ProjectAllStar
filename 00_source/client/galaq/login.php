<?php
$loginForm = '
<form action="index.php" method="post">
お名前:<br /><input type="text" name="userName" size="14" maxlength="12" /> <br/>
<font size="2" color="gray">例：スマキュー太郎</font><br /><br />
生月日:<br /><input type="text" name="password" size="14" maxlength="12" /> <br/>
<font size="2" color="gray">例：0402</font><br /><br />
コンテンツID:<br /><input type="number" step="1" name="contentID" size="14" maxlength="12" /> <br/>
<font size="2" color="gray">例：9</font><br /><br />
<input type="hidden" name="status" value="login" />
<input type="submit">
</form>
<br><br><a href="https://www.facebook.com/team405/">Team405</a>
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