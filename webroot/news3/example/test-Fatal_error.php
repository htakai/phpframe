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

//try 内外関係なくerror表示される
//	ini_set("memory_limit", "12M");
//	str_repeat("aaa", 50000000);

try{
	ini_set("memory_limit", "12M");
	str_repeat("aaa", 50000000);
	
	ini_set("max_execution_time", "1");
	for(;;){};
	
	} catch (\Throwable $e) {
echo 'catch throwable!';
		ErrorFunc::catchAfter($e);	
	
	}
	
	if(defined('DBG') && !empty( $GLOBALS['exceptions'])){
print('print all exceptions str!');
print('<br/>');			
		ErrorFunc::dispAll();
			
	}	
		
