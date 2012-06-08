<?php

function delete_file($usrnum, $fnum, $num){
  if($fnum==0) {
    $dtitle = poptitle($usrnum,$num);
    $file   = 'user'.$usrnum.'/file/'.$num.".txt";
    unlink($file);
    return $dtitle;
  } else {
    $dtitle = poptitlefolder($usrnum,$fnum,$num);
    $file   = 'user'.$usrnum.'/file/folder'.$fnum.'/'.$num.".txt";
    unlink($file);
    return $dtitle;
  }
}

function delete_folder($usrnum,$fnum){
  if($fnum==0){
    $file = getfile($usrnum);
    if(empty($file))  return "ファイルがありません";
    if(is_array($file)){
      foreach($file as $f){
        @unlink('user'.$usrnum.'/file/'.$f.".txt");
      }
    }
    return "トップフォルダを空にしました";
  } else {
    $fname = popfoldertitle($usrnum,$fnum);
    $file  = getfolderfile($usrnum,$fnum);
    @unlink('user'.$usrnum.'/file/folder'.$fnum.'/title');
    if(is_array($file)){
      foreach($file as $f){
        @unlink('user'.$usrnum.'/file/folder'.$fnum.'/'.$f.".txt");
      }
    }
    rmdir('user'.$usrnum.'/file/folder'.$fnum);
    return $fname;
  }
}

?>
