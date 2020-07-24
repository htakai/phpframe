<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/CreateHtmlTest2としてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\lib\html_view\CreateHtml;
use framework3\lib\html_view\HtmlDts;
use framework3\lib\html_view\CreateTagStr;

define('TEST', 1);
define("NOCACHE", 1);

class ExtCreateHtml extends CreateHtml
{
    public function public_cacheFree()
    {
        return $this->cacheFree();
    }

    public function getIdname()
    {
        return $this->id_name;
    }
    public function view()
    {
        echo 'ExtCreateHtml view!';
    }
}


class CreateHtmlTest2 extends TestCase
{
    protected $HtmlDts_obj;
    protected $CreateHtml_obj;
    protected $mock_CreateTagStr_obj;

    public function setUp()
    {
        $title = "create html test"; # #title# part insert.
        $id_name = "mytest"; # #id_name part insert.
        $dts = [[ #  #c1#　part insert.
                       [ "plain",
                         ["link" => "https://siawase.com/",
                          "str" => "plain textのテスト。"
                         ]
                       ]
                      ],
                      [ # #c2# part insert.
                        [ "tag",
                         ["link" => "https://iou./mypage.html/",
                          "h2" => "<>h2です。'"
                         ]
                       ]
                      ]
                     ];
        $temp_name = 'template_2notag';
        $this->HtmlDts_obj = new HtmlDts($title, $id_name, $dts);
        $this->CreateHtml_obj = new ExtCreateHtml($temp_name, $this->HtmlDts_obj);

        $this->mock_CreateTagStr_obj = Phake::mock(CreateTagStr::class);
    }

    /**
     * @test
     */
    public function getCreatehtmls正常Test()
    {
        $mock_dt = [['<h2>mock h2 string.</h2>',
                     '<p>mock p string.</p>'
                    ],
                    ['<h3>mock h3 string.</h3>'
                    ]
                   ];

        Phake::when($this->mock_CreateTagStr_obj)->create_htmlstr()->thenReturn($mock_dt);

        $expect = ['<h2>mock h2 string.</h2>'.
                   '<p>mock p string.</p>',
                   '<h3>mock h3 string.</h3>'
                   ];

        $contents = $this->CreateHtml_obj->getCreatehtmls($this->mock_CreateTagStr_obj);
        $this->assertEquals($expect, $contents);
    }

}
