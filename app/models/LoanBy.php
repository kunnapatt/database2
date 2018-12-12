<?php

class LoanBy extends \Phalcon\Mvc\Model
{
    public $cid;
    public $loanid;
    public $asset;
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("loan_by");
        $this->belongsTo('cid', 'Customers', 'cid', array('alias' => 'customer'));
        $this->belongsTo('loanid', 'LoanInformation', 'loanid', array('alias' => 'loan'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    // public function getSource()
    // {
    //     return 'loan_by';
    // }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return LoanBy[]|LoanBy|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return LoanBy|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function getCustomer()
    {
        return $this->alias_customer;
    }
    public function getLoan()
    {
        return $this->alias_loan;
    }

}
