<?php
function create_folder( $usrnum, $title ){

  $contents = '';

  $f = foldernum($usrnum);
  $flurl = 'user'.$usrnum.'/file/folder'.$f;
  $exist = false;
  $folder  = getfolder($usrnum);
  if($folder){
    foreach($folder as $num){
      if($title == popfoldertitle($usrnum, $num)){
        $exist = true;
        break;
      }
    }
  }
  if($exist){
    $contents .= '&nbsp;&nbsp;そのフォルダは既に存在しています．';
  }else{
    if(!file_exists($flurl)){
      mkdir($flurl);
      chmod($flurl, 0777);
    }
    file_put_contents($flurl.'/title', $title);
    $contents .= '&nbsp;&nbsp;['.$title."]フォルダを作成しました．";
  }

  return $contents;
}
?>
