<?php
    /**
     * cat
     *
     * cat_id integer primary key AUTOINCREMENT
     * cat_name TEXT
     *
     * @author Hiroyuki Takai <watashitakai@gmail.com>
     * @since 2020/06/
     */

namespace news3\models;

use framework3\mvc\Dao;


class CatDao extends Dao
{
    /*
     * insert db.
     *
     * @param array $dts バインドするデータ配列
     * @return int $cnt 正常に実行されたsql文の数
     */
    public function insertDB(array $dts): int
    {
        $sql = "insert into cat (cat_id,
                                 cat_name)
                values (:cat_id,
                        :cat_name
                        )";
        $cnt = $this->ope_use_prepare($sql, $dts);

        return $cnt;
    }
}
