<?php
error_reporting(1);
set_time_limit(0);
// header('Access-Control-Allow-Origin: *');

// include_once (__DIR__ . '/libs/functions.php');

$config = parse_ini_file(__DIR__ . '../../config.ini');

include_once (__DIR__ . '/libs/crud.class.php');
include_once (__DIR__ . '/libs/db.php');

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

function jsonData ($arr) {
        
    $away = $home = $h2h = [];
    if (count($arr['H'])>0) {
        foreach ($arr['H'] as $key => $val) {
            $home[] = [
            'home' => $val['H']['T'],
            'away' => $val['A']['T'],
            'date'  => $val['D'],
            'score'    =>
            [
                '1T'   =>[
                    $val['P'][0]['H'] ,
                    $val['P'][0]['A']
                ],
                'FT' => [
                    $val['S1'],
                    $val['S2']
                ]
            ] ,
            'gameID' => $val['I'],
            'teamID' => [ 'home'=> $val['H']['XI'] , 'away'=> $val['A']['XI']],
            

            'tour' => [
                $val['S']['C']['T'] , $val['S']['N']
            ]
        ];
        }
    }

    if (count($arr['A'])>0) {
        foreach ($arr['A'] as $key => $val) {
            $away[] = [
            'home' => $val['H']['T'],
            'away' => $val['A']['T'],
            'date'     => $val['D'],
            'score'    =>
            [
                '1T'   =>[
                    $val['P'][0]['H'] ,
                    $val['P'][0]['A']
                ],
                'FT' => [
                    $val['S1'],
                    $val['S2']
                ]
            ] ,
            'gameID' => $val['I'],
            'teamID' => [ 'home'=> $val['H']['XI'] , 'away'=> $val['A']['XI']],
            'tour' => [
                $val['S']['C']['T'] , $val['S']['N']
            ]
        ];
        }
    }

    if (count($arr['G'])>0) {
        foreach ($arr['G'] as $key => $val) {

            $h2h[] = [
                'home' => $val['H']['T'],  
                'away' => $val['A']['T'],  
                'date'  => $val['D'],  
                'score'    => 
                [
                    '1T'   =>[ 
                        $val['P'][0]['H'] , 
                        $val['P'][0]['A'] 
                    ],
                    'FT' => [
                        $val['S1'],
                        $val['S2']
                    ]
                ] ,  
                'gameID' => $val['I'],
                'teamID' => [ 'home'=> $val['H']['XI'] , 
                              'away'=> $val['A']['XI']
                            ],
                'tour' => [
                    $val['S']['C']['T'] , $val['S']['N']
                ]
            ];
        }
    }

    return [
        'home' => $home,
        'away' => $away,
        'h2h'  => $h2h,
    ];

}


$matches  = $crud->rawSelect('SELECT id, eventID, info FROM `matchs` WHERE `h2h` = 1')
              ->fetchAll(PDO::FETCH_ASSOC);


    foreach ($matches as $key => $match) {
        
        $info = json_decode($match['info'],1 );
        if ($info['gameId']!='') {

            echo $match['id'] . ' - ' . $match['eventID'] . "\n";

            $data = json_decode(getContent('https://1xbet.com/SiteService/HeadToHead?gameId='.$info['gameId'].'&ln=en&partner=51&geo=1'), 1);

            
            
            if ( is_countable($data) && count($data['A'])> 0 && count($data['H'])> 0) {
                $arr = jsonData($data);
                    $h2h[0] = [
                    'eventID'   => $match['eventID'],
                    'data'      => json_encode($arr),
                    'datetime'  =>  date('Y-m-d H:i:s'),
                ];
                
                $crud->dbInsert('h2h', $h2h);
                sleep(1);
            }
            $matchUpdate['h2h'] = 2;
            $crud->dbMultiUpdate('matchs', $matchUpdate, 'id', $match['id']);
        }
    }

    



// print_r ($json);