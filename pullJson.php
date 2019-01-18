<?php 
  $subjText = file_get_contents("subjects.txt");
  $subjArr = explode("\n", $subjText);
  $cmd = file_get_contents("cmd.txt");
  $cmd = str_replace("\n", "", $cmd);
foreach($subjArr as $subj){
    $file = "json/$subj".".json";
    $cmd1 = str_replace("*subject*", $subj, $cmd);
    $output = shell_exec($cmd1);
    file_put_contents($file, $output);
    echo "$cmd1 \nIteration Completed $file\n\n";
  }
?>