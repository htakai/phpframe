<?php

/**
 * dt
 *
 * id integer primary key
 * cat_id integer
 * title text
 * contents text
 * img_id integer
 * link_dir_id INTEGER, //リンク先ディレクトリ絶対パスid
 * link_fname text
 * date text   ex. 20180701
 * dtstop_flg
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */


namespace news3\models;

use framework3\mvc\Dao;


class DtDao extends Dao
{
    /*
     * オブジェクトにデータをまとめてセットする。
     * @param Dt $obj
     * @param array $pts セットするプロパティの配列
     * @return Dt オブジェクト.
     */
    public function setDtproperty(Dt $obj, array $pts): Dt
    {
        $id = $pts['id'] ?? null;
        $obj->setId($id);

        $cat_id = $pts['cat_id'] ?? null;
        $obj->setCatId($cat_id);

        $title = $pts['title'] ?? null;
        $obj->setTitle($title);

        $contents = $pts['contents'] ?? null;
        $obj->setContents($contents);

        $img_id = $pts['img_id'] ?? null;
        $obj->setImgId($img_id);

        $link_dir_id = $pts['link_dir_id'] ?? null;
        $obj->setLinkDirId($link_dir_id);

        $link_fname = $pts['link_fname'] ?? null;
        $obj->setLinkFname($link_fname);

        return $obj;
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
        $sql = "insert into dt (id,
                                cat_id,
                                title,
                                contents,
                                img_id,
                                link_dir_id,
                                link_fname,
                                date,
                                dtstop_flg)
        values (:id,
                :cat_id,
                :title,
                :contents,
                :img_id,
                :link_dir_id,
                :link_fname,
                $now,
                false
                )";

        $cnt = $this->ope_use_prepare($sql, $dts);

        return $cnt;
    }
}
