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
 * date text
 * dtstop_flg
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */


namespace news3\models;

class Dt
{
    private $id = null;
    private $cat_id;
    private $title;
    private $contents;
    private $img_id;
    private $link_dir_id;
    private $link_fname;
    private $ddate;
    private $dtstop_flg;


    // getter method.
    public function getId()  {return $this->id;}
    public function getCatId()  {return $this->cat_id;}
    public function getTitle()      {return $this->title;}
    public function getContents()       {return $this->contents;}
    public function getImgId()      {return $this->img_id;}
    public function getLinkDirId()      {return $this->link_dir_id;}
    public function getLinkFname()  {return $this->link_fname;}
    public function getdDate()  {return $this->ddate;}
    public function getDtstopFlg()  {return $this->dtstop_flg;}


    // setter method.
    public function setId($id)  {$this->id = $id;}
    public function setCatId($cat_id)   {$this->cat_id = $cat_id;}
    public function setTitle($title)    {$this->title = $title;}
    public function setContents($contents)  {$this->contents = $contents;}
    public function setImgId($img_id)   {$this->img_id = $img_id;}
    public function setLinkDirId($link_dir_id)  {$this->link_dir_id = $link_dir_id;}
    public function setLinkFname($link_fname)   {$this->link_fname = $link_fname;}
    public function setdDate($date) {$this->ddate = $date;}
    public function setDtstopFlg($flg) {$this->dtstop_flg = $flg;}
}
