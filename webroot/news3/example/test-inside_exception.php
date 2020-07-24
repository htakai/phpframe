<?php
/**
 * Error,Exception test. case exceptions inside try sentence
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */
require_once '../../../news3/config.php';
require_once '../../../framework3/runfirst.php'; 


use framework3\common\ErrorFunc;


try{
	
	//Error case DomainException case
	try {
		if ($val !== 2) {  # error
			$msg = 'not defined variable number setting!';
			throw new \DomainException ($msg, DOMAIN);
		}
	} catch(\DomainException $e) {
		$obj = ErrorFunc::getInstance();
		ErrorFunc::catchAfter($e);	
	}
	
	
	//InvalidArgumentException case	
	try {			
		$dig='k';
		if (!is_numeric($dig)) {
			$msg = 'inner2 exception!';
			throw new \InvalidArgumentException($msg, INVALID);
		}
	} catch(\InvalidArgumentException $e) {
		$obj = ErrorFunc::getInstance();
		ErrorFunc::catchAfter($e);
	}
	
	
	//BadFunctionCallExceptio case
	try{
		$arg = 'Unknown';
		$func = 'do' . $arg;
		if (!is_callable($func)) {
			$msg = 'Function ' . $func . ' is not callable';
			throw new \BadFunctionCallException($msg, BADFUNC);
		}
	} catch (\BadFunctionCallException $e){	
		$obj = ErrorFunc::getInstance();
		ErrorFunc::catchAfter($e);
	}


	//UnexpectedValueException
	define ("TYPE_FOO" ,'foo');
	define ("TYPE_BAR" , 'bar');

	function doSomething($x) {
		try {
			if($x != TYPE_FOO || $x != TYPE_BAR) {
				$msg ='unexpected value set!';
				throw new \UnexpectedValueException($msg, UNEXPECTED);
			}
		} catch (\UnexpectedValueException $e) { 
			$obj = ErrorFunc::getInstance();
			ErrorFunc::catchAfter($e);
		}	
	} 
	doSomething('unknown');


} catch (\Throwable $e) {
echo 'catch throwable!';
//var_dump($e);
	$obj = ErrorFunc::getInstance();
	ErrorFunc::catchAfter($e);
}

if(defined('DBG') && !empty( $GLOBALS['exceptions'])){
print('print all exceptions str!');
print('<br/>');			
	ErrorFunc::dispAll();
			
}	
