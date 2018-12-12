<?php

class Customers extends \Phalcon\Mvc\Model
{
    public $cid;
    public $fname;
    public $sname;
    public $dOB;
    public $gender;
    public $pnumber;
    public $homeaddress;
    public $workaddress;
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("customers");
        $this->hasOne('cid','account','cid',array('alias' => 'alias_account'));
        $this->hasOne('cid','calendar','cid',array('alias' => 'alias_calendar'));
        $this->hasMany("cid", "Paying", "cid", array('alias' => 'alias_paying'));
        $this->hasMany("cid", "LoanBy", "cid", array('alias' => 'alias_loanby'));
        $this->hasMany("cid", "CarryRequest", "cid", array('alias' => 'alias_request'));
        $this->hasManyToMany(
            'cid',
            'Loanby',
            'cid', 'loanid',
            'LoanInformation',
            'loanid',
            array(
                'alias' => 'alias_loan'
            )
        );
        $this->hasManyToMany(
            'cid',
            'CarryRequest',
            'cid', 'oid',
            'CrmOfficer',
            'oid',
            array(
                'alias' => 'alias_crm'
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
    public function getAccount()
    {
        return $this->alias_account;
    }
    public function getLoan()
    {
        return $this->alias_loan;
    }
    public function getLoanBy()
    {
        return $this->alias_loanby;
    }
    public function getCalendar()
    {
        return $this->alias_calendar;
    }
    public function getPaying()
    {
        return $this->alias_paying;
    }
    public function getMyrequest()
    {
        return $this->alias_request;
    }
    public function getMycrm()
    {
        return $this->alias_crm;
    }
}