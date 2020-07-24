<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ChkGlobalInitTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\common\ErrorFunc;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

// case of defined DBG mode.
class ChkGlobalInitTest extends TestCase
{
    /**
     * @test
     */
    public function chk_global_init正常()
    {
        $this->assertEquals('', $GLOBALS['exceptions']);
        $this->assertEquals('', $GLOBALS['ret_url']);
    }

    /**
     * @test
     */
    public function not_defined正常()
    {
        $this->assertFalse(array_key_exists('not_defined', $GLOBALS));
    }
}
