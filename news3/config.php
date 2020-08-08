<?php
/**
 * declar global constants.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */

namespace news3;


// アプリケーション名-->アプリケーション用の各種ファイルを置くディレクトリ名となる.
if (!defined('APPNAME')) {
    define('APPNAME', 'news3');
}

// 使用するdsn名ぶん登録DSN1, DSN2, DSN3,........
if (!defined('DSN1')) {
    define('DSN1', 'local'); # dbinit.phpのreturn 連想配列のkey名に対応.
}

// dbはsqliteであるか否か
if (!defined('LITE')) { # SQLITEを使う場合は1にする。その他は0
    define('LITE', 1);
}


// webroot名 example: "htdocs/"
if (!defined('WEBROOT')) {
    define('WEBROOT', 'htdocs/');
}

// キャッシュを無効にする。
// if (!defined('NOCACHE')) { # 
    // define('NOCACHE', 1);
// }
