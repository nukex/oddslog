<?php

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


function groupArray($array, $key) { 
    $key_array = []; 
    foreach($array as $val) { 
            $key_array[$val[$key]] = $val; 
    } 
    return $key_array; 
}

function keyExplode($val , $key) {
    $ex = explode('|', $val);

    return $ex[$key];
}

function getScore($arr, $key) {
    $arr = end($arr);

    return  $arr[$key];
}

function getFirstOdds($arr, $val) {
    $key = array_key_first($arr);

    return  $arr[$key][$val];
}


?>