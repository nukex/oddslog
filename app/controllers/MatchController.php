<?php

use Phalcon\Mvc\View\Simple as SimpleView;
class MatchController extends ControllerBase
{

    public function viewAction()
    {

        $this->getCaptchaCheck();

        
        $id = (int) $this->dispatcher->getParam('id') ;
        $slug =     $this->dispatcher->getParam('slug') ;
        $ajax =     $this->request->getQuery('ajax', 'int');

        $match = Matchs::findFirst("id = " . $id);

        $country = explode ('. ', $match->tournament);
        $country = (isset($match->country) ? $match->country  : $country[0])  ;
        $isWomen = (preg_match('/women/i',$match->tournament) ? true: false);

        $matchSlug =  Slug($country.' '. $match->team1.' '.$match->team2);
        

        // echo $matchSlug;
        
        // if ($slug!=$matchSlug && $match->eventID) {
        //     header('Location: https://oddslogs.com/match/'.$match->id.'/'.$matchSlug);
        //     exit;
        // }

        // if (!$match->eventID || $slug!=$matchSlug) {
        
        //     return $this->notFound();
        // }

        $odds   = Odds::find([
            'distinct' => 'matchTime',
            "eventID = " . $match->eventID 
        ]);
        $lastOdds   = $odds->getLast();
        $oddsCount  = $odds->count();

        
        $stats      = Stats::find( [
            'columns'   => 'matchTime as M,attacks as A,dangerous as D,possession as P,shotsOn as SO,
                            shotsOff as S,corners as C, yellow as Y,red as R,penalty as PE',

            'eventID = ' . $match->eventID,
            'order'     => 'matchTime',
            'distinct'  => 'matchTime',
        ]);

        $this->view->h2h   = H2h::findFirst([
            "eventID = " . $match->eventID 
        ]);




        //views
        $this->view->prevScore   = ['Home' => ($oddsCount>1 ? $odds[$oddsCount-2]->scoreHome : 0),
                                    'Away' => ($oddsCount>1 ? $odds[$oddsCount-2]->scoreAway : 0)
                                    ];
                                    
        $this->view->lastStats  =  (isset($stats->getLast()->P) ? statExplode($stats->getLast()) : false ) ;
        $this->view->match      =  $match;
        $this->view->odds       =  $odds;
        $this->view->stats      =  ($stats->count()>0 ? groupArray($stats->toArray(), 'M') : false ) ;
        $this->view->lastOdds   =  $lastOdds;

    
        $this->view->matchStatus = $this->matchStatus($lastOdds);
        $this->view->countryFlag = $isWomen ? 'women': $this->countryCode($country) ;

        $this->view->country     = $country;
        $this->view->matchInfo   = json_decode ($match->info, 1);

        $this->view->date = [
            'timestart'     => date('d.m.Y - H:i', strtotime($match->timestart) ),
            'view'          => date('D, M d Y, H:i', strtotime($match->timestart) )
        ];
     


        $this->view->meta    = [
            'info'      => $match->team1 . ' vs ' . $match->team2 . "  ({$lastOdds->scoreHome}:{$lastOdds->scoreAway}) - {$match->tournament}. Starts on ".date ('d/m/Y', strtotime($match->timestart) ).". Historical Stats & Odds. In-Play archive." ,

            'infoTitle' =>  $match->team1 . ' - ' . $match->team2 .  ($isWomen? " - Women " : " "). "(". date ('d/m/Y', strtotime($match->timestart)).') - OddsLog.com' 
        ];
        
        
        
        $this->setMetadata([    
                'title'     => $this->view->meta['infoTitle']  ,
                'desc'      => $this->view->meta['info'],
                // 'canonical'      => '/football/'.$match->id . '/'. $matchSlug
            ]) ;

        if ($ajax == 1) {
                $this->view->setRenderLevel( \Phalcon\Mvc\View::LEVEL_ACTION_VIEW ); 
         }

        
         $this->assets->collection('header')->addJs('static/js/chart.min.js');
         $this->assets->collection('footer')->addJs('static/js/live.js?v=3');
    }


    public function ajaxAction()
    {
        $view = new SimpleView();

        $id = (int) $this->dispatcher->getParam('id') ;
        $slug =     $this->dispatcher->getParam('slug') ;
        $ajax =     $this->request->getQuery('ajax', 'int');

        $match = Matchs::findFirst("id = " . $id);

        $odds   = Odds::find([
            'distinct' => 'matchTime',
            "eventID = " . $match->eventID 
        ]);

        $lastOdds   = $odds->getLast();
        $oddsCount  = $odds->count();
        $this->view->odds       =  $odds;
        $matchStatus = $this->matchStatus($lastOdds);

        if ($matchStatus->text !='FT') {

        $stats      = Stats::find( [
            'columns'   => 'matchTime as M,attacks as A,dangerous as D,possession as P,shotsOn as SO,
                            shotsOff as S,corners as C, yellow as Y,red as R,penalty as PE',

            'eventID = ' . $match->eventID,
            'order'     => 'matchTime',
            'distinct'  => 'matchTime',
        ]);

        //views
        $this->view->prevScore   = ['Home' => ($oddsCount>1 ? $odds[$oddsCount-2]->scoreHome : 0),
                                    'Away' => ($oddsCount>1 ? $odds[$oddsCount-2]->scoreAway : 0)
                                    ];

        $this->view->lastStats  =  (isset($stats->getLast()->P) ? statExplode($stats->getLast()) : false ) ;
        $this->view->stats      =  ($stats->count()>0 ? groupArray($stats->toArray(), 'M') : false ) ;

        $this->view->disableLevel(array(
            \Phalcon\Mvc\View::LEVEL_LAYOUT => true,
            \Phalcon\Mvc\View::LEVEL_MAIN_LAYOUT => true
        ));
        $html = $this->view->getRender('match', 'ajax');
        
        header('Content-type: application/json; charset=utf-8');

        echo  json_encode(
                [   'error' =>  false,
                'score' =>
                 [
                    $lastOdds->scoreHome,
                    $lastOdds->scoreAway
                 ],
                'content'=> $html,
                'time'  => $matchStatus->text,
                'scored' => [
                    ($lastOdds->scoreHome > $this->view->prevScore['Home'] ? true:false),
                    ($lastOdds->scoreAway > $this->view->prevScore['Away'] ? true:false)
                ]
            ]
            );
        }   
        else {
            echo    json_encode( ['error' =>  true , 'time'=> 'FT']);
        }

        die();
        exit;


        


    }

}

