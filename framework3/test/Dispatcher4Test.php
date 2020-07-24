<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Dispatcher4Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\mvc\Dispatcher;
use news3\controllers\PostController;
use news3\request\PostRequest;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

// $req_url==$_SERVER['REQUEST_URI']
// APPNAME=='news2'
// PLEVEL==1 $plevel==1
// 存在する階層１、存在しない階層２の場合-->expected PostControllerインスタンス, NotExistAction()生成
//                              NotExistRequestインスタンスが生成されないことの確認
class Dispatcher4Test extends TestCase
{
    protected $dispatcher;

    public function setUp() {
        $this->dispatcher = new Dispatcher();
    }


    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage notexist:Action can not found!
     */
    public function method_existsによって例外処理が発生する()
    {
        $this->ret = $this->dispatcher->dispatch('/news3/post/notexist/',1);
    }
}
