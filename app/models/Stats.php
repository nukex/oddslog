<?php

class Stats extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $eventID;

    /**
     *
     * @var integer
     */
    public $matchTime;

    /**
     *
     * @var string
     */
    public $attacks;

    /**
     *
     * @var string
     */
    public $dangerous;

    /**
     *
     * @var string
     */
    public $possession;

    /**
     *
     * @var string
     */
    public $shotsOn;

    /**
     *
     * @var string
     */
    public $shotsOff;

    /**
     *
     * @var string
     */
    public $corners;

    /**
     *
     * @var string
     */
    public $yellow;

    /**
     *
     * @var string
     */
    public $red;

    /**
     *
     * @var string
     */
    public $penalty;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
     
        $this->setSource("stats");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stats[]|Stats|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stats|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
