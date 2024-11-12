<?php

class Posts extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $text;

    /**
     *
     * @var string
     */
    public $slug;

    /**
     *
     * @var string
     */
    public $date_add;

    /**
     *
     * @var string
     */
    public $date_edit;

    /**
     *
     * @var integer
     */
    public $user;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("posts");
        // $this->hasOne('uid', 'Users', 'id');
        // $this->hasOne('cid', 'Category', 'id');

        $this->useDynamicUpdate(true);

    }

    public static function getTop()
    {
        $TopPost =  Posts::find([
            'conditions' => 'status >  0',
            'order'      =>  'orders DESC, views DESC',
            'limit'      => 5,
        ]);

       
        return $TopPost ;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts[]|Posts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
