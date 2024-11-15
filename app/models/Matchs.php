<?php
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
class Matchs extends \Phalcon\Mvc\Model
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
    public $team1;

    /**
     *
     * @var string
     */
    public $team2;

    /**
     *
     * @var string
     */
    public $tournament;
    public $info;
    public $descRu;
    public $country;
    public $rating;
    public $archived;
    public $h2h;

    /**
     *
     * @var string
     */
    public $timestart;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
     
        $this->setSource("matchs");
        $this->hasMany('eventID', 'Odds', 'eventID', ['alias' => 'Odds','reusable' => true]);
        $this->hasMany('eventID', 'Stats', 'eventID', ['alias' => 'Stats','reusable' => true]);
    }

    public static function dateMatchs($date)
    {

        $Matchs = Matchs::find(
            [
                'conditions' => " timestart LIKE '$date%'    ",
                'order'      => 'rating DESC, tournament ASC',
            ]
        );

       
        return $items ;

    }

    public static function getCountLiveMatchs($date)
    {
        $live = $all = 0;
        $Matchs = Matchs::find(
            [
                'columns'   => 'id,eventID, timestart',
                'conditions' => " timestart LIKE '$date%' ",
                'order'      => 'timestart ASC',
                'cache' => [
                    'key'      => 'liveCount.cache',
                    'lifetime' => 60,
                ],
            ]
        );

        foreach ($Matchs as $key => $match) {
            $diffTime  = round ( ( time() - strtotime($match->timestart)) / 60 );
            if ($diffTime < 110) {
                $liveMatchs [] = $match->id;
                $live++;
            } 
            $all++;
        }

        return $live;
    }

    public static function liveMatchs($date)
    {
        $live = $all = 0;
        $Matchs = Matchs::find(
            [
                'columns'   => 'id,eventID, timestart',
                'conditions' => " timestart LIKE '$date%'  ",
                'order'      => 'rating DESC, timestart ASC',
                'cache' => [
                    'key'      => 'live.cache',
                    'lifetime' => 60,
                ],
            ]
        );

        foreach ($Matchs as $key => $match) {
            $diffTime  = round ( ( time() - strtotime($match->timestart)) / 60 );
            if ($diffTime < 112) {
                $liveMatchs [] = $match->id;
                $live++;
            } 
            $all++;
        }

        if (!is_null($liveMatchs) && count($liveMatchs)>0) {
            $Matchs = Matchs::find(
                [
                'conditions' => ("  id IN (".implode(',', $liveMatchs).") ") ,
                'cache' => [
                    'key'      => 'Matchs.cache',
                    'lifetime' => 60,
                ],
            ]
            );

            return [
                'count' => $all,
                'matchs' =>$Matchs
            ] ;
        } 
        else 
        return false;

    }

    public static function listMatchs($date,$page)
    {

        $modelsManager = Phalcon\Di\Di::getDefault()->getModelsManager();
        $builder     = $modelsManager
            ->createBuilder()
            ->columns('*')
            ->where(    " timestart LIKE '$date%'  "  )  
            ->from('Matchs')
            // ->limit(250)
            ->orderBy('rating DESC, country ASC, timestart ASC');

        $paginator = new PaginatorQueryBuilder(
            [
                'builder' => $builder,
                'limit'   => 100 ,
                'page'    => $page,
            ]
        );
        return $paginator ;
    }

    public static function search($query)
    {

        $items = Matchs::find(
            [

                'conditions' => " team1 LIKE '". addslashes ($query) ."%'  OR  team2 LIKE '". addslashes ($query) ."%' ",
                'limit'      => 30,
                'order'      => ' timestart DESC',
            ]
        )->toArray();

        foreach ($items as $key => $val) {
            $country =  explode ('. ', $val['tournament']); 

            // echo $country;
        
            $country = (isset($val['country']) ? $val['country']  : $country[0])  ;
    
            $matchs [] =[ 
                 'team1'=> $val['team1'],
                 'team2'=> $val['team2'],
                 'country'=>strtolower (trim($country)),
                 'date'=> date('d.m.Y', strtotime($val['timestart'])) ,
                 'info' => preg_match('/women/i', $val['tournament'] ) ? 'women' : '',
                 'slug' => "/football/{$val['id']}/" . Slug($country.' '. $val['team1'].' '.$val['team2'] ) 
            ];
        }       

        return json_encode ($matchs , JSON_NUMERIC_CHECK) ;
    }

    public static function listSitemap($currentPage, $limit)
    {
 
        $modelsManager = Phalcon\DI::getDefault()->getModelsManager();
        $builder     = $modelsManager
            ->createBuilder()
            ->columns('*')
            // ->where(   " tid = 30 "  )  
            ->from('Matchs');
            // ->orderBy('timestart DESC');

        $paginator = new PaginatorQueryBuilder(
            [
                'builder' => $builder,
                'limit'   => $limit ,
                'page'    => $currentPage,
            ]
        );

        return $paginator;
    } 


    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Matchs[]|Matchs|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Matchs|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
