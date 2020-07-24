<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ChkGlobalNotInitTest2.phpとしてテスト.
 */

$GLOBALS['not_defined'] = "pre_isseted!"; # this is double bookking!.

require_once __DIR__ . '/../../news3/config.php';

use framework3\common\ErrorFunc;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

// case of defined DBG.
class ChkGlobalNotInitTest2 extends TestCase
{
    /**
     * @test
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function fallNotdefinedSet()
    {
        $this->expectExceptionMessage('check global variable [not_defined]!');
        require_once __DIR__ .'/../../framework3/runfirst.php';
    }

}
