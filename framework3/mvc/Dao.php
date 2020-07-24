<?php
/**
 * Data Access Object.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/05/
 */

namespace framework3\mvc;

use framework3\common\FactoryClass;

class Dao
{
    /*
     * プリペアドステートメントprepareを使わない、クエリー実行.
     *
     * @param $sql sql文.
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @return PDOStatement.
     */
    public function use_query(string $sql, string $dsn = DSN1): \PDOStatement
    {
        return DB::query($sql, $dsn);
    }


    /*
     * プリペアドステートメントprepareを使わないsql文のデータselectに対する操作で、データをオブジェクトでかえす.
     *
     * @param string $sql prepareを使わないsql文select
	 * @param string $classname 取得するオブジェクトの完全修飾形式クラス名
     * @param string $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2.....
     * @return array object
     */
    public function get_objs(string $sql, string $classname, string $dsn=DSN1): array
    {
        $stmt = DB::query($sql, $dsn);
        $fs_instance = FactoryClass::getNew();
        return DB::getObj($stmt, $classname, $fs_instance);
    }


    /*
     * プリペアドステートメントprepareを使わない、カラムだけを配列として、取得.
     *
     * @param $sql sql文.
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @return array 処理結果を配列として返す.
     */
    public function get_col(string $sql, string $dsn = DSN1): array
    {
        $stmt = DB::query($sql, $dsn);

        return DB::fetch_col($stmt);
    }


    /*
     * プリペアドステートメントprepareを使わないsql文のデータselectに対する操作で、keyと valueというテーブルのデータに対して連想配列でかえす.
     *
     * @param string $sql prepareを使わないsql文select
     * @param string $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2.....
     * @return array hash
     */
    public function getHash(string $sql, string $dsn = DSN1): array
    {
        $stmt = DB::query($sql, $dsn);
        return DB::retHash($stmt);
    }


    /*
     * プリペアドステートメントprepareを使う、クエリ結果を取得するselect文の処理.
     * @param $sql sql文.
     * @param $params バインドするもの　$params[]1次元配列として指定.
     * @param $classname 名前空間名を含むクラス名
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @return array classname objs
     */
    public function get_use_prepare(string $sql, array $params, string $classname, string $dsn = DSN1): array
    {
        $stmt = DB::prepare_select($sql, false, $params, $dsn);
        $fs_instance = FactoryClass::getNew();

        return DB::getObj($stmt, $classname, $fs_instance);
    }


    /*
     * プリペアドステートメントprepareを使う、カラムだけを配列として、取得.
     * @param $sql sql文.
     * @param array $params バインドするもの　$params[[]] 2次元配列.
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @return 2次元配列
     */
    public function get_col_use_prepare(string $sql, array $params, string $dsn = DSN1): array
    {
        return DB::prepare_select($sql, true, $params, $dsn);
    }


    /*
     * プリペアドステートメントprepareを使わない、データ取得を伴わないselect,insert,delete,updateクエリー実行.
     * @param $sql sql文
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @return int $count 実行した行数
     */
    public function use_exec(string $sql, string $dsn = DSN1): int
    {
        return DB::exec($sql, $dsn);
    }


    /*
     * プリペアドステートメントprepareを使う、データ取得を伴わないselect,insert,delete,updateクエリー実行.
     * @param $sql sql文.
     * @param $dsn config.phpで使用する登録されているdsn名　DSN1 or DSN2......
     * @param $params array(array()) $paramsバインドするもの.
     * @return int  プリペアドステートメントを実行した回数.
     */
    public function ope_use_prepare(string $sql, array $params, string $dsn = DSN1): int
    {
        return DB::prepare_not_getdt($sql, $params, $dsn);

    }
}
