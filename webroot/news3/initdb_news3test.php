<?php
/**
 * news3データベース初期設定
 *
 * このファイルを使用しない方法として、以下のようなやり方もあります。
 * sqlite3 では、データベースはファイルとして扱っているので、$dbfileで定義されているファイルをあらかじめ生成しておきます。
 * Windows7 xampp v3.2.4環境では、ターミナルウィンドウを開いて、以下のように打ち込むとファイルが生成される。
 *  cd C:\xampp;
 *  mkdir data;
 *  cd data;
 *  sqlite3 news3test.sq3;
 * つづいて、以下のように表示されるが、ここに、テーブル生成するためのsql文を書いてもこのファイルで行うのと同じような初期設定が可能である。
 *  sqlite >
 *
 *　　sqlite > .exit で終了する。
 * ここでは、
 *  cd C:\xampp;
 *  mkdir data;
 * という作業を終了しているものとして、このphpファイルをweb公開領域内（http://localhost/news3/initdb_news3test.php）で実行することにより、初期設定を行うものとする。尚、news3test.sq3（dbファイル）は、このphpファイルを実行することにより、自動生成される。
 * 生成されたnews3test.sq3ファイルはC:\xampp\news3\dbinit.phpにおいて、読み込み定義に使用される。
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/05/
 *
 */


try {
    $dbfile ='../../data/news3test.sq3';
    // 接続
    $pdo = new PDO('sqlite:'. $dbfile);

    // SQL実行時にもエラーの代わりに例外を投げるように設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // デフォルトのフェッチモードを連想配列形式に設定
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


    //table作成 cat
    $sql = "CREATE TABLE IF NOT EXISTS cat(
            cat_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            cat_name TEXT NOT NULL)";
    $pdo->exec($sql);

    // cat にデータ挿入
    $cats = array('news','faq');
    $sql = "INSERT INTO cat(cat_id, cat_name) VALUES
             (null,:news)
            ,(null,:faq)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':news', $cats[0], PDO::PARAM_STR);
    $stmt->bindParam(':faq', $cats[1], PDO::PARAM_STR);
    $stmt->execute();


    // table作成linkdir
    $sql = "CREATE TABLE IF NOT EXISTS linkdir(
            dir_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            dir_path TEXT NOT NULL)"; # url + ディレクトリパス
    $pdo->exec($sql);

    // linkdir にデータ挿入
    $linkdir = array('http;//localhost/',
                     'http://localhost/news3/');
    $sql =  "INSERT INTO linkdir(dir_id, dir_path) VALUES (
            null,:dir0)
            ,(null,:dir1)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':dir0', $linkdir[0], PDO::PARAM_STR);
    $stmt->bindParam(':dir1', $linkdir[1], PDO::PARAM_STR);
//  $stmt->bindParam(':dir2', $linkdir[2], PDO::PARAM_STR);
    $stmt->execute();


    // table作成dt
    $sql = "CREATE TABLE IF NOT EXISTS dt(
            id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            cat_id INTEGER NOT NULL ,
            title TEXT NOT NULL,
            contents TEXT,
            img_id INTEGER,
            link_dir_id INTEGER,
            link_fname TEXT,
            date TEXT NOT NULL,
            dtstop_flg INTEGER)";
    $pdo->exec($sql);


    // table作成certifi
    $sql = "CREATE TABLE IF NOT EXISTS certifi(
            ce_id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
            ce_name TEXT NOT NULL,
            ce_pword TEXT NOT NULL)";
    $pdo->exec($sql);

    // certifiにデータを挿入
    $user = 'account';  # your account
    $pass = 'password';  # your password
    $sql = "INSERT INTO certifi(ce_name, ce_pword) VALUES (
            :user,:pass)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
    $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
    $stmt->bindParam(':pass', $hashedpass, PDO::PARAM_STR);
    $stmt->execute();


    // table作成myimg
    $sql = "CREATE TABLE IF NOT EXISTS myimg(
            img_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
            filename TEXT NOT NULL,
            alt TEXT NOT NULL ,
            comment TEXT NOT NULL,
            ext INTEGER NOT NULL,
            cat INTEGER NOT NULL,
            date TEXT NOT NULL)";
    $pdo->exec($sql);

echo('create db success!');

} catch (Exception $e) {

    echo $e->getMessage() . PHP_EOL;

}
