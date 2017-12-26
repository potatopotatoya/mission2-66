<!--selectでテーブルの中身を表示-->
<?php
header('Content-Type: text/html; charset = UTF-8');
$dsn = 'mysql:dbname=co_627_it_99sv_coco_com;host=localhost';
$user = 'co-627.it.99sv-c';
$password = 'ub7Vcy4';
$pdo = new PDO($dsn,$user,$password);

$sqp = 'SELECT*FROM tennis;';
$results = $pdo -> query($sql);

foreach($results as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].'<br>';
}
?>
