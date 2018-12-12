<?php

class Account extends \Phalcon\Mvc\Model
{
    public $account_id;
    public $cid;
    public $category;
    public $balance;
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("account");
        $this->belongsTo('cid','Customers', 'cid',array('alias' => 'alias_customer'));
        $this->hasMany("cid", "Credit", "cid", array('alias' => 'alias_credit'));
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
    public function getCredit()
    {
        return $this->alias_credit;
    }
    

}
