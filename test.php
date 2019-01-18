<?php 
$time = date('Hi');
$time = $time-300;

      $hourTime = roundToTheNearestAnything($time, 100);
      $minuteFactor = $time-$hourTime;
      $minuteFactor = $minuteFactor/60;
      $hourTime = $hourTime/100;
      //echo $hourTime." ".$minuteFactor."\n";
echo $day;


function roundToTheNearestAnything($value, $roundTo){
    $mod = $value%$roundTo;
    return $value+($mod<($roundTo/2)?-$mod:$roundTo-$mod);
}
?>