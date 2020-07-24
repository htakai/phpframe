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
	//Error case and DomainException case
	try {
		if ($undefined !== 2) {  # error
			$msg = 'undefined number!';
			throw new \DomainException ($msg, DOMAIN);
		}
	} catch(\DomainException $e) {
		ErrorFunc::catchAfter($e);	
	}
	
	
	if ($unknown == "") { #error
		echo 'undefined variable!';
	}
	
	
	//未定義の変数の評価
	echo $undefined;
	
	
	//未定義のグローバル定数の評価
	echo UNDEFINED;
	
	
	//未定義の配列オフセットの評価
	$ary = [];
	echo $ary[0];
	
	
	//未定義のインスタンスプロパティの評価
	$obj = new stdClass;
	$obj->undefined;
	
	
	//配列と文字列の結合
	$ary = [];
	$ary . ""; // PHP 7 のコンパイル時エラー回避
	
	
	//配列のオフセットの型間違い
	$ary = [];
	$ary[[]] . "";
	
	
	//組み込み関数のタイプ指定無視
	strlen([]);
	
	
	//組み込み関数の引数不足
	strlen();


	//foreachの型間違い
	$num = 1;
	foreach ($num as $k => $v);
	
	
	//ユーザレベルの設定されたエラー
	if ($divisor == 0) {
		trigger_error("ゼロで割ることはできません", E_USER_ERROR);
	}


	//__toString()未実装時の文字列キャスト
	$obj = new stdClass;
	(string)$obj;



	//組み込み関数の引数余剰
	strlen("", "");


	//アサーションの失敗 (assert.exception=0)
	assert(false);


} catch (\Throwable $e) {
echo 'catch throwable!';
	ErrorFunc::catchAfter($e);	
	
} 

if(defined('DBG') && !empty( $GLOBALS['exceptions'])){
print('print all exceptions str!');
print('<br/>');			
	ErrorFunc::dispAll();
			
}	
		
