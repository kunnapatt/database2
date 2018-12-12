<?php

class CarryRequest extends \Phalcon\Mvc\Model
{

    public $cid;

    public $oid;

    public $ticketid;

    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("carry_request");
        $this->belongsTo('cid', 'Customers', 'cid', array('alias' => 'alias_customers'));
        $this->belongsTo('oid', 'CrmOfficer', 'oid', array('alias' => 'alias_crm'));
    }
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function getCrm()
    {
        return $this->alias_crm;
    }
    public function getCustomers()
    {
        return $this->alias_customers;
    }

}
