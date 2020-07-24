<?php
/**
 * aplication client
 * 
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */
 
require_once __DIR__ . '/../../../news3/config.php';
require_once __DIR__ . '/../../../framework3/runfirst.php';


use framework3\lib\html_view\HtmlDts;
use news3\views\util\CreateTablesec1Temp2;

$id_name = "my_test_table_util";
$title = "Global Error Setting for php";
$h2plain = ["link"=>"https://siawase.com/",
                "str"=>"About mode"
               ];
$caption = "different from production mode and development mode";
$th = ["", "production", "development"];
$td = [["", "error_reporting", "E_ALL & ~E_DEPRECATED & ~E_STRICT", "E_ALL"],
           ["", "display_errors", "Off", "On"],
           ["", "display_startup_errors", "Off", "On"],
           ["", "track_errors", "Off", "On"],
           ["", "mysqlnd.collect_memory_statistics", "Off", "On"],
           ["", "zend.assertions", "-1", "1"],
           ["", "opcache.huge_code_pages", "1", "0"]
          ];
$p = ["p"=>"This is refer form php.ini-development file and php.ini-production file located into the php folder"];

$htmldts = new HtmlDts($title, $id_name);
CreateTablesec1Temp2::view($h2plain,$caption,$th,$td ,$p, $htmldts);
