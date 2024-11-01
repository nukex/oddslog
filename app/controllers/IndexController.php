<?php


use Phalcon\Mvc\Model\Query;

// use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class IndexController extends ControllerBase
{
  
    protected function groupedMatchs( $matchs , $getStats) {
        $result =  [];
        $m = $l = 0;
        
        foreach ($matchs as $match) {
            $m++;
            $country = explode ('. ', $match->tournament);
            $country = (!empty($match->country) ? $match->country : $country[0])  ;

            $countryCode = (preg_match('/women/i',$match->tournament) ? 'women': $this->countryCode($country)) ;

            $prefix  = ( !preg_match("/{$country}/i", $match->tournament) ?  $country.'. ' : '' ); 
            $Odds['first'] = $match->Odds->getFirst();
            $Odds['last']  = $match->Odds->getLast();

            if ($getStats == 1) {
                if ($match->Stats->count()>0) {
                    $stats = $match->Stats->getLast();
                    $Stats['last']  =  [
                            'M' => $stats->matchTime,
                            'A' => $stats->attacks,
                            'D' => $stats->dangerous,
                            'P' => $stats->possession,
                            'SO'=> $stats->shotsOn,
                            'S' => $stats->shotsOff,
                            'C' => $stats->corners,
                            'Y' => $stats->yellow,
                            'R' => $stats->red,
                            'PE'=> $stats->penalty,
                        ];
                }
            }
        
            $matchStatus = (array) $this->matchStatus( $Odds['last']);
            
            $result['matchs'][$match->rating][$countryCode .'|' . $prefix.  $match->tournament] [] = 
            [
                'id'         => $match->id,
                'team1'      => $match->team1,
                'team2'      => $match->team2,
                'tournament' => $match->tournament,
                'rating'     => $match->rating,

                'beginTime'  => date ('H:i', round (strtotime($match->timestart) / 300  )*300 ),
                'matchStatus'=> $matchStatus,
                'url'        => $match->id . '/'. Slug($country.' '. $match->team1.' '.$match->team2),
                'matchTime'  => $Odds['last']->matchTime??0,
                'stats'      => (!empty($Stats['last']) ? json_encode ($Stats['last']) : '' ) ,

                'firstW1'    => $Odds['first']->w1,
                'firstX'     => $Odds['first']->x,
                'firstW2'    => $Odds['first']->w2,
                'w1'         => $Odds['last']->w1,
                'x'          => $Odds['last']->x,
                'w2'         => $Odds['last']->w2,

                'scoreHome'  => $Odds['last']->scoreHome??0,
                'scoreAway'  => $Odds['last']->scoreAway??0,

                'h'          => $Odds['last']->timeLine??0,
                'info'       => json_decode ($match->info,1),
            ] ;

            if ($matchStatus['text']!='FT') {
                $l++;
            }
        }
        
        $result['stat'] = ['count'=>$m,'live'=>$l];

        krsort($result['matchs']); 
   
        // print_r ($result['matchs']);
        // die();

        return (object) $result;
    }
  

    public function indexAction()
    {
        if ($this->dispatcher->getParam('year')) {
            $date = $this->dispatcher->getParam('year').'-'.
                    $this->dispatcher->getParam('month').'-'.
                    $this->dispatcher->getParam('day');
            $pastDate = true;
        }
        else  {
            $date = date('Y-m-d');
        }


        $page = $this->request->getQuery('page', 'int', 1);
        $matchs  = Matchs::listMatchs($date,  $page)->paginate();

        $this->view->total = [
            'Matchs' => $matchs->getTotalItems(),
            'Live'   => Matchs::getCountLiveMatchs($date)
        ];

   
        if ($this->view->total['Matchs']<1) {
            return $this->notAvailable();
        }

        $this->view->items =  $matchs;    
        $this->view->matchs = $this->groupedMatchs($matchs->getItems() , 1);
        $this->view->date = [
            'view'     => date('d-M-y', strtotime($date) ),
            'select'   => $date
        ];

        $this->setMetadata([    
            'title'     => (isset($pastDate) ? $date .' - Match Results - OddsLog.com ' :  //date title
                         "OddsLog.com -  In-play Odds Archive & Live Statistics" )      //index title
                         .($page>1 ? ' - '. $page: '' ) ,

            'desc'      =>  (isset($pastDate) ? $date .' matches archived results' :  
            'Archive of Odds, live score and statistics by the minute for all soccer matches' ),
        ]) ;

    }


    public function liveAction()
    {   
 
        $ajax = $this->request->getQuery('ajax', 'int');
        $date = date('Y-m-d');

        $matchs  = Matchs::liveMatchs($date);
        
        $this->setMetadata([
            'title'     => "OddsLog.com - Live Matchs In-play Odds" ,
            'desc'      =>  'Soccer in-play live Betting Odds logs, archived results, live scores & statistics for all soccer matches, covering all countries, leagues, teams and football clubs.',
        ]) ;

        if ($matchs['count']<1) { 
            if ($ajax == 1) {
                $this->view->setRenderLevel( \Phalcon\Mvc\View::LEVEL_ACTION_VIEW ); 
            }
    
                return $this->noLiveMatch();
        }

        $this->view->matchs = $this->groupedMatchs($matchs['matchs'] , 1);
        $this->view->total = [
            'Matchs' => $matchs['count'],
            'Live'   => $this->view->matchs->stat['live']
        ];

        $this->view->date = [
                'view'     => date('d-M-y', strtotime($date)),
                'select'   => date('Y-m-d')
            ];

        if ($ajax == 1) {
            $this->view->setRenderLevel( \Phalcon\Mvc\View::LEVEL_ACTION_VIEW ); 
        }

        $this->assets->collection('footer')->addJs('static/js/live.js?v=3');
 
    }

    public function searchAction()
    {
       
        if ($this->request->isPost()) {
            header('Content-Type: application/json');
            $query = $this->request->getPost('query');
            $items = Matchs::search($query);
            echo ($items);
            die();
        }

    }


    public function captchaAction()
    {
        $recaptcha = $_POST['g-recaptcha-response'];

        if(!empty($recaptcha)) {
          
            echo $recaptcha;
            $secret = '6Ld60D0gAAAAAAw_prL4EsLW8Q7M1Sg-Tu3ZpaVO';
        
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret ."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];

            $res = json_decode( file_get_contents ($url) , 1);

            if($res['success']) {
                $_SESSION['badView'] = 0;
                $_SESSION['totalView'] = 0;
                header("Location: /live");
         
            } else {
                header('HTTP/1.0 403 Forbidden');
                $this->view->pick('captcha');
            }

           
        } else {
            header('HTTP/1.0 403 Forbidden');
            $this->view->pick('captcha');
        }




        // print_r ($_POST);
        // die();

        // if ($_POST['captcha'] ==$_SESSION['captcha'] ) {
        //     $_SESSION['badView'] = 0;
        //     $_SESSION['totalView'] = 0;
        //     header("Location: /live");
        // } 
        //     else {
        //         header('HTTP/1.0 403 Forbidden');
        //         $this->view->pick('captcha');
        //     }


    }




}
