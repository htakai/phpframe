<?php
$dts = [[[ "tag",
["h2"=>"h2タグテストです。",
],
],

[ "plain",
["link"=>"https://siawase.com/",
"str"=>"plain textのテスト。"
],
],

],

[ [ "tag",
["link"=>"https://iou./mypage.html/",
"h2"=>"h2<scriptです。"
],
],


[ "tag",
["p"=>"昨日は<>つけ丼を食べました。",
],
],

[ "tag",
["link"=>"http://w-pecker.com/?p=2&id=4",
"p"=>"自然はの宿です。"
]
],

[ "ul",
["link"=>"http://wherever1.com",
"str"=>"somehow1",
],

["link"=>"",
"str"=>"somehow2",
],

["link"=>"https://whereever2.net",
"str"=>"somehow3",
],
],

[ "ol",
["link"=>"http://wherever1.com",
"str"=>"somehow1",
],

["link"=>"",
"str"=>"somehow2",
],

["link"=>"https://whereever2.net",
"str"=>"somehow3",
],
],

[ "img",
["link"=>"https://whereever2.net",
"name"=>"_181207hikari",
"alt"=>"家族団らんの貴重な時間でした。",
],
],

[ "dl",
["dt"=>"お母さん",
"dd"=>"優しい",
],

["link"=>"http://whereever2.net",
"dt"=>"お父さん",
"dd"=>"たくましい",
],
],

[ "table",
"caption"=>"名簿表",
"th"=>["名前","住所","年齢"],
"td"=>[ ["","高い","山梨県韮崎市",62],
["http://w-pecker.com/","清水","埼玉県",24],
["","荒川","千葉県松戸市",93],
],
],
],
];

echo 'dts[0][0][0]='.$dts[0][0][0]."\n";
echo 'dts[0][0][1]["h2"]='.$dts[0][0][1]['h2']."\n";

echo 'dts[0][1][0]='.$dts[0][1][0]."\n";
echo 'dts[0][1][1]["link"]='.$dts[0][1][1]['link']."\n";
echo 'dts[0][1][1]["str"]='.$dts[0][1][1]['str']."\n";

echo 'dts[1][0][0]='.$dts[1][0][0]."\n";
echo 'dts[1][0][1]["link"]='.$dts[1][0][1]['link']."\n";
echo 'dts[1][0][1]["h2"]='.$dts[1][0][1]['h2']."\n";

echo 'dts[1][1][0]='.$dts[1][1][0]."\n";
echo 'dts[1][1][1]["p"]='.$dts[1][1][1]['p']."\n";

echo 'dts[1][2][0]='.$dts[1][2][0]."\n";
echo 'dts[1][2][1]["link"]='.$dts[1][2][1]['link']."\n";
echo 'dts[1][2][1]["p"]='.$dts[1][2][1]['p']."\n";

echo 'dts[1][3][0]='.$dts[1][3][0]."\n";
echo 'dts[1][3][1]["link"]='.$dts[1][3][1]['link']."\n";
echo 'dts[1][3][1]["str"]='.$dts[1][3][1]['str']."\n";

echo 'dts[1][3][2]["link"]='.$dts[1][3][2]['link']."\n";
echo 'dts[1][3][2]["str"]='.$dts[1][3][2]['str']."\n";

echo 'dts[1][3][3]["link"]='.$dts[1][3][3]['link']."\n";
echo 'dts[1][3][3]["str"]='.$dts[1][3][3]['str']."\n";

echo 'dts[1][4][0]='.$dts[1][4][0]."\n";
echo 'dts[1][4][1]["link"]='.$dts[1][4][1]['link']."\n";
echo 'dts[1][4][1]["str"]='.$dts[1][4][1]['str']."\n";

echo 'dts[1][4][2]["link"]='.$dts[1][4][2]['link']."\n";
echo 'dts[1][4][2]["str"]='.$dts[1][4][2]['str']."\n";

echo 'dts[1][4][3]["link"]='.$dts[1][4][3]['link']."\n";
echo 'dts[1][4][3]["str"]='.$dts[1][4][3]['str']."\n";

echo 'dts[1][5][0]='.$dts[1][5][0]."\n";
echo 'dts[1][5][1]["link"]='.$dts[1][5][1]['link']."\n";
echo 'dts[1][5][1]["name"]='.$dts[1][5][1]['name']."\n";
echo 'dts[1][5][1]["alt"]='.$dts[1][5][1]['alt']."\n";

echo 'dts[1][6][0]='.$dts[1][6][0]."\n";
echo 'dts[1][6][1]["dt"]='.$dts[1][6][1]['dt']."\n";
echo 'dts[1][6][1]["dd"]='.$dts[1][6][1]['dd']."\n";

echo 'dts[1][6][2]["link"]='.$dts[1][6][2]['link']."\n";
echo 'dts[1][6][2]["dt"]='.$dts[1][6][2]['dt']."\n";
echo 'dts[1][6][2]["dd"]='.$dts[1][6][2]['dd']."\n";

echo 'dts[1][7][0]='.$dts[1][7][0]."\n";
echo 'dts[1][7]["caption"]='.$dts[1][7]['caption']."\n";
echo 'dts[1][7]["th"][0]='.$dts[1][7]['th'][0]."\n";
echo 'dts[1][7]["th"][1]='.$dts[1][7]['th'][1]."\n";
echo 'dts[1][7]["th"][2]='.$dts[1][7]['th'][2]."\n";
echo 'dts[1][7]["td"][0][0]='.$dts[1][7]['td'][0][0]."\n";
echo 'dts[1][7]["td"][0][1]='.$dts[1][7]['td'][0][1]."\n";
echo 'dts[1][7]["td"][0][2]='.$dts[1][7]['td'][0][2]."\n";
echo 'dts[1][7]["td"][0][3]='.$dts[1][7]['td'][0][3]."\n";
echo 'dts[1][7]["td"][1][0]='.$dts[1][7]['td'][1][0]."\n";
echo 'dts[1][7]["td"][1][1]='.$dts[1][7]['td'][1][1]."\n";
echo 'dts[1][7]["td"][1][2]='.$dts[1][7]['td'][1][2]."\n";
echo 'dts[1][7]["td"][1][3]='.$dts[1][7]['td'][1][3]."\n";
echo 'dts[1][7]["td"][2][0]='.$dts[1][7]['td'][2][0]."\n";
echo 'dts[1][7]["td"][2][1]='.$dts[1][7]['td'][2][1]."\n";
echo 'dts[1][7]["td"][2][2]='.$dts[1][7]['td'][2][2]."\n";
echo 'dts[1][7]["td"][2][3]='.$dts[1][7]['td'][2][3]."\n";
