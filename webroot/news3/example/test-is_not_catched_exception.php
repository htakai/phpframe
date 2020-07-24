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

	//catchされないException case
	$msg = 'is not chatched exception call!';
	throw new \Exception($msg);

try {

	//not defined Exception case
	$msg = 'unknown exception call!';
	throw new UnknownException($msg);

} catch (\Throwable $e) {
echo 'catch throwable!';
	ErrorFunc::catchAfter($e);		
	
} 

if (defined('DBG') && !empty( $GLOBALS['exceptions'])) {
print('print all exceptions str!');
print('<br/>');			
	ErrorFunc::dispAll();
			
}	
			

