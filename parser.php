<?php 

  include 'connect.php';
  $file = $argv[1];
  //$file="json/AAS.json";
  $rawJson = file_get_contents($file);
  $jsonDecode = json_decode($rawJson, true);
  $colArray = $jsonDecode["Results"]["COLUMNS"];
  $count = 0;
  while($count < count($jsonDecode["Results"]["DATA"])){
    $innerJson = $jsonDecode["Results"]["DATA"][$count][26]; //each number is a class
    $innerDecode = json_decode($innerJson, true);
    foreach($innerDecode["QUERY"]["DATA"] as $class){
      $hall = $class[0];
      $room = $class[1];

      $startTime = $class[2];
      $endTime = $class[3];
      $days = $class[16];
      $fullRoom = $hall." ".$room;

      
     
      $hourTime = roundToTheNearestAnything($startTime, 100);
      $minuteFactor = $startTime-$hourTime;
      $minuteFactor = $minuteFactor/60;
      $hourTime = $hourTime/100;
      $startTimeCode = $hourTime+$minuteFactor;
       if($startTimeCode<10){
        $startTimeCode = "0".$startTimeCode;
      }

      $hourTime = roundToTheNearestAnything($endTime, 100);
      $minuteFactor = $endTime-$hourTime;
      $minuteFactor = $minuteFactor/60;
      $hourTime = $hourTime/100;
      $endTimeCode = $hourTime+$minuteFactor;
      /*echo $fullRoom."<br />";
      echo $startTimeCode."<br />";
      echo $endTimeCode."<br />$days";
      echo "<hr />";//*/

      $sql  = "INSERT INTO `classes` (`id`, `hall`, `room`, `startTime`, `endTime`, `days`, `fullHall`) VALUES".
        " (NULL, '$hall', '$room', '$startTimeCode', '$endTimeCode', '$days', '$fullRoom')";
      $query = mysqli_query($connect, $sql); 
      echo "Successful Input\n";
    }
    
    $count++;
  }
 
function roundToTheNearestAnything($value, $roundTo){
    $mod = $value%$roundTo;
    return $value+($mod<($roundTo/2)?-$mod:$roundTo-$mod);
}
?>