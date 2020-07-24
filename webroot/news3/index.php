<?php

/**
 * aplication start file
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/12/
 */

require_once '../../news3/config.php';
require_once '../../framework3/runfirst.php';


use framework3\mvc\Dispatcher;
use framework3\common\ErrorFunc;


// 処理ディスパッチ
try {
    $dispatcher = new Dispatcher();

    $dispatcher->dispatch($_SERVER['REQUEST_URI'], PLEVEL); # chg

    } catch (\Throwable $e) {
        ErrorFunc::catchAfter($e);
    }

// for development
if (defined('DBG') && !empty( $GLOBALS['exceptions'])) {
    ErrorFunc::dispAll();
}
