<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Dispatcher2Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\mvc\Dispatcher;
use framework3\mvc\ControllerBase;
use framework3\mvc\Request;

use news3\controllers\PostController;
use news3\request\PostRequest;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

// $req_url==$_SERVER['REQUEST_URI']
// APPNAME=='news3'
// PLEVEL==1 $plevel==1
// 存在する階層１、階層２省略の場合-->expected PostControllerインスタンス, IndexAction()生成
//                              PostRequestインスタンスが生成されていることの確認
class Dispatcher2Test extends TestCase
{
    protected $dispatcher;
    protected $postInstance;

    protected $ret = array();

    public function setUp() {
        // 条件をセット
        $this->dispatcher = new Dispatcher();
        $this->ret = $this->dispatcher->dispatch('news3/post/',1);
    }


    /**
     * @test
     */
    public function urlから処理分枝されること()
    {
        // controller名、action名がピックアップされる
        $this->assertEquals('post', $this->ret['cont_nm']);
        $this->assertEquals('index', $this->ret['act_nm']);

        // controllerインスタンスが生成される
        $conInstance = $this->dispatcher->getControllerInstance($this->ret['cont_nm']);
        $this->assertInstanceOf(PostController::class, $conInstance);

        // requestインスタンスが生成される
        $reqInstance = $this->dispatcher->getRequestInstance($this->ret['cont_nm']);
        $this->assertInstanceOf(PostRequest::class, $reqInstance);
    }

}
