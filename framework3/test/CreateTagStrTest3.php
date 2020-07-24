<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/CreateTagStrTest3としてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\lib\html_view\CreateTagStr;
use framework3\common\F_util;

define('TEST', 1);

class CreateTagStrTest3 extends TestCase
{
    protected $obj;

    public function setUp()
    {
        $this->obj = new CreateTagStr();
    }


    /**
     * @test
     */
    public function create_htmlstr成功Test()
    {
        $dts = [
                [
                 [ "tag",
                    ["h2" => "h2タグテストです。",
                    ],
                 ]
                ]
               ];
        $expect = "\n".'<h2><?= F_util::hs("h2タグテストです。")?></h2>'."\n";

        $block = $this->obj->create_htmlstr($dts);

        $this->assertEquals($block[0][0], $expect);
    }


    /**
     * @test
     */
    public function create_htmlstr異常Test2()
    {
        // ありえない生成関数分類名である.
        $dts = [
                [
                 [ "strong",  # 生成関数分類名.
                    ["h2" => "h2タグテストです。",
                    ],
                 ]
                ]
               ];
        $this->expectExceptionCode(DOMAIN);
        $this->expectExceptionMessage('can not select defined function!');

        $this->obj->create_htmlstr($dts);

    }

}
