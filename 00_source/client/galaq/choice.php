<?php
if(isset($_POST["choice"])){
	//出力バッファリングを開始
	ob_start();
	//rank.phpを読み込む
	include ("../../server/choice.php");
	header('Content-Type:text/html; charset=UTF-8');
	$contents = ob_get_contents();
	//出力バッファリングを終了
	ob_end_clean();
	//結果を$jsonにいれる
	$json = json_decode($contents, true);
	//後はその$jsonをつかって良い
	echo '<font size="7" color="red">'.($_POST["choice"]+1).'</font> を送信しました。<br />';
	echo 'ようこそ '.($_POST["userName"]).' さん<br />';
}


$hiddenInfo = '
<input type="hidden" name="userNumber" value="'.$_POST["userNumber"].'">
<input type="hidden" name="userName" value="'.$_POST["userName"].'">
<input type="hidden" name="contentID" value="'.$_POST["contentID"].'">
';
echo '
以下のボタンから回答してください。<br />
ダイヤルキーでも送信できます。
';
echo '<br />
<table>
<tr>
';
for ($count = 0; $count < 4; $count++){
	echo '<td>
<form name="form'.$count.'" action="index.php" method="post">';
	echo $hiddenInfo;
	echo '<input type="hidden" name="choice" value="'.$count.'" />
<input style="font-size:30px;" size="1" type="submit" value="'.($count+1).'" accesskey="'.($count+1).'">
<input type="hidden" name="status" value="choice" />
</form>
</td>
';
	if($count==1) echo'
</tr><tr>
';
}
echo '</table>';
echo '<br />';
echo '
<a href="" onclick="document.form1.submit();return false;" > ログオフ</a>
<form name="form1" action="index.php" method="POST">
<input type=hidden name="status" value="logoff">
</form>
';
?>