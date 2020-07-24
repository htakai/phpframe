<?php
/**
 * settings that must read first.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */

namespace framework3;

require_once 'ApGlobal.php';

use framework3\ApGlobal;

ApGlobal::do_init();

require_once 'bootstrap.php';

require_once 'exceptions_define.php';

use framework3\common\ErrorFunc;
use framework3\common\F_util;

ErrorFunc::getInstance();

//require_once 'use_errorfunc.php';

if (!defined('TEST')) {
    require_once 'globalsetting.php';
}

try {
    if (!empty($not_defined)) {
        $not_defined = $not_defined. ' alredy defined!';
        throw new \LogicException($not_defined, LOGIC);
    }
} catch (\LogicException $e) {
//  ErrorFunc::catchAfter($e);
F_util::catchfunc($e);
}

if (isset($not_defined)) {
    unset($not_defined);
}
