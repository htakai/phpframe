<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ErrorFuncTest3としてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\common\ErrorFunc;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

class ExtErrorFunc extends ErrorFunc
{
    public function public_connect_ex_str(\throwable $e)
    {
        return parent::connect_ex_str($e);
    }
}


class ErrorFuncTest3 extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new ExtErrorFunc();
    }


    /**
     * @test
     */
    public function connect_ex_str正常処理()
    {
        $ext_obj = new \RuntimeException('test!', RUNTIME);
        $msg = $this->obj->public_connect_ex_str($ext_obj);
        $this->assertSame(
                        'throwable is=>RuntimeException<br/>-->test!<br/>-->C:\xampp\framework3\test\ErrorFuncTest3.php(42)<br/>',
                            $msg);
    }
}
