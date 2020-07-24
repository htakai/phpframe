<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ChkGlobalNotInitTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\common\ErrorFunc;
use PHPUnit\Framework\TestCase;

//define('TEST', 1);

// case of !defined DBG.
class ChkGlobalNotInitTest extends TestCase
{
    /**
     * @test
     */
    public function chk_global_init正常()
    {
        $this->assertTrue(array_key_exists('exceptions', $GLOBALS));
        $this->assertTrue(array_key_exists('ret_url', $GLOBALS));
    }
}
