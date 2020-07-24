<?php

/**
 * データベース接続操作クラス.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/07/
 */

namespace framework3\mvc;

use framework3\common\F_util;
use framework3\common\ErrorFunc;
use framework3\common\FactoryClass;
use framework3\common\Log;

class DB # -->final
{
    // データベース接続情報を返すファイル定義.
    const CONFIG_PATH = __DIR__ .'/../../'. APPNAME .'/dbinit.php';

    // PDOの配列格納用.
    private $dbs = [];

    // 接続情報格納用.
    private $conf = [];

    private function __construct()
    {
        // 接続情報の取得.
        $this->conf = require self::CONFIG_PATH;
    }

    /*
     * データベースに接続.
     *
     * @param string $dsn
     */
    private function connect (string $dsn)
    {
        try {
            if (empty($this->conf[$dsn])) {
                // 接続情報がない場合.
                $msg = $dsn. '-->Unknown database!';
                throw new \LogicException ($msg, LOGIC); # not found dbinfomation file exception.
            }
        } catch (\LogicException $e) {
//          ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }
        $conf = $this->conf[$dsn];

        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_STRINGIFY_FETCHES => false
        ];
        try {
            if (defined('LITE') && LITE === 1 ) { # sqlite使用の場合.
                $this->dbs[$dsn] = new \PDO($conf['dsn'], '', '', $options);
            } elseif (isset($conf['user']) && isset($conf['password'])) {
                $this->dbs[$dsn] = new \PDO($conf['dsn'], $conf['user'], $conf['password'], $options);
            } else {
                try {
                    $msg = 'set dsn mistake!';
                    throw new \LogicException ($msg, LOGIC);
                } catch (\LogicException $e) {
//                  ErrorFunc::catchAfter($e);
                    F_util::catchfunc($e);
                }
            }
        } catch (\PDOException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }
   }


    /*
     * 外部からPDOを取得するメソッド.
     * @param $dsn 使用する登録されているdns名　DSN1 or DSN2......
     * @return PDO
     */
    public static function getDB($dsn): \PDO # chg->final
    {
        static $instance;

        if (empty($instance)) {
            $instance = new static;
        }

        if (empty($instance->dbs[$dsn])) {
            $instance->connect($dsn);
        }

        return $instance->dbs[$dsn];
    }


