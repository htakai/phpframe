<?php
/**
 * aplication start file
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/09/
 */

require_once __DIR__ . '/../../../news3/config.php';
require_once __DIR__ . '/../../../framework3/runfirst.php';


use framework3\lib\html_view\HtmlDts;
use news3\views\Create2sec1;


$render_fname = "Create2sec1"; # 拡張子はつけない
$file = 'template_2';          # テンプレートファイル、拡張子はつけない
$id_name = "my_test3";
$title = "タグを生成しないケース";
$dts = ["今日はチラシ寿司",
         "明日はカレーうどんだ！",
       ];

$htmldts = new HtmlDts($title, $id_name, $dts);
$htmldts->display($render_fname, $file, $htmldts);
