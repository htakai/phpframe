<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/FutilTestとしてテスト.
 */

require_once __DIR__ .'/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use framework3\common\F_util;
use PHPUnit\Framework\TestCase;

define('TEST', 1);

class FutilTest extends TestCase
{
    /**
     * @test
     */
    public function hsエスケープする必要なしTest()
    {
        $this->assertEquals('takai', F_util::hs('takai'));
    }


    /**
     * @test
     */
    public function hsエスケープする必要ありTest()
    {
        $this->assertEquals(
                            '&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;',
                            F_util::hs("<a href='test'>Test</a>")
                            );
    }


    /**
     * @test
     */
    public function hsエスケープする必要あり配列の場合Test()
    {
        $in = ['takai', "<a href='test'>Test</a>"];
        $out = ['takai', '&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;'];

        $this->assertEquals($out, F_util::hs($in));
    }


    /**
     * @test
     */
     public function is_valid_phone_number正常スマホ番号()
     {
        $num = '000-0000-0000';
        $this->assertEquals($num, F_util::is_valid_phone_number($num));
     }


    /**
     * @test
     */
     public function is_valid_phone_number正常電話番号()
     {
        $num = '0000-00-0000';
        $this->assertEquals($num, F_util::is_valid_phone_number($num));
     }


     /**
     * @test
     */
     public function is_valid_phone_number異常全角文字列含む()
     {
        $num = '000１-00-0000';
        $this->assertFalse(F_util::is_valid_phone_number($num));
     }


    /**
     * @test
     */
     public function is_valid_phone_number異常桁数()
     {
        $num = '000-00000-0000';
        $this->assertFalse(F_util::is_valid_phone_number($num));
     }


    /**
     * @test
     */
     public function is_valid_url正常http()
     {
        $http = 'http://w-pecker.com/';
        $this->assertTrue(F_util::is_valid_url($http));
     }


    /**
     * @test
     */
     public function is_valid_url正常https()
     {
        $https = 'https://w-pecker.com/';
        $this->assertTrue(F_util::is_valid_url($https));
     }


    /**
     * @test
     */
    public function is_valid_url未対応mailto()
    {
        $mailto = 'mailto:test@example.com';
        $this->assertFalse(F_util::is_valid_url($mailto));
    }


    /**
     * @test
     */
    public function is_valid_url未対応ftp()
    {
        $ftp = 'ftp://yasasii.net/some.txt/';
        $this->assertFalse(F_util::is_valid_url($ftp));
    }
}
