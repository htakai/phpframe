<?php
    /**
     * cat
     *
     * cat_id integer primary key AUTOINCREMENT
     * cat_name TEXT
     *
     * @author Hiroyuki Takai <watashitakai@gmail.com>
     * @since 2020/05/
     */

namespace news3\models;

class Cat
{
    private $cat_id;
    private $cat_name;

    public function __construct($id = null, string $name = null)
    {
        if (isset($id)) {
            $this->cat_id = (int)$id;
        }
        $this->cat_name = $name;
    }

    // create read only property.
    public function getCatId(): ?int
    {
        return $this->cat_id;
    }

    public function getCatName(): ?string
    {
        return $this->cat_name;
    }
}
