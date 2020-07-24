<?php
/**
 * 2mark replace template file
 *
 */

namespace news3\views\mytemplate;


use framework3\common\F_util;


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>#title#</title>
  <link href="<?php echo SKM . $_SERVER['HTTP_HOST'].'/' . APPNAME?>/css/framework.css" rel="stylesheet" type="text/css">
  <style>
    section {
        margin-left: 10px;
    }
    img {
        width: 100%;
        max-width: 800px;
    }
  </style>
</head>
<body id="#id_name#">
  <div class="container">
    <h1>#title#</h1>
    <section>
      <div id="c1">
        #c1#
       </div>
    </section>
    <section>
      <div id="c2">
        #c2#
      </div>
    </section>
  </div>
</body>
</html>
