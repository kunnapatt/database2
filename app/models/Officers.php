<?php

class Officers extends \Phalcon\Mvc\Model
{
    public $oid;
    public $fname;
    public $sname;
    public $dOB;
    public $gender;
    public $typeid;
    public $calender;
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("officers");
        $this->hasOne("oid", "CrmOfficer", "oid", array('alias' => 'alias_crm'));
        $this->hasOne("oid", "DeptTrackers", "oid", array('alias' => 'alias_dept'));
        $this->hasMany("oid", "Calendar", "oid", array('alias' => 'alias_calendar'));
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
    public function getDept()
    {
        return $this->alias_dept;
    }
    public function getCalendar()
    {
        return $this->alias_calendar;
    }
}
