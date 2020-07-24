<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/DtDaoTestとしてテスト.
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/07/
 */


require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use news3\models\DtDao;
use news3\models\Dt;
use framework3\common\FactoryClass;

define('TEST', 1);

class DtDaoTest extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new DtDao();
    }


    /**
     * @test
     */
    public function insert正常Test()
    {
		$params = [["id" => null,
					"cat_id" => 1,
					"title" => "タイトル",
					"contents" => "本文",
					"img_id" => null,
					]];
		$cnt = $this->obj->insertDB($params);
		$this->assertEquals(1, $cnt);	
	}
	
	/**
     * @test
     */
    public function setDtproperty正常Test2()
	{
		$dt_obj = new Dt();
		$params = ["id" => null,
					"cat_id" => 2,
					"title" => "タイトル2",
					"contents" => "本文2",
					"link_dir_id" => 1,
					"link_fname" => "fname.html",
					];
		$ret_obj = $this->obj->setDtproperty($dt_obj, $params);	
		$this->assertInstanceOf(Dt::class, $ret_obj);
		$this->assertEquals(null, $ret_obj->getId());
		$this->assertEquals(2, $ret_obj->getCatId());
		$this->assertEquals("タイトル2", $ret_obj->getTitle());
		$this->assertEquals("本文2",$ret_obj->getContents());
		$this->assertEquals(1, $ret_obj->getLinkDirId());
		$this->assertEquals("fname.html", $ret_obj->getLinkFname());
		$this->assertEquals(null, $ret_obj->getImgId());
		$this->assertEquals(null, $ret_obj->getdDate());
		$this->assertEquals(null, $ret_obj->getDtstopFlg());		
	}
	
	/**
     * @test
     */
	public function get_objs正常Test3()
	{
		$sql = "select * from dt";
		$objs = $this->obj->get_objs($sql, Dt::class);
		$this->assertEquals(1, count($objs));
		$this->assertInstanceOf(Dt::class, $objs[0]);
	}

	/**
     * @test
     */
	public function get_use_prepare正常Test4()
	{
		$sql = "select * from dt where cat_id = :cat_id and title = :title";
		$params = ["cat_id" => 1, "title" => "タイトル"];
		$objs = $this->obj->get_use_prepare($sql, $params, Dt::class);
		$this->assertEquals(1, count($objs));
		$this->assertInstanceOf(Dt::class, $objs[0]);
	}

	/**
     * @test
     */
	public function use_execDeleteTest5()
	{
		$sql ="delete from dt where cat_id = 1";
		$ret = $this->obj->use_exec($sql);
		$this->assertEquals(1, $ret);
	}	
}
