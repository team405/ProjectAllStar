<?php
if(isset($choice)) require("../../server/choice.php");
$hiddenInfo = '
<input type="hidden" name "userNumber" value="'.$userNumber.'">
<input type="hidden" name "userName" value="'.$userName.'">
<input type="hidden" name "contentID" value="'.$contentID.'">
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