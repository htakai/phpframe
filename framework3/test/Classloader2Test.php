<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Classloader2Test.phpとしてテスト.
 */

require_once __DIR__ . '/../../framework3/exceptions_define.php';
require_once __DIR__ . '/../../framework3/common/ErrorFunc.php';
require_once __DIR__ . '/../../framework3/common/ClassLoader.php';

use framework3\common\ErrorFunc;
use framework3\common\ClassLoader;
use PHPUnit\Framework\TestCase;

define('TEST', 1);
define('DS', DIRECTORY_SEPARATOR);

class Classloader2Test extends TestCase
{
    protected $loader;

    public function setUp() {
        ErrorFunc::getInstance();
        $namespaces = array( 'framework3' => 'C:\xampp'
                         ,'news3' => 'C:\xampp');

        $this->loader = new ClassLoader($namespaces);
        $this->loader->register();
    }


    /**
     * @test
     */
    public function 登録してある名前空間付きクラス名を引数にする()
    {

        $this->assertTrue($this->loader->loadClass('framework3\\mvc\\Db'));
        $this->assertTrue($this->loader->loadClass('news3\\common\\MyvalidExceptionChild'));
        # news2\\common\\MyvalidExceptionChildは存在するクラスである。
    }


    /**
     * @test
     */
    public function 存在しないクラス名を引数にする()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionCode(RUNTIME);
        $this->expectExceptionMessage('NotExist:load file not exist!');
        $this->loader->loadClass('NotExist');
    }
}
