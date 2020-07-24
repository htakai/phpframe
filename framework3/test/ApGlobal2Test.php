<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ApGlobal2Test.phpとしてテスト.
 */

require_once __DIR__ .'/../../framework3/ApGlobal.php';

use framework3\ApGlobal;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

class  ApGlobal2Test extends TestCase
{
    /**
     * @test
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function ApGlobal異常()
    {
        $GLOBALS['not_defined'] = "someone";

        $this->expectExceptionMessage('check global variable [not_defined]!');
        ApGlobal::do_init();

    }
}
