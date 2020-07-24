<?php


/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Dispatcher8Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\mvc\Dispatcher;
use framework3\mvc\BadRequestException;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

// $req_url==$_SERVER['REQUEST_URI']
// APPNAME=='news2'
// PLEVEL==1 $plevel==1
// 存在しない階層１、階層２省略の場合-->expected NotExistControllerインスタンス, IndexAction()生成
//                              NotExistRequestインスタンスが生成されないことの確認
class Dispatcher8Test extends TestCase
{
    protected $dispatcher;

    protected $ret = array();

    public function setUp() {
        $this->dispatcher = new Dispatcher();
    }


    /**
     * @test
     */
    public function getControllerInstanceによって例外処理が発生する()
    {
        $this->expectExceptionCode(BADREQUEST);
        $this->expectExceptionMessage('C:\xampp/news3/controllers/NotexistController.php: file can not found!');
        $this->ret = $this->dispatcher->dispatch('/news3/notExist/',1);

    }
}
