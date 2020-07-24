<?php

require_once '../../../news3/config.php';
require_once '../../../framework3/runfirst.php';


use framework3\common\F_util;
use framework3\mvc\Session;
use news3\models\CertifiDao;
use framework3\common\ErrorFunc;
use framework3\common\Csrf;
//use framework3\mvc\MyvalidException;
//use news3\common\MyvalidExceptionChild;
//use news3\common\AppErrorFunc;

$form_name = 'test_certifi';
$session = Session::getInstance();

if (count($_POST) > 0) {
	// csrf対策
	if (isset($_POST['token'])) {
		$tokened = $_POST['token'];
		if (Csrf::check($form_name, $session, $tokened)) {
print('csrf ok!');			
			$name = F_util::hs($_POST['username']);
			$pass = F_util::hs($_POST['pass']);

			$ret_url = F_util::esc_url(SKM.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$certifiDao = new CertifiDao($session, $ret_url);
			if ($certifiDao->admin_execute($name, $pass)) {
				echo 'admin ok!';
				// after login processing
				return;
			}
		} else {
			echo 'unfair sending!';
		}
	} else {
		echo 'can not token check!';
	}
} else {
	$token = Csrf::create_token($form_name, $session);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザ認証sample</title>
<style>
body{
    padding: 5%;
    }

</style>
</head>
<body>
<h1>ユーザ認証</h1>
<form action="" method="post">
    <p><label>名前：<input type="text" name="username"></label></p>
    <p><label>パスワード：<input type="password" name="pass"></label></p>
	<input type="hidden" name="token" value=<?= F_util::hs($token) ?>>
    <p><input type="reset"><input type="submit"></p>
</form>

</body>
</html>
<?php
}
// for development
if (defined('DBG') && !empty( $GLOBALS['exceptions'])) {
    ErrorFunc::dispAll();
}	