    //クローンを禁止する.
    public function __clone() # chg->final
    {
        try {
            $msg = 'this instance is singleton class!';
            throw new \LogicException($msg, LOGIC); // may not create class clone exception.
        } catch (\LogicException $e) {
//          ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }
    }


    /*
     * トランザクション実行.
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     */
    public static function transaction($dsn)
    {
        try {
            self::getDB($dsn)->beginTransaction();
            $msg = "~ DB ~ Transaction ";
            Log::logwrite($msg);
        } catch (\PDOException $e) {
            F_util::catchfunc($e);
        }
    }


    /*
     * コミット.
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2.......
     */
    public static function commit($dsn)
    {
        self::getDB($dsn)->commit();
        $msg = "Commit ";
        Log::logwrite($msg);
    }


    /*
     * ロールバック.
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     */
    public static function rollback($dsn)
    {
        self::getDB($dsn)->rollBack();
        $msg = "Rollback ";
        Log::logwrite($msg);
    }

    /*
     * プリペアドステートメントprepareを使わない、クエリー実行、結果取得.
     * @param $sql sql文
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @return PDOStatement
     */
    public static function query(string $sql, string $dsn): \PDOStatement
    {
        $dbh = self::getDB($dsn);
        $stmt = $dbh->query($sql);
        return $stmt;
    }

    /*
     * プリペアドステートメントprepareを使わない、データ取得を伴わないselect,insert,delete,updateクエリー実行.
     * @param $sql sql文
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @return int $count 実行した行数
     */
    public static function exec(string $sql, string $dsn): int
    {
        $dbh = self::getDB($dsn);
        $count = $dbh->exec($sql);

        return $count;
    }


    /*
     * プリペアドステートメントprepareを使う、クエリ結果を取得するselect文の処理.
     * @param $sql sql文.
     * @param $flg  $paramsを2次元配列として受け取る(insert,delete,updateなど複数文を処理する場合)か否か.
     * @param $params バインドするもの　$params[] or $params[[]].
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @return $flg===trueの場合は、2次元配列$dts[[]]. $dts、falseの場合は　PDOStatement $stmt.
     */
    public static function prepare_select(string $sql, bool $flg, array $params , string $dsn)
    {
        $dbh = self::getDB($dsn);
        $stmt = $dbh->prepare($sql);

        if ($params != null) {
            if ($flg && is_array($params[0])) {
                $dts = [];
                for ($i = 0; $i < count($params); $i++) {
                    foreach ($params[$i] as $key => $val) {
                        self::create_bind($stmt, $key, $val);
                    }
                    $stmt->execute();
                    $ret = self::fetch_col($stmt);
                    $dts[] = $ret;
                }
                return $dts;
            } elseif ($flg) {
                try {
                $msg = "DB::prepare_select: params argument mistake!";
                throw new \InvalidArgumentException($msg, INVALID);
                } catch (\InvalidArgumentException $e) {
//                  ErrorFunc::catchAfter($e);
                    F_util::catchfunc($e);
                }
            } else {
                foreach ($params as $key => $val) {
                    self::create_bind($stmt, $key, $val);
                }
                $stmt->execute();
                return $stmt;
            }
        }
        return false;
    }


    /*
     * プリペアドステートメントprepareを使う、データ取得を伴わないselect,insert,delete,updateクエリー実行、トランザクションをつかう.
     * @param $sql sql文.
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @param array(array()) $paramsバインドするもの.
     * @return int  プリペアドステートメントを実行した回数.
     */
    public static function prepare_not_getdt(string $sql, array $params = [[]], string $dsn): int
    {
        $dbh = self::getDB($dsn);
        $stmt = $dbh->prepare($sql);
        if ($params != null && is_array($params[0])) {
            $cnt = 0;
            self::transaction($dsn);
            for ($i = 0; $i < count($params); $i++) {
                try {
                    foreach ($params[$i] as $key => $val) {
                        self::create_bind($stmt, $key, $val);
                    }
                    $stmt->execute();
                    $cnt++;
                } catch (\PDOException $e) {
                        self::rollback($dsn);
                        F_util::catchfunc($e);
                }
            }
            self::commit($dsn);
        } else {
            try {
            $msg = "DB::prepare_not_getdt: params argument mistake!";
            throw new \InvalidArgumentException($msg, INVALID);
            } catch (\InvalidArgumentException $e) {
//              ErrorFunc::catchAfter($e);
                F_util::catchfunc($e);
            }
        }
        return $cnt;
    }


    /*
     * sql文中の:name形式の値をプレイスフォルダーにバインドする.
     *
     * @param \PDOStatement
     * @parma $key
     * @param $val
     */
    protected static function create_bind(\PDOStatement $stmt, $key, $val)
    {
        if (is_int($val)) {
            $stmt->bindValue(':' . $key, $val, \PDO::PARAM_INT);
        } else if (is_bool($val)) {
            $stmt->bindValue(':' . $key, $val, \PDO::PARAM_BOOL);
        } else {
            $stmt->bindValue(':' . $key, $val, \PDO::PARAM_STR);
        }
    }


    /*
     * 結果セットからカラムだけを配列に格納し返す.
     *
     * @param \PDOStatement
     * @return array
     */
    public static function fetch_col( \PDOStatement $stmt): array
    {
        $ret = [];
        while (false !== $value = $stmt->fetchColumn()) {
            $ret[] = $value;
        }
        return $ret;
    }


    /*
     * PDOStatementからデータを取り出し、オブジェクト配列を生成する。
     *
     * @param \PDOStatement $stmt
     * @param string $cname_with_ns 完全修飾形式クラス名
     * @param FactoryClass $fs  Dependency injection.
     * @return array オブジェクト配列
     */
    public static function getObj(\PDOStatement $stmt, string $cname_with_ns, FactoryClass $fs): array
    {
        $objs = [];
        foreach ($stmt as $row) {
            $params = [];
            foreach ($row as $value) {
                $params[] = $value;
            }
            $obj = $fs::createClass0($cname_with_ns, $params);
            $objs[] = $obj;
        }
        return $objs;
    }


    /*
     * keyとvalueというPDOStatementオブジェクトに対して、連想配列としてとりだす.
     *
     * @param \PDOStatement $stmt
     * @return array $hash
     */
    public static function retHash(\PDOStatement $stmt): array
    {
        $hash = [];
        foreach ($stmt as $row) {
            $hash[$row['cat_id']] = $row['cat_name'];
        }
        return $hash;
    }


    /*
     * ステートメントによって直近の DELETE, INSERT, UPDATE 文によって作用したした行数をかえす.
     *
     * @param \PDOStatement $stmt.
     * @return int 直近の SQL ステートメントによって作用した行数.
     */
    public static function ret_cnt($stmt): int
    {
        return $stmt->rowCount();
    }
}
