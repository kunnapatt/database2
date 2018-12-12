<?php

class Calendar extends \Phalcon\Mvc\Model
{
    public $oid;
    public $date;
    public $customers_cid;
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("calendar");
        $this->belongsTo('cid', 'Customers', 'cid', array('alias' => 'alias_customer'));
        $this->belongsTo('oid', 'Officers', 'oid', array('alias' => 'alias_officer'));
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
    public function getOfficer()
    {
        return $this->alias_officer;
    }

}
