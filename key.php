<?php

$file=file_get_contents("http://www.youhosting.com/en/auth");
$output=$this->GetBetween($file,"document.write(",");");
$alphas = array_merge(range('A', 'Z'), range('a', 'z'));
$delete=array('"',"'","+","<",">"," ","=");
$key=str_replace($delete,"",$output);
$key=str_replace($alphas,"",$key);
$delete=array("'","+","<",">"," ");
$name=str_replace($delete,"",$output);
$name= $this->GetBetween($name,'inputname="','"');