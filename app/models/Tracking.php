<?php

class Tracking extends \Phalcon\Mvc\Model
{
    public $oid;
    public $cid;
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("tracking");
        $this->belongsTo('oid','DeptTrackers', 'oid',array('alias' => 'alias_depttracker'));
        $this->belongsTo('cid','Customers', 'cid',array('alias' => 'alias_customer'));
    }
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function getCustomer()
    {
        return $this->alias_customer;
    }
    public function getDepttracker()
    {
        return $this->alias_depttracker;
    }
}
