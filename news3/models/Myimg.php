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


class Myimg
{
    private $img_id = null;
    private $filename;
    private $alt;
    private $comment;
    private $ext;
    private $cat;
    private $ddate;


    public function getImgId()  {return $this->img_id;}
    public function getFilename()  {return $this->filename;}
    public function getAlt()  {return $this->alt;}
    public function getComment()  {return $this->comment;}
    public function getExt()  {return $this->ext;}
    public function getCat()  {return $this->cat;}
    public function getdDate()  {return $this->ddate;}

    public function setImgId($img_id)   {$this->img_id = $img_id;}
    public function setFilename($filename)  {$this->filename = $filename;}
    public function setAlt($alt)    {$this->alt = $alt;}
    public function setComment($comment)    {$this->comment = $comment;}
    public function setExt($ext)    {$this->ext = $ext;}
    public function setCat($cat)    {$this->cat = $cat;}
    public function setdDate($ddate) {$this->ddate = $ddate;}
}
