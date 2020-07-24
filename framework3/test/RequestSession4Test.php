<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/RequestSession4Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';


use framework3\mvc\Request;
use PHPUnit\Framework\TestCase;

class RequestSession4Test extends TestCase
{
    protected $request;
    protected $reqs = array();

    //case test post mode , nesesary to change config.php U_MODE 3.
    public function setUp()
    {

        $this->request = new Request($this->reqs);
    }


    /**
     * @test
     */
    public function setSessuibReqDt関数がfalseをかえす()
    {
        $ret = $this->request->setSessionReqDt();
        $this->assertFalse($ret);
    }
}
