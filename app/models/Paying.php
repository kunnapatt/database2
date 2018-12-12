<?php

class Paying extends \Phalcon\Mvc\Model
{
    public $payingid;
    /**
     *
     * @var string
     */
    public $cid;

    /**
     *
     * @var string
     */
    public $loanid;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var string
     */
    public $amount;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("paying");
        $this->belongsTo('cid', 'Customers', 'cid', array('alias' => 'alias_customers'));
        $this->belongsTo('loanid', 'LoanInformation', 'loanid', array('alias' => 'alias_loan'));
        $this->hasManyToMany(
            'payingid',
            'Tracking',
            'payingid', 'oid',
            'DeptTrackers',
            'oid',
            array(
                'alias' => 'alias_depttrackers'
            )
        );
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    // public function getSource()
    // {
    //     return 'paying';
    // }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Paying[]|Paying|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Paying|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function getCustomer()
    {
        return $this->alias_customers;
    }
    public function getLoan()
    {
        return $this->alias_loan;
    }
    public function getDepttrackers()
    {
        return $this->alias_depttrackers;
    }

}
