<pre>
<?php
error_reporting(1);
set_time_limit(0);
// header('Access-Control-Allow-Origin: *');

// include_once (__DIR__ . '/libs/functions.php');

$config = parse_ini_file(__DIR__ . '../../config.ini');

include_once (__DIR__ . '/libs/crud.class.php');
include_once (__DIR__ . '/libs/db.php');
require_once (__DIR__ . '/libs/sqlite.php');


$Xdomain = ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' ? '1xbet-mn.com' : '1xbet.com');

function nullVal ($d) {
    return ($d == '—' || $d =='-' || $d =='' || $d == 0 ? NULL : floatval($d));
    // return $d;
}
function get_sec()
	{
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		return $mtime;
	}
function groupArray($array, $key) { 
    $key_array = []; 
    foreach($array as $val) { 
            $key_array[$val[$key]] = $val; 
    } 
    return $key_array; 
}

function groupKeyValue($array, $key, $v) { 
    $key_array = []; 
    foreach($array as $val) { 
            $key_array[$val[$key]] = $val[$v]; 
    } 
    return $key_array; 
}

function replaceTitle ($str) {

    return str_replace ([' (Women)'],'', $str);
}

function separateArray($array) { 
    return (!is_null($array[0]) ? implode ('|', $array) : NULL); 
}

function getContent($url){
	
    $ctx = stream_context_create(array( 
        'http' => [ 
        'timeout' => 25 ,
           'header'=>[
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36",
                    'Referer: https://'.$Xdomain.'/live/Football/',
                    'Accept-Language:ru,tr;q=0.9,en;q=0.8,fr;',
                    'Accept: application/json, text/plain, */*',
                    'sec-ch-ua-platform: "Windows"',
                    'Cookie: fast_coupon=true; v3tr=1; typeBetNames=short; lng=en; flaglng=en; tzo=0.00; ggru=174; dnb=1; _glhf=1633120939; coefview=0; _ym_visorc=w; _gat_gtag_UA_131611796_1=1',
           
            ],
        ]
        ) 
    ); 

    $result = file_get_contents($url, 0, $ctx); 
    return $result;
}



$start_time = get_sec();

$file = getContent ('https://'.$Xdomain.'/LiveFeed/Get1x2_VZip?sports=1&count=1250&lng=en&antisports=188&mode=4&country=1&partner=51&noFilterBlockEvent=true');
// $file = getContent ('tmp/test.json1732201994');
$data =  json_decode($file,1);

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    // file_put_contents ('tmp/test.json' . time(), $file );
}


$dbCache = new SQLite(
    ['driver' => 'sqlite', 'url' => __DIR__ . '/matchs.db']);


printf ("<!-- %f -->", (get_sec() - $start_time) ) ;

