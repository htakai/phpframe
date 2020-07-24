<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ErrorFuncTest4としてテスト.
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


class ErrorFuncTest4 extends TestCase
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
        $ext_obj = new \ErrorException('test!', ERROR, E_ERROR, 'C:\xampp\framework3\errorfile', 22);
        $msg = $this->obj->public_connect_ex_str($ext_obj);
        $this->assertSame(
                        'throwable is=>ErrorException<br/>-->[E_ERROR]test!<br/>-->C:\xampp\framework3\errorfile(22)<br/>',
                            $msg);
    }


        /**
     * @test
     */
    public function connect_ex_strありえないservarity()
    {
        $this->expectExceptionCode(DOMAIN);
        $this->expectExceptionMessage('set_error_handler mistake!');
        $servarity = 3;
        $ext_obj = new \ErrorException('test!', ERROR, $servarity, 'C:\xampp\framework3\errorfile', 22);
        $this->obj->public_connect_ex_str($ext_obj);
    }
}
