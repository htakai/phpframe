<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/LinkdirDaoTestとしてテスト.
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/07/
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use news3\models\LinkdirDao;
use news3\models\Linkdir;
use framework3\common\FactoryClass;

define('TEST', 1);

class LinkdirDaoTest extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new LinkdirDao();
    }


    /**
     * @test
     */
    public function insert正常Test()
    {
        $params = [["dir_id" => null,
                    "dir_path" => "https://yasashii.net/",
                    ]];
        $cnt = $this->obj->insertDB($params);
        $this->assertEquals(1, $cnt);
    }

    /**
     * @test
     */
    public function get_objs正常Test2()
    {
        $sql = "select * from linkdir";
        $objs = $this->obj->get_objs($sql, Linkdir::class);
        $this->assertEquals(3, count($objs));
        $this->assertInstanceOf(Linkdir::class, $objs[0]);
    }

    /**
     * @test
     */
    public function get_use_prepare正常Test4()
    {
        $sql = "select * from linkdir where dir_path = :dir_path";
        $params = ["dir_path" => "https://yasashii.net/"];
        $objs = $this->obj->get_use_prepare($sql, $params, Linkdir::class);
        $this->assertEquals(1, count($objs));
        $this->assertInstanceOf(Linkdir::class, $objs[0]);
    }


    /**
     * @test
     */
    public function use_execDeleteTest5()
    {
        $sql = 'delete from linkdir where dir_path = "https://yasashii.net/"';
        $ret = $this->obj->use_exec($sql);
        $this->assertEquals(1, $ret);
    }
}
