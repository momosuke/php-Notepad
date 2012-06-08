<?php
require('usrfun.php');

function admin($id, $pass){
  $num = popUserNum($id);
  $result = array(0, "");
  if($num != ""){
    $address= 'user'.$num."/pass";
    $handle = @fopen($address, "r");
    if(!feof($handle)){
      $id_pass = fgets($handle, 4096);
      $id_pass = str_replace(PHP_EOL,"",$id_pass);
    }
    if($pass == $id_pass){
      $result[0] = 1;
      $result[1] = "success";
    } else   $result[1] = "illegal password !";
    @fclose($handle);
  } else {
    $result[1] = "no such id !";
  }
  return $result;
}

?>