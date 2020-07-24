<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/CreateHtmlTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\lib\html_view\CreateHtml;
use framework3\lib\html_view\HtmlDts;

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


class CreateHtmlTest extends TestCase
{
    protected $HtmlDts_obj;
    protected $CreateHtml_obj;

    public function setUp()
    {
        $title = "create html test"; # #title# part insert.
        $id_name = "mytest"; # #id_name part insert.
        $dts = [[ #  #c1#　part insert.
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
        $temp_name = 'template_2notag';
        $this->HtmlDts_obj = new HtmlDts($title, $id_name, $dts);
        $this->CreateHtml_obj = new ExtCreateHtml($temp_name, $this->HtmlDts_obj);

    }


    /**
     * @test
     */
    public function cacheFree正常Test()
    {
        $old_idname = $this->CreateHtml_obj->getIdname();
        $this->CreateHtml_obj->public_cacheFree();
        $new_idname = $this->CreateHtml_obj->getIdname();

        $this->assertNotSame($new_idname, $old_idname);
    }
}
