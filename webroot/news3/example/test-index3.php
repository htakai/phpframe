<?php
/**
 * aplication start file
 * 
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */
 
 
require_once __DIR__ . '/../../../news3/config.php';
require_once __DIR__ . '/../../../framework3/runfirst.php';


use framework3\lib\html_view\HtmlDts;


$render_fname = "Create2sec1";
$file = "template_2notag";
$id_name = "my_test5";
$title = "create html test3";
$dts = [[[ "tag",
            ["h2" => "h2タグテストです。",
            ],
         ],
     
         [ "plain",
            ["link" => "https://siawase.com/",
             "str" => "plain textのテスト。" 
            ],
         ],
    
        ],  
    
        [ [ "tag",
            ["link" => "https://iou./mypage.html/",
             "h2" => "<>h2です。'"
            ],
          ],    
          [ "tag",
            ["p" => "昨日は<>つけ丼を食べました。",
            ],
          ],
          
          [ "tag",
            ["link" => "http://w-pecker.com/?p=2&id=4",
             "p" => "自然はの宿です。"            
            ]     
          ],
          [ "ul",
            ["link" => "http://wherever1.com",
             "str" => "somehow1",
            ],
            ["link" => "",
             "str" => "somehow2",
            ],
            ["link" => "https://whereever2.net",
             "str" => "somehow3",
            ],
          ],    
          
          [ "ol",
            ["link" => "http://wherever1.com",
             "str" => "somehow1",
            ],
            ["link" => "",
             "str" => "somehow2",
            ],
            ["link" => "https://whereever2.net",
             "str" => "somehow3",
            ],
          ],    
          [ "img",
            ["link" => "https://whereever2.net",
             "name" => "tree",
             "alt" => "家族団らんの貴重な時間でした。",          
            ],
          ],
          [ "dl",
            ["dt" => "お母さん",
             "dd" => "優しい",
            ],
    
            ["link" => "http://whereever2.net",
             "dt" => "お父さん",
             "dd" => "たくましい",
            ],
          ],
          
          [ "table",
            "caption" => "名簿表",
            "th" => ["名前","住所","年齢"],
            "td" => [ ["","高い","山梨県韮崎市",62],
                      ["http://w-pecker.com/","清水","埼玉県",24],
                      ["","荒川","千葉県松戸市",93],
                    ],
          ],
        ],
       ];
$htmldts = new HtmlDts($title, $id_name, $dts); 
$htmldts->display($render_fname, $file, $htmldts);
