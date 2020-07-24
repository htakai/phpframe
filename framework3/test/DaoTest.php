<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/DaoTestとしてテスト.
 */


require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\mvc\Dao;
use framework3\mvc\DB;
use news3\models\Cat;

define('TEST', 1);

// created follows for sqlite db
//
// CREATE TABLE IF NOT EXISTS cat(
//          cat_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
//          cat_name TEXT NOT NULL)
// INSERT INTO cat(cat_id, cat_name) VALUES
//             (null,news)
//            ,(null,faq)

class DaoTest extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new Dao();
    }


    /**
     * @test
     */
    public function use_query正常Test()
    {
        // use_queryの$dnsはAPPNAMEフォルダー内のconfig.phpに定義されているdns名を指定することになる。ここでは'local'と指定している。具体的なdnsの中身はAPPNAMEフォルダー内のdbinit.phpで関連すけられている。
        $sql = "select * from cat";
        $stmt = $this->obj->use_query($sql, 'local');
        $hash = DB::retHash($stmt);
        $cat_names = [$hash[1], $hash[2]];
        $expect = ['news', 'faq'];
        $this->assertEquals($cat_names, $expect);

    }

    /**
     * @test
     */
    public function use_query正常Test2()
    {
        // use_queryの$dnsはAPPNAMEフォルダー内のconfig.phpに定義されているdns名を指定することになる。ここでは'local'と指定している。具体的なdnsの中身はAPPNAMEフォルダー内のdbinit.phpで関連ずけられている。
        $sql = "select * from cat";
        $stmt = $this->obj->use_query($sql); # 引数$dnsを省略するとデフォルトでDNS1、つまり、localがセットされることになる。
        $hash = DB::retHash($stmt);
        $cat_names = [$hash[1], $hash[2]];
        $expect = ['news', 'faq'];
        $this->assertEquals($cat_names, $expect);
    }


    /**
     * @test
     */
    public function use_query異常Test3()
    {
        // use_queryの$dnsはAPPNAMEフォルダー内のconfig.phpに定義されているdns名を指定することになる。具体的なdnsの中身はAPPNAMEフォルダー内のdbinit.phpで関連ずけられている。
        // ここでは、定義づけられていないremoteを指定。
        $this->expectExceptionCode(LOGIC);
        $this->expectExceptionMessage('unknown-->Unknown database!');
        $sql = "select * from cat";
        $stmt = $this->obj->use_query($sql, 'unknown'); # unknownは定義されていない。
    }


    /**
     * @test
     */
    public function get_col正常Test41()
    {
        // $sql = "insert into cat (cat_name) values (:cat_name)";
        // $names = [
                  // ["cat_name" => "add_category"],
                 // ];
        // $cnt = DB::prepare_not_getdt($sql, $names, DNS1);
// print('cnt='.$cnt);
        $sql = "select cat_name from cat";
        $cat_names = $this->obj->get_col($sql);

        // $expect = ['news', 'faq', 'add_category'];
        $expect = ['news', 'faq'];
        $this->assertEquals($cat_names, $expect);
    }

    /**
     * @test
     */
    public function get_col異常Test4()
    {
        // 定義されてないカラム名指定.
        $this->expectExceptionCode(HY000);  # HY000はPDO のエラーコード.
        $sql = "select notexist from cat";
        $notexsists = $this->obj->get_col($sql);
    }


    /**
     * @test
     */
    public function getHash正常Test5()
    {
        $sql = "select * from cat";
        $cats = $this->obj->getHash($sql);

//        $expect = [1 => 'news', 2 => 'faq', 3 => 'add_category'];
        $expect = [1 => 'news', 2 => 'faq'];
        $this->assertEquals($cats, $expect);

    }


    /**
     * @test
     */
    public function get_use_prepare正常Test6()
    {
        $sql = "select * from cat where cat_name = :name";
        $params = ["name" => "faq"];
        $classname = Cat::class;
        $created_obj = $this->obj->get_use_prepare($sql, $params, $classname);
        $this->assertTrue($created_obj[0] instanceof $classname);
        $this->assertEquals("faq", $created_obj[0]->getCatName());

    }


    /**
     * @test
     */
    public function get_col_use_prepare正常Test7()
    {
        $sql = "select cat_name from cat where cat_id = :cat_id";
        $ids = [["cat_id" => 1],
                ["cat_id" => 2]
               ];
        $ret = $this->obj->get_col_use_prepare($sql, $ids);
        $this->assertTrue(is_array($ret));
        $this->assertTrue(is_array($ret[0]));
        $this->assertEquals('news', $ret[0][0]);
        $this->assertEquals('faq', $ret[1][0]);
    }

    /**
     * @test
     */
    public function get_col_use_prepare異常Test7()
    {
        $this->expectExceptionCode(INVALID);
        $this->expectExceptionMessage('DB::prepare_select: params argument mistake!');
        $sql = "select cat_name from cat where cat_id = :cat_id";
        $ids = ["cat_id" => 1]; # mistake!.

        $ret = $this->obj->get_col_use_prepare($sql, $ids);
    }


    /**
     * @test
     */
    public function use_exec正常Test8()
    {
        $sql = "select * from cat";
        $stmt = $this->obj->use_query($sql);
        $hash = DB::retHash($stmt);
        // $cat_names = [$hash[1], $hash[2], $hash[3]];
        // $expect = ['news', 'faq', 'add_category'];
        $cat_names = [$hash[1], $hash[2]];
        $expect = ['news', 'faq'];
        $this->assertEquals($cat_names, $expect);
    }


    /**
     * @test
     */
    public function ope_use_prepare正常Test9()
    {
        $sql = "insert into cat (cat_name) values (:cat_name)";
        $names = [['cat_name' => 'add_category']
                 ];
        $cnt = DB::prepare_not_getdt($sql, $names, DSN1);

        $this->assertEquals(1, $cnt);

        $sql = "select * from cat";
        $stmt = $this->obj->use_query($sql);
        $hash = DB::retHash($stmt);
        $cat_names = array_values($hash);
        $expect = ['news', 'faq', 'add_category'];
        $this->assertEquals($cat_names, $expect);
    }


    /**
     * @test
     */
    public function ope_use_prepare正常Test10()
    {
        $sql = "update cat set cat_id = 3 where cat_name = :cat_name";
        $params = [['cat_name' => 'add_category']];
        $ret = $this->obj->ope_use_prepare($sql, $params);
        $this->assertEquals(1, $ret);

        $sql = "delete from cat where cat_id = :cat_id";
        $params = [['cat_id' => 3]];
        $ret = $this->obj->ope_use_prepare($sql, $params);

        $sql = "select cat_name from cat";
        $cat_names = $this->obj->get_col($sql);
        $expect = ['news', 'faq'];
        $this->assertEquals($cat_names, $expect);

        $sql = "select cat_id from cat";
        $cat_ids = $this->obj->get_col($sql);
        $expect = [1, 2];
        $this->assertEquals($cat_ids, $expect);

    }

    /**
     * @test
     */
    public function ope_use_prepare異常Test11()
    {
        $this->expectExceptionCode(INVALID);
        $this->expectExceptionMessage('DB::prepare_not_getdt: params argument mistake!');
        $sql = "update cat set cat_id = 3 where cat_name = :cat_name";
        $params = ['cat_name' => 'add_category']; # mistake!.

        $ret = $this->obj->ope_use_prepare($sql, $params);

    }
}
