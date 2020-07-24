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


	//Error case
	$val = 3;
	$dt = $val/0;

	try{
		//Error case
		$val = 3;
		$dt = $val/0;
	
		//DomainException case
		try {
			if ($val !== 2) {
				$msg = 'inner1 exception!';
				throw new \DomainException ($msg, DOMAIN);
			}
		} catch(\DomainException $e) {
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
		
