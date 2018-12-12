<?php

class Credit extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     */
    public $acount_id;

    /**
     *
     * @var string
     */
    public $expire_date;

    /**
     *
     * @var string
     */
    public $limit;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("mydb");
        $this->setSource("credit");
        $this->belongsTo("acount_id", "Account", "account_id", array('alias' => 'alias_account'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    // public function getSource()
    // {
    //     return 'credit';
    // }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Credit[]|Credit|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Credit|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function getAccount()
    {
        return $this->alias_account;
    }
}
