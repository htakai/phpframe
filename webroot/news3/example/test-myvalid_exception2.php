<?php
/**
 * myvalidExceptionChild test
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */
require_once '../../../news3/config.php';
require_once '../../../framework3/runfirst.php';


use framework3\common\F_util;
use framework3\common\ErrorFunc;
use framework3\mvc\MyvalidException;
use news3\common\MyvalidExceptionChild;
use news3\common\AppErrorFunc;

// try{

    //MyvalidException case
    if (count($_POST) > 0) {
        $error = "";
        $num ="";

        $phone = F_util::is_valid_phone_number($_POST['tel']);

        if(empty($phone)){
            $error .= "phone mistake!"." ";
            $num .= __LINE__;
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if(empty($email)){
            $error .= "email mistake!"." ";
            $num .= __LINE__;
        }

        $url = F_util::is_valid_url($_POST['url']);
        if(empty($url)){
            $error .= "url mistake!"." ";
            $num .= __LINE__;
        }

        try {
            if (!empty($error)) {
                if (!empty($num)) {
                    $msg = MyvalidException::createMsg($num, $error);
                    throw new MyvalidExceptionChild($msg, MYVALID);
                } else {
                    try {
                        $msg = 'not defined identified number!';
                        throw new \LogicException($msg, LOGIC);
                    } catch(\LogicException $e) {
                        ErrorFunc::catchAfter($e);
                    }
                }

            }
        } catch(MyvalidExceptionChild $e) {
            $ret_url = 'http://w-pecekr.com/?id=2&mode=2';
            $e->customFunction($ret_url);
            AppErrorFunc::getInstance();
            AppErrorFunc::catchAfter($e);
        }

    }

// } catch (\Throwable $e) {
// echo 'catch throwable!';
// //var_dump($e);
    // ErrorFunc::catchAfter($e);

// }

if(defined('DBG') && !empty( $GLOBALS['exceptions'])){
print('print all exceptions str!');
print('<br/>');
    ErrorFunc::dispAll();

}


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