<?php

function entry($userID) {
    $line = $userID. PHP_EOL;
    file_put_contents("user.csv", $line, FILE_APPEND);
}

$userID = $_POST["userID"];

if ($userID !== "") {
    // entry�֐����Ăяo��
    entry($userID);
    // �Z�b�V�������J�n
    session_start();
    // �Z�b�V�����Ƀ��[�UID��ۑ�
    $_SESSION["userID"] = $userID ;   

    // ���O�C������ choice.html�փ��_�C���N�g
    header("location: ./choice.html");
} else {
    // �o�^���s login.php�փ��_�C���N�g
    header("location: ./login.html");
}
?>