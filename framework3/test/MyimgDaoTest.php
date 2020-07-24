<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/MyimgDaoTestとしてテスト.
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/07/
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use news3\models\MyimgDao;
use news3\models\Myimg;
use framework3\common\FactoryClass;
use news3\T_Const;

define('TEST', 1);

class MyimgDaoTest extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new MyimgDao();
    }


    /**
     * @test
     */
    public function insert正常Test()
    {
		$params = [["img_id" => null,
					"filename" => "myfile",
					"alt" => "myfile alt",
					"comment" => "myfile comment",
					"ext" => T_Const::PNG,
					"cat" => T_Const::CAT_STR['human'],
					]];
		$cnt = $this->obj->insertDB($params);
		$this->assertEquals(1, $cnt);	
	}
	
	/**
     * @test
     */
	public function get_objs正常Test2()
	{
		$sql = "select * from myimg";
		$objs = $this->obj->get_objs($sql, Myimg::class);
		$this->assertEquals(1, count($objs));
		$this->assertInstanceOf(Myimg::class, $objs[0]);
	}

	/**
     * @test
     */
	public function get_use_prepare正常Test4()
	{
		$sql = "select * from myimg where filename = :filename";
		$params = ["filename" => "myfile"];
		$objs = $this->obj->get_use_prepare($sql, $params, Myimg::class);
		$this->assertEquals(1, count($objs));
		$this->assertInstanceOf(Myimg::class, $objs[0]);
	}


	/**
     * @test
     */
	public function use_execDeleteTest5()
	{
		$sql = 'delete from myimg where filename = "myfile"';
		$ret = $this->obj->use_exec($sql);
		$this->assertEquals(1, $ret);
	}	
}	
	