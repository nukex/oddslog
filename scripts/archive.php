<?php

ini_set('memory_limit', '444M');

$config = parse_ini_file(__DIR__ . '../../config.ini');
include_once (__DIR__ . '/libs/crud.class.php');
include_once (__DIR__ . '/libs/db.php');



$time = date ('Y-m-d 23:59:59', strtotime("-1 days") )  ;



$matches  = $crud->rawSelect('
    SELECT id, eventID , info
    FROM `matchs` 
    WHERE 
      #archived = 0
        #AND timestart < "'.$time.'"
    eventID = 560029086
    Order by eventID DESC


') ->fetchAll(PDO::FETCH_ASSOC);


    foreach ($matches as $key => $match) {

     


        $odds  = $crud->rawSelect('
            SELECT matchTime,scoreHome,scoreAway,w1,x,w2,odd1X,odd12,oddX2,hcap1,hcap2,hcap1Odd,hcap2Odd,underTotal,overTotal,total,period
            FROM `odds` 
            WHERE eventID = '.$match['eventID'].'

            Order by timeLine ASC

        ') ->fetchAll(PDO::FETCH_ASSOC);
        
        $stats  = $crud->rawSelect('
            SELECT matchTime,attacks,dangerous,possession,shotsOn,shotsOff,corners,yellow,red,penalty
            FROM `stats` 
            WHERE eventID = '.$match['eventID'].'
            Order by matchTime ASC
        ') ->fetchAll(PDO::FETCH_ASSOC);


        echo 'id: '.  $match['id'] . ' | eventID: '. $match['eventID']  . "\n";
    
        $info       = json_decode( $match['info'] ,true);
        $firstOdd   = $odds[0];
        $endOdd     = end ($odds);
        $endStat    = end($stats);

        $archive[0] = [
            'matchID'   => $match['id'],
            'eventID'   => $match['eventID'],
            // 'data'      => "\x1f\x8b\x08\x00".gzcompress(json_encode ([
            //             'odds'=>  $odds ,
            //             'stats'=>  $stats ,
            //         ]) 
            //     ), 
                          
            'odds'  =>   json_encode([
                        'w1' =>     $firstOdd['w1'],
                        'x' =>     $firstOdd['x'],
                        'w2' =>     $firstOdd['w2'],
            ]),
            
            'stats'  =>   json_encode($endStat),
            'gameID' =>   $info['gameId'] ?? NULL,


            'scoreHome'  =>  $endOdd['scoreHome'] ,
            'scoreAway'  =>  $endOdd['scoreAway'] ,
        ];

        print_r ( $archive);

        die();

        // $crud->dbInsert('archive', $archive);

        // $update['archived'] = 1;
        // $crud->dbMultiUpdate('matchs', $update, 'id', $match['id']);
    }