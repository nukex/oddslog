<pre>
<?php
error_reporting(1);
set_time_limit(0);
// header('Access-Control-Allow-Origin: *');

// include_once (__DIR__ . '/libs/functions.php');

$config = parse_ini_file(__DIR__ . '../../config.ini');

include_once (__DIR__ . '/libs/crud.class.php');
include_once (__DIR__ . '/libs/db.php');

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

function getContent($url){
	
    $ctx = stream_context_create(array( 
        'http' => [ 
        'timeout' => 25 ,
           'header'=>[
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36",
                    'Referer: https://1xbet.com/live/Football/',
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

function separateArray($array) { 


    return (!is_null($array[0]) ? implode ('|', $array) : NULL); 
}

$start_time = get_sec();

$file = getContent ('https://1xbet.com/LiveFeed/Get1x2_VZip?sports=1&count=1250&lng=en&antisports=188&mode=4&country=1&partner=51&noFilterBlockEvent=true');
// $file = getContent ('test.json1633032728');

if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    file_put_contents ('tmp/test.json' . time(), $file );
}



$data =  json_decode($file,1);
$tmpdb = file(__DIR__ . '/tmpdb.txt', FILE_IGNORE_NEW_LINES);

$u = 0;

printf ("<!-- %f -->", (get_sec() - $start_time) ) ;

// print_r ($tmpdb);

if (count($data['Value'])>0) {


    foreach ($data['Value'] as $key => $val) {
        
        // not cyber sport
        if ($val['MIS'][0]['K']!=3 && !preg_match('/(CompletedMatch|4x4|3x3|5x5)/i',$val['L'])) {

            $matchTime = floor($val['SC']['TS']/60);


                //not in tmpdb && match start
                if (!in_array($val['I'], $tmpdb) && !is_null($val['SC']['TS']) ) {
                    $matches [] = [
                    'eventID'   =>  $val['I'],
                    'team1'     =>  replaceTitle ($val['O1']),
                    'team2'     =>  replaceTitle ($val['O2']),
                    'country'   =>  $val['CN'],
                    'tournament'=>  $val['L'],
                    'timestart' =>  date('Y-m-d H:i:s', $val['S']),
                    'descRu'    =>  json_encode([
                                    'team1' => $val['O1R'],
                                    'team2' => $val['O2R'],
                                    'lg' => $val['LR'],
                                    ]),
                    'info'    =>  json_encode([
                                    'place'     => groupKeyValue ($val['MIS'],'K','V'),
                                    'team1ID'   => $val['O1I'],
                                    'team2ID'   => $val['O2I'],
                                    'gameId'    => $val['SGI'],
                                    'lineup'    => $val['HLU'],
                                    'lID'       => $val['LI'],
                                    ]),

                    'h2h'       => ($val['SGI']!=''?1:0),
                    'rating'    => $val['R'] / 100

                    ];

                    $eventID[] = $val['I'];
                }

            $coef = groupArray ($val['E'],'T');
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

    
            if (  
                (!empty($statRaw) && ($val['SC']['CPS'] !='Half time' 
            && $val['SC']['TS'] !=2700))  
            && $matchTime !=0 
            && count($statRaw)>0 ) {
                    
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

            // update info match

            // if ($matchTime == 2) {
            //     $matchInfo['info'] = json_encode([
            //                 'place'     => $val['MIS'],
            //                 'team1ID'   => $val['O1I'],
            //                 'team2ID'   => $val['O2I'],
            //     ]);
              
            //     echo "\n Update: ". $val['I']."\n";
            //     $crud->dbMultiUpdate('matchs',   $matchInfo ,  'eventID',  $val['I']);
            //     $u++;
            // }
        }
    }


    if (!empty($matches)) {
        $crud->dbInsert('matchs', $matches);
        echo "\n ** Add  matches: ".count($matches);

        if (count($tmpdb)>300 && date('H') == 4) {
            echo "\n +++ reset tmp DB +++\n";
            $output = array_slice($tmpdb, -200, 300);
            $resetDB = array_merge($output, $eventID);

            file_put_contents(__DIR__ . '/tmpdb.txt', implode("\n",$resetDB)."\n");

        } else {
            file_put_contents(__DIR__ . '/tmpdb.txt', implode("\n",$eventID)."\n", FILE_APPEND | LOCK_EX);
        }

        

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