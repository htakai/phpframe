<?php
/**
 * バリデーションに係わるカスタム例外クラスを定義する
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */
require_once '../../../news3/config.php';
require_once '../../../framework3/runfirst.php'; 


use framework3\common\ErrorFunc;


try{
//	try{
//		$datetime = new DateTime('abcde');            // これは例外が throw される 
//	} catch(RuntimeException $e) {
//		ErrorFunc::catchAfter($e);
//	}	
	try {
		$datetime2 = new DateTime('2010-04-00 00:00:00'); # この日付はおかしいけど、例外は投げてこない

		//おかしなフォーマットになっているなら、エラーログに流して処理は継続する
		$errors = $datetime2->getLastErrors();
		if (($errors['warning_count'] + $errors['error_count']) != 0) {
			throw new \RuntimeException(var_export($errors,true), RUNTIME); # このような形にして初めてエラーがあることがわかる
		}
	} catch(\RuntimeException $e) {	
		ErrorFunc::catchAfter($e);
	}	
	
	$datetime = new DateTime('abcde');     # これは例外が throw される  
	
} catch (\Throwable $e) {
echo 'catch throwable!';
	
	ErrorFunc::catchAfter($e);
} 

if(defined('DBG') && !empty( $GLOBALS['exceptions'])){
print('print all exceptions str!');
print('<br/>');			
ErrorFunc::dispAll();
			
}	
			



