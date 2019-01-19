

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
  
  
  
include 'connect.php';
$sql     = "SELECT DISTINCT `fullHall` from classes";
$query   = mysqli_query($connect, $sql);
$classes = array();
$count   = 0;
while (($row = mysqli_fetch_assoc($query))) {
  if(!strpos($row['fullHall'], "TBA")){
    array_push($classes, $row['fullHall']);
  }
}
$time = 12;
$days      = array(
    "M",
    "T",
    "W",
    "R",
    "F"
);
$hallArray = array();
/*
foreach ($days as $day) {
$file        = $day . ".txt";
$fileContent = "";
//*/
$day       = $_GET['day'];
$time = $_GET['time'];

foreach ($classes as $class) {
    
    $sql      = "SELECT * FROM `classes` WHERE `days` LIKE '%%$day%%' AND `fullHall` LIKE '$class' ORDER BY `startTime` ASC";
    $query    = mysqli_query($connect, $sql);
    $prevTime = 0;
    $oldData;
    //$time         = $time - 300;
    $hourTime     = roundToTheNearestAnything($time, 100);
    $minuteFactor = $time - $hourTime;
    $minuteFactor = $minuteFactor / 60;
    $hourTime     = $hourTime / 100;
    $newTime      = $hourTime + $minuteFactor;
    
    
    while (($row = mysqli_fetch_assoc($query))) {
        $timegap = $row['startTime'] - $prevTime;
                      $hall = $row['hall'];

        if ($timegap >= .5 && $prevTime != 0 && !strpos($hall, "TBA")) {
            if ($newTime >= $prevTime && $newTime <= $row['startTime']) {
                $start = convertNumberToTime($prevTime);
                $end = convertNumberToTime($row['startTime']);
                if (!isset($hallArray[$hall])) {
                    $hallArray[$hall] = array();
                }
                array_push($hallArray[$hall], "$class|$prevTime|" . $row['startTime']);
                //echo "$class Time gap: $start to $end<br />";
            }
        }
        
        $prevTime = $row['endTime'];
        $oldData  = $row;
    }
    
    if ($newTime >= $oldData["endTime"]) {
        
        $hall = $oldData["hall"];
        if (!isset($hallArray[$hall])) {
            $hallArray[$hall] = array();
        }
      $str = $oldData["fullHall"] . "|-1|" . $oldData["endTime"];
      if(!in_array($str, $hallArray[$hall]) && !strpos($str, "TBA")){
        array_push($hallArray[$hall], $str);
      }
        
    }
}
 echo "<hr />  <div style=\"\" class='row'>";
    $keys = array_keys($hallArray);
  $count = 1;
  foreach($keys as $key){
                echo "<div style='  border-style: solid;
  border-width: 0px 0px 4px 0px;' class='col-md-3'>
          <div style=\"  \">
            ";
          echo "<h1 onclick=\"showDiv('$key')\">$key</h1><br />";
          echo "<div id='$key' style='display: none;'><h3 onclick=\"hideDiv('$key')\" >Close</h3><br />";
    foreach($hallArray[$key] as $time){
          $timeSplit = explode("|", $time);
          if($timeSplit[1] == -1){
            echo $timeSplit[0]." is free after ".convertNumberToTime($timeSplit[2])."<br />";
          }else{
          echo $timeSplit[0]." is free from ".convertNumberToTime($timeSplit[1])." to ".
            convertNumberToTime($timeSplit[2])."<br />";

          }
        }
                  
                  
                  echo "</div>
          </div>
     
        </div>";
    
        $count++;
  }
    
//echo json_encode($hallArray);
/*file_put_contents($file, $fileContent);
}//*/



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




function roundToTheNearestAnything($value, $roundTo)
{
    $mod = $value % $roundTo;
    return $value + ($mod < ($roundTo / 2) ? -$mod : $roundTo - $mod);
}

?>