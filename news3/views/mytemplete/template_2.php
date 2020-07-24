<?php

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
  </style>
</head>
<body id="#id_name#">
  <div class="container">
    <section>
      <h1>#title#</h1>
      <div id="c1">
        <h2><?= F_util::hs("#c1#")?></h2>
      </div>
    </section>
    <section>
        <div id="c2">
            <?= F_util::hs("#c2#")?>
        </div>
    </section>
  </div>
</body>
</html>
