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

$file = "kadai_2-6r.txt";

//テキストファイルを配列に入れる
$tiring = file($file, FILE_IGNORE_NEW_LINES);

//ファイルを開く（追記⇒上書き）
$fp=fopen("kadai_2-6r.txt","w");

//時間の変数を作ってstringで全部の情報入力
$timestamp = time();
$t=date("Y/m/d/A/H/i/s", $timestamp);

//maxnumberを指定
$maxnumber=0;

//コメント編集の場合の変数newstr
$newstr = $vhh."|".$_POST["namae"]."|".$_POST["komento"]."|".$pas."|".$t;

//fileの内容を書き込む(パスワードが入っているとき、いないときでかえる。入っていなかったらコピーするだけ)
for ($b = 0; $b < count($tiring); ++$b){
	$c = explode("|", $tiring[$b]);
	if($word == $c[3]){
		if($c[0] == $hk){
			echo $hk."は削除されました<br/>\n";
		}elseif($c[0] == $hh){
			fwrite($fp, $tiring[$b]."\n");
			$hnum = $c[0];
			$hname = $c[1];
			$hcomment = $c[2];
		}else{
			fwrite($fp, $tiring[$b]."\n");
			$maxnumber = $c[0];
		}
	}else{
		if($c[0] == $vhh){
			fwrite($fp, $newstr."\n");
		}else{
			fwrite($fp, $tiring[$b]."\n");
			$maxnumber = $c[0];
		}
	}
}

//新しい投稿番号を取得
$newnumber = $maxnumber +1;

$str = $newnumber."|".$_POST["namae"]."|".$_POST["komento"]."|".$pas."|".$t;

//ファイルに内容を書き込む
//ifで名前、コメントに内容がある時のみ書き込む
if (!empty($_POST["namae"]) && !empty($_POST["komento"]) && !empty($pas) && empty($vhh)){
	fwrite($fp, $str);
}

//ファイルを閉じる
fclose($fp);
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
header('Content-Type: text/html; charset = UTF-8');

//新しくファイルを定義
$newf = file("kadai_2-6r.txt", FILE_IGNORE_NEW_LINES);

//編集したときの記入内容newstrg
$newstrg=explode("|", $newstr);

//foreach, explode, echoでそれぞれ表示
for ($a = 0; $a < count($newf); ++$a){
	$tired = explode("|", $newf[$a]);
	if($tired[3] == $word){
		if($tired[0] != $hk and $newf[0] != $hh){
			echo ($tired[0]."番, 氏名:".$tired[1]."\n"."コメント:".$tired[2]."\n"."投稿時期"."$tired[4]"."<br/>\n");
		}else{
			echo ($tired[0]."番, 氏名:".$tired[1]."\n"."コメント:".$tired[2]."\n"."投稿時期"."$tired[4]"."<br/>\n");
		}
	}else{
		if($newf[0] == $vhh){
			echo ($newstrg[0]."番, 氏名:".$newstrg[1]."\n"."コメント:".$newstrg[2]."\n"."投稿時期"."$newstrg[4]"."<br/>\n");
		}else{
			echo ($tired[0]."番, 氏名:".$tired[1]."\n"."コメント:".$tired[2]."\n"."投稿時期"."$tired[4]"."<br/>\n");
		}
	}
}
?>

</body>
</html>
