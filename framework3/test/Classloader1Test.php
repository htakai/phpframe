<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Classloader1Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ . '/../../framework3/bootstrap.php';
require_once __DIR__ . '/../../framework3/exceptions_define.php';

use framework3\common\ErrorFunc;
use framework3\common\ClassLoader;
use PHPUnit\Framework\TestCase;

define('TEST', 1);
define('DS', DIRECTORY_SEPARATOR);

class Classloader1Test extends TestCase
{
    protected $loader;

    public function setUp() {
        ErrorFunc::getInstance();
        $namespaces = array( 'framework3' => 'C:\xampp'
                         ,'news3' => 'C:\xampp');

        $this->loader = new ClassLoader($namespaces);
    }


    /**
     * @test
     */
    public function 登録してある名前空間付きクラス名を引数にする()
    {

        $this->assertTrue($this->loader->loadClass('framework3\\mvc\\Db'));

    }



    /**
     * @test
     */
    public function 存在しないクラス名を引数にする()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(RUNTIME);
        $this->expectExceptionMessage('NotExist:load file not exist!');
        $this->loader->loadClass('NotExist');
    }
}
