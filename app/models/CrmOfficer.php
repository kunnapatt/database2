<?php

class CrmOfficer extends \Phalcon\Mvc\Model
{
    public $oid;
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("crm_officer");
        $this->belongsTo('oid', 'Officers', 'oid', array('alias' => 'officer'));
        $this->hasMany("oid", "CarryRequest", "oid", array('alias' => 'alias_request'));
        $this->hasManyToMany(
            'oid',
            'CarryRequest',
            'oid', 'cid',
            'Customers',
            'cid',
            array(
                'alias' => 'alias_customers'
            )
        );
    }
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function getOfficer()
    {
        return $this->alias_officer;
    }
    public function getCustomers()
    {
        return $this->alias_customers;
    }
    public function getRequest()
    {
        return $this->alias_request;
    }

}
