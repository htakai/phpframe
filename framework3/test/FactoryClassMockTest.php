<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/FactoryClassMockTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\common\FactoryClass;

define('TEST', 1);

class FactoryClassMockTest extends TestCase
{
    protected $factoryclass_mock;

    public function setUp()
    {
        // 全部握りつぶす、コンストラクタは呼ばれない。-->mock使用
        // 全部そのまま、コンストラクタは呼ばれる。-->partialMock使用
//      $this->factoryclass_mock = Phake::partialMock(FactoryClass::class);
        $this->factoryclass_mock = Phake::mock(FactoryClass::class);
    }

    /**
     * @test
     */
    public function FactoryClassMockStaticTest()
    {
        Phake::whenStatic($this->factoryclass_mock)->createClass0()->thenReturn(true);

        $result = $this->factoryclass_mock::createClass0();
        $this->assertEquals(true, $result);

    }
}
