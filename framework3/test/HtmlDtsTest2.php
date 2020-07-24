<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/HtmlDtsTest2としてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\lib\html_view\HtmlDts;

define('TEST', 1);

class HtmlDtsTest2 extends TestCase
{
    protected $title = "create html test"; # #title# part insert.
    protected $id_name = "mytest"; # #id_name part insert.
    protected $obj;

    public function setUp()
    {
        // 生成タグデータはあとから.
        $this->obj = new HtmlDts($this->title, $this->id_name);
    }


    /**
     * @test
     */
    public function addDtblock正常Test()
    {
        $dtblock = [
                ["img",
                 ["link" => "https://whereever2.net",
                  "name" => "tree",
                  "alt" => "家族団らんの貴重な時間でした。",
                 ],
                ]
               ];
        $this->obj->adddtblock($dtblock);
        $expect = [
                   [
                    ["img",
                     ["link" => "https://whereever2.net",
                      "name" => "tree",
                      "alt" => "家族団らんの貴重な時間でした。",
                     ],
                    ]
                   ]
                  ];
        $this->assertEquals($expect, $this->obj->getDts());

        $render_fname = 'Create2sec1';
        $temp_fname = 'template_2notag';
        $create_ns_classname = 'news3\\views\\'. $render_fname;
        $instance = $this->obj->display($render_fname, $temp_fname, $this->obj);
        $this->assertTrue($instance instanceof $create_ns_classname);

    }
}
