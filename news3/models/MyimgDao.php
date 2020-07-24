<?php
    /**
      * myimg table.
      *
      * img_id      INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT.
      * filename    TEXT NOT NULL UNIQUE.
      * alt         TEXT NOT NULL.
      * comment     TEXT NOT NULL.
      * ext         INTEGER NOT NULL.
      * cat         INTEGER NOT NULL.
      * date        TEXT NOT NULL.
      *
      * @author Hiroyuki Takai <watashitakai@gmail.com>
      * @since 2018/07/
      */

namespace news3\models;

use framework3\mvc\Dao;

class MyimgDao extends Dao
{
    /*
     * オブジェクトにデータをまとめてセットする。
     * @param Dt $obj
     * @param array $pts セットするプロパティの配列
     * @return Dt オブジェクト.
     */
    public function setMyimgproperty(Myimg $obj, array $pts): Myimg
    {
        $img_id = $pts['img_id'] ?? null;
        $obj->setImgId($img_id);

        $filename = $pts['filename'] ?? null;
        $obj->setFilename($filename);

        $alt = $pts['alt'] ?? null;
        $obj->setAlt($alt);

        $comment = $pts['comment'] ?? null;
        $obj->setComment($comment);

        $ext = $pts['ext'] ?? null;
        $obj->setExt($ext);

        $cat = $pts['cat'] ?? null;
        $obj->setCat($cat);

        $ddate = $pts['ddate'] ?? null;
        $obj->setdDate($ddate);
    }


    /*
     * insert db.
     *
     * @param array $dts バインドするデータ配列
     * @return int $cnt 正常に実行されたsql文の数
     */
    public function insertDB(array $dts): int
    {
        $now =  \date("Ymd");
        $sql = "insert into myimg (img_id,
                                   filename,
                                   alt,
                                   comment,
                                   ext,
                                   cat,
                                   date)
        values (:img_id,
                :filename,
                :alt,
                :comment,
                :ext,
                :cat,
                $now
                )";

        $cnt = $this->ope_use_prepare($sql, $dts);

        return $cnt;
    }
}
