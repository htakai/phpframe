<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/HtmlDtsTest3としてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\lib\html_view\HtmlDts;

define('TEST', 1);

class HtmlDtsTest3 extends TestCase
{
    protected $render_fname = "Create2sec1"; # set APPNAME\views\CreateException for operating.
    protected $title = "タグを生成しないケース"; # #title# part insert.
    protected $id_name = "mytest3"; # #id_name part insert.
    protected $temp_fname = "template_2"; #  APPNAME/views/mytemplate/template_2.php for creating view file.
    protected $obj;
    protected $dts = ["今日はチラシ寿司",
                      "明日はカレーうどんだ！",
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
}
