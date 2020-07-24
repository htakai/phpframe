<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/FutilTest2としてテスト.
 */

require_once __DIR__ .'/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\common\F_util;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

class FutilTest2 extends TestCase
{
    /**
     * @test
     */
    public function esc_url正常1()
    {
        $http = 'http://w-pecker.com/';
        $this->assertEquals($http, F_util::esc_url($http));
    }


    /**
     * @test
     */
    public function esc_url正常2()
    {
        $https = 'https://w-pecker.com/';
        $this->assertEquals($https, F_util::esc_url($https));
    }


    /**
     * @test
     */
    public function esc_url正常3()
    {
        $https = 'https://w-pecker.com/?id=123';
        $this->assertEquals($https, F_util::esc_url($https));
    }


    /**
     * @test
     */
    public function esc_url正常4()
    {
        $https = 'https://w-pecker.com/some.txt';
        $this->assertEquals($https, F_util::esc_url($https));
    }


    /**
     * @test
     */
    public function esc_url無効filename1()
    {
        $file = '/file.html';
        $this->assertEquals("", F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url無効url1()
    {
        $file = 'ftp://example.com/pub/file.txt';
        $this->assertEquals("", F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url無効url2()
    {
        $file = 'http://w-pecker.com/?id=あ　';
        $this->assertEquals("", F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url無効url3()
    {
        $file = 'http://w-pecker.com/?id=<あ　>';
        $this->assertEquals("", F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url無効url4()
    {
        $file = 'http://w-pecker.com/?名前=たかい';
        $this->assertEquals("", F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url無効query1()
    {
        $file = 'https://w-pecker.com/?';
        $this->assertEquals("https://w-pecker.com/", F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url無効query2()
    {
        $file = 'http://w-pecker.com/?id="高井';
        $this->assertEquals("", F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url変換query1()
    {
        $file    = 'http://w-pecker.com/?id=#12_';
        $encoded = 'http://w-pecker.com/?id=%2312_';
        $this->assertEquals($encoded, F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url変換query2()
    {
        $file    = 'http://w-pecker.com/?id=<#12_>';
        $encoded = 'http://w-pecker.com/?id=%3C%2312_%3E';
        $this->assertEquals($encoded, F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url変換query3()
    {
        $file    = 'http://w-pecker.com/?my->name=takai';
        $encoded = 'http://w-pecker.com/?my-%3Ename=takai';
        $this->assertEquals($encoded, F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url変換query4()
    {
        $file    = 'http://w-pecker.com/?id=123&pass=23kio&date=0310&0311';
        $encoded = 'http://w-pecker.com/?id=123&pass=23kio&date=0310%260311';
        $this->assertEquals($encoded, F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url変換query5()
    {
        $file    = 'http://w-pecker.com/some<javascript>.txt';
        $escape = 'http://w-pecker.com/some&lt;javascript&gt;.txt';
        $this->assertEquals($escape, F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_url変換query6()
    {
        $file    = 'http://w-pecker.com/?pass=<somehow>';
        $escape = 'http://w-pecker.com/?pass=%3Csomehow%3E';
        $this->assertEquals($escape, F_util::esc_url($file));
    }


    /**
     * @test
     */
    public function esc_urlデコードquery6()
    {
        $file    = 'http://w-pecker.com/?pass=<somehow>';
        $decoded = F_util::hs(rawurldecode(F_util::esc_url($file)));
        $result  = 'http://w-pecker.com/?pass=&lt;somehow&gt;';
        $this->assertEquals($result, $decoded);
    }

}
