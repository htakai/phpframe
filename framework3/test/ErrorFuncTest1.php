<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ErrorFuncTest1としてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\common\ErrorFunc;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

class ErrorFuncTest1 extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = ErrorFunc::getInstance();
    }


    /**
     * @test
     */
    public function instanceが正しく生成される()
    {
        $this->assertInstanceOf('framework3\common\ErrorFunc', $this->obj);
    }


    /**
     * @test
     */
    public function cloneによる例外発生()
    {
        $this->expectExceptionCode(RUNTIME);
        $this->expectExceptionMessage('Clone is not allowed against framework3\common\ErrorFunc');
        $cloned = clone $this->obj;
    }
}
