<?php
/**
 * バリデーションに係わるカスタム例外クラスを定義する
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */
require_once '../../../news3/config.php';
require_once '../../../framework3/runfirst.php'; 


use framework3\common\ErrorFunc;

if (!empty($_POST)) {
try {

	//PDOException case
	$dsn = 'mysql:dbname=myvote5;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'sbc00';
	
	try {
		$dbh = new \PDO($dsn, $user, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
		// このテーブルが存在しないとして、このコードを実行すると E_WARNING レベルのエラーになります。例外にはなりません。

		$dbh->query("SELECT wrongcolumn FROM wrongtable"); #error
	//	$error = $dbh->errorInfo(); 間違った場所でthrowされるので実行されない。
	} catch (\PDOException $e) {
		echo 'Connection failed!';
        ErrorFunc::catchAfter($e);	
	}
	
	try {
		$dbh->query("SELECT wrongcolumn FROM wrongtable"); #error
	} catch (\PDOException $e) {
		echo 'Connection failed!';	
        ErrorFunc::catchAfter($e);	
	}	
	
} catch (\Throwable $e) {
echo 'catch throwable!';
	ErrorFunc::catchAfter($e);		
	
} 

if(defined('DBG') && !empty( $GLOBALS['exceptions'])){
print('print all exceptions str!');
print('<br/>');			
	ErrorFunc::dispAll();
			
}	

} else {			

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>電話番号、URL、メールアドレス用の入力フィールドを作りたい</title>
</head>
<body>
<form action="" method="post">
	<p>電話番号：<input type="tel" name="tel"></p>
	<p>メールアドレス：<input type="email" name="email"></p>
	<p>URL：<input type="url" name="url" value=""></p>
	<p><input type="submit" value="送信"></p>
</form>
</body>
</html>

<?php
}
