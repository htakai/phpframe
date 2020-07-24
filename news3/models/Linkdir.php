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


class Linkdir
{
    private $dir_id = null;
    private $dir_path;

    // getter method.
    public function getDirId()          {return $this->dir_id;}
    public function getDirPath()        {return $this->dir_path;}

    // setter method.
    public function setDirId($dir_id){$this->dir_id=$dir_id;}
    public function setDirPath($dir_path){$this->dir_path=$dir_path;}
}
