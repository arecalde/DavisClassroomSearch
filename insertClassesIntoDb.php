<?php 
  $dir = scandir("json");
  foreach($dir as $file){
    if($file != "." && $file != ".."){
      $output = shell_exec("php -f parser.php 'json/$file'");
      $output = str_replace("<br />", "\n", $output);
      $output = str_replace("<hr />", "\n\n", $output);
      echo $output;
    }
  }

?>