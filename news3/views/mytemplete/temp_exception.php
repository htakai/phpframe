<?php

namespace news3\views\mytemplate;


use framework3\common\F_util;


?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= F_util::hs("#title#") ?></title>
<link href="<?php echo SKM . $_SERVER['HTTP_HOST'] . '/' . APPNAME ?>/css/framework.css" rel="stylesheet" type="text/css">
<style>
h1 {
    background: #FF6347;
}
p {
    color: red;
    font-weight: bold;
}
a {
    color: white;
    }
span {
    background-color: red;
    padding: 0 1%;
}

</style>
</head>
<body>
<div class="container">
  <div id="<?= F_util::hs("#id_name#") ?>" >
    <h1><?= F_util::hs("#title#") ?></h1>
    <p><?= F_util::hs("#contents#") ?>
      <br>
<?php
if (!empty("#url#")) {
?>
      <span><a href="<?= F_util::url_attr("#url#") ?>">   戻る</a> </span>
<?php
 }
?>
    </p>
  </div>
</div>
</body>
</html>
