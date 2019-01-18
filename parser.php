<?php 
  $rawJson = file_get_contents("json/AAS.json");
  $jsonDecode = json_decode($rawJson, true);
  $colArray = $jsonDecode["Results"]["COLUMNS"];
  $count = 0;
  while($count < count($jsonDecode["Results"]["DATA"])){
    $innerJson = $jsonDecode["Results"]["DATA"][$count][26]; //each number is a class
    $innerDecode = json_decode($innerJson, true);
    $room = $innerDecode["QUERY"]["DATA"][0][0]." ".$innerDecode["QUERY"]["DATA"][0][1];
    $startTime = $innerDecode["QUERY"]["DATA"][0][2];
    $endTime = $innerDecode["QUERY"]["DATA"][0][3];
    $days = $innerDecode["QUERY"]["DATA"][0][16];
    //echo $innerJson."<br /><br />";  
    echo $room."<br />";
    $hourTime = roundToTheNearestAnything($startTime, 100);
    $minuteFactor = $startTime-$hourTime;
    $minuteFactor = $minuteFactor/60;
    $hourTime = $hourTime/100;
    $startTimeCode = $hourTime+$minuteFactor;
    echo $startTimeCode."<br />";
    
    $hourTime = roundToTheNearestAnything($endTime, 100);
    $minuteFactor = $endTime-$hourTime;
    $minuteFactor = $minuteFactor/60;
    $hourTime = $hourTime/100;
    $endTimeCode = $hourTime+$minuteFactor;
    echo $endTimeCode."<br />$days";
    echo "<hr />";
    $count++;
  }
 
function roundToTheNearestAnything($value, $roundTo){
    $mod = $value%$roundTo;
    return $value+($mod<($roundTo/2)?-$mod:$roundTo-$mod);
}
?>