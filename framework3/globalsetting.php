<?php
/**
 * about error exception standard function
 * ~エラーや例外処理に関する設定、関数~
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/ 
 */
 
 
use function framework3\hs;
use framework3\common\ErrorFunc;


//デバックモード設定
if (defined('DBG')) {
    //エラーの内容をスクリプトの出力に含めるかどうかを設定
    ini_set('display_errors', 1); 
    //エラーの報告の設定 
    error_reporting(-1); # 全ての PHP エラーを表示する
} else { # php ini-productionファイルに順ずる
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0); # PHPの起動シーケンスにおいて発生したエラーを含めない
    ini_set('mysqlnd.collect_memory_statistics', 0); # The collection of statistics is disabled by default for performance reasons.
    ini_set('zend.assertions', 'disabled'); # アサーションコードを生成せず。
    
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
}
//すべてのエラーをログファイルに記録する。
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error.txt');


 /**
 * エラーハンドラユーザ定義関数(エラーを例外にかえる) 
 * @param int $code -->error level
 * @param string $message
 * @param string $file
 * @param int $line
 */
function error_handler(int $error_n, string $message, string $file, int $line) 
{
    try {
        throw new \ErrorException($message, ERROR, $error_n, $file, $line);
        } catch(\ErrorException $e) {       
            ErrorFunc::catchAfter($e);
        }
        return; 
}

set_error_handler("error_handler", E_ALL);


/**
 * 例外ハンドラ関数
 */
function exception_handler(\Throwable $ex)
{
    try {
        throw $ex;
    } catch(\Exception $e) {    
        ErrorFunc::catchAfter($e);
    } finally {
        if (defined('DBG') && !empty( $GLOBALS['exceptions'])) {        
        ErrorFunc::dispAll();
            
        }
    }
 
    return;
}
set_exception_handler("exception_handler");
/**
 * シャットダウン時に実行する関数
 */
function shutdownfunction()
{
    $error = error_get_last();  # 最後に発生したエラー情報type,message,file,lineを取得し連想配列でかえす
    if ($error === NULL) {
        return;
    } else {
        echo ('shutdownfunction start!');   
        $message = sprintf('[%s] %s in %s (%s)'
        , ErrorFunc::ELEBEL[$error['type']]
        , $error['message']
        , $error['file']
        , $error['line']
        );
        if (defined('DBG')) {
            echo hs($message);
        } else {
            echo ('~~~~~ system error! ~~~~~');
            error_log($message, 0);
        }
    }
}
register_shutdown_function('shutdownfunction');