if (count($data['Value'])>0) {

    foreach ($data['Value'] as $key => $val) {
        
        // not cyber sport
        if ($val['MIS'][0]['K']!=3 && !preg_match('/(CompletedMatch|4x4|3x3|5x5)/i',$val['L'])) {

            $team['team1'] = replaceTitle ($val['O1']);
            $team['team2'] = replaceTitle ($val['O2']);

            $time['4h']    = date ('Y-m-d H:i:s', time() - 3600* 4 );
            $time['now']    = date ('Y-m-d H:i:s', time() );

            $checkCacheID = $dbCache->select('matchs')
            ->where(" eventID ='{$val['I']}' ")
            ->first()->run();

                //not in tmpdb && match start
                if ( !$checkCacheID && !is_null($val['SC']['TS']) ) {

                    $checkTeamName = $dbCache->select('matchs')
                        ->where(" team1 = '{$team['team1']}' AND team2 = '{$team['team2']}' AND date BETWEEN '{$time['4h']}' AND '{$time['now']}' ")
                        ->first()->run();


                    //Change eventID -> Old ID for Odds & Stats (fix double Team Name )
                    if (  $checkTeamName['eventID']!='' &&  $checkTeamName['eventID'] !=  $val['I']) {
                        echo "!! Change eventID: {$val['I']} -> {$checkTeamName['eventID']} \n";
                        
                        $val['I'] = $checkTeamName['eventID'];
                    } 

                     else {

                        $matches [] = [
                            'eventID'   =>  $val['I'],
                            'team1'     =>  $team['team1'],
                            'team2'     =>  $team['team2'],
                            'country'   =>  $val['CN'],
                            'tournament'=>  $val['L'],
                            'timestart' =>  date('Y-m-d H:i:s', $val['S']),
                  
        
                            'info'    =>  json_encode([
                                            'gameId'    => $val['SGI'],
                                            'place'     => groupKeyValue ($val['MIS'],'K','V'),
                                            'team1ID'   => $val['O1I'],
                                            'team2ID'   => $val['O2I'],
                                           
                                            'lineup'    => $val['HLU'],
                                            'lID'       => $val['LI'],
                                            ]),
        
                            'h2h'       => ($val['SGI']!='' ?1:0),
                            'rating'    => $val['R'] / 100
        
                            ];
        
                            $cacheEventID[] = [   
                                                'id' => NULL,
                                                'eventID' => $val['I'],
                                                'date' =>  $dbCache->func('date', 'Y-m-d H:i:s'),
                                                'team1' => $team['team1'],
                                                'team2' => $team['team2'],              
                                             ];

                     }
               
                }

            $coef       = groupArray ($val['E'],'T');
            $matchTime  = floor($val['SC']['TS']/60);

            if (!empty($val['SC']['TS']) && ($val['SC']['CPS'] !='Half time' && $val['SC']['TS'] !=2700) ) {
                    $lines [] = [
                        'eventID'       =>  $val['I'],
                        'matchTime'     =>  $matchTime,

                        'scoreHome'     =>  $val['SC']['FS']['S1']??0,
                        'scoreAway'     =>  $val['SC']['FS']['S2']??0,

                        'w1'            =>  nullVal($coef[1]['C']),
                        'x'             =>  nullVal($coef[2]['C']),
                        'w2'            =>  nullVal($coef[3]['C']),
                        'odd1X'         =>  nullVal($coef[4]['C']),
                        'odd12'         =>  nullVal($coef[5]['C']),
                        'oddX2'         =>  nullVal($coef[6]['C']),

                        'hcap1'         => $coef[7]['P']??0,
                        'hcap2'         => $coef[8]['P']??0,

                        'hcap1Odd'      => nullVal($coef[7]['C']),
                        'hcap2Odd'      => nullVal($coef[8]['C']),

                        'total'         =>  nullVal($coef[9]['P']),
                        'overTotal'     =>  nullVal($coef[9]['C']),
                        'underTotal'    =>  nullVal($coef[10]['C']),

                        'period'        => $val['SC']['CP']??0,
            
                        'timeLine'      => date('Y-m-d H:i:s'),
                ];
            }


            //stat 
            $statRaw = groupArray ($val['SC']['ST'][0]['Value'],'ID');

    
            if (  (!empty($statRaw) && ($val['SC']['CPS'] !='Half time' 
                    && $val['SC']['TS'] !=2700))  
                    && $matchTime !=0 
                    && count($statRaw)>0 ) 
                {
                    
                    $stats [] = [
                            'eventID'       => $val['I'],
                            'matchTime'     => $matchTime,
                            'attacks'       => separateArray ( [$statRaw[45]['S1'] , $statRaw[45]['S2']] ) ,
                            'dangerous'     => separateArray ( [$statRaw[58]['S1'] , $statRaw[58]['S2']] ) ,
                            'possession'    => separateArray ( [$statRaw[29]['S1'] , $statRaw[29]['S2']] ) ,
                            'shotsOn'       => separateArray ( [$statRaw[59]['S1'] , $statRaw[59]['S2']] ) ,
                            'shotsOff'      => separateArray ( [$statRaw[60]['S1'] , $statRaw[60]['S2']] ) ,
                            'corners'       => separateArray ( [$statRaw[70]['S1'] , $statRaw[70]['S2']] ) ,
                            'yellow'        => separateArray ( [$statRaw[26]['S1'] , $statRaw[26]['S2']] ),
                            'red'           => separateArray ( [$statRaw[71]['S1'] , $statRaw[71]['S2']] ),
                            'penalty'       => separateArray ( [$statRaw[72]['S1'] , $statRaw[72]['S2']] ),
                    ];

        
            }

        }
    }


    if (!empty($matches)) {
        $crud->dbInsert('matchs', $matches);
        echo "\n ** Add  matches: ".count($matches);

        $insertCache = $dbCache->insertArray('matchs', $cacheEventID) ->run();

    }


    if (count($lines)>0) {
        $crud->dbInsert('odds', $lines);
        echo "\n ++ Add  odds: ".count($lines) ;
    }
    if (count($stats)>0) {
        $crud->dbInsert('stats', $stats);
        echo "\n %% Add  stats: ".count($stats) ;
    }

    if ($u>0) {
        echo "\n $$ Update match info: ".$u ;
    }



}



?>