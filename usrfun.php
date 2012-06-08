<?php

function usernum(){
  $user = glob('user*');
  for($i=0;$i<count($user);$i++){
    $usernum[$i]=substr($user[$i],4,1);
  }
  for($i=0;$i<count($usernum);$i++){
    $array[$i]=0;
  }
  for($i=0;$i<count($usernum);$i++){
    $r=$usernum[$i]-1;
    $array[$r]=1;
  }
  for($i=0;$i<count($usernum);$i++){
    if($array[$i]==0){
      $num=$i+1;
      break;
    }
  }
  if($i==count($usernum)){
    $num=$i+1;
  }
  return $num;
}

function popUserName($num){
  $address= 'user'.$num."/id";
  $handle = @fopen($address, "r");
  if(!feof($handle)){
    $name = fgets($handle, 4096);
    $name = str_replace(PHP_EOL,"",$name);
  }
  return $name;
}

function popUserNum($id){
  $users = glob('user*');
  foreach($users as $u){
    $u = substr($u, 4, 1);
    $id2 = popUserName($u);
    if($id == $id2) return $u;
  }
  return "";
}

function ip_check($u,$ip){
  $address= 'user'.$u."/ip";
  $handle = @fopen($address, "r");
  if(!feof($handle)){
    $ip_else = fgets($handle, 4096);
    $ip_else = str_replace(PHP_EOL,"",$ip_else);
  }
  if($ip == $ip_else)  return false;
  else                 return true;
}

function user_check($id, $ip){
  $ret = array(0, "");
  $users = glob('user*');
  foreach($users as $u){
    $u = substr($u, 4, 1);
    $id2 = popUserName($u);
    if($id == $id2)       $ret[1] .= "this id is used !<br>";
    if(!ip_check($u,$ip)) $ret[1] .= "this ip is used !<br>";
    if($ret[1] != "") return $ret;
  }
  $ret[0] = 1;
  return $ret;
}

function makeuser($id,$pass,$ip){
  if( empty($id) || empty($pass) )  return "illegal input !";
  $check = user_check($id,$ip);
  if( $check[0] == 0 ) return $check[1];

  $next = usernum();
  if(!file_exists('user'.$next)){
    mkdir('user'.$next);
    chmod('user'.$next, 0777);
    $userurl = 'user'.$next.'/id';
    file_put_contents($userurl, $id);
    $userurl = 'user'.$next.'/pass';
    file_put_contents($userurl, $pass);
    $userurl = 'user'.$next.'/ip';
    file_put_contents($userurl, $ip);
  }
  if(!file_exists('user'.$next.'/file')){
    mkdir('user'.$next.'/file');
    chmod('user'.$next.'/file', 0777);
  }
  if(file_exists($userurl))  return "true";
  else {
    deluser($next);
    return "fault: make id";
  }
}

function deluser($num){
  if(empty($num)) return;
  @unlink('user'.$num.'/id');
  $txt = glob('user'.$num.'/*/*/*');
  foreach($txt as $tx) unlink($tx);
  $flds = glob('user'.$num.'/*/*');
  foreach($flds as $fld){
    if(ereg($fld, '*.txt')) @unlink($fld);
    else                    rmdir($fld);
  }
  $tops = glob('user'.$num.'/*');
  foreach($tops as $top) rmdir($top);
  rmdir('user'.$num);
}
