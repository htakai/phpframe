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
	//__clone()の直接実行 php7では実行可能
	class myclass
	{
		public function __clone()
		{
			return new self;
		}
	}
	$obj = new myclass;
	$obj->__clone();
//	eval("\$obj->__clone();");// PHP 5 のコンパイル時エラー回避
	
	
	//ゼロ剰余算
	1 % 0;  #[DivisionByZeroError]
	
	
	//マイナスのビットシフト
	1 << -1;  #[ArithmeticError]


	//クラス経由でのインスタンスプロパティへのアクセス
	class myclass4
	{
		public $prop;
	}
	myclass4::$prop;  #[Error]
	
	
	//アクセス権限のないプロパティへのアクセス
	class Klass5
	{
		private static $prop;
	}
	Klass5::$prop;  #[Error]


	
	//アサーションの失敗 (assert.exception=1)
	ini_set("assert.exception", "1");
	assert(false);  # [AssertionError]

	
	//ユーザ定義関数の引数不足
	function func($a) { }
	func();  #[ArgumentCountError]

	
	//ユーザ定義関数のタイプヒンティングの無視
	function func(stdClass $obj) { }
	func(1);  #[TypeError]
	
	
	//ArrayAccess未実装時の配列形式アクセス
	$obj = new stdClass;
	$obj[0] = 1;  #[Error]
		

	//未定義の静的プロパティの評価'
	$obj = new stdClass;
	$obj::$undefined . ""; #[Error]


	//未定義のクラス定数の評価'
	$obj = new stdClass;
	$obj::UNDEFINED . "";  #[Error]


	//クラス経由でのインスタンスプロパティへのアクセス
	class myclass2
	{
		public $prop;
	}
	myclass2::$prop;  #[Error]

	
} catch (\Throwable $e) {
echo 'catch throwable!';
	ErrorFunc::catchAfter($e);		
} 

if(defined('DBG') && !empty( $GLOBALS['exceptions'])){
print('print all exceptions str!');
print('<br/>');			
	ErrorFunc::dispAll();
			
}	
			

