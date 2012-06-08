<?php
function create($usrnum, $foldernumber, $title){

  $contents = '';
  
  // ディレクトリの指定と重複の確認
  $exist = false;
  if($foldernumber==0){
    $next = filenum($usrnum);
    $flurl = 'user'.$usrnum.'/file/'.$next.".txt";
    $file   = getfile($usrnum);
    if($file){
      foreach($file as $number){
        if($title == poptitle($usrnum, $number)){
          $exist = true;
          break;
        }
      }
    }
  }else{
    $next = folderfilenum($usrnum, $foldernumber);
    $foldertitle = popfoldertitle($usrnum, $foldernumber);
    $flurl = 'user'.$usrnum.'/file/folder'.$foldernumber.'/'.$next.".txt";
    $file   = getfolderfile($usrnum, $foldernumber);
    if($file){
      foreach($file as $number){
        if($title == poptitlefolder($usrnum, $foldernumber, $number)){
          $exist = true;
          break;
        }
      }
    }
  }

  // ファイルの作成
  if($exist){
      $contents .= '&nbsp;&nbsp;そのタイトルは既に存在しています．';
    if($foldernumber==0){
      $contents .= '<p>&nbsp;&nbsp;<a href="./">メモ一覧</a>';
    }else{
      $contents .= '<p>&nbsp;&nbsp;<a href="./?folder='.$foldernumber.'">メモ一覧</a>';
    }
  }else{
    file_put_contents($flurl, $title);
    $contents .= '&nbsp;&nbsp;'.$title." を作成しました．";
    if(empty($foldernumber)){
      $contents .= '<p>&nbsp;&nbsp;<a href="./edit.php?title='.$next.'">編集</a>　';
      $contents .= '<a href="./">メモ一覧</a>';
    }else{
      $contents .= '<p>&nbsp;&nbsp;<a href="./edit.php?title='.$next.'&folder='.$foldernumber.'">編集</a>　';
      $contents .= '<a href="./?folder='.$foldernumber.'">メモ一覧</a>';
    }
  }

  return $contents;
}
?>
