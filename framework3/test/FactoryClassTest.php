<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/FactoryClassTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\common\FactoryClass;
use news3\models\CatDao;
use news3\models\Cat;

define('TEST', 1);

class FactoryClassTest extends TestCase
{
    protected $fs_instance;
    public function setUp()
    {
        $this->fs_instance = FactoryClass::getNew();
    }


    /**
     * @test
     */
    public function createClass成功Test()
    {
        $ns_classname = 'news3\\models\\CatDao';

        $instance = $this->fs_instance::createClass0($ns_classname);
        $this->assertTrue($instance instanceof $ns_classname);
    }


    /**
     * @test
     */
    public function createClass成功Test2()
    {
        $ns_classname = Cat::class;
        $params = [5, cat3];

        $instance = $this->fs_instance::createClass0($ns_classname, $params);
        $this->assertTrue($instance instanceof $ns_classname);
        $this->assertEquals(5, $instance->getCatId());
        $this->assertEquals('cat3', $instance->getCatName());
    }


    /**
     * @test
     */
    public function createClass失敗Test()
    {
        // Classloader loadClass()でキャッチされる.
        $this->expectExceptionCode(RUNTIME);
        $this->expectExceptionMessage('news3\models\NotExist:load file not exist!');

        $ns_classname = 'news3\\models\\NotExist';
        $instance = $this->fs_instance::createClass1($ns_classname);
    }
}
