<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ApGlobalTest.phpとしてテスト.
 */

require_once __DIR__ .'/../../framework3/ApGlobal.php';

use framework3\ApGlobal;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

class  ApGlobalTest extends TestCase
{
    /**
     * @test
     */
    public function ApGlobal初期化が正常に行われる()
    {
        $this->expectOutputString('not_defined set! unset!');
        $this->assertTrue(ApGlobal::do_init());
        $this->assertEquals(DBG, 1);
        $this->assertEquals(NOCACHE, 1);
        $this->assertFalse(array_key_exists('not_defined', $GLOBALS));
    }
}
