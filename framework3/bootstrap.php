<?php
/**
 * アプリケーションnewsファイルオートローダー読み込み登録処理
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/12/
 */
 
namespace framework3;


use framework3\common\ClassLoader;

//外部モジュール、オートローダー処理クラスの読み込み
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/common/ClassLoader.php';


//オートローダーで読み込むクラスのディレクトリ構成に対応したトップレベルの名前空間名=>ベースディレクトリを登録する
$namespaces = array( 'framework3' => SYSROOT
                         ,APPNAME => SYSROOT); 
                         
//登録処理
$loader = new ClassLoader($namespaces);
$loader->register();

//追加登録があれば  
//$loader->registerNamespace($namespace, $dir);
