<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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

function dd($data) 
{
    echo '<pre>';
    print_r($data);
    die('</pre>');
}

function json($array) 
{
    // if (isset($array['status']) && $array['status'] == 'error') {
    //     header('HTTP/1.0 403 Forbidden');
    // }

    die(json_encode($array) );

}

function alert($status, $text) {
    $colors = ["ok" =>"success", "success"=>"success", "error"=>"danger" , "warn"=> "warning" ];

   return (object) [  'status' => $status , 'color' => $colors[$status] , 'text' =>  $text];

}

function strRot($str) {

    return strtr( 
          $str ,
        'pbcdefghajklmnoSqrstuvwxyz0-:_|,;.$123456789ABCDEFGHIJKLMNOPQRiTUVWXYZ?=&',
        '123456789ABCDEFGHIJKLMNOPQRiTUVWXYZpbcdefghajklmnoSqrstuvwxyz0-:_|,;.$?=&');
} 

function cryptStr($str, $encode = true) {

    $str = ( $encode == true ? 
            strRot(base64_encode ($str) ) : 
            base64_decode (strRot($str)) 
        );

    return $str;
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
        '66.249.',
        '127.0.'
    ];

    $clintIP =  explode('.', str_replace(':', '.',  getClientIP())) ;
    // 


    return (    
                // preg_match('/googlebot|/i', $_SERVER['HTTP_USER_AGENT'])  &&
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

function getCaptcha () {
    $digCollect = [1,2,4,0,9,6,7];
    $rands = array_rand ($digCollect,4);

    foreach ($rands as $key => $rand) {
        $dig[] = $digCollect[$rand];
    }


    $captcha_num = implode('', $dig);
    setcookie("code", cryptStr($captcha_num), time()+3600, "/");


    $font_size = 38;
    $width = 130;
    $height = 50;

    $colors =  [ rand(110,200), 150,  150 ];
    $text_color =  [ 0, 10, 30   ];

    $font = __DIR__ . '/font.ttf';

    header('Content-type: image/jpeg');
    
    $image = imagecreate($width, $height); 
    imagecolorallocate($image, $colors[0], $colors[1], $colors[2]);

    for ($i=0;$i<15;$i++)
    imageline($image, mt_rand(0,$width), mt_rand(0,$height) , mt_rand(0,$width), mt_rand(0,$height),
    imagecolorallocate($image, rand(20,100),rand(0,50),rand(10,50)));
    

    $text_color = imagecolorallocate($image, $text_color[0]  , $text_color[1], $text_color[2] ); 
    imagettftext($image, $font_size, 0, 2, rand(40,50), $text_color, $font, $captcha_num);


    imagejpeg($image,  NULL, 12);
    die();
}

function getEmptyProfile() {
    
    //https://th.bing.com/th/id/OIP.w2McZSq-EYWxh02iSvC3xwHaHa
    $profile = [
        'avatar' => '0/no.png',
        'name' => '',
        'about'  => '',
        'other' =>'',

        'social' => [
            'youtube' =>'',
            'facebook' =>'',
            'discord' =>'',
            'instagram' =>'',
            'telegram' =>'',
            ]
        ];

    
    return json_encode ($profile);
} 

function sendEmail ($to, $template) {

    $key = time() . ':' . cryptStr($to);
           
    $fileTemplate =  file_get_contents(__DIR__.'/../views/forms/mail/'.$template.'.html')  ;        

    switch ($template) {
        case 'reset':
            $subject = '⚡OddsLog.com: Reset Password';

            $link = 'https://' . $_SERVER['HTTP_HOST'] . 
            '/user/change-password?key=' . base64_encode ( $key ) .'&crc=' . hash('ripemd128', $key) ;

            $template =  str_replace ( '{{resetLink}}', $link,   $fileTemplate) ;
           
        break;

        case 'activate':
            $subject = '⚡OddsLog.com: Action Required to Activate your Account';

            $link = 'https://' . $_SERVER['HTTP_HOST'] . 
            '/user/activate?key=' . base64_encode ( $key ) .'&crc=' . hash('ripemd128', $key) ;

            $template =  str_replace ( '{{activeLink}}', $link,   $fileTemplate) ;
        break;
        
        default:
            # code...
            break;
    }


   return sendMailSMTP( $to,  $subject , $template );

}


function sendMailSMTP ($to, $subject, $body) {


    
    require_once __DIR__ .'/PHPMailer/src/Exception.php';
    require_once __DIR__ .'/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ .'/PHPMailer/src/SMTP.php';

    $mail = new PHPMailer;
    $mail->CharSet = 'UTF-8';
    
    // Настройки SMTP
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 0;
    
    $mail->Host = 'ssl://smtp.mail.ru';
    $mail->Port = 465;
    $mail->Username = 'info@oddslog.com';
    $mail->Password = "i9zh6D1ndExFFrpfH7kZ";
    

    $mail->setFrom('info@oddslog.com', 'OddsLog.com');		
    
   
    $mail->addAddress($to, '');
    

    $mail->Subject = $subject;
    
    $mail->msgHTML($body);
    
    // $mail->send();

    return ($mail->send() ? true:false) ;

    // if(!$mail->send()) {
    //     $return = 'Message could not be sent.';
    //     $return .= 'Mailer Error: ' . $mail->ErrorInfo;
    // } else {
    //     $return = 'Message has been sent';
    // }

    // return  $return;
}

?>