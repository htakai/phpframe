<?php
/**
 * this is abstract class that use iterator for aplication .
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/07/
 */

namespace framework3\mvc;

use framework3\common\FactoryClass;
use framework3\common\F_util;
use framework3\mvc\Dao;


abstract class DaoIterator implements \IteratorAggregate
{
    protected $dao;  # target dao class.
    protected $target_classname;  # target class name.
    protected $target_objs;  # picked up objects from database.
    protected $array_obj;  # transformed ArrayObject for target objects.


    /*
     * construct.
     *
     * @param FactoryClass $fc  for dependency injection.
     * @param string $ns_classname  target class name with namespace.
    */
    public function __construct(FactoryClass $fc, string $ns_dao_classname, $ns_target_classname)
    {
        $this->dao = $fc::createClass0($ns_dao_classname);
        $this->target_classname = $ns_target_classname;
        $this->array_obj = $fc::createClass1('\\ArrayObject');
    }

    /*
     * get selected data from table and return pointed objects.
     *
     * @param string $sql
     * @param array $params  バインドするもの　$params  hashとして指定.
     * @return array target objects.
     */
    public function getSel($sql, array $params): array
    {
        $this->target_objs = $this->dao->get_use_prepare($sql, $params, $this->target_classname);
        $fc = FactoryClass::getNew();
        $this->setArrayObject($this->target_objs, $fc);

        return $this->target_objs;
    }


    /*
     * get all data from table and return pointed objects.
     *
     * @param string $ns_classname  fully quaryfied class name.
     * @return array objects of this class type.
     */
    public function getAll(): array
    {
        $classname = $this->pickupClassName($this->target_classname);
        $sql = "select * from ".strtolower($classname);
        $this->target_objs = $this->dao->get_objs($sql, $this->target_classname);
        $fc = FactoryClass::getNew();
        $this->setArrayObject($this->target_objs, $fc);

        return $this->target_objs;
    }


    /*
     * pickup only class name from fully quaryfied classname.
     *
     * @param string $ns classname  fully quaryfied classname.
     * @return string pickuped classname.
     */
    protected function pickupClassName(string $ns_classname): string
    {
        return substr(strrchr($ns_classname, '\\'), 1);
    }


    /*
     * set into ArrayObject from target objects.
     *
     * @param array $objs
     * @param FactoryClass $fc  for dependency injection.
     * @return ArrayObject
     */
    protected function setArrayObject(array $objs, FactoryClass $fc): \ArrayObject
    {
        try {
            if ($objs[0] instanceof $this->target_classname) {
                for ($i = 0; $i < count($objs); $i++) {
                    $this->array_obj[] = $objs[$i];
                }
            } else {
                throw new \InvalidArgumentException('argument type invalid!', INVALID);
            }
        } catch (\InvalidArgumentException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }
        return $this->array_obj;
    }


    /*
     * add object into ArrayObject.
     *
     * @param $obj  nessesary instanceof target class.
     */
    public function addArrayObject($obj)
    {
        try {
            if ($obj instanceof $this->target_classname) {
                $this->array_obj[] = $obj;
            } else {
                throw new \InvalidArgumentException('argument type invalid!', INVALID);
            }
        } catch (\InvalidArgumentException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }
    }


    /*
     * return  this array_obj
     *
     *@return ArrayObject $this->array_obj.
     */
    public function retArrayObj(): \ArrayObject
    {
        return $this->array_obj;
    }

    abstract function getIterator();
}

