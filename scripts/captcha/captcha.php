<?php
session_start();
// $captcha_num = rand(1000, 9999);
// $_SESSION['code'] = $captcha_num;
 
$digCollect = [1,2,4,0,9,6,7];
$rands = array_rand ($digCollect,4);

foreach ($rands as $key => $rand) {
  $dig[] = $digCollect[$rand];
}




$captcha_num = implode('', $dig);
$_SESSION['captcha'] = $captcha_num;


$font_size = 38;
$width = 130;
$height = 50;

$colors =  [ rand(100,250), rand(80,250), rand(130,200) ];
$text_color =  [ 0, 10, 30   ];



$font = __DIR__ . '/files/brightlights.ttf';
header('Content-type: image/jpeg');
 
$image = imagecreate($width, $height); 
imagecolorallocate($image, $colors[0], $colors[1], $colors[2]);

for ($i=0;$i<15;$i++)
  imageline($image, mt_rand(0,$width), mt_rand(0,$height) , mt_rand(0,$width), mt_rand(0,$height),
  imagecolorallocate($image, rand(20,100),rand(0,50),rand(10,50)));
 

$text_color = imagecolorallocate($image, $text_color[0]  , $text_color[1], $text_color[2] ); 
imagettftext($image, $font_size, 0, 2, rand(40,50), $text_color, $font, $captcha_num);




imagejpeg($image,  NULL, 6);
?>