<?php
    /**
     *linkdir
     *
     * dir_id integer primary key AUTOINCREMENT
     * dir_path TEXT 絶対参照パス
     *
     * @author Hiroyuki Takai <watashitakai@gmail.com>
     * @since 2018/07/
     */

namespace news3\models;

use framework3\mvc\Dao;


class LinkdirDao extends Dao
{
    /*
     * insert db.
     *
     * @param array $dts バインドするデータ配列
     * @return int $cnt 正常に実行されたsql文の数
     */
    public function insertDB(array $dts): int
    {
        $sql = "insert into linkdir (dir_id,
                                     dir_path)
                values (:dir_id,
                        :dir_path
                        )";
        $cnt = $this->ope_use_prepare($sql, $dts);

        return $cnt;
    }
}
