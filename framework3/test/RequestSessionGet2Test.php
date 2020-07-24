<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/RequestSessionGet2Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\mvc\Request;
use PHPUnit\Framework\TestCase;

session_start();

define('TEST', 1);

class RequestSessionGet2Test extends TestCase
{
    protected $request;
    protected $reqs;

    //case test get mode , nesesary to change config.php U_MODE 3
    public function setUp()
    {


        $this->reqs = array( 'get'=>1,
                        'nm'=>"高井",
                      'age'=>62,
                      'fruits'=>array( '0'=>'orange',
                                      '1'=>'apple',
                                      '2'=>'banana'
                                    ),
                                    );
        $this->request = new Request($this->reqs);
    }


    /**
     * @test
     */
    public function 正常にsetSessuibReqDt関数が機能する()
    {
        $ret = $this->request->setSessionReqDt();
        $this->assertEquals($this->reqs, $ret);
    }

    protected function tearDown()
    {
        $_SESSION = array();
    }
}
