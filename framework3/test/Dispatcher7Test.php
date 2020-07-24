<?php


/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Dispatcher7Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\mvc\Dispatcher;
use news3\controllers\PostController;
use news3\request\PostRequest;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

// $req_url==$_SERVER['REQUEST_URI']
// APPNAME=='news3'
// PLEVEL==2 $plevel==2　plevelの指定を間違える
// 存在する階層１、存在する階層２のつもりでurl指定場合
class Dispatcher7Test extends TestCase
{
    protected $dispatcher;

    protected $ret = array();

    public function setUp() {
        $this->dispatcher = new Dispatcher();
    }


    /**
     * @test
     * @expectedException DomainException
     * @expectedExceptionMessage plevel must set over 1
     */
    public function plevelチェックによって例外処理が発生する()
    {
        //controller-->index, action-->indexのつもり
        $this->ret = $this->dispatcher->dispatch('/news2/',0);
    }
}
