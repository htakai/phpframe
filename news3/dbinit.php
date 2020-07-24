<?php

/**
 * Dbクラスに読み込まれるdsn情報があるファイル(sqlite)
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */

//読みこまれるdsn情報分だけ作成する　$dsn1, $dsn2,..... $dbpath1, $dbpath2,.....
    $dbpath1 = __DIR__ . '/../data/'. 'news3test.sq3'; 
    $dsn1 = sprintf('sqlite:%s',$dbpath1);
    
return [
//config.phpと対応させる
    'local' => [
        'dsn' => $dsn1,
    ],

    'remote' => [
        'dsn' => $dsn1,
    ],
];
