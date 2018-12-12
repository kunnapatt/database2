<?php

class DeptTrackers extends \Phalcon\Mvc\Model
{
    public $oid;
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("dept_trackers");
        $this->belongsTo('oid', 'officers', 'oid', array('alias' => 'alias_officer'));
        $this->hasManyToMany(
            'oid',
            'Tracking',
            'oid', 'cid',
            'customers',
            'cid',
            array(
                'alias' => 'alias_track'
            )
        );
    }
    // public function getSource()
    // {
    //     return 'dept_trackers';
    // }
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function getTrack()
    {
        return $this->alias_track;
    }
    public function getOfficer()
    {
        return $this->alias_officer;
    }

}
