<?php
use \Phalcon\Mvc\ModelInterface;
class Odds extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $matchTime;

    /**
     *
     * @var integer
     */
    public $scoreHome;

    /**
     *
     * @var integer
     */
    public $scoreAway;

    /**
     *
     * @var double
     */
    public $w1;

    /**
     *
     * @var double
     */
    public $x;

    /**
     *
     * @var double
     */
    public $w2;

    /**
     *
     * @var double
     */
    public $odd1X;

    /**
     *
     * @var double
     */
    public $odd12;

    /**
     *
     * @var double
     */
    public $oddX2;

    /**
     *
     * @var string
     */
    public $hcap1;

    /**
     *
     * @var double
     */
    public $hcap1Val;

    /**
     *
     * @var string
     */
    public $hcap2;

    /**
     *
     * @var double
     */
    public $hcap2Val;

    /**
     *
     * @var string
     */
    public $under;

    /**
     *
     * @var double
     */
    public $underVal;

    /**
     *
     * @var string
     */
    public $over;

    /**
     *
     * @var double
     */
    public $overVal;

    /**
     *
     * @var string
     */
    public $timeLine;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("odds");
    }



    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Odds[]|Odds|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Odds|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null): ?ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
