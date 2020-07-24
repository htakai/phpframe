<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/CatDaoTestとしてテスト.
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/07/
 */


require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use news3\models\catDao;
use news3\models\Cat;

define('TEST', 1);

class CatTest extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new CatDao();
    }


    /**
     * @test
     */
    public function get_objs正常Test2()
    {
        $sql = "select * from cat";
        $objs = $this->obj->get_objs($sql, Cat::class);
        $this->assertEquals(2, count($objs));
        $this->assertInstanceOf(Cat::class, $objs[0]);
        $this->assertInstanceOf(Cat::class, $objs[1]);

        $this->assertEquals('news', $objs[0]->getCatName());
        $this->assertEquals(1, $objs[0]->getCatId());
        $this->assertEquals('faq', $objs[1]->getCatName());
        $this->assertEquals(2, $objs[1]->getCatId());
    }



    /**
     * @test
     */
    public function get_use_prepare正常Test()
    {
        $sql = "select * from cat where cat_name = :cat_name";
        $params = [cat_name => 'faq'];
        $objs = $this->obj->get_use_prepare($sql, $params, Cat::class);
        $this->assertEquals(1, count($objs));
        $this->assertInstanceOf(Cat::class, $objs[0]);

        $this->assertEquals(2, $objs[0]->getCatId());
        $this->assertEquals('faq', $objs[0]->getCatName());
    }
}
