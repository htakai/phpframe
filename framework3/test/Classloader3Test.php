<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ChkGlobalNotInitTest3.phpとしてテスト.
 */

require_once __DIR__ . '/../../framework3/exceptions_define.php';
require_once __DIR__ . '/../../framework3/common/ErrorFunc.php';
require_once __DIR__ . '/../../framework3/common/ClassLoader.php';

use framework3\common\ErrorFunc;
use framework3\common\ClassLoader;
use PHPUnit\Framework\TestCase;
use news3\common\MyvalidExceptionChild;
use framework3\mvc\MyvalidException;

define('TEST', 1);
define('DS', DIRECTORY_SEPARATOR);

class Classloader3Test extends TestCase
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
    public function registerNamespace正常()
    {
        $namespace = 'news3';
        $basedir = 'C:\xampp';
        $this->loader->registerNamespace($namespace, $basedir);
        $namespace = 'framework3';
        $basedir = 'C:\xampp';
        $this->loader->registerNamespace($namespace, $basedir);
        $this->loader->register();


        $this->assertTrue($this->loader->loadClass('news3\\common\\MyvalidExceptionChild'));
        # news3\\common\\MyvalidExceptionChildは存在するクラスである。
    }
}
