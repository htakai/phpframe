<?php
/**
 * 
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */
require_once '../../../news3/config.php';
require_once '../../../framework3/runfirst.php'; 


use framework3\common\ErrorFunc;
use framework3\mvc\BadRequestException;

try{

	//BadRequestException case	
	try {			
		$_get = ['id'=>5,];
		if ($_get['id'] > 4) {
			$msg = 'bad url parametar send!';
			throw new BadRequestException($msg, BADREQUEST);
		}
	} catch(BadRequestException $e) {
		ErrorFunc::catchAfter($e);
	}
	

} catch (\Throwable $e) {
	echo 'catch throwable!';
//var_dump($e);
	ErrorFunc::catchAfter($e);		
	
} 

if(defined('DBG') && !empty( $GLOBALS['exceptions'])){
print('print all exceptions str!');
print('<br/>');			
	ErrorFunc::dispAll();
			
}	

