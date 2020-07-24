<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Dispatcher5Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\mvc\Dispatcher;
use framework3\mvc\ControllerBase;
use news3\controllers\PostController;
use news3\request\PostRequest;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

// $req_url==$_SERVER['REQUEST_URI']
// APPNAME=='news3'
// PLEVEL==1 $plevel==1
// 存在する階層１、存在する階層２の場合-->expected PostControllerインスタンス, chkWorkAction()生成
//                              PostRequestインスタンスが生成されていることの確認
class Dispatcher5Test extends TestCase
{
    protected $dispatcher;

    protected $ret = array();

    public function setUp() {

        $this->dispatcher = new Dispatcher();
        $this->ret = $this->dispatcher->dispatch('/news3/post/chkWork/',1);

    }


    /**
     * @test
     */
    public function controller名がpostでaction名がchkWorkになる()
    {

        $this->assertEquals('post', $this->ret['cont_nm']); #controller名
        $this->assertEquals('chkWork', $this->ret['act_nm']); #action名
    }


    /**
     * @test
     */
    public function getControllerInstanceによってインスタンスが生成される()
    {
        $actual = $this->dispatcher->getControllerInstance($this->ret['cont_nm']);
        $this->assertInstanceOf(PostController::class, $actual);

    }


    /**
     * @test
     */
    public function getRequestInstanceによってインスタンスが生成される()
    {
        $actual = $this->dispatcher->getRequestInstance($this->ret['cont_nm']);
        $this->assertInstanceOf(PostRequest::class, $actual);

    }
}
