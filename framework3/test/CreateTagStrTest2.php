<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/CreateTagStrTest2としてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\lib\html_view\CreateTagStr;
use framework3\common\F_util;

define('TEST', 1);

class CreateTagStrTest2 extends TestCase
{
    /**
     * @test
     */
    public function createUL成功Test()
    {
        $dts = ["東京", "大阪", "名古屋"];
        $expect = "\n"."<ul>"."\n"."  <li>東京</li>"."\n"."  <li>大阪</li>"."\n"."  <li>名古屋</li>"."\n"."</ul>";
        $ret = CreateTagStr::createUL($dts);

        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createUL失敗Test()
    {
        // 引数がnullの場合は空文字列をかえす.
        $dts = [];
        $expect = "";
        $ret = CreateTagStr::createUL($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createOL成功Test2()
    {
        $dts = ["東京", "大阪", "名古屋"];
        $expect = "\n"."<ol>"."\n"."  <li>東京</li>"."\n"."  <li>大阪</li>"."\n"."  <li>名古屋</li>"."\n"."</ol>";
        $ret = CreateTagStr::createOL($dts);

        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createOL失敗Test()
    {
        // 引数がnullの場合は空文字列をかえす.
        $dts = [];
        $expect = "";
        $ret = CreateTagStr::createOL($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createIMG成功Test3()
    {
        $dts = ["link" => "https://whereever2.net",
                "name" => "tree",
                "alt"  => "家族団らんの貴重な時間でした。",
               ];
        $httphost = '';  // $_SERVER['HTTP_HOST']がphpunitでは使えない.
        $expect = "\n".'<a href="<?= F_util::esc_url("https://whereever2.net") ?>"><img src="http://'.$httphost.'/news3/imgs/<?=F_util::hs("tree") ?>.png" alt="<?=F_util::hs("家族団らんの貴重な時間でした。")?>"></a>';
        $ret = CreateTagStr::createIMG($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createIMG成功Test4()
    {
        $dts = ["link" => "https://whereever2.net",
                "name" => "tree",
                "alt"  => "家族団らんの貴重な時間でした。",
               ];
        $httphost = '';  // $_SERVER['HTTP_HOST']がphpunitでは使えない.
        $expect = "\n".'<a href="<?= F_util::esc_url("https://whereever2.net") ?>"><img src="http://'.$httphost.'/news3/imgs/<?=F_util::hs("tree") ?>.png" alt="<?=F_util::hs("家族団らんの貴重な時間でした。")?>"></a>';
        $ret = CreateTagStr::createIMG($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createIMG成功Test5()
    {
        $dts = ["name" => "tree"
               ];
        $httphost = '';  // $_SERVER['HTTP_HOST']がphpunitでは使えない.
        $expect = "\n".'<img src="http://'.$httphost.'/news3/imgs/<?=F_util::hs("tree") ?>.png" alt="<?=F_util::hs("")?>">';
        $ret = CreateTagStr::createIMG($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createDL成功Test7()
    {
        $dts = [
                ["dt" => "お母さん",
                 "dd" => "優しい",
                ],

                ["link" => "http://whereever2.net",
                 "dt" => "お父さん",
                 "dd" => "たくましい",
                ],
               ];
        $expect = "\n".'<dl>'."\n".
        ' <dt><?= F_util::hs("お母さん") ?></dt>'."\n".
        '  <dd><?= F_util::hs("優しい") ?></dd>'."\n".
        ' <dt><?= F_util::hs("お父さん") ?></dt>'."\n".
        '  <dd><a href="<?= F_util::esc_url("http://whereever2.net") ?>"><?= F_util::hs("たくましい") ?></a></dd>'."\n".
        '</dl>'."\n";
        $ret = CreateTagStr::createDL($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createDL成功Test8()
    {
        $dts = [
                ["dt" => "お母さん",
                ],

                ["link" => "http://whereever2.net",
                 "dt" => "お父さん",
                 "dd" => "たくましい",
                ],
               ];
        $expect = "\n".'<dl>'."\n".
        ' <dt><?= F_util::hs("お母さん") ?></dt>'."\n".
        ' <dt><?= F_util::hs("お父さん") ?></dt>'."\n".
        '  <dd><a href="<?= F_util::esc_url("http://whereever2.net") ?>"><?= F_util::hs("たくましい") ?></a></dd>'."\n".
        '</dl>'."\n";
        $ret = CreateTagStr::createDL($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createDL失敗Test9()
    {
        // case empty($dts[]['dt']) == true.
        $dts = [
                ["dt" => "",
                 "dd" => "優しい",
                ],

                ["link" => "http://whereever2.net",
                 "dt" => "お父さん",
                 "dd" => "たくましい",
                ],
               ];
        $expect = "";
        $ret = CreateTagStr::createDL($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createTag成功Test10()
    {
        $dts = [
                ["link" =>"http://w-pecker.com/?p=2&id=4",
                 "p" => "自然派の宿です。"
                ]
               ];
        $expect = "\n".'<p><a href="<?= F_util::esc_url("http://w-pecker.com/?p=2&id=4") ?>"><?= F_util::hs("自然派の宿です。")?></a></p>'."\n";
        $ret = CreateTagStr::createTag($dts);
        $this->assertEquals($ret, $expect);
    }

    /**
     * @test
     */
    public function createTag失敗Test11()
    {
        // link以外の生成可能タグの値が空文字の場合は、何も生成されない.
        $dts = [
                ["link" =>"http://w-pecker.com/?p=2&id=4",
                 "p" => ""
                ]
               ];
        $expect = "";
        $ret = CreateTagStr::createTag($dts);
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createTag異常Test12()
    {
        // case that tag is not defined!
        $dts = [
                ["link" =>"http://w-pecker.com/?p=2&id=4",
                 "h7" => "自然派の宿です。"
                ]
               ];
        $this->expectExceptionCode(DOMAIN);
        $this->expectExceptionMessage('do not parse tag use!');

        CreateTagStr::createTag($dts);
    }


    /**
     * @test
     */
    public function createTable成功Test13()
    {
        $dts = ["caption" => "名簿表",
                "th" => ["名前","住所","年齢"],
                "td" => [
                           ["","高い","山梨県韮崎市",62],
                           ["http://w-pecker.com/","清水","埼玉県",24],
                           ["","荒川","千葉県松戸市",93],
                         ],
                ];

        $expect = '<table>'."\n".
                  '  <caption><?= F_util::hs("名簿表") ?></caption>'."\n".
                  '  <tr>'."\n".
                  '    <th><?= F_util::hs("名前") ?></th>'."\n".
                  '    <th><?= F_util::hs("住所") ?></th>'."\n".
                  '    <th><?= F_util::hs("年齢") ?></th>'."\n".
                  '  </tr>'."\n".
                  '  <tr>'."\n".
                  '    <td><?= F_util::hs("高い") ?></td>'."\n".
                  '    <td><?= F_util::hs("山梨県韮崎市") ?></td>'."\n".
                  '    <td><?= F_util::hs("62") ?></td>'."\n".
                  '  </tr>'."\n".
                  '  <tr>'."\n".
                  '    <td><a href="<?= F_util::esc_url("http://w-pecker.com/") ?>"><?= F_util::hs("清水") ?></a></td>'."\n".
                  '    <td><?= F_util::hs("埼玉県") ?></td>'."\n".
                  '    <td><?= F_util::hs("24") ?></td>'."\n".
                  '  </tr>'."\n".
                  '  <tr>'."\n".
                  '    <td><?= F_util::hs("荒川") ?></td>'."\n".
                  '    <td><?= F_util::hs("千葉県松戸市") ?></td>'."\n".
                  '    <td><?= F_util::hs("93") ?></td>'."\n".
                  '  </tr>'."\n".
                  '</table>'."\n";
        $ret = CreateTagStr::createTable($dts);
		
        $this->assertEquals($ret, $expect);
    }


    /**
     * @test
     */
    public function createTable失敗Test14()
    {
        // $dts['td'] not isset!.
        $dts = ["caption" => "名簿表",
                "th" => ["名前","住所","年齢"],
               ];
        $expect = "";
        $ret = CreateTagStr::createTable($dts);
        $this->assertEquals($ret, $expect);
    }

}
