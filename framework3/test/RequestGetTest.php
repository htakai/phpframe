<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/RequestGetTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\mvc\Request;
use framework3\mvc\BadRequestException;
use framework3\common\ErrorFunc;
use PHPUnit\Framework\TestCase;

define('TEST', 1);


class RequestGetTest extends TestCase
{
    protected $request;
    protected $reqs;

    //case test get mode , nesesary to change config.php U_MODE=1
    public function setUp() {
        $this->reqs = array( 'get'=>1,
                        'nm'=>"高井",
                      'age'=>62,
                      );
        $this->request = new Request($this->reqs);
    }


    /**
     * @test
     */
    public function 正常にgetデータが格納されているnm()
    {
        $ret = $this->request->getQuery('nm');
        $this->assertEquals("高井", $ret);
    }


    /**
     * @test
     */
    public function 正常にgetデータが格納されているage()
    {
        $ret = $this->request->getQuery('age');
        $this->assertEquals(62, $ret);
    }


    /**
     * @test
     */
    public function 正常にgetデータが格納されているget引数なし()
    {
        $ret = $this->request->getQuery();
        $this->assertEquals($this->reqs, $ret);
    }


    /**
     * @test
     */
    public function 定義されていないgetデータunknownが格納されている()
    {
        $this->expectExceptionCode(BADREQUEST);
        $this->expectExceptionMessage('unknown: request query key not exist!');
        $ret = $this->request->getQuery('unknown');
    }


    /**
     * @test
     */
    public function 定義されていないgetデータ空文字が格納されている()
    {
        $this->expectExceptionCode(BADREQUEST);
        $this->expectExceptionMessage(' : request query key not exist!');
        $ret = $this->request->getQuery(" ");
    }


    /**
     * @test
     */
    public function 定義されていないgetデータ空文字が格納されている2()
    {
        $this->expectExceptionCode(BADREQUEST);
        $this->expectExceptionMessage(': request query key not exist!');
        $ret = $this->request->getQuery('');
    }


    /**
     * @test
     */
    public function chkDefindedKey関数が真になるケース()
    {
        $keys =['get', 'nm', 'age',];
        $this->assertTrue($this->request->chkDefindedKey($keys));
    }


    /**
     * @test
     */
    public function chkDefindedKey関数が偽になるケース1()
    {
        $keys =['get', 'nm', 'unknown',];
        $this->assertFalse($this->request->chkDefindedKey($keys));
    }


    /**
     * @test
     */
    public function chkDefindedKey関数が偽になるケース2()
    {
        $keys =['get', 'nm',];
        $this->assertFalse($this->request->chkDefindedKey($keys));
    }
}
