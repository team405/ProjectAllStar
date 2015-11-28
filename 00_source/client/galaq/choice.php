<?php
if(isset($_POST["choice"])){
	//出力バッファリングを開始
	ob_start();
	//rank.phpを読み込む
	require ("../../server/choice.php");
	//$contents = ob_get_contents();
	//出力バッファリングを終了
	ob_end_clean();
	echo $_POST["choice"]."を回答しました。<br /><br />";
}
$hiddenInfo = '
<input type="hidden" name="userNumber" value="'.$_POST["userNumber"].'">
<input type="hidden" name="userName" value="'.$_POST["userName"].'">
<input type="hidden" name="contentID" value="'.$_POST["contentID"].'">
';
echo '
回答時は以下のボタンを選択してください
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
<input type="submit" value="'.($count+1).'">
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