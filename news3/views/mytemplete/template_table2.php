<?php

namespace news3\views\mytemplate;


use framework3\common\F_util; 


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="<?php echo SKM . $_SERVER['HTTP_HOST'] .'/' . APPNAME?>/css/framework.css" rel="stylesheet" media="print" onload="this.media='all'">
  <title>#title#</title>
  <style>
    body {
        padding: 5%;
        font-size: 0.8rem;
    }
    section {
        padding: 2%;
    }
    @media screen and (min-width:600px) {
        body{
            font-size: 1rem;
        }
    }
  </style>
</head>
<body id="#id_name#">
  <header>
    <div class="header-container">
      <h1>#title#</h1>
    </div>
  </header>

  <main>
    <div class="main-container">
      <section>
        <h2>#h2-1#</h2>
        #table1#
      </section>
    </div>
  </main>

  <footer>
    <div class="footer-container">
      <div class="copyright">
        <p>著作権表示</p>
      </div>
    </div>
  </footer>
</body>
</html>
