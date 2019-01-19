<?php 
$time = date('Hi');
$time = $time-300;

      $hourTime = roundToTheNearestAnything($time, 100);
      $minuteFactor = $time-$hourTime;
      $minuteFactor = $minuteFactor/60;
      $hourTime = $hourTime/100;
      //echo $hourTime." ".$minuteFactor."\n";
echo convertNumberToTime(15.166666667)."\n";

function convertNumberToTime($number){
  $timeSplit = explode(".", $number);
  $hour = $timeSplit[0];
  $isNight = false;  
  if($hour > 12){
    $hour = $hour-12;
    $isNight = true;
  }
  if (count($timeSplit) == 1) {
      $time =  $hour. ":00";
  } else {
      $timeSplit[1] = "0." . $timeSplit[1];
      $timeMin  = (($timeSplit[1]) * 60);
      $time         = $hour . ":" . floor($timeMin);
  }
  if($isNight){
    return $time." PM";
  }else{
    return $time." AM";

  }

}

function roundToTheNearestAnything($value, $roundTo){
    $mod = $value%$roundTo;
    return $value+($mod<($roundTo/2)?-$mod:$roundTo-$mod);
}
?>