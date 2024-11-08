<?php

function Slug($string) {
	$string = trim(urldecode( $string)); 
	$slug = \Transliterator::createFromRules(
    ':: Any-Latin;'
    . ':: NFD;'
    . ':: [:Nonspacing Mark:] Remove;'
    . ':: NFC;'
    . ':: [:Punctuation:] Remove;'
    . ':: Lower();'
    . '[:Separator:] > \'-\''
	)
    ->transliterate( $string );
	$string = preg_replace("/-+/ui","-", $string);

	return $slug;

}


function statExplode($arr) {   
    if (isset($arr)) {
        foreach ($arr as $key => $val) {
            $stat[$key] = explode('|', $val);
        }
      return $stat;
    }

    else 
        return false;
}

function statPercent($i , $arr)
{
   
    return round($arr[$i]/($arr[0]+$arr[1]) *100,2);

}


function groupArray($array, $key) { 
    $key_array = []; 
    foreach($array as $val) { 
            $key_array[$val[$key]] = $val; 
    } 
    return $key_array; 
}

function h2hStatus($team, $team1, $team2 , $score)
{
   if ($team == $team1 ) {
       if ($score[0]> $score[1]) {
           $status = ['W' , 'success'];
       }
       if ($score[0] == $score[1]) {
           $status = ['D' , 'warning'];
       }
       if ($score[0] < $score[1]) {
           $status = ['L' , 'danger'];
       }
   }
   if ($team == $team2 ) {
       if ($score[0]< $score[1]) {
           $status = ['W' , 'success'];
       }
       if ($score[0] == $score[1]) {
           $status = ['D' , 'warning'];
       }
       if ($score[0] > $score[1]) {
           $status = ['L' , 'danger'];
       }
   }
    return [
        'val'=>     $status[0] , 
        'badge'=>   $status[1]
    ];
    
}

function h2hWinCalc($team, $h2h)
{
    $win = $c = $avgHome = $avgAway = 0;

    foreach ($h2h as $key => $match) {
        $score = $match->score->FT;
        if ($team == $match->home) {
            
            if ($score[0]> $score[1]) {
                $win++;
                $avgHome++;
            }
        }
        if ($team == $match->away) {
            if ($score[0]< $score[1]) {
                $win++;
                $avgAway++;
            }
        }
        $c++;
    }
    $avg = round(($win/$c)*100); 
    if ($avg < 35) {
        $status = 'danger';
    }
    if ($avg >= 35 && $avg <=50) {
        $status = 'warning';
    }
    if ($avg >= 50 && $avg <=70) {
        $status = 'success';
    }
    if ($avg >= 70) {
        $status = 'primary';
    }

    return [
        'avg'  => $avg,
        'home' => $win>0 ?? round(($avgHome/$win)*100),
        'away' => $win>0 ?? round(($avgAway/$win)*100),
        'status' => $status
    ];
}


function h2hPPGCalc($team, $h2h)
{
    $point = $pointHome = $pointAway =  $ppg = $c = $cH = $cA = 0;

    foreach ($h2h as $key => $match) {
        $score = $match->score->FT;

        if ($team == $match->home) {
            
            if ($score[0]> $score[1]) {
                $point+=3;
                $pointHome +=3;
                $cH ++;
            }
            if ($score[0] == $score[1]) {
                $point+=1;
                $pointHome +=1;
                $cH ++;
            }
        }

        if ($team == $match->away) {
            if ($score[0] < $score[1]) {
                $point+=3;
                $pointAway +=3;
                $cA ++;
            }
            if ($score[0] == $score[1]) {
                $point+=1;
                $pointAway +=1;
                $cA ++;
            }
        }
        $c++;
    }

    $ppg = round( ($point/$c) , 2); 

    if ($ppg < 1) {
        $status = 'danger';
    }
    if ($ppg >= 1 && $ppg <1.7) {
        $status = 'warning';
    }
    if ($ppg > 1.7) {
        $status = 'success';
    }


    return [
        'ppg'  => $ppg,
        'ppgHome'  => $cH>0 ?? round( ($pointHome/$cH) , 2) ,
        'ppgAway'  => $cA>0 ?? round( ($pointAway/$cA) , 2),  
        'status' => $status
    ];
}



function h2hScored($team, $h2h)
{
    $scored = $scoredHome = $scoredAway = $c = $cH = $cA = 0;

    foreach ($h2h as $key => $match) {
        $score = $match->score->FT;

        if ($team == $match->home) {
            $scored     += $score[0];
            $scoredHome += $score[0];
            $cH++;
        }

        if ($team == $match->away) {
            $scored     += $score[1];
            $scoredAway += $score[1];
            $cA++;
        }

        $c++;
    }

    return [
        'avg'      => $c> 0 ?? round( ($scored/$c) , 2),
        'avgHome'  => $cH>0 ?? round( ($scoredHome/$cH) , 2),
        'avgAway'  => $cA>0 ?? round( ($scoredAway/$cA) , 2),  
    ];
}

function h2hBTTS($team, $h2h)
{
    $btts = $bttsHome = $bttsAway = $c = $cH = $cA = 0;

    foreach ($h2h as $key => $match) {
        $score = $match->score->FT;

        if ($team == $match->home) {
            if ($score[0]>0 && $score[1]>0) {
                $btts ++;
                $bttsHome++;
            }
           
            $cH++;
        }

        if ($team == $match->away) {
            if ($score[0]>0 && $score[1]>0) {
                $btts ++;
                $bttsAway++;
            }
            $cA++;
        }

        $c++;
    }


    return [
        'avg'      => $c>0 ?? round( ($btts/$c)*100),
        'avgHome'  => $cH>0 ?? round( ($bttsHome/$cH)*100),
        'avgAway'  => $cA>0 ?? round( ($bttsAway/$cA)*100), 
    ];
}


//https://developers.google.com/search/apis/ipranges/googlebot.json

function isGoogleBot()
{
   
    $googleIpList = [
        '2001.4860.', //ipv6
        '192.178.5.',
        '192.178.6.',
        '34.100.182.',
        '34.101.50.',
        '34.118.66.',
        '35.247.243.',
        '34.96.162.',
        '34.89.198.',
        '34.88.194.',
        '34.64.82.',
        '34.22.85.',
        '34.176.130.',
        '34.175.160.',
        '34.165.18.',
        '34.155.98.',
        '34.154.114.',
        '34.152.50.',
        '34.151.74.',
        '34.146.150.',
        '34.126.178.',
        '66.249.'
    ];

    $clintIP =  explode('.', str_replace(':', '.',  getClientIP())) ;
    // 


    return (    preg_match('/googlebot/i', $_SERVER['HTTP_USER_AGENT'])  &&
                preg_grep ('/'.$clintIP[0].'\.'.$clintIP[1].'\./i', $googleIpList)
            ) 
            ? true: false;



}

 function getClientIP()
{
    $ip='127.0.0.1';

    if(!empty($_SERVER['HTTP_CLIENT_IP'])):
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    else:
        $ip=$_SERVER['REMOTE_ADDR'];
    endif;
    return $ip;
}



?>