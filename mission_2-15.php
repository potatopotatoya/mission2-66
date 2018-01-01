<!DOCTYPE html>
<html lang = "ja">
<head>
<title>keiziban</title>
</head>

<body>
<!--タイトルを目立たせる-->
<p>
<h3>mission2-6</h3>
</p>

<?php
header('Content-Type: text/html; charset = UTF-8');
//mysql接続情報、テーブル名はpotatoでid,name,comment,password,timeで事前に作成
$dsn = 'mysql:dbname=co_627_it_99sv_coco_com;host=localhost';
$user = 'co-627.it.99sv-c';
$password = 'ub7Vcy4';
$pdo = new PDO($dsn,$user,$password);

//編集番号を受け取る
$h = $_POST["hen"];
//削除番号を受け取る,なにか入ってたら表示
$k = $_POST["kesu"];

//hiddenのポストを受け取る
$hk = $_POST["hk"];
$hh = $_POST["hh"];

//編集のやつで使う変数を指定
$hnum = NULL;
$hname = NULL;
$hcomment = NULL;
$vhh = $_POST["vhh"];

//パスワード
$pas = $_POST["pas"];
$word = $_POST["word"];

//時間の変数を作ってstringで全部の情報入力
$timestamp = time();
$t=date("Y/m/d/A/H/i/s", $timestamp);

//入力内容
$name = $_POST["namae"];
$comment = $_POST["komento"];

//テーブル作成
$sql = "CREATE TABLE potatos"
."("
."id INT PRIMARY KEY AUTO_INCREMENT,"
. "name CHAR(32),"
."comment TEXT,"
. "password TEXT,"
. "time DATETIME"
.");";
$stmt = $pdo->query($sql);

//ファイルに内容を書き込む
//ifで名前、コメントに内容がある時のみ書き込む
//ここでinsertでテーブルに情報入力
if (!empty($name) && !empty($comment) && !empty($pas) && empty($vhh)){
	$sql = $pdo ->prepare("INSERT INTO potatos(name, comment, password, time) VALUES(:name,:comment, :pas, :time);");
	$sql -> bindParam(':name',$name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':pas', $pas, PDO::PARAM_STR);
	$sql -> bindParam(':time', $t, PDO::PARAM_STR);
	$sql -> execute();
}

//tableでパスワードが一致するときに消すか編集するためにいろいろやるのを作る
$sql = 'SELECT*FROM potatos;';
$results = $pdo -> query($sql); 
foreach($results as $row){
	//まず削除
	if($word == $row['password'] && $hk == $row['id']){
		$sql = "delete from potatos where id = '$hk';";
		$result = $pdo->query($sql);
	//編集番号を取得
	}elseif($word == $row['password'] && $hh == $row['id']){
		$hnum = $hh;
		$hname = $row['name'];
		$hcomment = $row['comment'];
	}elseif(!empty($name) && !empty($comment) && !empty($pas) && $vhh == $row['id']){
		$sql = "update potatos set name = '$name',comment = '$comment',password = '$pas', time = '$t' where id = '$vhh';";
		$result = $pdo->query($sql);
	}
}
?>

<!--入力フォームpas付き-->
<form action = "" method = "post">
<p> 名前;<input type = "text" name = "namae"  value = "<?php echo $hname; ?>" > </p>
<p> コメント;<input type = "text" name = "komento" value = "<?php echo $hcomment; ?>" ></p>
<p> パスワード；<input type = "text" name = "pas"></p>
<p> <input type = "submit" value = "送信"></p>
<p> <input type = "hidden" name = "vhh" value = "<?php echo $hnum; ?>" ></p>
</form>

<!--削除フォーム-->
<form action = "" method = "post">
<!--phpのif文を利用して、フォームを変える-->
<p>
<?php if(empty($k)) : ?>
<?php echo "削除対象番号：<input type = 'text' name = 'kesu' >"; ?>
<?php else: ?>
<?php echo "パスワード：<input type = 'text' name = 'word'>"; ?>
<?php echo "<input type = 'hidden' name = 'hk' value = '$k'>"; ?>
<?php endif; ?>
</p>
<p> <input type = "submit" value = "削除"></p>
</form>

<!--編集フォーム-->
<form action = "" method = "post">
<!--phpのif文を利用して、フォームを変える-->
<p>
<?php if(empty($h)) : ?>
<?php echo "編集対象番号：<input type = 'text' name = 'hen' >"; ?>
<?php else: ?>
<?php echo "パスワード：<input type = 'text' name = 'word'>"; ?>
<?php echo "<input type = 'hidden' name = 'hh' value = '$h'>"; ?>
<?php endif; ?>
</p>
<p> <input type = "submit" value = "編集"></p>
</form>

<?php
//tableの内容を表示
$sql = 'SELECT*FROM potatos;';
$resultss = $pdo -> query($sql); 
foreach($resultss as $row){
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['password'].',';
	echo $row['time'].'<br>';
}
?>

</body>
</html>