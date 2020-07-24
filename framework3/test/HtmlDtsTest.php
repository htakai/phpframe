<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/HtmlDtsTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\lib\html_view\HtmlDts;

define('TEST', 1);

class HtmlDtsTest extends TestCase
{
    protected $render_fname = "Create2sec1"; # set APPNAME\views\CreateException for operating.
    protected $title = "create html test"; # #title# part insert.
    protected $id_name = "mytest"; # #id_name part insert.
    protected $temp_fname = "template_2notag"; #  APPNAME\views\mytemplate\template_2notag for creating view file.
    protected $obj;
    protected $dts = [[ #  #c1#　part insert.
                       [ "plain",
                         ["link" => "https://siawase.com/",
                          "str" => "plain textのテスト。"
                         ],
                       ],
                      ],
                      [ # #c2# part insert.
                        [ "tag",
                         ["link" => "https://iou./mypage.html/",
                          "h2" => "<>h2です。'"
                         ],
                       ],
                      ],
                     ];

    public function setUp()
    {
        $this->obj = new HtmlDts($this->title, $this->id_name, $this->dts);
    }


    /**
     * @test
     */
    public function display正常Test()
    {
        $create_ns_classname = 'news3\\views\\'. $this->render_fname;
        $instance = $this->obj->display($this->render_fname, $this->temp_fname, $this->obj);
        $this->assertTrue($instance instanceof $create_ns_classname);
    }


    /**
     * @test
     */
    public function addDtTag正常Test()
    {
        // add tag data.
        $block_num = 0;
        $add_dt_tag = [ "img",
                       ["link" => "https://whereever2.net",
                        "name" => "tree",
                        "alt" => "家族団らんの貴重な時間でした。",
                       ],
                      ];
        $expect = [[ #  #c1#　part insert.
                    [ "plain",
                      ["link" => "https://siawase.com/",
                       "str" => "plain textのテスト。"
                      ],
                    ],
                    [ "img",
                     ["link" => "https://whereever2.net",
                      "name" => "tree",
                      "alt" => "家族団らんの貴重な時間でした。",
                     ],
                    ],
                   ],
                   [ # #c2# part insert.
                     [ "tag",
                      ["link" => "https://iou./mypage.html/",
                       "h2" => "<>h2です。'",
                      ],
                     ],
                   ],
                  ];
        $this->obj->addDtTag($block_num, $add_dt_tag);
        $this->assertEquals($expect, $this->obj->getDts());
    }


    /**
     * @test
     */
    public function createRenderObj異常()
    {
        // throw RuntimeException at ClassLoader (77).
        $this->expectExceptionCode(RUNTIME);
        $this->expectExceptionMessage('news3\\views\\not_exist_file:load file not exist!');

        $not_exist_render_filename = 'not_exist_file';
        $instance = $this->obj->display($not_exist_render_filename, $this->temp_fname, $this->obj);

    }
}
