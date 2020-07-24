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


try{
	try {
		$json_string = "}";
		$json = json_decode($json_string, true);
	
		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new \LogicException('[json error]'.json_last_error_msg(), LOGIC);
		}
	} catch(\LogicException $e) {
//var_dump($e);		
		ErrorFunc::catchAfter($e);
	}

	//php7.3以降で有効
	try {
		json_decode("{", true, 512, JSON_THROW_ON_ERROR);
	} catch (JsonException $e) {
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
		

