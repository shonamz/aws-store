<?php

 
 $json = file_get_contents('php://input');
 $file ="data1.json";
 //file_put_contents($file, "");
  
  if (filesize($file))
  {
  	$f= ",".$json;
   file_put_contents($file, $f, FILE_APPEND);
   	var_dump($f);
    }
  else
   {
   	file_put_contents($file, $json, FILE_APPEND); 
    var_dump($d);
}
 
 ?>