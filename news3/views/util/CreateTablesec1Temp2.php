<?php
/**
  * utility create table use template_table2.php file.
  *
  */

namespace news3\views\util;


use framework3\lib\html_view\HtmlDts;
use news3\views\CreateTablesec1;


class CreateTablesec1Temp2
{
     /*
      * table view function
      *
      * @param array $h2plain
      * @param string $caption
      * @param array $th
      * @param array $td
      * @param array $p
      * @param HtmlDts $htmldts
      */
    public static function view (
                                array $h2plain,
                                string $caption,
                                array $th,
                                array $td ,
                                array $p,
                                HtmlDts $htmldts
                                ): void
    {
        $render = "createTablesec1"; # rendering file
        $temp = "template_table2"; # template file

        $dt = [];

        $dt[0][0][0] = "plain";
        $dt[0][0][] = $h2plain; # ex. $h2plain=["link"=>"val1","str"=>"val2"]
        $dt[1][0][0] = "table";
        $dt[1][0]["caption"] = $caption;
        $dt[1][0]["th"] = $th;# ex. $th=["","th1","th2"]
        $dt[1][0]["td"] = $td;# ex. $td =["","td1","td2","td3"],,,

        $dt[1][1][0] = "tag";
        $dt[1][1][] = $p;# ex. $p=["p"=>"val"]

        //ex. $dt[0]はtemplate_table.phpの#h2-1#、$dt[1]は#table1#をreplaceされる
        $htmldts->addDtblock($dt[0]);
        $htmldts->addDtblock($dt[1]);
        $htmldts->display($render, $temp, $htmldts);
    }
}
