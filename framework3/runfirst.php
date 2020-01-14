<?php
/**
 * グローバルな設定
 * 
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */
 
 
//define global variable for check 
if (!array_key_exists('not_defined', $GLOBALS)) {
    $not_defined = "";
} else {
    $msg = __FILE__. ' can not check global variable!';
    trigger_error($msg, E_USER_NOTICE);
}


//run for debug
if (!defined('DBG')) {
    define("DBG", 1);
} else {
        $not_defined .= "DBG, ";
}

//setting cache on or off
if (!defined('NOCACHE')) {
    define("NOCACHE", 1);
} else {
	$not_defined .= "NOCACHE, ";
}

//global setting
if (defined('DBG')) {
    if (!array_key_exists('exceptions', $GLOBALS) && !array_key_exists('ret_url', $GLOBALS)) {
        $exceptions = "";
        $ret_url = "";
    } else {
        $not_defined .= "exceptions or ret_url global variable alredy defined, ";
    }       
}

if (!defined('U_MODE')) { # set unit test mode
    define ('U_MODE',0); # test set=1,off=0
} else {
    $not_defined .= "U_MODE, ";
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('PLEVEL')) { # URLの階層設定。document rootよりどの階層からをパラメータとして解釈するか。1以上をセット、 /hoge/以下に置くなら1, /hoge/piyo/以下に置くなら2
    define('PLEVEL', 1);
} else {
    $not_defined .= "and PLEVEL, ";
}

if (!defined('SKM')) {
    define('SKM', 'http://');
} else {
    $not_defined .= "and SKM, ";
}

if (!defined('SYSROOT')) {
    define('SYSROOT', dirname(__DIR__)); # case SYSROOT/DOCROOT
} else {
    $not_defined .= "and SYSROOT, ";
}

if (!defined('DOCROOT')) { 
    define('DOCROOT', $_SERVER['DOCUMENT_ROOT']); 
} else {
    $not_defined .= "and DOCROOT, ";
}

if (!defined('HOST')) {
    define('HOST', SKM.$_SERVER['SERVER_NAME'].'/');  
} else {
    $not_defined .= "and HOST, ";
}

//画像ファイル格納場所の定義
if (!defined("IMG_DIR")) {
    define( "IMG_DIR", DOCROOT. "./img/" );  # upload dir
} else {
    $not_defined .= "and IMG_DIR, ";
}
if (!defined("IMG_DIR_S")) {    
    define( "IMG_DIR_S", DOCROOT. "/img_s/" );  # 縮小画像s　dir
} else {
    $not_defined .= "and IMG_DIR_S, ";
}
if (!defined("IMG_DIR_M")) {
    define( "IMG_DIR_M", DOCROOT. "/img_m/" );   # 縮小画像m　dir
} else {
    $not_defined .= "and IMG_DIR_M, ";
}


//フレームワークで使用する定数定義
//Exception code
define("ERROR", 110); # ErrorException
define("LOGIC", 300); # LogicException
define("BADFUNC", 310); # BadFunctionCallException
define("BADMETHOD", 320); # BadMethodCallException
define("DOMAIN", 330); # DomainException
define("INVALID", 340); # InvalidArgumentException
define("LENGTH", 350); # LengthException
define("OUTOFRANGE", 360); # OutOfRangeException
define("RUNTIME", 400); # RuntimeException
define("OUTOFBOUNDS", 410); # OutOfBoundsException
define("OVERFLOW", 420); # OverflowException
define("RANGES", 430); # RangeException
define("UNDERFLOW", 440); # UnderflowException
define("UNEXPECTED", 450); # UnexpectedValueException
define("BADREQUEST", 4001); # BadRequestException
define("MYVALID", 5000); # MyvalidException

require_once 'util.php';
require_once 'bootstrap.php';

use framework3\common\ErrorFunc;

ErrorFunc::getInstance();

require_once 'globalsetting.php';

try {
    if (!empty($not_defined)) {
        $not_defined = $not_defined. ' alredy defined!'; 
        throw new \LogicException($not_defined, LOGIC);
    }
} catch (\LogicException $e) {
    ErrorFunc::catchAfter($e);
}
