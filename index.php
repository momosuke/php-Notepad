<?php

/*INIT*/
require('admin.php');
$comment = "";
$user_id   = $_COOKIE['user_id_cookie'  ];
$user_num  = $_COOKIE['user_num_cookie' ];
$user_pass = $_COOKIE['user_pass_cookie'];
$delete    = $_COOKIE['delete_cookie'];

// DELETE_MODE - ON/OFF //
if(!empty($_POST['delete'])){
  if($_POST['delete']=="2") $delete = 1;
  else                      $delete = 0;
}

/*ADDUSER*/
if(!empty($_GET ['add_user'])){
  $adduser = '1';
}

/*MAKE*/
if(!empty($_POST['make_user'])){
  if($_POST['make_user']=='MAKE'){
    $ip = $_SERVER["REMOTE_ADDR"];
    if(!empty($_POST['user_id'  ])) $user_id   = $_POST  ['user_id'  ];
    if(!empty($_POST['user_pass'])) $user_pass = $_POST  ['user_pass'];
    $comment .= makeuser($user_id, $user_pass, $ip);
    if($comment == "true") $comment = 'new id: '.$user_id;
    else                   $adduser = '1';
    $user_id   = "";
    $user_num  = "";
    $user_pass = "";
  }
}

/*LOGIN*/
if(!empty($_POST['loginn'])){
  if($_POST['loginn']=='LOGIN'){
    if(!empty($_POST['user_id'  ])) $user_id   = $_POST['user_id'  ];
    if(!empty($_POST['user_pass'])) $user_pass = $_POST['user_pass'];
    /*ID_PASS_Check*/
    $user_num = popUserNum($user_id);
    $ret = admin($user_id, $user_pass);
    if( $ret[0] == 1 ){
      $success = '1';
      $delete = 0;
    }else{
      $comment .= $ret[1];
      $user_id   = "";
      $user_num  = "";
      $user_pass = "";
    }
  }else if($_POST['loginn']=='LOGOFF'){
    setcookie("user_id_cookie");	// clear id cookie
    $user_id = "";			// clear id
    setcookie("user_num_cookie");
    $user_num = "";
    setcookie("user_pass_cookie");
    $user_pass = "";
    setcookie("delete_cookie");         // clear delete cookie
    $delete = "";
  }
}

/*ID_PASS_Check*/
else{
  if($user_id != "" || $user_pass != ""){
    $ret = admin($user_id, $user_pass);
    if( $ret[0] == 1 ){
      $success = '1';
    }else{
      $comment .= "illegal access !";
    }
  }
}

/*MAIN*/
if( $success == '1' ){
  setcookie("user_num_cookie",  $user_num,  time()+6*60*60);
  setcookie("user_id_cookie",   $user_id,   time()+6*60*60);
  setcookie("user_pass_cookie", $user_pass, time()+6*60*60);
  setcookie("delete_cookie",    $delete,    time()+6*60*60);
  require('list.php');
  list_main($user_num, $user_id, $delete);
}else{
  echo "<html>";
  echo "<head>";
  echo "<title>メモ帳</title>";
  echo "<meta http-equiv='Content-Type' content='text/html; charset=euc-jp' />";
  echo "</head>";
  echo "<body><center><br>";
  echo "<table border=0 height=80%><tr><td>";
  if( $adduser == '1' ){
    echo "<table border=0><tr><td colspan=2><b>AddUser</b><hr></td></tr><tr><th>User</th><td>";
  }else{
    echo "<table border=0><tr><td colspan=2><b>LOGIN</b><hr></td></tr><tr><th>User</th><td>";
  }
  echo "<form action='./' method='post'>";
  echo "　<input type='text' name='user_id' size='12'>";
  echo "</td><td></td></tr><tr><th>Pass</th><td>";
  echo "　<input type='password' name='user_pass' size='12'>";
  if( $adduser == '1' ){
    echo "</td><td><input type='submit' name='make_user' value='MAKE'></td></form></tr>";
    echo "<tr><td colspan=2><a href='./'>Back</a></td></tr>";
  }else{
    echo "</td><td><input type='submit' name='loginn' value='LOGIN'></td></form></tr>";
    echo "<tr><td colspan=2><a href='./?add_user=1'>AddUser</a></td></tr>";
  }
  echo "<tr><td colspan=3><b>".$comment."</b></td></tr>";
  echo "</table>";
  echo "</td></tr></table>";
  echo "</body>";
  echo "</html>";
}
