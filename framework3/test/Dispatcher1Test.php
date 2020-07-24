<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Dispatcher1Testとしてテスト.
 */

require_once __DIR__ .'/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';


use framework3\mvc\Dispatcher;
use news3\controllers\IndexController;
use news3\request\IndexRequest;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

//$req_url==$_SERVER['REQUEST_URI']
//APPNAME=='news3'
//PLEVEL==1 $plevel==1
//階層１、階層２省略の場合-->expected IndexControllerインスタンス, IndexAction()生成
//                              IndexRequestインスタンスがせいせいされていることの確認
class Dispatcher1Test extends TestCase
{
    protected $dispatcher;

    protected $ret = array();

    public function setUp() {
        $this->dispatcher = new Dispatcher();
        $this->ret = $this->dispatcher->dispatch('/news3/',1);
    }


    /**
     * @test
     */
    public function controller名action名がindexになる()
    {
        $this->assertEquals('index', $this->ret['cont_nm']); #controller名
        $this->assertEquals('index', $this->ret['act_nm']); #action名


    }


    /**
     * @test
     */
    public function getControllerInstanceによってインスタンスが生成される()
    {
        $actual = $this->dispatcher->getControllerInstance($this->ret['cont_nm']);
        $this->assertInstanceOf(IndexController::class, $actual);

    }


    /**
     * @test
     */
    public function getRequestInstanceによってインスタンスが生成される()
    {
        $actual = $this->dispatcher->getRequestInstance($this->ret['cont_nm']);
        $this->assertInstanceOf(IndexRequest::class, $actual);
    }
}
