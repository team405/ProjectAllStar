<?php
// mysqli�N���X�̃I�u�W�F�N�g���쐬
$mysqli = new mysqli("localhost", "dbsmaq", "ufbn516", "dbsmaq");
if ($mysqli->connect_error) {
    echo $mysqli->connect_error;
    exit();
} else {
    $mysqli->set_charset("utf8");
}

//�����ɏ���������
$sql = "SELECT * FROM adminUser";
if ($result = $mysqli->query($sql)) {
    // �A�z�z����擾
    while ($row = $result->fetch_assoc()) {
        echo $row["adminUid"] .",". $row["adminPass"] . "<br>";
    }
    // ���ʃZ�b�g�����
    $result->close();
}
//���������I�������

// DB�ڑ������
$mysqli->close();
?>