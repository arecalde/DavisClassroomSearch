<?php
include 'connect.php';
$sql     = "SELECT DISTINCT `fullHall` from classes";
$query   = mysqli_query($connect, $sql);
$classes = array();
$count   = 0;
while (($row = mysqli_fetch_assoc($query))) {
    array_push($classes, $row['fullHall']);
}
$time = 12;

$days = array(
    "M",
    "T",
    "W",
    "R",
    "F"
);
/*
foreach ($days as $day) {
          $file        = $day . ".txt";
        $fileContent = "";
  //*/
    $day = date("l");
    if($day == "Thursday"){
      $day = $day[0];
    }else{
      $day = $day[0];
    }
    foreach ($classes as $class) {

        $sql         = "SELECT * FROM `classes` WHERE `days` LIKE '%%$day%%' AND `fullHall` LIKE '$class' ORDER BY `startTime` ASC";
        $query       = mysqli_query($connect, $sql);
        $prevTime    = 0;
        
        while (($row = mysqli_fetch_assoc($query))) {
            $timegap = $row['startTime'] - $prevTime;
            if ($timegap >= .5 && $prevTime != 0) {
                $time = date('Hi');
              $time = $time-300;
              $hourTime = roundToTheNearestAnything($time, 100);
              $minuteFactor = $time-$hourTime;
              $minuteFactor = $minuteFactor/60;
              $hourTime = $hourTime/100;
                    $newTime = $hourTime+$minuteFactor;
              if($newTime >= $prevTime && $newTime <= $row['startTime']){
                $startSplit = explode(".", $prevTime);
                $endSplit = explode(".", $row['startTime']);
                if(count($startSplit) == 1){
                  $start = $startSplit[0].":00";
                }else{
                  $startSplit[1] = "0.".$startSplit[1];
                  $startMinutes = (($startSplit[1])*60);
                  $start = $startSplit[0].":".floor($startMinutes);
                }
                
                if(count($endSplit) == 1){
                  $end = $endSplit[0].":00";
                }else{
                  $endSplit[1] = "0.".$endSplit[1];
                  $endMinutes = (($endSplit[1])*60);
                  $end = $endSplit[0].":".floor($endMinutes);
                }
                
                //echo $startSplit[1]."<br />";
                echo "$class Time gap: $start to $end<br />";
                //$fileContent = $fileContent . "$class Time gap: $prevTime to " . $row['startTime'] . "\n";
              }
            }
            $prevTime = $row['endTime'];  
        }

        
    }
        /*file_put_contents($file, $fileContent);
}//*/


function roundToTheNearestAnything($value, $roundTo){
    $mod = $value%$roundTo;
    return $value+($mod<($roundTo/2)?-$mod:$roundTo-$mod);
}

?>