<?php
  $usrnum  = $_COOKIE['user_num_cookie'];
  $user_id = $_COOKIE['user_id_cookie'];

  header( "Content-Type: application/octet-stream" );
  header( "Content-disposition: attachment; filename=".$user_id.".zip" );

  require('zipfun.php');
  require('zip.lib.php');
  require('function.php');
  
  $zipfile = new zipfile();
  $file = getfile($usrnum,$fnum);
  $maxnum = 0;
  if( is_array($file) ){
    foreach($file as $num){
      $sortfile[$num] = $num;
      if($num>$maxnum) $maxnum = $num;
    }
    for($i=1; $i<$maxnum+1; $i++){
      if($sortfile[$i]){
        $pre = prezip_file($usrnum,$sortfile[$i]);
        $zipfile->addFile($pre[0], $pre[1]);
        unset($pre);
      }
    }
  }

  $folder = getfolder($usrnum);
  if( is_array($folder) ){
    foreach($folder as $fnum){
      $file = getfolderfile($usrnum,$fnum);
      $maxnum = 0;
      if( is_array($file) ){
        foreach($file as $num){
          $sortfile[$num] = $num;
          if($num>$maxnum) $maxnum = $num;
        }
        for($i=1; $i<$maxnum+1; $i++){
          if($sortfile[$i]){
            $pre = prezip_folder($usrnum,$fnum,$sortfile[$i]);
            $zipfile->addFile($pre[0], $pre[1]);
            unset($pre);
          }
        }
      }
    }  
  }

  $zip_buffer = $zipfile->file();
  print $zip_buffer;
?>
