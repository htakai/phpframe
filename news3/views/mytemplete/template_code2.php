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
  <link href="<?php echo HOST . APPNAME?>/css/framework.css" rel="stylesheet" type="text/css">
</head>
<body>
  <div class="container">
    <div id="#id_name#">
      <section>
        <h1>#title#</h1>
        <p><?= htmlspecialchars("#p1#", ENT_QUOTES) ?></p>
        <pre><code>
.leftmenu {
    position: absolute;
    top: 120px;
    left: 0;
    width: 170px;
    padding: 0 0 20px 10px;
}
        </code></pre>

      </section>
      <section>
        <p><?= F_util::hs("#p2#")?></p>
        <pre><code>
.leftmenu {
    position: absolute;
    top: 120px;
    left: 0;
    width: 170px;
    padding: 0 0 20px 10px;
}
        </code></pre>
      </section>
    </div>
  </div>
</body>
</html>
