<!--insertを使ってデータを入力-->
<?php
header('Content-Type: text/html; charset = UTF-8');
$dsn = 'mysql:dbname=co_627_it_99sv_coco_com;host=localhost';
$user = 'co-627.it.99sv-c';
$password = 'ub7Vcy4';
$pdo = new PDO($dsn,$user,$password);
$sql = $pdo ->prepare("INSERT INTO tennis(id, name, comment) VALUES('1',:name,:comment);");
$sql -> bindParam(':name',$name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$name = '名前';
$comment = 'コメント';
$sql -> execute();
?>