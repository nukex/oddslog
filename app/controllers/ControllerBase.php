<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function initialize()
    {

        $this->getCaptchaCheck();

        $this->view->TotalLive = Matchs::getCountLiveMatchs(date('Y-m-d'));

        $footerJS = $this->assets->collection('footer');
        $footerJS->addJs('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',false);
        $footerJS->addJs('/static/bootstrap-5.3.3/js/bootstrap.bundle.min.js',false);
        $footerJS->addJs('static/js/script.js?v=3');

       
       

    }

    public function setMetadata($ar)
    {
        $this->view->metadata     =  [
            'title'    => $ar['title'] ,
            'desc'     => $ar['desc'],
            'keywords' => (isset($ar['keywords']) ? $ar['keywords']: null),
            'og:image' =>  (isset($ar['img']) ? $ar['img']: '/static/img/android-chrome-512x512.png'),
            'alternate' => (isset($ar['alternate']) ? $ar['alternate']: null),
            'canonical' => (isset($ar['canonical']) ? $ar['canonical']: null),
        ] ;
    }


public function getCaptchaCheck() {
    
    session_start();
   
if (!isset($_SESSION['initTime'])) {
    $_SESSION['initTime'] = time();
 }

  $totalView =   $_SESSION['totalView'] ?? 0 ;
  $initTime =    $_SESSION['initTime']  ?? 0 ;
  $lastView =    $_SESSION['lastView'] ?? 0 ;
  $badView =     $_SESSION['badView']  ?? 0 ;

  $diffLastView  =( time() - $lastView);
  $diffInitView  =( time() - $initTime);

  $_SESSION['totalView'] = ($totalView+1);
  $_SESSION['lastView'] = time();



  if ($diffLastView <= 1) {
    $_SESSION['badView'] = $badView + 1;
  }
  
  if  ( isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == 'https://www.google.com/' ) {
    $_SESSION['badView'] = $badView + 1;
  }

  if ( $badView >= 6 || ($diffInitView <= 300 && $totalView > 50)  || ($totalView > 50)  ) 
  {
    header('HTTP/1.0 403 Forbidden');
    $this->view->pick('captcha');
  }


}

public function notFound() {
    header("HTTP/1.0 404 Not Found");
    $this->view->pick('404');

  }

  public function noLiveMatch() {
    // header("HTTP/1.0 404 Not Found");
    $this->view->pick('noLiveMatch');

  }
  public function notAvailable() {
    // header("HTTP/1.0 404 Not Found");
    $this->view->pick('notAvailable');

  }

public function countryCode($val) {
    // $val = trim($val);

    $myList = [
        'Friendlies' => 'world',
        'Wom' => 'women',
        'Women' => 'women',
        'Northern Ireland' => 'northern-ireland',
        'North Ireland' => 'northern-ireland',
        'Equador' => 'ecuador',
        'Kazahstan' => 'kazakhstan',
        'Nikaragua'=>'nicaragua',
        'Saudi Arabia'=>'sau',
        'United States'=>'usa',
        'South Africa'=>'zaf',
        'South America'=>'sam',
        'Hong Kong'=>'hkg',
        'Hong Kong'=>'hkg',
        'United Arab Emirates'=>'uae',
        'Czech Republic'=>'cze',
        'Burkina Faso'=>'bfa',
        'Costa Rica'=>'cri',
        'New Zealand'=>'nzl',
        'Bosnia and Herzegovina'=>'bih',
        'Dominican Republic'=>'dom',
        'Faroe Islands'=>'fro',
        'Puerto Rico'=>'pri',
        'South Korea'=>'kor',
    ];


    if ( !empty($myList[$val])) {
        return $myList[$val];
    } else 
        return strtolower(trim($val));

     
}



    public function matchStatus($match)
    {
        if (is_array($match)) {
            $match = (object) $match;
        }

        $status = new \stdClass;
        $diffDateTime  =( time() - strtotime($match->timeLine));
        
       
        if ( $match->matchTime >= 90 &&   $diffDateTime > 120 ) {
            $status->text = 'FT';
            $status->alert = 'success';           
        }
      

        elseif ( in_array($match->matchTime, range(44,50) )  && $diffDateTime > 70 ) {
            $status->text = 'HT';
            $status->alert = 'primary blink';
        }

        elseif ( is_null($match->matchTime) && is_null($match->scoreHome) ) 
         {
            $status->text = 'Waiting';
            $status->alert = 'warning';
        }
        elseif ( $diffDateTime > 60*5 ) {
            $status->text = 'FT';
            $status->alert = 'success';           
        }
        else {
          
            $status->text = ( ($match->matchTime <=44 || ($match->matchTime >45 && $match->matchTime<=89) )  ? ( (int) $match->matchTime + 1) : $match->matchTime)  . " '" ;
            $status->alert = 'danger blink fw-bold';  
        }

        return $status;
    }






}
