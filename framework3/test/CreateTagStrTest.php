<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/CreateTagStrTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\lib\html_view\CreateTagStr;
//use framework3\common\F_util;

define('TEST', 1);

class CreateTagStrTest extends TestCase
{

    public function setUp()
    {
    }

    /**
     * @test
     */
    public function createPlain成功Test()
    {
        $dts = [
                  [ "link" => "https://siawase.com/",
                    "str" => "plain text"
                  ],
                ];

        $expect = '<a href="<?= F_util::esc_url("https://siawase.com/") ?>"><?= F_util::hs("plain text")?></a>';
        $ret = CreateTagStr::createPlain($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createPlain成功Test2()
    {
        $dts = [
                  [ "str" => "plain text日本語"
                  ],
               ];

        $expect = '<?= F_util::hs("plain text日本語")?>';
        $ret = CreateTagStr::createPlain($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createPlain成功Test3()
    {
        // strキーに対して、二つ以上の値を指定しても最後に指定したものだけが反映される.、
        $dts = [
                  [ "str" => "plain text日本語",
                    "str" => "plain text英語",
                  ],
               ];

        $expect .= '<?= F_util::hs("plain text英語")?>';
        $ret = CreateTagStr::createPlain($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createPlain異常Test4()
    {
        // array set except 'link'key or 'str'key.!
        $dts = [
                  [ "p" => "p text",
                  ],
               ];
        $this->expectExceptionCode(DOMAIN);
        $this->expectExceptionMessage('do not parse tag use!');

        CreateTagStr::createPlain($dts);
    }


    /**
     * @test
     */
    public function createPlain異常Test5()
    {
        // array structur mistake!
        $dts = [ "str" => "plain text"
               ];
        $this->expectExceptionCode(DOMAIN);
        $this->expectExceptionMessage('array is defined mistake!');

        CreateTagStr::createPlain($dts);
    }


    /**
     * @test
     */
    public function createStrParts成功Test6()
    {
        $dts = [
                   ["link" => "http://wherever1.com",
                    "str" => "somehow1",
                   ],
                   ["link" => "",
                    "str" => "somehow2",
                   ],
               ];
        $expect = ['<a href="http://wherever1.com"><?=F_util::hs("somehow1")?></a>',
                   '<?=F_util::hs("somehow2")?>',
                  ];
        $ret = CreateTagStr::createStrParts($dts);
        $this->assertEquals($ret, $expect);

        return $ret;
    }


    /**
     * @test
     */
    public function createStrParts失敗Test7()
    {
        $dts = [
                   ["link" => "http://wherever1.com",
                    "str" => "",  # empty value!.
                   ],
                   ["link" => "",
                    "str" => "somehow2",
                   ],
               ];
        $this->expectExceptionCode(LOGIC);
        $this->expectExceptionMessage('hash str value empty!');

        CreateTagStr::createStrParts($dts);
    }


    /**
     * @test
     */
    public function createStrParts失敗Test8()
    {
        // array structur mistake!
        $dts = [ "link" => "http://wherever1.com",
                  "p" => "somehow"
               ];
        $this->expectExceptionCode(LOGIC);
        $this->expectExceptionMessage('array is defined mistake!');

        CreateTagStr::createStrParts($dts);
    }


    /**
     * @test
     * @depends createStrParts成功Test6
     */
    public function createUL実活用Test9($ret)
    {
        $ret2 = CreateTagStr::createUL($ret);
        $expect = "\n".'<ul>'."\n".
                   '  <li><a href="http://wherever1.com"><?=F_util::hs("somehow1")?></a></li>'."\n".
                    '  <li><?=F_util::hs("somehow2")?></li>'."\n".
                   '</ul>';
        $this->assertEquals($ret2, $expect);
    }


    /**
     * @test
     * @depends createStrParts成功Test6
     */
    public function createOL実活用Test10($ret)
    {
        $ret2 = CreateTagStr::createOL($ret);
        $expect = "\n".'<ol>'."\n".
                   '  <li><a href="http://wherever1.com"><?=F_util::hs("somehow1")?></a></li>'."\n".
                    '  <li><?=F_util::hs("somehow2")?></li>'."\n".
                   '</ol>';
        $this->assertEquals($ret2, $expect);
    }
}
