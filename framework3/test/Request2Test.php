<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/Request2Testとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\mvc\Request;
use framework3\mvc\BadRequestException;
use framework3\common\ErrorFunc;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

class Request2Test extends TestCase
{
    protected $request;
    protected $reqs;

    // case test post mode , nesesary to change config.php U_MODE 3
    public function setUp() {
        $this->reqs = array( 'post'=>1,
                        'nm'=>"高井",
                      'age'=>62,
                      'fruits'=>array( '0'=>'orange',
                                      '1'=>'apple',
                                      '2'=>'banana'
                                    ),
                      );
        $this->request = new Request($this->reqs);
    }


    /**
     * @test
     */
    public function 正常にpostデータが格納されているnm()
    {
        $ret = $this->request->getPost('nm');
        $this->assertEquals("高井", $ret);
    }


    /**
     * @test
     */
    public function 正常にpostデータが格納されているage()
    {
        $ret = $this->request->getPost('age');
        $this->assertEquals(62, $ret);
    }


    /**
     * @test
     */
    public function 正常にpostデータが格納されているPost引数なし()
    {
        $ret = $this->request->getPost();
        $this->assertEquals($this->reqs, $ret);
    }


    /**
     * @test
     *
     */
    public function 定義されていないpostデータunknownが格納されている()
    {
//      $this->expectOutputString('400#unknown: request post key not exist!');
        $this->expectExceptionCode(BADREQUEST);
        $this->expectExceptionMessage('unknown: request post key not exist!');
        $ret = $this->request->getPost('unknown');
    }


    /**
     * @test
     * @depends 定義されていないpostデータunknownが格納されている
     */
    public function 定義されていないpostデータunknownが返すもの($ret)
    {
        $this->assertNull($ret);
    }


    /**
     * @test
     */
    public function 定義されていないpostデータ空文字が格納されているPost()
    {
        $this->expectExceptionCode(BADREQUEST);
        $this->expectExceptionMessage(' : request post key not exist!');
        $ret = $this->request->getPost(" ");
    }


    /**
     * @test
     */
    public function 定義されていないpostデータ空文字が格納されているPost2()
    {
        $this->expectExceptionCode(BADREQUEST);
        $this->expectExceptionMessage(': request post key not exist!');
        $ret = $this->request->getPost('');
    }


    /**
     * @test
     */
    public function chkDefindedKey関数が真になるケース()
    {
        $keys = array('post', 'nm', 'age', 'fruits');
        $this->assertTrue($this->request->chkDefindedKey($keys));
    }


    /**
     * @test
     */
    public function chkDefindedKey関数が偽になるケース1()
    {
        $keys =['post', 'nm', 'age', 'unknown',];
        $this->assertFalse($this->request->chkDefindedKey($keys));
    }


    /**
     * @test
     */
    public function chkDefindedKey関数が偽になるケース2()
    {
        $keys =['post', 'nm',];
        $this->assertFalse($this->request->chkDefindedKey($keys));
    }


    /**
     * @test
     */
    public function url_attr関数が正常に返されるケース1()
    {
        $param = 'http://w-pecker.com/';
        $ret = Request::url_attr($param);

        $this->assertEquals($ret, $param);
    }


    /**
     * @test
     */
    public function url_attr関数が正常に返されるケース2()
    {
        $param = 'https://yasashii.com/';
        $ret = Request::url_attr($param);

        $this->assertEquals($ret, $param);
    }


    /**
     * @test
     */
    public function url_attr関数が例外処理を出すケース1()
    {
        $this->expectExceptionCode(BADREQUEST);
        $this->expectExceptionMessage('request must start http or https!');
        $param = "javascript: alert('xss!')";
        $ret = Request::url_attr($param);
    }

}
