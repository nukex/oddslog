<?php
error_reporting(1);
set_time_limit(0);

include_once (__DIR__ . '/libs/functions.php');

$config = parse_ini_file(__DIR__ . '../../config.ini');

include_once (__DIR__ . '/libs/crud.class.php');
include_once (__DIR__ . '/libs/db.php');



$matches  = $crud->rawSelect('
SELECT c.id,  c.eventID , m.id as mid, m.timestart as timestart, m.team1,m.team2, m.tournament, h.data as h2h
    FROM `compile` c
    INNER JOIN matchs as m ON  m.eventID = c.eventID
    INNER JOIN h2h as h ON  h.eventID = c.eventID
    WHERE status = 0 AND c.id < 10000

') ->fetchAll(PDO::FETCH_ASSOC);


foreach ($matches as $key => $match) {

    $Odds  = $crud->rawSelect('
    SELECT matchTime,scoreHome,scoreAway,w1,x,w2,odd1X,odd12,oddX2,hcap1,hcap2,hcap1Odd,hcap2Odd,underTotal,overTotal,total,period
        FROM `odds` 
        WHERE eventID = '.$match['eventID'].'

        Order by timeLine ASC

    ') ->fetchAll(PDO::FETCH_ASSOC);

    $Stats  = $crud->rawSelect('
        SELECT matchTime,attacks,dangerous,possession,shotsOn,shotsOff,corners,yellow,red,penalty
        FROM `stats` 
        WHERE eventID = '.$match['eventID'].'
        Order by matchTime ASC
    ') ->fetchAll(PDO::FETCH_ASSOC);


    $Odds  = groupArray( $Odds  , 'matchTime' ); 
    $Stats = groupArray( $Stats , 'matchTime' );

    $h2h = json_decode( $match['h2h']);

    $ppg1 = h2hPPGCalc ($match['team1'] , $h2h->home);
    $ppg2 = h2hPPGCalc ($match['team2'] , $h2h->away);




    echo 'id: '.  $match['mid'] . ' | eventID: '. $match['eventID']  . "\n";

    // print_r ($match);
    $update['status'] = 1;


    $update['dateMatch'] = $match['timestart'] ?? NULL;

    $update['score1'] = getScore($Odds, 'scoreHome');
    $update['score2'] = getScore($Odds, 'scoreAway');

    $update['w1'] = getFirstOdds($Odds, 'w1') ;
    $update['w2'] = getFirstOdds($Odds, 'w2');
    $update['x'] = getFirstOdds($Odds, 'x');

    $update['ppg1'] = $ppg1['ppg'];
    $update['ppg2'] = $ppg2['ppg'];


                 // (!empty($Odds[15]) ? $Odds[15]['w2'] : $Odds[14]['w2']);

    #### Time - 15
    $update['t15-score1'] = $Odds[15]['scoreHome']?? $Odds[14]['scoreHome'] ;
    $update['t15-score2'] = $Odds[15]['scoreAway']?? $Odds[14]['scoreAway'] ;

    $update['t15-w1']     = $Odds[15]['w1'] ?? $Odds[14]['w1'] ; 
    $update['t15-w2']     = $Odds[15]['w2'] ?? $Odds[14]['w2'];

    $update['t15-at1']     = keyExplode ($Stats[15]['attacks'], 0 );
    $update['t15-at2']     = keyExplode ($Stats[15]['attacks'], 1 );

    $update['t15-da1']     = keyExplode ($Stats[15]['dangerous'], 0 );
    $update['t15-da2']     = keyExplode ($Stats[15]['dangerous'], 1 );

    $update['t15-so1']     = keyExplode ($Stats[15]['shotsOn'], 0 );
    $update['t15-so2']     = keyExplode ($Stats[15]['shotsOn'], 1 );

    $update['t15-c1']     = keyExplode ($Stats[15]['corners'], 0 );
    $update['t15-c2']     = keyExplode ($Stats[15]['corners'], 1 );


    #### Time - 30
    $update['t30-score1'] = $Odds[30]['scoreHome']; 
    $update['t30-score2'] = $Odds[30]['scoreAway'];

    $update['t30-w1']     = $Odds[30]['w1'] ?? 0 ;  
    $update['t30-w2']     = $Odds[30]['w2']?? 0 ; 

    $update['t30-at1']     = keyExplode ($Stats[30]['attacks'], 0 );
    $update['t30-at2']     = keyExplode ($Stats[30]['attacks'], 1 );

    $update['t30-da1']     = keyExplode ($Stats[30]['dangerous'], 0 );
    $update['t30-da2']     = keyExplode ($Stats[30]['dangerous'], 1 );

    $update['t30-so1']     = keyExplode ($Stats[30]['shotsOn'], 0 );
    $update['t30-so2']     = keyExplode ($Stats[30]['shotsOn'], 1 );

    $update['t30-c1']     = keyExplode ($Stats[30]['corners'], 0 );
    $update['t30-c2']     = keyExplode ($Stats[30]['corners'], 1 );


    #### Time - 60
    $update['t60-score1'] = $Odds[60]['scoreHome']; 
    $update['t60-score2'] = $Odds[60]['scoreAway'];

    $update['t60-w1']     = $Odds[60]['w1'] ?? 0 ; 
    $update['t60-w2']     = $Odds[60]['w2'] ?? 0;

    $update['t60-at1']     = keyExplode ($Stats[60]['attacks'], 0 );
    $update['t60-at2']     = keyExplode ($Stats[60]['attacks'], 1 );

    $update['t60-da1']     = keyExplode ($Stats[60]['dangerous'], 0 );
    $update['t60-da2']     = keyExplode ($Stats[60]['dangerous'], 1 );

    $update['t60-so1']     = keyExplode ($Stats[60]['shotsOn'], 0 );
    $update['t60-so2']     = keyExplode ($Stats[60]['shotsOn'], 1 );

    $update['t60-c1']     = keyExplode ($Stats[60]['corners'], 0 );
    $update['t60-c2']     = keyExplode ($Stats[60]['corners'], 1 );

    // print_r ($Stats[15]);
    print_r ($update);



   $crud->dbMultiUpdate('compile', $update, 'id', $match['id']);   

 
    // echo 'ppg1: '.  $ppg1['ppg'] .' / ppg2: '.  $ppg2['ppg'] . "\n";
    // echo "__________\n";


}
